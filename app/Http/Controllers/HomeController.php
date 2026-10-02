<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\Padron;
use App\Models\Referente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $general ;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:rol.index')->only('general_config');
        $this->middleware('permission:rol.index')->only('general_config_post');
        $this->general = General::find(1);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rol = auth()->user()->getRoleNames();

        if($rol->isEmpty()){
           return view('home');
        }

        if($rol[0] <> 'admin'){
           return view('home');
        }

        $local_desde = Local::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->select('id')
        ->min('id');

        $local_hasta = Local::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->select('id')
        ->max('id');


        $data = Padron::with('local')
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->where('voto', 1)
        ->whereBetween('local_id', [$local_desde, $local_hasta])
        ->select('local_id', DB::raw('COUNT(*) as total_votos'))
        ->groupBy('local_id')
        ->get();

        return view('consulta.pollito', compact('data'));

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
        $referente = Referente::find(1);
        $referente->anio = $request->anio;
        $referente->tipo_votacion = $request->tipo_votacion;
        $referente->update();
        return redirect()->route('general_config')->with('message', 'Actualizado con exito.');

    }
}
