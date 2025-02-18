<?php

namespace App\Listeners;

use App\Events\UpdateAuthDataEvent;
use App\Models\B24UserField;
use Bitrix24\SDK\Services\ServiceBuilder;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateAuthDataListener
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
     * Обработка события обновления аутентификационных данных.
     *
     * Метод получает событие UpdateAuthDataEvent и обновляет поля логина и пароля в CRM-системе Bitrix24.
     * Поля логина и пароля определяются по соответствию полей системы с полями CRM.
     *
     * @param UpdateAuthDataEvent $event Событие, содержащее идентификатор сделки и новые данные для логина и пароля.
     *
     * @throws Exception Если происходит ошибка при обновлении данных в CRM.
     */
    public function handle(UpdateAuthDataEvent $event): void
    {
        try {
            $fields = B24UserField::whereIn('site_field', ['userLogin', 'userPassword'])
                                  ->pluck('uf_crm_code', 'site_field')
                                  ->toArray();

            $userLogin = $fields['userLogin'];
            $userPassword = $fields['userPassword'];

            Log::info('Обновление данных пользователя в CRM', [
                'deal_id' => $event->dealId,
                'phone' => $event->phone,
                'user_login' => $userLogin,
            ]);

            $this->serviceBuilder->getCRMScope()->deal()->update(
                $event->dealId,
                [
                    $userLogin => $event->phone,
                    $userPassword => $event->password,
                ]
            );

            Log::info('Данные успешно обновлены в CRM', [
                'deal_id' => $event->dealId,
            ]);
        } catch (Exception $e) {
            Log::error('Ошибка при обновлении данных в CRM', [
                'error_message' => $e->getMessage(),
                'deal_id' => $event->dealId,
            ]);

            throw new Exception("Ошибка при обновлении данных в CRM: " . $e->getMessage());
        }
    }
}
