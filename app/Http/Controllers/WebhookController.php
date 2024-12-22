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
        /* добавить проверку, что пришли данные от вебхука по "event":"ONCRMDEALUPDATE" и "application_token":"wquq6wp27009fcunwc0392fue9czyfii"
         * {"event":"ONCRMDEALUPDATE","event_handler_id":"17","data":{"FIELDS":{"ID":"11"}},"ts":"1734841673","auth":{"domain":"b24-aiahsd.bitrix24.ru","client_endpoint":"https://b24-aiahsd.bitrix24.ru/rest/","server_endpoint":"https://oauth.bitrix.info/rest/","member_id":"ad9655a553314544102513ee3bec2b19","application_token":"wquq6wp27009fcunwc0392fue9czyfii"}}
         */
//        return response()->json(['status' => 'success'], 200);

        $dealId = $data['data']['FIELDS']['ID']; // 11
        $dealData = $this->incomingWebhookDealService->getDealData($dealId);
        $event = $data['event'];                                // "event":"ONCRMDEALUPDATE"
        $domain = $data['auth']['domain'];                      // "domain":"b24-aiahsd.bitrix24.ru"
        $applicationToken = $data['auth']['application_token']; // "application_token":"wquq6wp27009fcunwc0392fue9czyfii"
        if ($event !== 'ONCRMDEALUPDATE' || $domain !== 'b24-aiahsd.bitrix24.ru' || $applicationToken !== 'wquq6wp27009fcunwc0392fue9czyfii' || !isset($dealData['isUserCreateAccount'])) {
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
        Storage::put($path, ' - '.$b24Status);

        // userMessageFromB24 - сохранить в БД "Сообщение клиенту от компании"
        $user = User::where('id_b24', $dealId);
        if (!$user->exists()) {
            $b24Documents = B24Documents::create();
            $user = User::create([
                'name' => $contactFullName,
                'email' => $email,
                'phone' => $dealData['userLogin'],
                'password' => Hash::make($dealData['userPassword']),
                'id_b24' => $dealId,
                'b24_status' => $b24Status->id,
                'sum_contract' => $dealData['userContractAmount'],
                'is_first_auth' => true,
                'is_registered_myself' => false,
                'documents_id' => $b24Documents->id,
                'link_to_court' => $dealData['userLinkToCourt'],
            ]);
        } else {
            $b24documentsId = B24Documents::where('id', $user->first()->documents_id);
            $documents = $this->incomingWebhookDealService->getDocuments($dealData);
            $b24documentsId->update($documents);
            $user->update([
                'name' => $contactFullName,
                'email' => $email,
                'phone' => $dealData['userLogin'],
                'password' => Hash::make($dealData['userPassword']),
                'b24_status' => $b24Status->id,
                'sum_contract' => $dealData['userContractAmount'],
                'link_to_court' => $dealData['userLinkToCourt'],
            ]);
        }

        Storage::put($path, ' - '.$dealData['userContractAmount']);
        return response()->json(['status' => 'success'], 200);
    }
}
