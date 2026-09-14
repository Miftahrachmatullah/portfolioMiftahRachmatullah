<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => \App\Models\Technology::orderBy('name')->get()
        ]);
    }
}
