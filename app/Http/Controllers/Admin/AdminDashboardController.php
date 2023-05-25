<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminDashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {

        $totalUsers=User::where([["role","user"],["status","active"]])->count();

        // $totalLastMonthUsers=User::where([["role","user"],["status","active"]])->whereBetween('created_at', [now()->subMonth(), now()])->count();

        $totalVendors=User::where([["role","vendor"],["status","active"]])->count();

        // $totalLastMonthVendors=User::where([["role","vendor"],["status","active"]])->where("created_at")->count();

        $totalOrders=Order::where("status", "delivered")->count();

        $todaySales = Order::where('order_date', date('y-m-d'))->sum('total_amount');

        return inertia("Admin/Dashboard", compact("totalUsers", "totalVendors", "totalOrders", "todaySales"));

    }
}
