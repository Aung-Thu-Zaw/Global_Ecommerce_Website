<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminDashboardController extends Controller
{
    public function index(): Response
    {
        return inertia("Admin/Dashboard");
    }
}
