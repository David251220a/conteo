<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Local;
use App\Models\Referente;
use App\Models\Vehiculo;
use App\Models\VehiculoLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    public $general;

    public function __construct()
    {
        $this->general = General::find(1);
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $query = Vehiculo::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('documento', $request->search)
                ->orWhere('nombre', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($request->filled('local_id')) {
            $query->whereHas('vehiculo_local', function ($q) use ($request) {
                $q->where('local_id', $request->local_id);
            });
        }

        $cantidadTotal = (clone $query)->count();
        $montoTotal = (clone $query)->sum('monto');
        $data = $query->paginate(50)->appends($request->query());

        $locales = Local::where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->where('estado_id', 1)
        ->get();

        return view('vehiculo.index', compact('data', 'search', 'cantidadTotal', 'montoTotal', 'locales'));
    }

    public function create()
    {
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        $referentes =  Referente::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        return view('vehiculo.create', compact('locales', 'referentes'));
    }

    public function store(Request $request)
    {
        $documento = str_replace(['.', ' '], '', $request->documento);
        $monto = str_replace(['.', ' '], '', $request->monto);
        $nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $request->merge([
            'documento' => $documento,
            'nombre' => $nombre,
        ]);

        $request->validate([
            'documento' => [
                'required',
                Rule::unique('vehiculos', 'documento')
                ->where(function ($query) {
                    return $query->where('anio', $this->general->anio)
                    ->where('tipo_votacion', $this->general->tipo_votacion);
                }),
            ],
            'nombre' => 'required',
        ]);

        if ($documento == 0) {
            return redirect()->back()->withErrors('El documento no puede ser 0');
        }

        try {

            DB::beginTransaction();

            $vehiculo = Vehiculo::create([
                'documento' => $documento,
                'nombre' => $nombre,
                'chapa' => $request->chapa,
                'monto' => $monto,
                'referente_id' => $request->referente_id,
                'estado_id' => 1,
                'user_id' => auth()->id(),
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
            ]);

            VehiculoLocal::create([
                'vehiculo_id' => $vehiculo->id,
                'local_id' => $request->local_id,
                'estado_id' => 1,
                'user_id' => auth()->id(),
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
            ]);

            DB::commit();
            return redirect()->route('vehiculo.index')->with('message', 'Vehiculo creado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Ocurrió un error al guardar el vehículo.');
        }
    }

    public function edit(Vehiculo $vehiculo)
    {
        $locales = Local::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        $referentes =  Referente::where('estado_id', 1)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->get();

        $data = $vehiculo;

        return view('vehiculo.edit', compact('locales', 'referentes', 'data'));
    }

    public function update(Vehiculo $vehiculo, Request $request)
    {

        $documento = str_replace(['.', ' '], '', $request->documento);
        $monto = str_replace(['.', ' '], '', $request->monto);
        $nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $request->merge([
            'documento' => $documento,
            'nombre' => $nombre,
        ]);

        $request->validate([
            'documento' => [
                'required',
                Rule::unique('vehiculos', 'documento')
                ->ignore($vehiculo->id)
                ->where(function ($query) {
                    return $query->where('anio', $this->general->anio)
                    ->where('tipo_votacion', $this->general->tipo_votacion);
                }),
            ],
            'nombre' => 'required',
        ]);

        if ($documento == 0) {
            return redirect()->back()->withErrors('El documento no puede ser 0');
        }

        try {

            DB::beginTransaction();

            $vehiculo->update([
                'documento' => $documento,
                'nombre' => $nombre,
                'chapa' => $request->chapa,
                'monto' => $monto,
                'referente_id' => $request->referente_id,
                'estado_id' => $request->estado_id,
                'user_id' => auth()->id(),
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
            ]);

            DB::commit();
            return redirect()->route('vehiculo.index')->with('message', 'Vehiculo editado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Ocurrió un error al guardar el vehículo.');
        }
    }

    public function agregar_local(Vehiculo $vehiculo, Request $request)
    {
        $existe = VehiculoLocal::where('vehiculo_id', $vehiculo->id)
        ->where('local_id', $request->agregar_local_id)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();

        if (!$existe){
            VehiculoLocal::create([
                'vehiculo_id' => $vehiculo->id,
                'local_id' => $request->agregar_local_id,
                'estado_id' => 1,
                'user_id' => auth()->id(),
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
            ]);
        }else{
            $existe->update([
                'estado_id' => 1,
                'user_id' => auth()->id()
            ]);
        }

        return redirect()->route('vehiculo.edit', $vehiculo)->with('message', 'Local agregado con exito.');
    }

    public function eliminar_local(VehiculoLocal $VehiculoLocal, Request $request)
    {
        $VehiculoLocal->update([
            'estado_id' => 2,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('vehiculo.edit', $VehiculoLocal->vehiculo_id)->with('message', 'Local elimnado con exito.');
    }

    public function pagar(Vehiculo $vehiculo)
    {
        $vehiculo->update([
            'pagado' => 1,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('vehiculo.index')->with('message', 'La persona ' . $vehiculo->nombre . ' ya le fue abonado su pago');
    }
}
