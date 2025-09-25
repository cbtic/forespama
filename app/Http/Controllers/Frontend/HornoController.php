<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoHorno;
use App\Models\Persona;
use App\Models\Almacene;
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
		$almacen_model = new Almacene;

		if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();
		$almacen = $almacen_model->getAlmacenAll();

		return view('frontend.horno.modal_horno_nuevoIngresoHorno',compact('id','ingreso_horno','horno','operador','almacen'));

    }

	public function modal_salida_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        //$empresa_cubicaje_model = new EmpresaCubicaje;
        $persona_model = new Persona;
		$almacen_model = new Almacene;

		if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();
		$almacen = $almacen_model->getAlmacenAll();

		return view('frontend.horno.modal_horno_nuevoSalidaHorno',compact('id','ingreso_horno','horno','operador','almacen'));

    }

    public function send_ingreso_horno(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$ingreso_horno = new IngresoHorno;
		}else{
			$ingreso_horno = IngresoHorno::find($request->id);
		}

        $ingreso_horno->id_numero_horno = $request->horno;
        $ingreso_horno->fecha_encendido = $request->fecha;
        $ingreso_horno->hora_encendido = $request->hora_encendido;
        $ingreso_horno->temperatura_inicio = $request->temperatura_inicio;
        $ingreso_horno->humedad_inicio = $request->humedad_inicio;
        $ingreso_horno->id_operador_inicio = $request->operador;
        /*$ingreso_horno->fecha_apagado = $request->fecha;
        $ingreso_horno->hora_apagado = $request->fecha;
        $ingreso_horno->humedad_apagado = $request->fecha;
        $ingreso_horno->id_operador_apagado = $request->fecha;
        $ingreso_horno->observacion = $request->fecha;*/
        $ingreso_horno->total_ingreso = $request->total_ingreso_horno;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_inserta = $id_user;
		$ingreso_horno->save();

        return response()->json(['success' => 'Registro guardado exitosamente.']);

    }

	public function send_salida_horno(Request $request){

        $id_user = Auth::user()->id;

		//if($request->id == 0){
			//$ingreso_horno = new IngresoHorno;
		//}else{
			$ingreso_horno = IngresoHorno::find($request->id);
		//}

        $ingreso_horno->fecha_apagado = $request->fecha_salida;
        $ingreso_horno->hora_apagado = $request->hora_apagado;
        $ingreso_horno->humedad_apagado = $request->humedad_fin;
        $ingreso_horno->id_operador_apagado = $request->operador_salida;
        $ingreso_horno->observacion = $request->observacion;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_actualiza = $id_user;
		$ingreso_horno->save();

        return response()->json(['success' => 'Registro guardado exitosamente.']);

    }

    public function cargar_detalle_acerrado(){
		
		$produccion_acerrado_madera_model = new ProduccionAcerradoMadera;
		$detalle_acerrado = $produccion_acerrado_madera_model->getDetalleAcerrado();
		
		return response()->json([
			'detalle_acerrado' => $detalle_acerrado
		]);
	}
}
