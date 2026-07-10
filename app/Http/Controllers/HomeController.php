<?php

namespace App\Http\Controllers;

use App\Models\General;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rol.index')->only('general_config');
        $this->middleware('permission:rol.index')->only('general_config_post');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function general_config()
    {
        $data = General::find(1);
        return view('general', compact('data'));
    }

    public function general_config_post(Request $request)
    {
        $request->validate([
            'anio' => 'required',
            'tipo_votacion' => 'required'
        ]);

        $data = General::find(1);
        $data->anio = $request->anio;
        $data->tipo_votacion = $request->tipo_votacion;
        $data->update();
        return redirect()->route('general_config')->with('message', 'Actualizado con exito.');

    }
}
