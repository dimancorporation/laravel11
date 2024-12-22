<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\ProgressStatusService;
use App\Services\ProgressBarService;

class DashboardController extends Controller
{
    private ProgressStatusService $progressStatusService;
    private ProgressBarService $progressBarService;

    public function __construct(ProgressStatusService $progressStatusService, ProgressBarService $progressBarService)
    {
        $this->progressStatusService = $progressStatusService;
        $this->progressBarService = $progressBarService;
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $b24Status = $user->b24Status;
        $progressImages = $this->progressStatusService->getProgressStatusImages($user->b24_status);
        $progressBarData = $this->progressBarService->getProgressBar($user->b24_status);
        return view('dashboard', compact('user', 'b24Status', 'progressImages', 'progressBarData'));
    }
}
