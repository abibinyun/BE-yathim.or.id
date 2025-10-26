<?php

namespace App\Http\Controllers\module;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->paginate(5);

        return new CategoryResource(true, 'List Data Category', $category);
    }
}
