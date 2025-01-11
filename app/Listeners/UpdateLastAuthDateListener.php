<?php

namespace App\Listeners;

use App\Events\UpdateLastAuthDate;
use App\Models\B24UserField;
use Bitrix24\SDK\Core\Exceptions\BaseException;
use Bitrix24\SDK\Core\Exceptions\TransportException;
use Bitrix24\SDK\Services\ServiceBuilder;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class UpdateLastAuthDateListener
{
    protected ServiceBuilder $serviceBuilder;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->serviceBuilder = app(ServiceBuilder::class);
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateLastAuthDate $event): void
    {
        $dateTimeInMSK = Carbon::now('Europe/Moscow')->format('d.m.Y H:i:s');
        $user = $event->user;

        if ($user->role !== 'Admin') {
            $b24Id = $user->id_b24;

            $lastAuthDate = B24UserField::getUfCrmCode('user_last_auth_date');

            dump($lastAuthDate);
            dump($b24Id && $lastAuthDate);

            if ($b24Id && $lastAuthDate) {
                try {
                    $this->serviceBuilder->getCRMScope()->deal()->update($b24Id, [
                        $lastAuthDate => $dateTimeInMSK,
                    ]);
                } catch (TransportException|BaseException $e) {
                    dump($e);
                }
            }
        }
    }
}
