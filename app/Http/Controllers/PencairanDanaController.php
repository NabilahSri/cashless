<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PencairanDanaController extends Controller
{
    public function index()
    {
        return view('v_page.pencairan_dana.index', ['page' => 'pencairanDana', 'pageName' => 'Pencairan Dana', 'selected' => 'Pencairan Dana']);
    }
}
