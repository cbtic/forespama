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
		
		return view('frontend.activos.create');

	}

    public function listar_activos_ajax(Request $request){

		$activos_model = new Activo;
		$p[]=$request->fecha;
        $p[]=1;
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

        $ingreso_horno->fecha_ingreso = $request->fecha;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_inserta = $id_user;
		$ingreso_horno->save();
		$id_ingreso_produccion_acerrado_madera = $ingreso_produccion_acerrado_madera->id;

        return response()->json(['success' => 'Registro de activo guardado exitosamente.']);

    }
}
