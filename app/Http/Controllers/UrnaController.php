<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrnaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sondeo.index')->only('index');
        $this->middleware('permission:sondeo.show')->only('show');
    }

    public function index()
    {
        return view('sondeo.index');
    }

    public function show()
    {
        return view('sondeo.show');
    }
}
