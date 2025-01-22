<?php

namespace App\Services;

use App\Models\User;

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

    public function getDashboardData(User $user): array
    {
        $b24Status = $user->b24Status;
        $progressImages = $this->progressStatusService->getProgressStatusImages($user->b24_status);
        $progressBarData = $this->progressBarService->getProgressBar($user->b24_status);
        $invoices = $this->invoiceService->getUserInvoices($user);
        $alreadyPaid = $invoices->sum('opportunity');

        return [
            'user' => $user,
            'b24Status' => $b24Status,
            'progressImages' => $progressImages,
            'progressBarData' => $progressBarData,
            'alreadyPaid' => $alreadyPaid,
        ];
    }
}
