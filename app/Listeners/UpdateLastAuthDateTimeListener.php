<?php

namespace App\Listeners;

use App\Events\UpdateLastAuthDateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Bitrix24\SDK\Services\ServiceBuilder;

class UpdateLastAuthDateTimeListener
{
    protected ServiceBuilder $serviceBuilder;

    public function __construct(ServiceBuilder $serviceBuilder)
    {
        $this->serviceBuilder = $serviceBuilder;
    }

    public function handle(UpdateLastAuthDateTime $event): void
    {
        $user = $event->user;
        $userIP = $event->userIP;
        $dateTimeInMSK = Carbon::now('Europe/Moscow')->format('d.m.Y H:i:s');

        if ($user->role !== 'Admin') {
            $b24Id = $user->id_b24;

            $lastAuthDate = DB::table('b24_user_fields')
                ->where('site_field', 'userLastAuthDate')
                ->value('uf_crm_code');

            Log::info('Обновление даты последней авторизации', [
                'user_id' => $user->id,
                'b24_id' => $b24Id,
                'user_last_auth_date' => $lastAuthDate,
                'current_time' => $dateTimeInMSK,
                'user_ip' => $userIP,
            ]);

            if ($b24Id && $lastAuthDate) {
                try {
                    $this->serviceBuilder->getCRMScope()->deal()->update($b24Id, [
                        $lastAuthDate => $dateTimeInMSK,
                    ]);
                    Log::info('Дата последней авторизации успешно обновлена', [
                        'b24_id' => $b24Id,
                        'new_auth_date' => $dateTimeInMSK,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Ошибка при обновлении даты последней авторизации', [
                        'b24_id' => $b24Id,
                        'error_message' => $e->getMessage(),
                    ]);
                }
            } else {
                Log::warning('Не удалось обновить дату последней авторизации, отсутствуют данные', [
                    'b24_id' => $b24Id,
                    'last_auth_date' => $lastAuthDate,
                ]);
            }
        }

        $user->update(['ip_address' => $userIP]);
    }
}
