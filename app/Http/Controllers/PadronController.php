<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\General;
use App\Models\Padron;
use App\Models\PadronConsulta;
use App\Models\Referente;
use App\Models\User;
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

    public function index(Request $request)
    {
        $documento = str_replace('.', '', $request->documento);

        $data = Padron::where('documento', $documento)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->first();
        $inte = Candidato::find(59);
        $local = auth()->user()->local;
        $id = 0;
        $corresponde = 0;

        if ($data && $data->local_id == $local->id){
            PadronConsulta::create([
                'padron_id' => $data->id,
                'anio' => $this->general->anio,
                'tipo_votacion' => $this->general->tipo_votacion,
                'estado_id' => 1,
                'user_id' => auth()->id()
            ]);
            Padron::where('id', $data->id)->update(['voto' => 1]);
            $id = $data->id;
            $estilo = 'text-success text-bold';
            $corresponde = 1;
        }else{
            $estilo = 'text-danger text-bold';
        }

        $mensaje = 'No corresponde al local vinculado: ' . $local->descripcion;
        $mensaje_alerta = 'No corresponde al local vinculado: ' . $local->descripcion;

        $conteo = PadronConsulta::where('padron_id', $id)
        ->where('anio', $this->general->anio)
        ->where('tipo_votacion', $this->general->tipo_votacion)
        ->orderBy('created_at', 'ASC')
        ->get();

        if ($conteo->count() === 1){
            $primeraConsulta = $conteo->first();
            $mensaje_alerta = 'Primera vez consultado. Mesa: ' . $data->mesa . ' y Orden: ' . $data->orden;
            $mensaje = 'Consultado';
            $estilo = 'text-success text-bold';
        }

        if ($conteo->count() > 1){
            $primeraConsulta = $conteo->first();
            $usuario_consulta = User::find($primeraConsulta->user_id);
            $mensaje_alerta = 'La persona ya fue consultada a las: ' . $primeraConsulta->created_at->format('H:i:s') . ' por el usuario:' . $usuario_consulta->username;
            $mensaje = 'Consultado';
            $estilo = 'text-success text-bold';
        }
        $documento = '';
        return view('padron.index', compact('data', 'inte', 'local', 'mensaje', 'estilo', 'mensaje_alerta', 'corresponde', 'conteo', 'documento'));
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
