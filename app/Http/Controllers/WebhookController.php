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




//        $json = json_encode($data);
//// Декодируем JSON в ассоциативный массив
//        $data = json_decode($json, true);


        $event = $data['event'];                                // "event":"ONCRMDEALUPDATE"
        $domain = $data['auth']['domain'];                      // "domain":"b24-aiahsd.bitrix24.ru"
        $applicationToken = $data['auth']['application_token']; // "application_token":"wquq6wp27009fcunwc0392fue9czyfii"

        $dealId = $data['data']['FIELDS']['ID']; // 11
        $dealData = iterator_to_array($this->serviceBuilder->getCRMScope()->deal()->get($dealId)->deal()->getIterator());

        /*
         * получаем данные по сделке
         */
        $CONTACT_ID = $dealData['CONTACT_ID']; //айди контакта
        $USER_CREATE_ACCOUNT = $dealData['UF_CRM_1708511654449']; //СОЗДАТЬ ЛК КЛИЕНТУ
        $USER_LOGIN = $dealData['UF_CRM_1708511589360']; //ЛОГИН ЛК КЛИЕНТА
        $USER_PASSWORD = $dealData['UF_CRM_1708511607581']; //ПАРОЛЬ ЛК КЛИЕНТА
        $USER_STATUS = $dealData['UF_CRM_1709533755311'] == null ? 0 : $dealData['UF_CRM_1709533755311']; //СТАТУС ДЛЯ ЛК КЛИЕНТА
        $USER_CONTRACT_AMOUNT = $dealData['UF_CRM_1725026451112'] == '' ? 0 : $dealData['UF_CRM_1725026451112']; //СУММА ДОГОВОРА
        $USER_MESSAGE_FROM_B24 = $dealData['UF_CRM_1708511318200']; //СООБЩЕНИЕ КЛИЕНТУ ОТ КОМПАНИИ
        $USER_LINK_TO_COURT = $dealData['UF_CRM_1708511472339']; //ССЫЛКА НА ДЕЛО В КАДР. АРБИТР
        $USER_LAST_AUTH_DATE = $dealData['UF_CRM_1715524078722']; //Дата последней авторизации (МСК)

        $contactData = $this->incomingWebhookDealService->getContactData($CONTACT_ID);
        $contactFullName = $this->incomingWebhookDealService->getContactFullName($contactData);
        $email = $this->incomingWebhookDealService->getEmail($contactData);
        $phone = $this->incomingWebhookDealService->getPhone($contactData);
        $b24Status = B24Status::where('b24_status_id', $USER_STATUS)->first();
        Storage::put($path, ' - '.$b24Status);

        $user = User::where('id_b24', $dealId);
        if (!$user->exists()) {
            $b24Documents = B24Documents::create();
            $user = User::create([
                'name' => $contactFullName,
                'email' => $email,
                'phone' => $USER_LOGIN,
                'password' => Hash::make($USER_PASSWORD),
                'id_b24' => $dealId,
                'b24_status' => $b24Status->id,
                'sum_contract' => $USER_CONTRACT_AMOUNT,
                'is_first_auth' => true,
                'is_registered_myself' => false,
                'documents_id' => $b24Documents->id,
                'link_to_court' => $USER_LINK_TO_COURT,
            ]);
        } else {
            $b24documentsId = B24Documents::where('id', $user->first()->documents_id);
            $documents = $this->incomingWebhookDealService->getDocuments($dealData);
            $b24documentsId->update($documents);
            $user->update([
                'name' => $contactFullName,
                'email' => $email,
                'phone' => $USER_LOGIN,
                'password' => Hash::make($USER_PASSWORD),
                'b24_status' => $b24Status->id,
                'sum_contract' => $USER_CONTRACT_AMOUNT,
                'link_to_court' => $USER_LINK_TO_COURT,
            ]);
        }

        Storage::put($path, ' - '.$USER_CONTRACT_AMOUNT);
        return response()->json(['status' => 'success'], 200);
    }
}
