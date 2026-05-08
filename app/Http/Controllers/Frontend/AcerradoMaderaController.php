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
use App\Models\Producto;
use App\Models\Kardex;
use App\Models\ConsultaOxapampaMovimiento;
use App\Models\IngresoVehiculoTroncoCubicaje;
use Auth;
use Carbon\Carbon;

class AcerradoMaderaController extends Controller
{
    public function __construct(){

		/*$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});*/

		$this->middleware('auth');
		$this->middleware('can:Acerrado')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;

		$cerrado = $tablaMaestra_model->getMaestroByTipo(119);
		
		return view('frontend.acerrado_madera.create',compact('cerrado'));

	}

    public function listar_ingreso_produccion_acerrado_madera_ajax(Request $request){

		$ingreso_produccion_acerrado_madera_model = new IngresoProduccionAcerradoMadera;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->situacion;
        $p[]=$request->estado;
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
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->situacion;
        $p[]=$request->estado;
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

		$fecha = Carbon::now()->format('Ymd');

		$ingreso_produccion_acerrado_model = new IngresoProduccionAcerradoMadera;
		$lote = $ingreso_produccion_acerrado_model->obtenerLote($fecha);

        $ingreso_produccion_acerrado_madera->fecha_ingreso = $request->fecha;
		$ingreso_produccion_acerrado_madera->lote = $lote[0]->lote;
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

				$IngresoVehiculoTroncoTipoMaderaAll = IngresoVehiculoTroncoTipoMadera::where('id',$id_ingreso_acerrado_detalle[$index])->where('estado',1)->first();

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

				$producto_model = new Producto;

				$producto = $producto_model->getProductoByTipoMadera($id_tipo_madera[$index]);
				
				$idProducto = $producto[0]->id;

				$idCorte = Kardex::where('id_producto', $idProducto)->where('id_almacen_destino', 21)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
				
				$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

				$kardex = new Kardex;
				$kardex->id_producto = $idProducto;
				$kardex->id_almacen_destino = 21;
				$kardex->fecha = $request->fecha;

				$kardex->entradas_cantidad = 0;
				$kardex->salidas_cantidad = $cantidad_ingreso_produccion[$index];

				$kardex->saldos_cantidad = $saldoBase - $cantidad_ingreso_produccion[$index];

				//$kardex->id_ingreso_vehiculo_tronco = $id_ingreso_produccion_acerrado_madera;
				$kardex->id_tipo_movimiento = 32;//CONSULTAR CONTADOR
				$kardex->id_movimiento = $id_ingreso_produccion_acerrado_madera;
				$kardex->codigo_movimiento = "";
				//$kardex->fecha = $request->fecha;
				$kardex->id_usuario_inserta = $id_user;
				$kardex->save();

				$cantidad_ingreso_produccion[$index];

				$ingreso = IngresoVehiculoTroncoCubicaje::where('id_ingreso_vehiculo_tronco_tipo_maderas',$id_ingreso_acerrado_detalle[$index])->where('estado',1)->orderBy('id', 'desc')->get();

				$total_volumen = 0;
				$total_precio = 0;
				$total_costo = 0;

				foreach ($ingreso as $item) {
					$total_volumen += $item->volumen_total_pies;
					$total_precio += $item->precio_total;
				}

				$total_costo = $total_precio / $total_volumen;

				$idCorte_ = ConsultaOxapampaMovimiento::where('id_producto', $idProducto)->where('id_almacen', '21')->where('id_tipo_movimiento', 1)->whereDate('fecha', '<=', Carbon::now())->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');

				$saldoBase = $idCorte_ > 0 ? ConsultaOxapampaMovimiento::where('id', $idCorte_)->value('saldos') : 0;
				$totalSaldosCantidadBase = $idCorte_ > 0 ? ConsultaOxapampaMovimiento::where('id', $idCorte_)->value('total_saldos') : 0;

				$consulta_oxapampa_movimiento = new ConsultaOxapampaMovimiento;
				$consulta_oxapampa_movimiento->id_producto = $idProducto;
				$consulta_oxapampa_movimiento->id_tipo_movimiento = '1';
				$consulta_oxapampa_movimiento->id_movimiento = $id_ingreso_acerrado_detalle[$index];
				$consulta_oxapampa_movimiento->entradas = 0;
				$consulta_oxapampa_movimiento->costo_entradas = 0;//number_format($precio_promedio_final,2);
				$consulta_oxapampa_movimiento->total_entradas = 0;//$precio_total_final;
				$consulta_oxapampa_movimiento->salidas = $total_volumen;
				$consulta_oxapampa_movimiento->costo_salidas = number_format($total_costo,2);
				$consulta_oxapampa_movimiento->total_salidas = number_format($total_precio,2);
				$consulta_oxapampa_movimiento->saldos = $saldoBase + $total_volumen;
				$consulta_oxapampa_movimiento->costo_saldos = 0;//number_format($precio_promedio_final,2);
				$consulta_oxapampa_movimiento->total_saldos = $totalSaldosCantidadBase - number_format($total_precio,2);
				$consulta_oxapampa_movimiento->id_almacen = '21';
				$consulta_oxapampa_movimiento->fecha = Carbon::now()->format('Y-m-d');
				$consulta_oxapampa_movimiento->estado = '1';
				$consulta_oxapampa_movimiento->id_usuario_inserta = $id_user;
				$consulta_oxapampa_movimiento->save();

			}
        }

        return response()->json(['success' => 'Registro de Ingreso Acerrio guardado exitosamente.']);

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
		$medida_texto = $request->input('medida_texto');
		$paquete = $request->input('paquete');
		$medida_paquete1 = $request->input('medida_paquete1');
		$medida_paquete2 = $request->input('medida_paquete2');
		$n_piezas = $request->input('n_piezas');
        $id_salida_acerrado_madera =$request->id_salida_acerrado_madera;
		$seleccionados = $request->input('seleccionados', []);
		//dd($seleccionados);exit();
		if (!$request->has('seleccionados')) {
			return response()->json([
				'error' => 'Debe seleccionar al menos un lote'
			], 422);
		}

        $produccion_acerrado_madera->id_ingreso_produccion_acerrado_maderas = $seleccionados[0];
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
			$produccion_acerrado_madera_detalle->cantidad_pendiente = $paquete[$index];
			$produccion_acerrado_madera_detalle->estado_produccion_acerrado = 1;
			$produccion_acerrado_madera_detalle->estado = 1;
			$produccion_acerrado_madera_detalle->id_usuario_inserta = $id_user;
			$produccion_acerrado_madera_detalle->save();

			$array_produccion_acerrado_madera_detalle[] = $produccion_acerrado_madera_detalle->id;

			/*$produccionAcerradoMaderaDetalleAll = ProduccionAcerradoMaderaDetalle::where('id_ingreso_produccion_acerrado_maderas',$id_ingreso_acerrado_detalle)->where('estado',1)->first();

			if($cantidad_ingreso_produccion[$index] == $cantidad_ingreso[$index]){
				$produccionAcerradoMaderaDetalleAll->estado_ingreso_acerrado = 0;
				$produccionAcerradoMaderaDetalleAll->save();
			}*/

			$ingresoProduccionAcerradoMaderaDetalleAll = IngresoProduccionAcerradoMaderaDetalle::where("id_ingreso_produccion_acerrado_maderas",$seleccionados[0])->where("estado","1")->get();
				
			foreach($ingresoProduccionAcerradoMaderaDetalleAll as $key=>$row){
				
				if (!in_array($row->id, $array_produccion_acerrado_madera_detalle)){
					$ingreso_produccion_acerrado_madera_detalle = IngresoProduccionAcerradoMaderaDetalle::find($row->id);
					$ingreso_produccion_acerrado_madera_detalle->estado_ingreso_acerrado = 0;
					$ingreso_produccion_acerrado_madera_detalle->save();
				}
			}

			$idProducto = $id_salida_acerrado_madera[$index];

			$idCorte = Kardex::where('id_producto', $idProducto)->where('id_almacen_destino', 22)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
			
			$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

			$kardex = new Kardex;
			$kardex->id_producto = $idProducto;
			$kardex->id_almacen_destino = 22;
			$kardex->fecha = $request->fecha;

			$kardex->entradas_cantidad = $n_piezas[$index];
			$kardex->salidas_cantidad = 0;

			$kardex->saldos_cantidad = $saldoBase + $n_piezas[$index];

			//$kardex->id_ingreso_vehiculo_tronco = $id_produccion_acerrado_madera;
			$kardex->id_tipo_movimiento = 9;
			$kardex->id_movimiento = $id_produccion_acerrado_madera;
			$kardex->codigo_movimiento = "";
			//$kardex->fecha = $request->fecha;
			$kardex->id_usuario_inserta = $id_user;
			$kardex->save();

			$medida_tabla = $medida_texto[$index];

			$medida_partes = explode('X', $medida_tabla);

			$numeros = [];

			foreach ($medida_partes as $parte) {
				$numeros[] = preg_replace('/[^0-9.]/', '', $parte);
			}

			$espesor = $numeros[0];
			$ancho = $numeros[1];
			$largo = $numeros[2];
			
			$espesor_pies = $espesor / 30.48;//4/30.48 = 0.131
			$ancho_pies = $ancho / 30.48;//13/30.48 = 0.426
			$largo_pies = $largo * 3.28084;//2.5*3.28084 = 8.202

			$volumen_pies = $espesor_pies * $ancho_pies * $largo_pies;//0.457

			$cantidad_acerrado_pies = $n_piezas[$index] * $volumen_pies;//120*0.457 = 54.84

			$idCorte_ = ConsultaOxapampaMovimiento::where('id_producto', $idProducto)->where('id_almacen', '22')->where('id_tipo_movimiento', 2)->where('id_movimiento', '!=', $produccion_acerrado_madera_detalle->id)->whereDate('fecha', '<=', Carbon::now())->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
        
			$saldoBase = $idCorte_ > 0 ? ConsultaOxapampaMovimiento::where('id', $idCorte_)->value('saldos') : 0;
			$totalSaldosCantidadBase = $idCorte_ > 0 ? ConsultaOxapampaMovimiento::where('id', $idCorte_)->value('total_saldos') : 0;

			//$consulta_oxapampa_movimiento = ConsultaOxapampaMovimiento::where('id_tipo_movimiento','2')->where('id_movimiento',$produccion_acerrado_madera_detalle->id)->where('estado',1)->first();
			$consulta_oxapampa_movimiento = new ConsultaOxapampaMovimiento;
			$consulta_oxapampa_movimiento->id_producto = $idProducto;
			$consulta_oxapampa_movimiento->id_tipo_movimiento = '2';
			$consulta_oxapampa_movimiento->id_movimiento = $produccion_acerrado_madera_detalle->id;
			$consulta_oxapampa_movimiento->entradas = $cantidad_acerrado_pies;
			$consulta_oxapampa_movimiento->costo_entradas = 0;//number_format($precio_promedio_final,2);
			$consulta_oxapampa_movimiento->total_entradas = 0;//$precio_total_final;
			$consulta_oxapampa_movimiento->salidas = 0;
			$consulta_oxapampa_movimiento->costo_salidas = 0;
			$consulta_oxapampa_movimiento->total_salidas = 0;
			$consulta_oxapampa_movimiento->saldos = $saldoBase + $cantidad_acerrado_pies;
			$consulta_oxapampa_movimiento->costo_saldos = 0;//number_format($precio_promedio_final,2);
			$consulta_oxapampa_movimiento->total_saldos = 0;//$totalSaldosCantidadBase + $precio_total_final;
			$consulta_oxapampa_movimiento->id_almacen = '22';
			$consulta_oxapampa_movimiento->fecha = Carbon::now()->format('Y-m-d');
			$consulta_oxapampa_movimiento->estado = '1';
			$consulta_oxapampa_movimiento->id_usuario_inserta = $id_user;
			$consulta_oxapampa_movimiento->save();

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

	public function cargar_acerrado_pendiente(){
		
		$produccion_acerrado_madera_model = new ProduccionAcerradoMadera;
		$detalle_acerrado_pendiente = $produccion_acerrado_madera_model->getDetalleAcerradoPendienteByLote();
		
		return response()->json([
			'detalle_acerrado_pendiente' => $detalle_acerrado_pendiente
		]);
	}
}
