<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\EmpresaCubicaje;
use App\Models\IngresoProduccionAcerradoMadera;
use App\Models\IngresoProduccionAcerradoMaderaDetalle;
use App\Models\ProduccionAcerradoMadera;
use App\Models\ProduccionAcerradoMaderaDetalle;
use App\Models\IngresoVehiculoTroncoTipoMadera;
use Auth;
use Carbon\Carbon;

class AcerradoMaderaController extends Controller
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
		
		return view('frontend.acerrado_madera.create');

	}

    public function listar_ingreso_produccion_acerrado_madera_ajax(Request $request){

		$ingreso_produccion_acerrado_madera_model = new IngresoProduccionAcerradoMadera;
		$p[]=$request->fecha;
        $p[]=1;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_produccion_acerrado_madera_model->listar_ingreso_produccion_acerrado_madera_ajax($p);
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

	public function listar_produccion_acerrado_madera_ajax(Request $request){

		$produccion_acerrado_madera_model = new ProduccionAcerradoMadera;
		$p[]=$request->fecha;
        $p[]=1;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $produccion_acerrado_madera_model->listar_produccion_acerrado_madera_ajax($p);
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

    public function modal_ingreso_acerrado_madera($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $empresa_cubicaje_model = new EmpresaCubicaje;

		if($id>0){
			$ingreso_produccion_acerrado_madera = IngresoProduccionAcerradoMadera::find($id);
		}else{
			$ingreso_produccion_acerrado_madera = new IngresoProduccionAcerradoMadera;
		}

		$tipo_madera = $tabla_maestra_model->getMaestroByTipo('42');
		$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        $letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();

		return view('frontend.acerrado_madera.modal_acerrado_madera_nuevoAcerradoMadera',compact('id','ingreso_produccion_acerrado_madera','tipo_madera','medida_acerrado','letra_empresa_cubicaje'));

    }

	public function modal_salida_acerrado_madera($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $empresa_cubicaje_model = new EmpresaCubicaje;

		if($id>0){
			$produccion_acerrado_madera = ProduccionAcerradoMadera::find($id);
		}else{
			$produccion_acerrado_madera = new ProduccionAcerradoMadera;
		}

		$tipo_madera = $tabla_maestra_model->getMaestroByTipo('42');
		$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        $letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();

		return view('frontend.acerrado_madera.modal_salida_acerrado_madera_nuevoAcerradoMadera',compact('id','produccion_acerrado_madera','tipo_madera','medida_acerrado','letra_empresa_cubicaje'));

    }

    public function send_ingreso_produccion_acerrado_madera(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$ingreso_produccion_acerrado_madera = new IngresoProduccionAcerradoMadera;
		}else{
			$ingreso_produccion_acerrado_madera = IngresoProduccionAcerradoMadera::find($request->id);
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

        $ingreso_produccion_acerrado_madera->fecha_ingreso = $request->fecha;
		$ingreso_produccion_acerrado_madera->estado = 1;
        $ingreso_produccion_acerrado_madera->id_usuario_inserta = $id_user;
		$ingreso_produccion_acerrado_madera->save();
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

				/*$OrdenCompraAll = OrdenCompraDetalle::where("id_orden_compra",$orden_compra->id)->where("estado","1")->get();
				
				foreach($OrdenCompraAll as $key=>$row){
					
					if (!in_array($row->id, $array_ingreso_produccion_acerrado_madera_detalle)){
						$orden_compra_detalle = OrdenCompraDetalle::find($row->id);
						$orden_compra_detalle->estado = 0;
						$orden_compra_detalle->save();
					}
				}*/

			}
            
        }

        return response()->json(['success' => 'Registro de ingreso guardado exitosamente.']);

    }

	public function send_produccion_acerrado_madera(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$produccion_acerrado_madera = new ProduccionAcerradoMadera;
		}else{
			$produccion_acerrado_madera = ProduccionAcerradoMadera::find($request->id);
		}

		$tipo_madera = $request->input('tipo_madera');
		$medida = $request->input('medida');
		$paquete = $request->input('paquete');
		$medida_paquete1 = $request->input('medida_paquete1');
		$medida_paquete2 = $request->input('medida_paquete2');
		$n_piezas = $request->input('n_piezas');
        $id_salida_acerrado_madera =$request->id_salida_acerrado_madera;
		
        //$produccion_acerrado_madera->id_ingreso_produccion_acerrado_maderas = $request->denominacion;
		$produccion_acerrado_madera->fecha_produccion = $request->fecha;
		$produccion_acerrado_madera->estado = 1;
        $produccion_acerrado_madera->id_usuario_inserta = $id_user;
		$produccion_acerrado_madera->save();
		$id_produccion_acerrado_madera = $produccion_acerrado_madera->id;

		$array_produccion_acerrado_madera_detalle = array();

		foreach($tipo_madera as $index => $value) {
            
			$produccion_acerrado_madera_detalle = new ProduccionAcerradoMaderaDetalle;
		
			$produccion_acerrado_madera_detalle->id_produccion_acerrado_maderas = $id_produccion_acerrado_madera;
			$produccion_acerrado_madera_detalle->id_medida = $medida[$index];
			$produccion_acerrado_madera_detalle->id_tipo_madera = $tipo_madera[$index];
			$produccion_acerrado_madera_detalle->cantidad_paquetes = $paquete[$index];
			$produccion_acerrado_madera_detalle->medida1_paquete = $medida_paquete1[$index];
			$produccion_acerrado_madera_detalle->medida2_paquete = $medida_paquete2[$index];
			$produccion_acerrado_madera_detalle->total_n_piezas = $n_piezas[$index];
			$produccion_acerrado_madera_detalle->estado_produccion_acerrado = 1;
			$produccion_acerrado_madera_detalle->estado = 1;
			$produccion_acerrado_madera_detalle->id_usuario_inserta = $id_user;
			$produccion_acerrado_madera_detalle->save();

			$array_produccion_acerrado_madera_detalle[] = $produccion_acerrado_madera_detalle->id;

			/*$IngresoVehiculoTroncoTipoMaderaAll = ProduccionAcerradoMaderaDetalle::where('id',$id_ingreso_acerrado_detalle)->where('estado',1)->first();

			if($cantidad_ingreso_produccion[$index] == $cantidad_ingreso[$index]){
				$IngresoVehiculoTroncoTipoMaderaAll->estado_acerrado = 0;
				$IngresoVehiculoTroncoTipoMaderaAll->save();
			}*/
        }

        return response()->json(['success' => 'Registro de produccion de acerrado guardado exitosamente.']);

    }

    public function cargar_detalle_ingreso_vehiculo_acerrado(){
		
		$ingreso_vehiculo_tronco_tipo_madera_model = new IngresoVehiculoTroncoTipoMadera;
		$detalle_ingreso_acerrado = $ingreso_vehiculo_tronco_tipo_madera_model->getDetalleIngresoVehiculoAcerrado();
		
		return response()->json([
			'detalle_ingreso_acerrado' => $detalle_ingreso_acerrado
		]);
	}
}
