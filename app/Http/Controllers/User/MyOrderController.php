<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class MyOrderController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $orders=Order::where("user_id", auth()->user()->id)->orderBy("id", "desc")->get();

        return inertia("User/MyOrders/Index", compact("orders"));
    }
}
