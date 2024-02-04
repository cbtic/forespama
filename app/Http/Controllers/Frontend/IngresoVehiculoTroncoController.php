<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoVehiculoTronco;
use App\Models\IngresoVehiculoTroncoTipoMadera;
use App\Models\IngresoVehiculoTroncoCubicaje;
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

		$ingresoVehiculoTronco = new IngresoVehiculoTronco;
		$ingresoVehiculoTronco->fecha_ingreso = $request->fecha_ingreso;
		$ingresoVehiculoTronco->fecha_salida = $request->fecha_ingreso;
		$ingresoVehiculoTronco->id_empresa_transportista = $request->id_empresa_transportista;
		$ingresoVehiculoTronco->id_empresa_proveedor = $request->id_empresa_transportista;//0;
		$ingresoVehiculoTronco->id_vehiculos = $request->id_vehiculos;
		$ingresoVehiculoTronco->id_conductores = $request->id_conductores;
		$ingresoVehiculoTronco->id_encargados = 1;
		$ingresoVehiculoTronco->id_procedencias = 0;
		$ingresoVehiculoTronco->save();
		$id_ingreso_vehiculo_troncos = $ingresoVehiculoTronco->id;
		
		$ingresoVehiculoTroncoTipoMadera = new IngresoVehiculoTroncoTipoMadera;
		$ingresoVehiculoTroncoTipoMadera->id_ingreso_vehiculo_troncos = $id_ingreso_vehiculo_troncos;
		$ingresoVehiculoTroncoTipoMadera->id_tipo_maderas = $request->tipo_maderas_id;
		$ingresoVehiculoTroncoTipoMadera->cantidad = $request->cantidad;
		$ingresoVehiculoTroncoTipoMadera->estado = 1;
		$ingresoVehiculoTroncoTipoMadera->save();
		$id_ingreso_vehiculo_tronco_tipo_maderas = $ingresoVehiculoTroncoTipoMadera->id;
		
		for($i=1;$i<=$request->cantidad;$i++){
			$ingresoVehiculoTroncoCubicaje = new IngresoVehiculoTroncoCubicaje;
			$ingresoVehiculoTroncoCubicaje->id_ingreso_vehiculo_tronco_tipo_maderas=$id_ingreso_vehiculo_tronco_tipo_maderas;
			$ingresoVehiculoTroncoCubicaje->diametro_1= 0;
			$ingresoVehiculoTroncoCubicaje->diametro_2 = 0;
			$ingresoVehiculoTroncoCubicaje->diametro_dm = 0;
			$ingresoVehiculoTroncoCubicaje->longitud = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_m3 = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_pies = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_total_m3 = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_total_pies = 0;
			$ingresoVehiculoTroncoCubicaje->precio_unitario = 0;
			$ingresoVehiculoTroncoCubicaje->precio_total = 0;
			$ingresoVehiculoTroncoCubicaje->save();
		}

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

	public function cubicaje(){

		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);

		return view('frontend.cubicaje.create'/*,compact('tipo_madera')*/);

	}

	public function cargar_cubicaje($id){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
        $cubicaje = $ingresoVehiculoTronco_model->getIngresoVehiculoTroncoCubicajeById($id);

        return view('frontend.cubicaje.cubicaje_ajax',compact('cubicaje'));

    }
	
	public function cargar_reporte_cubicaje($id){
		 
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
        $cubicaje = $ingresoVehiculoTronco_model->getIngresoVehiculoTroncoCubicajeReporteById($id);
		
        return view('frontend.cubicaje.cubicaje_reporte_ajax',compact('cubicaje'));
		
    }
	
	public function send_cubicaje(Request $request){

		$id_ingreso_vehiculo_tronco_cubicaje = $request->id_ingreso_vehiculo_tronco_cubicaje;
		$diametro_1 = $request->diametro_1;
		$diametro_2 = $request->diametro_2;
		$diametro_dm = $request->diametro_dm;
		$longitud = $request->longitud;
		$volumen_m3 = $request->volumen_m3;
		$volumen_pies = $request->volumen_pies;
		$volumen_total_m3 = $request->volumen_total_m3;
		$volumen_total_pies = $request->volumen_total_pies;
		$precio_unitario = $request->precio_unitario;
		$precio_total = $request->precio_total;

		foreach($id_ingreso_vehiculo_tronco_cubicaje as $key=>$row){

			$ingresoVehiculoTroncoCubicaje = IngresoVehiculoTroncoCubicaje::find($row);
			$ingresoVehiculoTroncoCubicaje->diametro_1= $diametro_1[$key];
			$ingresoVehiculoTroncoCubicaje->diametro_2 = $diametro_2[$key];
			$ingresoVehiculoTroncoCubicaje->diametro_dm = $diametro_dm[$key];
			$ingresoVehiculoTroncoCubicaje->longitud = $longitud[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_m3 = $volumen_m3[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_pies = $volumen_pies[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_total_m3 = $volumen_total_m3[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_total_pies = $volumen_total_pies[$key];
			$ingresoVehiculoTroncoCubicaje->precio_unitario = $precio_unitario[$key];
			$ingresoVehiculoTroncoCubicaje->precio_total = $precio_total[$key];
			$ingresoVehiculoTroncoCubicaje->save();
		}

    }

}
