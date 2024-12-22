<?php

namespace App\Http\Controllers;

use App\Models\B24Documents;
use App\Models\User;
use App\Models\B24Status;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    protected ServiceBuilder $serviceBuilder;
    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }
    public function handle(Request $request): JsonResponse
    {
//        $path = 'logs/log.txt';
        // Получаем данные из запроса
        $data = $request->all();
//        Log::info('Bitrix24 webhook received:', $data);
//        Storage::put($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
//        return response()->json(['status' => 'success'], 200);
        /*
        {"event":"ONCRMDEALUPDATE","event_handler_id":"17","data":{"FIELDS":{"ID":"11"}},"ts":"1734841673","auth":{"domain":"b24-aiahsd.bitrix24.ru","client_endpoint":"https://b24-aiahsd.bitrix24.ru/rest/","server_endpoint":"https://oauth.bitrix.info/rest/","member_id":"ad9655a553314544102513ee3bec2b19","application_token":"wquq6wp27009fcunwc0392fue9czyfii"}}
        */
        // Записываем данные в файл логов



        $json = json_encode($data);
// Декодируем JSON в ассоциативный массив
        $data = json_decode($json, true);

// Извлекаем нужные свойства
        $event = $data['event'];          // ONCRMDEALUPDATE
        $dealId = $data['data']['FIELDS']['ID']; // 11
        $applicationToken = $data['auth']['application_token']; // wquq6wp27009fcunwc0392fue9czyfii

        $dealData = $this->serviceBuilder->getCRMScope()->deal()->get($dealId)->deal()->getIterator();
//        $stringData = json_encode($dealData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//        Log::info('Bitrix24 webhook received:', $dealData);
        $path = 'logs/log.txt';

//        if (isset($dealData['UF_CRM_1708509490009'])) {
//            $doc_passport_all_pages = true;
//        } else {
//            $doc_passport_all_pages = false;
//        }

        $doc_passport_all_pages = isset($dealData['UF_CRM_1708509490009']);
        $doc_scan_inn = isset($dealData['UF_CRM_1708509740365']);
        $doc_snils = isset($dealData['UF_CRM_1708510606993']);
        $doc_marriage_certificate = isset($dealData['UF_CRM_1708510636060']);
        $doc_passport_spouse = isset($dealData['UF_CRM_1708510675413']);
        $doc_snils_spouse = isset($dealData['UF_CRM_1708510724402']);
        $doc_divorce_certificate = isset($dealData['UF_CRM_1708510771069']);
        $doc_ndfl = isset($dealData['UF_CRM_1708510936813']);
        $doc_childrens_birth_certificate = isset($dealData['UF_CRM_1708510989101']);
        $doc_extract_egrn = isset($dealData['UF_CRM_1708511092399']);
        $doc_scan_pts = isset($dealData['UF_CRM_1708511164599']);
        $doc_sts = isset($dealData['UF_CRM_1708511175692']);
        $doc_pts_spouse = isset($dealData['UF_CRM_1708511204032']);
        $doc_sts_spouse = isset($dealData['UF_CRM_1708511215650']);
        $doc_dkp = isset($dealData['UF_CRM_1708511237220']);
        $doc_dkp_spouse = isset($dealData['UF_CRM_1708511248493']);
        $doc_other = isset($dealData['UF_CRM_1708511269272']);


        /*
Список документов
ПАСПОРТ (ВСЕ СТРАНИЦЫ) - UF_CRM_1708509490009
СКАН ИНН - UF_CRM_1708509740365
СНИЛС - UF_CRM_1708510606993
СВИДЕТЕЛЬСТВО О ЗАКЛЮЧЕНИИ БРАКА - UF_CRM_1708510636060
ПАСПОРТ СУПРУГА - UF_CRM_1708510675413  
СНИЛС СУПРУГА - UF_CRM_1708510724402
СВИДЕТЕЛЬСТВО О РАСТОРЖЕНИИ БРАКА - UF_CRM_1708510771069
2 НДФЛ ЗА ПОСЛЕДНИЕ 3 ГОДА - UF_CRM_1708510936813
СВИДЕТЕЛЬСТВО О РОЖДЕНИИ ДЕТЕЙ - UF_CRM_1708510989101
ВЫПИСКА ИЗ ЕГРН НЕДВИЖИМОСТИ - UF_CRM_1708511092399  
ПТС - UF_CRM_1708511164599
СТС - UF_CRM_1708511175692
ПТС СУПРУГА - UF_CRM_1708511204032
СТС СУПРУГА - UF_CRM_1708511215650
ДКП - UF_CRM_1708511237220
ДКП СУПРУГ - UF_CRM_1708511248493
ДРУГОЕ - UF_CRM_1708511269272

         */

        /*
doc_passport_all_pages
doc_scan_inn
doc_snils
doc_marriage_certificate
doc_passport_spouse
doc_snils_spouse
doc_divorce_certificate
doc_ndfl
doc_childrens_birth_certificate
doc_extract_egrn
doc_scan_pts
doc_sts
doc_pts_spouse
doc_sts_spouse
doc_dkp
doc_dkp_spouse
doc_other

         */
        $CONTACT_ID = $dealData['CONTACT_ID'];
        $USER_CREATE_ACCOUNT = $dealData['UF_CRM_1708511654449'];
        $USER_LOGIN = $dealData['UF_CRM_1708511589360'];
        $USER_PASSWORD = $dealData['UF_CRM_1708511607581'];
        $USER_STATUS = $dealData['UF_CRM_1709533755311'] == null ? 0 : $dealData['UF_CRM_1709533755311'];
        $USER_CONTRACT_AMOUNT = $dealData['UF_CRM_1725026451112'] == '' ? 0 : $dealData['UF_CRM_1725026451112'];
        $USER_MESSAGE_FROM_B24 = $dealData['UF_CRM_1708511318200'];
        $USER_LINK_TO_COURT = $dealData['UF_CRM_1708511472339'];
        $USER_LAST_AUTH_DATE = $dealData['UF_CRM_1715524078722'];

        $contactData = $this->serviceBuilder->getCRMScope()->contact()->get($CONTACT_ID)->contact()->getIterator();
        $contactName = $contactData['NAME'];
        $contactSecondName = $contactData['SECOND_NAME'];
        $contactLastName = $contactData['LAST_NAME'];

        $contactFullName = trim(
            ($contactName ?? ' ') .
            ($contactSecondName ?? ' ') .
            ($contactLastName ?? '')
        );
//"NAME" => "новый"
//"SECOND_NAME" => null
//"LAST_NAME" => "иван иванович"

        /*
        "NAME" => "тестовый" - имя
        "SECOND_NAME" => null - отчество
        "LAST_NAME" => "тест тестович" - фамилия
        ["PHONE"][0]["VALUE"]
         */

        $email = '';
        if (isset($contactData["EMAIL"]) && is_array($contactData["EMAIL"]) && isset($contactData["EMAIL"][0]) && is_array($contactData["EMAIL"][0]) && isset($contactData["EMAIL"][0]["VALUE"])) {
            $email = $contactData["EMAIL"][0]["VALUE"];
        }
        // Проверяем наличие записи с таким же id_b24
//        $user = User::firstOrCreate(
//            ['id_b24' => $dealId],
//            [
//                'name' => $contactFullName,
//                'email' => $email,
//                'phone' => $USER_LOGIN,
//                'password' => Hash::make($USER_PASSWORD),
//                'b24_status' => $USER_STATUS ?? 0,
//                'sum_contract' => $USER_CONTRACT_AMOUNT,
//                'is_first_auth' => true,
//                'is_registered_myself' => false,
//                'documents_id' => $b24Documents->id,
//            ]
//        );
        $b24Status = B24Status::where('b24_status_id', $USER_STATUS)->first();
        Storage::put($path, ' - '.$b24Status);

        $user = User::where('id_b24', $dealId);
        if (!$user->exists()) {
            // Записи с таким id_b24 не существует, создаем новую


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
            $b24documentsId->update([
                'passport_all_pages' => $doc_passport_all_pages,
                'scan_inn' => $doc_scan_inn,
                'snils' => $doc_snils,
                'marriage_certificate' => $doc_marriage_certificate,
                'passport_spouse' => $doc_passport_spouse,
                'snils_spouse' => $doc_snils_spouse,
                'divorce_certificate' => $doc_divorce_certificate,
                'ndfl' => $doc_ndfl,
                'childrens_birth_certificate' => $doc_childrens_birth_certificate,
                'extract_egrn' => $doc_extract_egrn,
                'scan_pts' => $doc_scan_pts,
                'sts' => $doc_sts,
                'pts_spouse' => $doc_pts_spouse,
                'sts_spouse' => $doc_sts_spouse,
                'dkp' => $doc_dkp,
                'dkp_spouse' => $doc_dkp_spouse,
                'other' => $doc_other,
            ]);

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

//        $b24Documents = B24Documents::create();
//        $user = User::create([
//            'name' => $contactFullName,
//            'email' => $email,
//            'phone' => $USER_LOGIN,
//            'password' => Hash::make($USER_PASSWORD),
//            'id_b24' => $dealId,
//            'b24_status' => $USER_STATUS ?? 0,
//            'sum_contract' => $USER_CONTRACT_AMOUNT,
//            'is_first_auth' => true,
//            'is_registered_myself' => false,
//            'documents_id' => $b24Documents->id,
//        ]);


//        $CONTACT_ID = $dealData['CONTACT_ID'];
//        $USER_CREATE_ACCOUNT = $dealData['UF_CRM_1708511654449'];
//        $USER_LOGIN = $dealData['UF_CRM_1708511589360'];
//        $USER_PASSWORD = $dealData['UF_CRM_1708511607581'];
//        $USER_STATUS = $dealData['UF_CRM_1709533755311'];
//        $USER_CONTRACT_AMOUNT = $dealData['UF_CRM_1725026451112'];
//        $USER_MESSAGE_FROM_B24 = $dealData['UF_CRM_1708511318200'];
//        $USER_LINK_TO_COURT = $dealData['UF_CRM_1708511318200'];
//        $USER_LAST_AUTH_DATE = $dealData['UF_CRM_1715524078722'];

//USER_CREATE_ACCOUNT
//USER_LOGIN
//USER_PASSWORD
//USER_STATUS
//USER_CONTRACT_AMOUNT
//USER_MESSAGE_FROM_B24
//USER_LINK_TO_COURT
//USER_LAST_AUTH_DATE
//
//
//        UF_CRM_1708511654449 - СОЗДАТЬ ЛК КЛИЕНТУ
//        UF_CRM_1708511589360 - ЛОГИН ЛК КЛИЕНТА
//        UF_CRM_1708511607581 - ПАРОЛЬ ЛК КЛИЕНТА
//        UF_CRM_1709533755311 - СТАТУС ДЛЯ ЛК КЛИЕНТА
//        UF_CRM_1725026451112 - СУММА ДОГОВОРА
//        UF_CRM_1708511318200 - СООБЩЕНИЕ КЛИЕНТУ ОТ КОМПАНИИ
//        UF_CRM_1708511472339 - ССЫЛКА НА ДЕЛО В КАДР. АРБИТР
//        UF_CRM_1715524078722 - Дата последней авторизации (МСК)
//        CONTACT_ID - айди контакта


//        $b24Documents = B24Documents::create();
//
//        //id_b24
//


//        Storage::put($path,
//            $CONTACT_ID.' - '.
//            $USER_CREATE_ACCOUNT.' - '.
//            $USER_LOGIN.' - '.
//            $USER_PASSWORD.' - '.
//            $USER_STATUS.' -- '.
//            $USER_CONTRACT_AMOUNT.' -- '.
//            $USER_MESSAGE_FROM_B24.' - '.
//            $USER_LINK_TO_COURT.' - '.
//            $USER_LAST_AUTH_DATE.' '.' - '.
//            $email);
//        Storage::put($path, $stringData);
//        Storage::put($path, $USER_STATUS .' - '.$email);
        Storage::put($path, ' - '.$USER_CONTRACT_AMOUNT);
        return response()->json(['status' => 'success'], 200);
    }
}
