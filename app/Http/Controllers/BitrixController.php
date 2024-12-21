<?php

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
        $response = $this->serviceBuilder->getCRMScope()->deal()->get(3)->deal();
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

        //$response = $this->serviceBuilder->getCRMScope()->contact()->get(5)->contact();
        /*
        "NAME" => "тестовый" - имя
        "SECOND_NAME" => null - отчество
        "LAST_NAME" => "тест тестович" - фамилия
        ["PHONE"][0]["VALUE"]
         */

        //https://dev.1c-bitrix.ru/api_d7/bitrix/crm/crm_owner_type/identifiers.php
        //для счетов entityTypeId = 31
        $response = $this->serviceBuilder->getCRMScope()->item()->list(
            31,
            [],
            ['contactId' => 7],
            ['*']
//            ['id', 'title', 'opportunity', 'isManualOpportunity', 'currencyId', 'createdTime', 'updatedTime', 'movedTime', 'stageId', 'previousStageId', 'begindate', 'closedate', 'categoryId', 'contactId']
        )->getItems();
        //"categoryId" => 3 ???
        //"stageId" => "DT31_3:P"
        //"opportunity" => 10000
        //"isManualOpportunity" => "Y"
        dump($response);

        $response = $this->serviceBuilder->getCRMScope()
            ->deal()
            ->get(3);

        $deal = $response->deal();

        dump($deal->ID);

        return response()->json($deal->getIterator());
    }
}
