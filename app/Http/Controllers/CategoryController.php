<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function allCategories()
    {
        $cats = Category::all();
        return response()->json(['success' => true, 'data' => $cats], Response::HTTP_OK);
    }
}
