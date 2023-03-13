<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class AdminCategoryController extends Controller
{
    public function index(): Response
    {
        $categories=Category::paginate(15);

        return inertia("Admin/Category/Index", compact("categories"));
    }

    public function create(): Response
    {
        return inertia("Admin/Category/Create");
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Category $category)
    {
        //
    }

    public function edit(Category $category): Response
    {
        return inertia("Admin/Category/Edit", compact("category"));
    }

    public function update(Request $request, Category $category)
    {
        //
    }


    public function trash(): Response
    {
        return inertia("Admin/Category/Trash");
    }

    public function destroy(Category $category)
    {
        //
    }
}
