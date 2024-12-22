<?php

namespace App\Services;

use Bitrix24\SDK\Services\ServiceBuilder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\B24UserField;

class UpdateCRMService
{
    private ServiceBuilder $serviceBuilder;

    public function __construct($serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function updateDeal(string $fieldName): void
    {
        $crmFieldCode = B24UserField::getLastAuthDateCrmCode($fieldName);

        if ($crmFieldCode) {
            $dateTimeInMSK = Carbon::now('Europe/Moscow')->format('d.m.Y H:i:s');
            $user = Auth::user();
            $b24Id = $user->b24_id;
            $this->serviceBuilder->getCRMScope()->deal()->update($b24Id, [
                $crmFieldCode => $dateTimeInMSK,
            ]);
        }
    }
}
