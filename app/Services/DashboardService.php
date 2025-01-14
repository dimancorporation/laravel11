<?php

namespace App\Services;

use App\Models\User;

class DashboardService
{
    private ProgressStatusService $progressStatusService;
    private ProgressBarService $progressBarService;

    public function __construct(ProgressStatusService $progressStatusService, ProgressBarService $progressBarService)
    {
        $this->progressStatusService = $progressStatusService;
        $this->progressBarService = $progressBarService;
    }

    public function getDashboardData(User $user): array
    {
        $b24Status = $user->b24Status;
        $progressImages = $this->progressStatusService->getProgressStatusImages($user->b24_status);
        $progressBarData = $this->progressBarService->getProgressBar($user->b24_status);

        return [
            'user' => $user,
            'b24Status' => $b24Status,
            'progressImages' => $progressImages,
            'progressBarData' => $progressBarData,
        ];
    }
}
