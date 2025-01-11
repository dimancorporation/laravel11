<?php

namespace App\Http\Controllers;

use App\Models\B24Documents;
use App\Models\User;
use App\Models\B24Status;
use App\Services\IncomingWebhookDealService;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    protected IncomingWebhookDealService $incomingWebhookDealService;
    public function __construct(ServiceBuilder $serviceBuilder, IncomingWebhookDealService $incomingWebhookDealService)
    {
        $this->serviceBuilder = $serviceBuilder;
        $this->incomingWebhookDealService = $incomingWebhookDealService;
    }
    public function handle(Request $request): JsonResponse
    {
        $path = 'logs/log.txt';
        $data = $request->all();
        Log::info('Bitrix24 deal webhook received:', $data);
        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $dealId = $data['data']['FIELDS']['ID'];
        $dealData = $this->incomingWebhookDealService->getDealData($dealId);

        Log::info('Bitrix24 deal webhook received:', $dealData);
        Storage::put($path, json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $isRequestFromWebhook = $this->incomingWebhookDealService->isRequestFromWebhook($data, $dealData);
        if (!$isRequestFromWebhook) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bad Request'
            ], 400);
        }

        $contactData = $this->incomingWebhookDealService->getContactData($dealData['contactId']);
        $contactFullName = $this->incomingWebhookDealService->getContactFullName($contactData);
        $email = $this->incomingWebhookDealService->getEmail($contactData);
        $phone = $this->incomingWebhookDealService->getPhone($contactData);
        $b24Status = B24Status::where('b24_status_id', $dealData['userStatus'])->first();
        $userData = [
            'name' => $contactFullName,
            'email' => $email,
            'phone' => $phone,
            'b24_status' => $b24Status->id,
            'role' => $b24Status->name === 'Должник' ? 'blocked' : 'user',
            'sum_contract' => $dealData['userContractAmount'],
            'link_to_court' => $dealData['userLinkToCourt'],
        ];
        // userMessageFromB24 - сохранить в БД "Сообщение клиенту от компании"
        $user = User::where('id_b24', $dealId);
        if (!$user->exists()) {
            $password = $this->incomingWebhookDealService->generatePassword();
            $this->incomingWebhookDealService->updateAuthData($dealId, $phone, $password);
            $b24Documents = B24Documents::create();
            User::create(array_merge($userData, [
                'password' => Hash::make($password),
                'is_first_auth' => true,
                'is_registered_myself' => false,
                'documents_id' => $b24Documents->id,
                'link_to_court' => $dealData['userLinkToCourt'],
                'contact_id' => $dealData['contactId'],
            ]));
        } else {
            $b24documentsId = B24Documents::where('id', $user->first()->documents_id);
            $documents = $this->incomingWebhookDealService->getDocuments($dealData);
            $b24documentsId->update($documents);
            $user->update(array_merge($userData, [
                'password' => Hash::make($dealData['userPassword']),
            ]));
        }

        Storage::put($path, json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        return response()->json(['status' => 'success'], 200);
    }
}
