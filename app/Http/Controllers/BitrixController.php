<?php

namespace App\Http\Controllers;

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
//        $response = $this->serviceBuilder->getCRMScope()->deal()->get(3);
//        $response = $this->serviceBuilder->getCRMScope()->core->call('crm.deal.get', ['ID' => 3]);
//        dd([
//            'данные по сделке' => $response,
//        ]);

        $response = $this->serviceBuilder->getCRMScope();

        return response()->json($response->company());
    }
}
