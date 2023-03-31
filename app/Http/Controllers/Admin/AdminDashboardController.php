<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Inertia\ResponseFactory;

class AdminDashboardController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia("Admin/Dashboard");
    }
}
