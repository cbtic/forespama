<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoVehiculoTronco;
use App\Models\IngresoVehiculoTroncoTipoMadera;
use Auth;

class IngresoVehiculoTroncoController extends Controller
{
    public function index(){
	
		$tablaMaestra_model = new TablaMaestra;
		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		/*
		$proyecto_model = new Proyecto;
		$tablaMaestra_model = new TablaMaestra;
		$departamento = $proyecto_model->getDepartamento();
		$estado_proyecto = $tablaMaestra_model->getMaestroByTipo("EST_PY");
		*/
		return view('frontend.ingreso.create',compact('tipo_madera'));
	
	}
	
	public function obtener_datos_vehiculo($placa){
	
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
		$vehiculo = $ingresoVehiculoTronco_model->getEmpresaConductorVehiculos($placa);
		echo json_encode($vehiculo);
		
	}
	
	public function send_ingreso(Request $request){

		$id_user = Auth::user()->id;
		/*
		if($request->id == 0){
			$comision = new Comisione;
		}else{
			$comision = Comisione::find($request->id);
		}
		*/
		
		$ingresoVehiculoTronco = new IngresoVehiculoTronco;
		$ingresoVehiculoTronco->fecha_ingreso = $request->fecha_ingreso;
		$ingresoVehiculoTronco->fecha_salida = $request->fecha_ingreso;
		$ingresoVehiculoTronco->empresa_transportista_id = $request->empresa_transportista_id;
		$ingresoVehiculoTronco->empresa_proveedor_id = $request->empresa_transportista_id;//0;
		$ingresoVehiculoTronco->vehiculos_id = $request->vehiculos_id;
		$ingresoVehiculoTronco->conductores_id = $request->conductores_id;
		$ingresoVehiculoTronco->encargados_id = 1;
		$ingresoVehiculoTronco->procedencias_id = 0;
		$ingresoVehiculoTronco->save();
		$id_ingreso_vehiculo_tronco = $ingresoVehiculoTronco->id;
		
		$ingresoVehiculoTroncoTipoMadera = new IngresoVehiculoTroncoTipoMadera;
		$ingresoVehiculoTroncoTipoMadera->ingreso_vehiculo_troncos_id = $id_ingreso_vehiculo_tronco;
		$ingresoVehiculoTroncoTipoMadera->tipo_maderas_id = $request->tipo_maderas_id;
		$ingresoVehiculoTroncoTipoMadera->cantidad = $request->cantidad;
		$ingresoVehiculoTroncoTipoMadera->estado = 1;
		$ingresoVehiculoTroncoTipoMadera->save();
				
    }
	
	public function listar_ingreso_vehiculo_tronco_ajax(Request $request){
	
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco(); 
		$p[]=$request->placa;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_ajax($p);
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
	
	
	
}
