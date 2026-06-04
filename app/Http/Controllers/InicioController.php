<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Padron;
use App\Models\PadronConsulta;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();
        return view('welcome', compact('data'));
    }

    public function adolfo(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(19);
        return view('padron.general', compact('data','inte','con'));
    }

    public function cesar(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(8);
        return view('padron.general', compact('data','inte','con'));
    }

    public function dani(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(9);
        return view('padron.general', compact('data','inte','con'));
    }

    public function giselle(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(10);
        return view('padron.general', compact('data','inte','con'));
    }

    public function roberto(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(11);
        return view('padron.general', compact('data','inte','con'));
    }

    public function esmilse(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(12);
        return view('padron.general', compact('data','inte','con'));
    }

    public function diosnel(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(13);
        return view('padron.general', compact('data','inte','con'));
    }

    public function liza(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(14);
        return view('padron.general', compact('data','inte','con'));
    }

    public function carlos(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(15);
        return view('padron.general', compact('data','inte','con'));
    }

    public function julio(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(16);
        return view('padron.general', compact('data','inte','con'));
    }

    public function joel(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(17);
        return view('padron.general', compact('data','inte','con'));
    }

    public function oliver(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(18);
        return view('padron.general', compact('data','inte','con'));
    }

    public function simulacion(Request  $request)
    {
        $padron_id = 0;
        $back = 'cesar';
        if($request->padron_id){
            $padron_id = $request->padron_id;
        }


        if($request->back){
            $back = $request->back;
        }


        return view('padron.simulacion', compact('padron_id', 'back'));
    }

    public function benito(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(32);
        return view('padron.general', compact('data','inte','con'));
    }


    public function humberto(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(33);
        return view('padron.general', compact('data','inte','con'));
    }

    public function juan(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(34);
        return view('padron.general', compact('data','inte','con'));
    }

    public function gabriela(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(35);
        return view('padron.general', compact('data','inte','con'));
    }

    public function diego(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(36);
        return view('padron.general', compact('data','inte','con'));
    }

    public function miguel(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(37);
        return view('padron.general', compact('data','inte','con'));
    }

    public function espinola(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(38);
        return view('padron.general', compact('data','inte','con'));
    }

    public function ofelia(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(39);
        return view('padron.general', compact('data','inte','con'));
    }

    public function gilberto(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(40);
        return view('padron.general', compact('data','inte','con'));
    }

    public function ernesto(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(41);
        return view('padron.general', compact('data','inte','con'));
    }

    public function maria(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(42);
        return view('padron.general', compact('data','inte','con'));
    }

    public function cuevas(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        $inte = Candidato::find(1);
        $con = Candidato::find(43);
        return view('padron.general', compact('data','inte','con'));
    }

    public function general(Request $request)
    {
        $data = Padron::where('documento', $request->documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();
        $mensaje = '';
        $estado_id = 0;
        if($data){
            PadronConsulta::create([
                'padron_id' => $data->id,
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
                'estado_id' => 1,
                'user_id' => 1
            ]);

            $conteo = PadronConsulta::where('padron_id', $data->id)
            ->where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->orderBy('created_at', 'ASC')
            ->get();

            $data->voto = 1;
            $data->update();

            if ($conteo->count() > 1){
                $estado_id = $conteo->count();
                $primeraConsulta = $conteo->first();
                $mensaje = 'La persona ya fue consultada por primera vez a las: ' .
                $primeraConsulta->created_at->format('H:i:s');
            }

        }

        $inte = Candidato::find(1);
        $con = Candidato::find(10);
        return view('padron.solo', compact('data', 'inte', 'con', 'mensaje', 'estado_id'));
    }



}
