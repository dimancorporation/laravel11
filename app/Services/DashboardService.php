<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DashboardService
{
    private ProgressStatusService $progressStatusService;
    private ProgressBarService $progressBarService;
    private InvoiceService $invoiceService;

    public function __construct()
    {
        $this->progressStatusService = app(ProgressStatusService::class);
        $this->progressBarService = app(ProgressBarService::class);
        $this->invoiceService = app(InvoiceService::class);

    }

    /**
     * @throws Exception
     */
    public function getDashboardData(User $user): array
    {
        Log::info('Начало получения данных для пользовательской панели', [
            'user_id' => $user->id,
            'user_email' => $user->email,
        ]);

        try {
            $b24Status = $user->b24Status;
            Log::info('Получен статус, на котором сейчас находится дело', [
                'b24Status' => $b24Status,
            ]);

            $progressImages = $this->progressStatusService->getProgressStatusImages($user->b24_status);
            Log::info('Получены изображения статуса прогресса', [
                'progressImages_count' => count($progressImages),
            ]);

            $progressBarData = $this->progressBarService->getProgressBar($user->b24_status);
            Log::info('Получены данные для прогресс-бара', [
                'progressBarData' => $progressBarData,
            ]);

            $invoices = $this->invoiceService->getUserInvoices($user);
            Log::info('Получены счета пользователя', [
                'invoices_count' => $invoices->count(),
                'total_opportunity' => $invoices->sum('opportunity'),
            ]);

            $alreadyPaid = $invoices->sum('opportunity');

            Log::info('Получены данные об общей суммы оплаты', [
                'alreadyPaid' => $alreadyPaid,
            ]);

            $activeTheme = Session::get('active_theme');
            Log::info('Получена активная тема', [
                'activeTheme' => $activeTheme,
            ]);

            return [
                'user' => $user,
                'b24Status' => $b24Status,
                'progressImages' => $progressImages,
                'progressBarData' => $progressBarData,
                'alreadyPaid' => $alreadyPaid,
                'activeTheme' => $activeTheme,
            ];
        } catch (Exception $e) {
            Log::error('Ошибка при получении данных для пользовательской панели', [
                'user_id' => $user->id,
                'error_message' => $e->getMessage(),
            ]);

            throw new Exception('Ошибка при получении данных: ' . $e->getMessage());
        }
    }
}
