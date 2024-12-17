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
        $response = $this->serviceBuilder->getUserScope();

        dump($response);
    }
}
