<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $dashboardData = $this->dashboardService->getDashboardData($user);

        return view('dashboard', $dashboardData);
    }
}
