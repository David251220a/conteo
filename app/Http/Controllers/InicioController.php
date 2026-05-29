<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Padron;
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

}
