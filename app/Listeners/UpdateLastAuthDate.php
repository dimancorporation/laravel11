<?php

namespace App\Listeners;

use App\Models\B24UserField;
use Bitrix24\SDK\Services\ServiceBuilder;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastAuthDate
{
    protected ServiceBuilder $serviceBuilder;

    /**
     * Create the event listener.
     */
    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $dateTimeInMSK = Carbon::now('Europe/Moscow')->format('d.m.Y H:i:s');
        $user = $event->user;

        if ($user->role !== 'Admin') {
            $b24Id = $user->id_b24;

            $lastAuthDate = B24UserField::getUfCrmCode('USER_LAST_AUTH_DATE');

            if ($b24Id && $lastAuthDate) {
                $this->serviceBuilder->getCRMScope()->deal()->update($b24Id, [
                    $lastAuthDate => $dateTimeInMSK,
                ]);
            }
        }
    }
}
