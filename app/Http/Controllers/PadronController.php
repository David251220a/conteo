<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Padron;
use App\Models\Referente;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class PadronController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
        $this->middleware('permission:padron.index')->only('index');
        $this->middleware('permission:padron.todos')->only('todos');
    }

    public function index()
    {
        return view('padron.index');
    }

    public function todos(Request $request)
    {
        $moviles = Vehiculo::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();


        $punteros = Referente::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();

        if($request->search){
            $data = Padron::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where('nombre', 'LIKE', '%' . $request->search . '%')
            ->orWhere('apellido', 'LIKE', '%' . $request->search . '%')
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->orWhere('documento', 'LIKE', '%' . $request->search . '%')
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->paginate(50);
        }else{
            $data = Padron::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->paginate(50);
        }
        return view('padron.todos', compact('data','moviles','punteros'));
    }

    public function asignar(Request $request)
    {
        $data = Padron::find($request->padron_id_aux);
        $data->vehiculo_id = $request->aux_movil_id;
        $data->update();

        return redirect()->route('padron.todos',['search' => $request->search_aux]);
    }

    public function asignar_refe(Request $request)
    {
        $data = Padron::find($request->padron_id_aux_refe);
        $data->referente_id = $request->aux_refe_id;
        $data->update();

        return redirect()->route('padron.todos',['search' => $request->search_aux_refe]);
    }
}
