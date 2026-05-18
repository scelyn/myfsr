<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\OrderItem;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(DashboardService $dashboardService)
    {
        $data = $dashboardService->getDashboardData();
        
        return view('dashboard', $data);
    }
}
