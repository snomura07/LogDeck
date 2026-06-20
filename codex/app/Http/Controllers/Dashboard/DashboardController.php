<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Dashboard\GetDashboardDataAction;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, GetDashboardDataAction $getDashboardDataAction): View
    {
        $filters = $request->validate([
            'system_id' => ['nullable', 'integer', 'exists:systems,id'],
            'level' => ['nullable', 'string', 'in:INFO,WARN,ERROR'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'message' => ['nullable', 'string', 'max:1000'],
            'sort' => ['nullable', 'string', 'in:received_at_asc,received_at_desc'],
        ]);

        $dashboardData = $getDashboardDataAction->execute($filters);

        return view('dashboard.index', [
            'filters' => $filters,
            'logs' => $dashboardData['logs'],
            'systems' => $dashboardData['systems'],
            'summary' => $dashboardData['summary'],
        ]);
    }
}
