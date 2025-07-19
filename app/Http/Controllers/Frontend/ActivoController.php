<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Activo;
use App\Models\Persona;
use App\Models\Ubigeo;
use App\Models\Marca;
use Auth;
use Carbon\Carbon;

class ActivoController extends Controller
{
    
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create(){
		
		$tabla_maestra_model = new TablaMaestra;

		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');

		return view('frontend.activos.create',compact('tipo_activo'));

	}

    public function listar_activos_ajax(Request $request){

		$activos_model = new Activo;
		$p[]=$request->tipo_activo;
		$p[]=$request->descripcion;
		$p[]=$request->placa;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $activos_model->listar_activos_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        echo json_encode($result);

	}

    public function modal_activos_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $persona_model = new Persona;
        $ubigeo_model = new Ubigeo;
        $marca_model = new Marca;

		if($id>0){
			$activo = Activo::find($id);
		}else{
			$activo = new Activo;
		}

		$tipo_activo = $tabla_maestra_model->getMaestroByTipo('84');
		$estado_activos = $tabla_maestra_model->getMaestroByTipo('85');
		$tipo_combustible = $tabla_maestra_model->getMaestroByTipo('86');
        $departamento = $ubigeo_model->getDepartamento();
        $marca = $marca_model->getMarcaVehiculo();

		return view('frontend.activos.modal_activos_nuevoActivo',compact('id','activo','tipo_activo','estado_activos','marca','tipo_combustible','departamento'));

    }

    public function send_activo(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$activo = new Activo;
		}else{
			$activo = Activo::find($request->id);
		}

        $activo->id_ubigeo = $request->distrito;
        $activo->direccion = $request->direccion;
        $activo->id_tipo_activo = $request->tipo_activo;
        $activo->descripcion = $request->descripcion;
        $activo->placa = $request->placa;
        $activo->modelo = $request->modelo;
        $activo->serie = $request->serie;
        $activo->id_marca = $request->marca;
        $activo->color = $request->color;
        $activo->titulo = $request->titulo;
        $activo->partida_registral = $request->partida_registral;
        $activo->partida_circulacion = $request->partida_circulacion;
        $activo->vigencia_circulacion = $request->vigencia_circulacion;
        $activo->fecha_vencimiento_soat = $request->fecha_vencimiento_soat;
        $activo->fecha_vencimiento_revision_tecnica = $request->fecha_vencimiento_revision_tecnica;
        $activo->valor_libros = $request->valor_libros;
        $activo->valor_comercial = $request->valor_comercial;
        $activo->id_tipo_combustible = $request->tipo_combustible;
        $activo->dimensiones = $request->dimension;
        $activo->id_estado_activo = $request->estado_activo;
		$activo->estado = 1;
        $activo->id_usuario_inserta = $id_user;
		$activo->save();

        return response()->json(['success' => 'Registro de activo guardado exitosamente.']);

    }

	public function obtener_provincia_distrito($id){
		
		$activos_model = new Activo;
		$ubigeo_activo = $activos_model->getProvinciaDistritoById($id);
		
		echo json_encode($ubigeo_activo);
	}

}
