<?php

namespace App\Http\Controllers;

use Bitrix24\SDK\Services\ServiceBuilder;
use Illuminate\Http\JsonResponse;

class BitrixController extends Controller
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function getUserList(): JsonResponse
    {
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

        /** обновить сделку
         * $response = $this->serviceBuilder->getCRMScope()->deal()->update(3, [
         * 'TITLE' => 'NEW DEAL NEW TITLE'
         * ]);
         */

        /** создать сделку
         * $response = $this->serviceBuilder->getCRMScope()->deal()->add([
         * 'TITLE' => 'New Deal',
         * 'TYPE_ID' => 'SALE',
         * 'STAGE_ID' => 'NEW'
         * ])->getId();
         */

        /** получение значений выпадашки "СТАТУС ДЛЯ ЛК КЛИЕНТА" - UF_CRM_1709533755311
         * $response = $this->serviceBuilder->getCRMScope()->deal()->get(11)->deal()->getUserfieldByFieldName('UF_CRM_1709533755311');
         * $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->list([], ['FIELD_NAME' => 'UF_CRM_1709533755311'])->getUserfields();
         * $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->get(1137);
         * $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->get(1137)->userfieldItem()->LIST;
         * $response = $this->serviceBuilder->getCRMScope()->dealUserfield()->list([], ['FIELD_NAME' => 'UF_CRM_1709533755311'])->getUserfields();
         */

        /** получение всех статусов сделок
         * $response = $this->serviceBuilder->getCRMScope()->dealCategoryStage()->list(0)->getDealCategoryStages();
         */

        /** получение сделки по айди, фильтруем по contactId, вместо списка полей можно использовать ['*']
         * $response = $this->serviceBuilder->getCRMScope()->item()->list(2,
         * [],
         * ['contactId' => 11],
         * ['id', 'title', 'opportunity', 'isManualOpportunity', 'currencyId', 'createdTime', 'updatedTime', 'movedTime', 'stageId', 'previousStageId', 'begindate', 'closedate', 'categoryId', 'contactId']
         * )->getItems();
         */

        /** получение сделки по айди
         * $response = $this->serviceBuilder->getCRMScope()->deal()->get(11)->deal();
         */

        /** получение данных контакта (фио, тел, email) по айди
         * "NAME" => "тестовый" - имя
         * "SECOND_NAME" => null - отчество
         * "LAST_NAME" => "тест тестович" - фамилия
         * ["PHONE"][0]["VALUE"]
         * ["EMAIL"][0]["VALUE"]
         * $response = $this->serviceBuilder->getCRMScope()->contact()->get(11)->contact();
         */

        /** получение списка счетов по айди контакта, вместо списка полей можно использовать ['*']
         * https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
         * для счетов entityTypeId = 31
         * $response = $this->serviceBuilder->getCRMScope()->item()->list(
         * 31,
         * [],
         * ['contactId' => 7],
         * ['id', 'title', 'opportunity', 'isManualOpportunity', 'currencyId', 'createdTime', 'updatedTime', 'movedTime', 'stageId', 'previousStageId', 'begindate', 'closedate', 'categoryId', 'contactId']
         * )->getItems();
         */

        /** получение списка счетов по айди контакта, вместо списка полей можно использовать ['*']
         * https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
         * для счетов entityTypeId = 31
         */

        /** создание счета по айди контакта
         * $response = $this->serviceBuilder->getCRMScope()->item()->add(31, [
         * 'title' => 'New Payment 3',
         * 'contactId' => 23,
         * 'currencyId' => 'RUB',
         * 'opportunity' => 30303,
         * "opened" => "N",
         * "stageId" => "DT31_3:N",
         * 'ufCrm_SMART_INVOICE_1712111561782' => 271,
         * "parentId2" => 23,
         * ]);
         * dump($response);
         */

        $bitrixInvoiceEntityTypeId = env('BITRIX_INVOICE_ENTITY_TYPE_ID');
        //stageId -> DT31_2:P - завершенный платеж
        //stageId -> DT31_2:N
        /* обновление данных счета битрикс24 */
        $invoiceIdForUpdate = 2;
        $response = $this->serviceBuilder->getCRMScope()->item()->update($bitrixInvoiceEntityTypeId, $invoiceIdForUpdate, [
            'stageId' => 'DT31_2:P',
            'opportunity' => 1001,
            'title' => 'Новый платеж огого',
        ]);
        dump($response);

//        $response = $this->serviceBuilder->getCRMScope()->item()->add(31, [
//            'title' => 'New Payment 33',
//            'contactId' => 23,
//            'currencyId' => 'RUB',
//            'opportunity' => 40404,
//            "opened" => "N",
//            "stageId" => "DT31_3:N",
//            'ufCrm_SMART_INVOICE_1712111561782' => 271,
//            "parentId2" => 23,
//        ]);
//        dump($response);

//        ufCrm_SMART_INVOICE_1735207439444 - доп поле для счетов
//        https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
//        для счетов entityTypeId = 31
         $response = $this->serviceBuilder->getCRMScope()->item()->list(
             $bitrixInvoiceEntityTypeId,
             [],
             ['id' => 4],
             ['*']
         )->getItems();
        dump($response);

//        $response = $this->serviceBuilder->getCRMScope()
//            ->deal()
//            ->get(3);
//        $deal = $response->deal();
//        dump($deal->ID);
        return response()->json($response);
    }
}
