<?php

namespace App\Http\Controllers\Admin\Managements\UserManage;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminRegisterUserController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        $users=User::search(request("search"))
                    ->where("role", "user")
                    ->orderBy(request("sort", "id"), request("direction", "desc"))
                    ->paginate(request("per_page", 10))
                    ->appends(request()->all());

        return inertia("Admin/Managements/UserManage/RegisterUsers/Index", compact("users"));
    }
}
