<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\ProgressStatusService;

class DashboardController extends Controller
{
    private ProgressStatusService $progressStatusService;

    public function __construct(ProgressStatusService $progressStatusService)
    {
        $this->progressStatusService = $progressStatusService;
    }
    public function index(Request $request): View
    {
        $user = $request->user();
        $b24Status = $user->b24Status;
        $progressImages = $this->progressStatusService->getProgressStatusImages($user->b24_status);
        return view('dashboard', compact('user', 'b24Status', 'progressImages'));
    }
}
