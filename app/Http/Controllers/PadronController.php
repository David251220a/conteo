<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PadronController extends Controller
{
    public function index()
    {
        return view('padron.index');
    }
}
