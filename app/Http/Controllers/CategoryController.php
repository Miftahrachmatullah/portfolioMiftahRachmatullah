<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => \App\Models\Category::orderBy('name')->get()
        ]);
    }
}
