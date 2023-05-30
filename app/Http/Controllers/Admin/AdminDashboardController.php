<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminDashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();

        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $today = Carbon::today()->format('Y-m-d');

        $currentYear=Carbon::now()->format("Y");
        $lastYear=Carbon::now()->subYear()->format("Y");

        $totalUsers=User::where([["role","user"],["status","active"]])->count();
        $lastMonthUserCount = User::where([["role", "user"], ["status","active"]])->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $thisMonthUserCount = User::where([["role", "user"], ["status","active"]])->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();
        $userCountDifference = $thisMonthUserCount - $lastMonthUserCount;
        $percentageChangeForUser =$lastMonthUserCount ? ($userCountDifference / $lastMonthUserCount) * 100 : 0;
        $percentageChangeForUser = max(min($percentageChangeForUser, 100), -100);

        $totalVendors=User::where([["role","vendor"],["status","active"]])->count();
        $lastMonthVendorCount = User::where([["role", "vendor"],["status","active"]])->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $thisMonthVendorCount = User::where([["role", "vendor"],["status","active"]])->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();
        $vendorCountDifference = $thisMonthVendorCount - $lastMonthVendorCount;
        $percentageChangeForVendor =$lastMonthVendorCount ? ($vendorCountDifference / $lastMonthVendorCount) * 100 : 0;
        $percentageChangeForVendor = max(min($percentageChangeForVendor, 100), -100);

        $totalOrders=Order::count();
        $lastMonthOrderCount = Order::whereNull("return_date")->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $thisMonthOrderCount = Order::whereNull("return_date")->whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();
        $orderCountDifference = $thisMonthOrderCount - $lastMonthOrderCount;
        $percentageChangeForOrder =$lastMonthOrderCount ? ($orderCountDifference / $lastMonthOrderCount) * 100 : 0;
        $percentageChangeForOrder = max(min($percentageChangeForOrder, 100), -100);

        $yesterdaySales = Order::whereNull("return_date")->whereDate('created_at', $yesterday)->sum('total_amount');
        $todaySales = Order::whereNull("return_date")->whereDate('created_at', $today)->sum('total_amount');
        $salesDifference = $todaySales - $yesterdaySales;
        $percentageChangeForSales =$yesterdaySales ? ($salesDifference / $yesterdaySales) * 100 : 0;
        $percentageChangeForSales = max(min($percentageChangeForSales, 100), -100);

        $thisYearMonthlySales=Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_amount')
                                   ->groupBy('month')
                                   ->whereYear("created_at", $currentYear)
                                   ->whereNull("return_date")
                                   ->orderBy("month", "asc")
                                   ->get();
        $thisYearMonthlySaleLables = $thisYearMonthlySales->pluck('month');
        $thisYearMonthlySaleData = $thisYearMonthlySales->pluck('total_amount');

        $lastYearMonthlySales=Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_amount')
                                   ->groupBy('month')
                                   ->whereYear("created_at", $lastYear)
                                   ->whereNull("return_date")
                                   ->orderBy("month", "asc")
                                   ->get();
        $lastYearMonthlySaleLables = $lastYearMonthlySales->pluck('month');
        $lastYearMonthlySaleData = $lastYearMonthlySales->pluck('total_amount');

        $thisYearMonthlyOrder = Order::selectRaw('MONTH(created_at) as month,COUNT(*) as total_orders')
                                     ->whereYear('created_at', $currentYear)
                                     ->whereNull("return_date")
                                     ->groupBy('month')
                                     ->orderBy('month', 'asc')
                                     ->get();
        $thisYearMonthlyOrderLables = $thisYearMonthlyOrder->pluck('month');
        $thisYearMonthlyOrderData = $thisYearMonthlyOrder->pluck('total_orders');

        $lastYearMonthlyOrder = Order::selectRaw('MONTH(created_at) as month,COUNT(*) as total_orders')
                                         ->whereYear('created_at', $lastYear)
                                         ->whereNull("return_date")
                                         ->groupBy('month')
                                         ->orderBy('month', 'asc')
                                         ->get();
        $lastYearMonthlyOrderLables = $lastYearMonthlyOrder->pluck('month');
        $lastYearMonthlyOrderData = $lastYearMonthlyOrder->pluck('total_orders');

        $thisYearMonthlyUserRegister = User::selectRaw('MONTH(created_at) as month,COUNT(*) as total_register')
                                         ->whereYear('created_at', $currentYear)
                                         ->where("role", "user")
                                         ->where("status", "active")
                                         ->groupBy('month')
                                         ->orderBy('month', 'asc')
                                         ->get();
        $thisYearMonthlyUserRegisterLables = $thisYearMonthlyUserRegister->pluck('month');
        $thisYearMonthlyUserRegisterData = $thisYearMonthlyUserRegister->pluck('total_register');

        $lastYearMonthlyUserRegister = User::selectRaw('MONTH(created_at) as month,COUNT(*) as total_register')
                                         ->whereYear('created_at', $lastYear)
                                         ->where("role", "user")
                                         ->where("status", "active")
                                         ->groupBy('month')
                                         ->orderBy('month', 'asc')
                                         ->get();
        $lastYearMonthlyUserRegisterLables = $lastYearMonthlyUserRegister->pluck('month');
        $lastYearMonthlyUserRegisterData = $lastYearMonthlyUserRegister->pluck('total_register');

        $thisYearMonthlyVendorRegister = User::selectRaw('MONTH(created_at) as month,COUNT(*) as total_register')
                                             ->whereYear('created_at', $currentYear)
                                             ->where("role", "vendor")
                                             ->where("status", "active")
                                             ->groupBy('month')
                                             ->orderBy('month', 'asc')
                                             ->get();
        $thisYearMonthlyVendorRegisterLables = $thisYearMonthlyVendorRegister->pluck('month');
        $thisYearMonthlyVendorRegisterData = $thisYearMonthlyVendorRegister->pluck('total_register');

        $lastYearMonthlyVendorRegister = User::selectRaw('MONTH(created_at) as month,COUNT(*) as total_register')
                                             ->whereYear('created_at', $lastYear)
                                             ->where("role", "vendor")
                                             ->where("status", "active")
                                             ->groupBy('month')
                                             ->orderBy('month', 'asc')
                                             ->get();
        $lastYearMonthlyVendorRegisterLables = $lastYearMonthlyVendorRegister->pluck('month');
        $lastYearMonthlyVendorRegisterData = $lastYearMonthlyVendorRegister->pluck('total_register');

        return inertia("Admin/Dashboard", compact(
            "totalUsers",
            "totalVendors",
            "totalOrders",
            "todaySales",
            "percentageChangeForUser",
            "percentageChangeForVendor",
            "percentageChangeForOrder",
            "percentageChangeForSales",
            "thisYearMonthlySaleLables",
            "thisYearMonthlySaleData",
            "lastYearMonthlySaleLables",
            "lastYearMonthlySaleData",
            "thisYearMonthlyOrderLables",
            "thisYearMonthlyOrderData",
            "lastYearMonthlyOrderLables",
            "lastYearMonthlyOrderData",
            "thisYearMonthlyUserRegisterLables",
            "thisYearMonthlyUserRegisterData",
            "lastYearMonthlyUserRegisterLables",
            "lastYearMonthlyUserRegisterData",
            "thisYearMonthlyVendorRegisterLables",
            "thisYearMonthlyVendorRegisterData",
            "lastYearMonthlyVendorRegisterLables",
            "lastYearMonthlyVendorRegisterData",
        ));

    }
}
