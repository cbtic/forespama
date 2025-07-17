<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoHorno;
use App\Models\Persona;
use App\Models\ProduccionAcerradoMadera;
use Auth;
use Carbon\Carbon;

class HornoController extends Controller
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
		
		return view('frontend.horno.create');

	}

    public function listar_ingreso_horno_ajax(Request $request){

		$ingreso_horno_model = new IngresoHorno;
		$p[]=$request->fecha;
        $p[]=1;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_horno_model->listar_ingreso_horno_ajax($p);
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

    public function modal_ingreso_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        //$empresa_cubicaje_model = new EmpresaCubicaje;
        $persona_model = new Persona;

		/*if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}*/

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();

		return view('frontend.horno.modal_horno_nuevoIngresoHorno',compact('id',/*'ingreso_horno',*/'horno','operador'));

    }

	public function modal_salida_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        //$empresa_cubicaje_model = new EmpresaCubicaje;
        $persona_model = new Persona;

		/*if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}*/

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();

		return view('frontend.horno.modal_horno_nuevoSalidaHorno',compact('id',/*'ingreso_horno',*/'horno','operador'));

    }

    public function send_ingreso_horno(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$ingreso_horno = new IngresoHorno;
		}else{
			$ingreso_horno = IngresoHorno::find($request->id);
		}
		
		$ruc = $request->input('ruc');
		$razon_social = $request->input('razon_social');
		$letra = $request->input('letra');
		$placa = $request->input('placa');
		$id_tipo_madera = $request->input('id_tipo_madera');
		$tipo_madera = $request->input('tipo_madera');
		$cantidad_ingreso = $request->input('cantidad_ingreso');
		$cantidad_ingreso_produccion = $request->input('cantidad_ingreso_produccion');
		$porcentaje = $request->input('porcentaje');
        $id_ingreso_acerrado_detalle =$request->id_ingreso_acerrado_detalle;

        $ingreso_horno->fecha_ingreso = $request->fecha;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_inserta = $id_user;
		$ingreso_horno->save();
		$id_ingreso_produccion_acerrado_madera = $ingreso_produccion_acerrado_madera->id;

		$array_ingreso_produccion_acerrado_madera_detalle = array();

		foreach($ruc as $index => $value) {
            
			if($cantidad_ingreso_produccion[$index] != "" || $cantidad_ingreso_produccion[$index] > 0){

				$ingreso_produccion_acerrado_madera_detalle = new IngresoProduccionAcerradoMaderaDetalle;
            
				$ingreso_produccion_acerrado_madera_detalle->id_ingreso_produccion_acerrado_maderas = $id_ingreso_produccion_acerrado_madera;
				$ingreso_produccion_acerrado_madera_detalle->id_ingreso_vehiculo_tronco_tipo_maderas = $id_ingreso_acerrado_detalle[$index];
				$ingreso_produccion_acerrado_madera_detalle->cantidad_ingreso_tronco = $cantidad_ingreso_produccion[$index];
				$ingreso_produccion_acerrado_madera_detalle->id_tipo_madera = $id_tipo_madera[$index];
				$ingreso_produccion_acerrado_madera_detalle->estado_ingreso_acerrado = 1;
				$ingreso_produccion_acerrado_madera_detalle->estado = 1;
				$ingreso_produccion_acerrado_madera_detalle->id_usuario_inserta = $id_user;
				$ingreso_produccion_acerrado_madera_detalle->save();

				$array_ingreso_produccion_acerrado_madera_detalle[] = $ingreso_produccion_acerrado_madera_detalle->id;

				$IngresoVehiculoTroncoTipoMaderaAll = IngresoVehiculoTroncoTipoMadera::where('id',$id_ingreso_acerrado_detalle)->where('estado',1)->first();

				if($cantidad_ingreso_produccion[$index] == $cantidad_ingreso[$index]){
					$IngresoVehiculoTroncoTipoMaderaAll->estado_acerrado = 0;
					$IngresoVehiculoTroncoTipoMaderaAll->save();
				}

			}
            
        }

        return response()->json(['success' => 'Registro de ingreso guardado exitosamente.']);

    }

    public function cargar_detalle_acerrado(){
		
		$produccion_acerrado_madera_model = new ProduccionAcerradoMadera;
		$detalle_acerrado = $produccion_acerrado_madera_model->getDetalleAcerrado();
		
		return response()->json([
			'detalle_acerrado' => $detalle_acerrado
		]);
	}
}
