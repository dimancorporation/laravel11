<?php
/*
b24_doc_fields

id - autoincremet
site_field - varchar255
b24_field - varchar255
uf_crm_code - varchar255
created_at - timestamp
updated_at - timestamp
 */

/*
b24_documents

id - autoincremet
passport_all_pages - true/false, default - false
pts - true/false, default - false
scan_inn - true/false, default - false
snils - true/false, default - false
marriage_certificate - true/false, default - false
passport_spouse - true/false, default - false
snils_spouse - true/false, default - false
divorce_certificate - true/false, default - false
ndfl - true/false, default - false
childrens_birth_certificate - true/false, default - false
extract_egrn - true/false, default - false
scan_pts - true/false, default - false
sts - true/false, default - false
pts_spouse - true/false, default - false
sts_spouse - true/false, default - false
dkp - true/false, default - false
dkp_spouse - true/false, default - false
other - true/false, default - false
created_at - timestamp
updated_at - timestamp
 */

/*
b24_statuses

b24_status_id,name - 0,Не активно
b24_status_id,name - 95,Знакомство
b24_status_id,name - 97,Правовой анализ
b24_status_id,name - 99,Запросы БКИ
b24_status_id,name - 101,Поиск имущества и сделок
b24_status_id,name - 103,Реестр документов
b24_status_id,name - 105,Сбор документов
b24_status_id,name - 107,Готов на подачу в АС
b24_status_id,name - 109,Введение процедуры БФЛ
b24_status_id,name - 111,Судебный процесс
b24_status_id,name - 113,Завершение суда
b24_status_id,name - 115,Списание долга
b24_status_id,name - 117,Должник

id - autoincrement
b24_status_id - bigint
name - varchar255
created_at - timestamp
updated_at - timestamp
 */

/*
b24_user_fields

id - autoincrement
site_field - varchar255
b24_field - varchar255
uf_crm_code - varchar255
created_at - timestamp
updated_at - timestamp
 */

/*
users

id - autoincrement
name - varchar255
email - varchar255
email_verified_at - timestamp
password - varchar255
remember_token - varchar100
phone - varchar255
role - роли admin/user/blocked
id_b24 - bigint -> b24_id
message_from_b24
is_first_auth - true/false, default - true
is_registered_myself - true/false, default - false
b24_status - smallint
link_to_court - varchar255
sum_contract - numeric9
already_paid - bigint
documents_id - bigint
created_at - timestamp
updated_at - timestamp

 */



/*
0,Не активно,,
95,Знакомство,,
97,Правовой анализ,,
99,Запросы БКИ,,
101,Поиск имущества и сделок,,
103,Реестр документов,,
105,Сбор документов,,
107,Готов на подачу в АС,,
109,Введение процедуры БФЛ,,
111,Судебный процесс,,
113,Завершение суда,,
115,Списание долга,,
117,Должник,,

 */
namespace App\Http\Controllers;

use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BitrixController extends Controller
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function getUserList(): JsonResponse
    {
//        $response = $this->serviceBuilder->getCRMScope()->deal()->update(3, [
//            'TITLE' => 'NEW DEAL NEW TITLE'
//        ]);
//        print_r($response);
//
//        $response = $this->serviceBuilder->getCRMScope()->deal()->add([
//            'TITLE' => 'New Deal',
//            'TYPE_ID' => 'SALE',
//            'STAGE_ID' => 'NEW'
//        ])->getId();
//        print_r($response);
//

        //818
//        $response = $this->serviceBuilder->getCRMScope()->deal()->get(11)->deal()->getUserfieldByFieldName('UF_CRM_1709533755311'); //получает ID статуса лк клиента
//        $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->list([], ['FIELD_NAME' => 'UF_CRM_1709533755311'])->getUserfields();
        $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->get(1137);
//        $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->get(1137)->userfieldItem()->LIST;
//        $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->list([], ['FIELD_NAME' => 'UF_CRM_1709533755311'])->getUserfields();
        dump($response);


//        $response = $this->serviceBuilder
//            ->getCRMScope()->dealCategoryStage()->list(0)->getDealCategoryStages();

//        $response = $this->serviceBuilder->getCRMScope()->userfield()->enumerationFields()->getFieldsDescription();
//        dump($response);


//        $response = $this->serviceBuilder
//            ->getCRMScope()
//            ->userfield()
//            ->enumerationFields();
//
//        $fields = $response->getFieldsDescription();
//        dump($fields);

        //crm.status.list
//        $response = $this->serviceBuilder->getCRMScope()->item()->list(2,
//            [],
//            ['contactId' => 11],
//            ['*']
////            ['id', 'title', 'opportunity', 'isManualOpportunity', 'currencyId', 'createdTime', 'updatedTime', 'movedTime', 'stageId', 'previousStageId', 'begindate', 'closedate', 'categoryId', 'contactId']
//        )->getItems();
//        dump($response);


//        $response = $this->serviceBuilder->getCRMScope()->deal()->get(11)->deal();
//        dump($response->getIterator());
        /*
        UF_CRM_1708511654449 - СОЗДАТЬ ЛК КЛИЕНТУ
        UF_CRM_1708511589360 - ЛОГИН ЛК КЛИЕНТА
        UF_CRM_1708511607581 - ПАРОЛЬ ЛК КЛИЕНТА
        UF_CRM_1709533755311 - СТАТУС ДЛЯ ЛК КЛИЕНТА
        UF_CRM_1725026451112 - СУММА ДОГОВОРА
        UF_CRM_1708511318200 - СООБЩЕНИЕ КЛИЕНТУ ОТ КОМПАНИИ
        UF_CRM_1708511472339 - ССЫЛКА НА ДЕЛО В КАДР. АРБИТР
        UF_CRM_1715524078722 - Дата последней авторизации (МСК)
        CONTACT_ID - айди контакта
         */

//        $response = $this->serviceBuilder->getCRMScope()->contact()->get(11)->contact();
//        dump($response);
        /*
        "NAME" => "тестовый" - имя
        "SECOND_NAME" => null - отчество
        "LAST_NAME" => "тест тестович" - фамилия
        ["PHONE"][0]["VALUE"]
         */

        //https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
        //для счетов entityTypeId = 31
//        $response = $this->serviceBuilder->getCRMScope()->item()->list(
//            31,
//            [],
//            ['contactId' => 7],
//            ['*']
////            ['id', 'title', 'opportunity', 'isManualOpportunity', 'currencyId', 'createdTime', 'updatedTime', 'movedTime', 'stageId', 'previousStageId', 'begindate', 'closedate', 'categoryId', 'contactId']
//        )->getItems();
        //"categoryId" => 3 ???
        //"stageId" => "DT31_3:P"
        //"opportunity" => 10000
        //"isManualOpportunity" => "Y"
//        dump($response);

//        $response = $this->serviceBuilder->getCRMScope()
//            ->deal()
//            ->get(3);
//
//        $deal = $response->deal();
//
//        dump($deal->ID);

        return response()->json($response);
    }
}
