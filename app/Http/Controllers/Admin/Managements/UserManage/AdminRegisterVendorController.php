<?php

namespace App\Http\Controllers\Admin\Managements\UserManage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegisterVendorController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $vendors=User::search(request("search"))
                    ->where("role", "vendor")
                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                    ->paginate(request("per_page", 10))
                    ->appends(request()->all());

        return inertia("Admin/Managements/UserManage/RegisterVendors/Index", compact("vendors"));
    }
}
