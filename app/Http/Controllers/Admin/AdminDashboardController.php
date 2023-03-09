<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $avatarUrl=auth()->user()->avatar ?? Storage::url('avatars/default-avatar-'.auth()->user()->id.'.png');

        return inertia("Admin/Dashboard", compact("avatarUrl"));
    }
}
