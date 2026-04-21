<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\Referente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ReferenteController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index(Request $request)
    {
        $search = $request->search;
        if ($request->search) {
            $data = Referente::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->where(function ($query) use ($request) {
                $query->where('documento', $request->search)
                    ->orWhere('referente', 'LIKE', '%' . $request->search . '%');
            })
            ->paginate(50);
        } else {
            $data = Referente::where('anio', $this->general->anio)
            ->where('tipo_votacion', $this->general->tipo_votacion)
            ->paginate(50);
        }

        return view('referente.index', compact('data', 'search'));
    }

    public function create()
    {
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->select('id', 'descripcion')->get();
        $locales->prepend((object)[
            'id' => 0,
            'descripcion' => 'Sin especificar'
        ]);
        return view('referente.create', compact('locales'));
    }

    public function store(Request $request)
    {
        $documento = str_replace(['.', ' '], '', $request->documento);
        $request->merge([
            'documento' => $documento,
        ]);

        $request->validate([
            'documento' => [
                    'required',
                    Rule::unique('referentes', 'documento')
                    ->where(function ($query){
                        return $query->where('anio', $this->general->anio)
                        ->where('tipo_votacion', $this->general->tipo_votacion);
                    }),
                ],
            'nombre' => 'required',
        ]);

        $nombre = mb_strtoupper($request->nombre, 'UTF-8');

        if ($documento == 0) {
            return redirect()->back()->withErrors('El documento no puede ser 0');
        }

        Referente::create([
            'documento' => $documento,
            'referente' => $nombre,
            'celular' => $request->celular,
            'local_id' => $request->local_id,
            'estado_id' => 1,
            'user_id' => auth()->id(),
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
        ]);


        return redirect()->route('referente.index')->with('message', 'Referente creado correctamente.');
    }

    public function edit(Referente $referente)
    {
        $data = $referente;
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->select('id', 'descripcion')->get();
        $locales->prepend((object)[
            'id' => 0,
            'descripcion' => 'Sin especificar'
        ]);
        return view('referente.edit', compact('data','locales'));
    }

    public function update(Referente $referente, Request $request)
    {
        $documento = str_replace(['.', ' '], '', $request->documento);
        $request->merge([
            'documento' => $documento,
        ]);

        $request->validate([
            'documento' => [
                'required',
                Rule::unique('referentes', 'documento')
                ->ignore($referente->id)
                ->where(function ($query) {
                    return $query->where('anio', $this->general->anio)
                    ->where('tipo_votacion', $this->general->tipo_votacion);
                }),
            ],
            'nombre' => 'required',
        ]);

        $nombre = mb_strtoupper($request->nombre, 'UTF-8');

        if ($documento == 0) {
            return redirect()->back()->withErrors('El documento no puede ser 0');
        }

        $referente->update([
            'documento' => $documento,
            'referente' => $nombre,
            'celular' => $request->celular,
            'local_id' => $request->local_id,
            'estado_id' => 1,
            'user_id' => auth()->id(),
            'anio' => $this->general->anio,
            'tipo_votacion' => $this->general->tipo_votacion,
        ]);


        return redirect()->route('referente.index')->with('message', 'Referente editado correctamente.');
    }
}
