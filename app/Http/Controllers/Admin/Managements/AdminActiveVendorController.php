<?php

namespace App\Http\Controllers\Admin\Managements;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminActiveVendorController extends Controller
{
    public function index()
    {
        return inertia("Admin/Managements/Vendors/ActiveVendors/Index");
    }
}
