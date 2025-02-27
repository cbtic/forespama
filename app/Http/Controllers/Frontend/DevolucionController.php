<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devolucione;
use App\Models\DevolucionDetalle;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Kardex;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\SalidaProducto;
use App\Models\SalidaProductoDetalle;
use App\Models\OrdenCompra;
use Auth;

class DevolucionController extends Controller
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

		$empresa = Empresa::all();
		
		return view('frontend.devolucion.create',compact('empresa'));

	}

    public function listar_devolucion_ajax(Request $request){

		$devolucion_model = new Devolucione;
		$p[]=$request->empresa;
		$p[]=$request->fecha;
        $p[]=$request->numero_devolucion;
        $p[]=$request->numero_orden_compra_cliente;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $devolucion_model->listar_devolucion_ajax($p);
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

    public function modal_devolucion($id){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		
		if($id>0){
			$devolucion = Devolucione::find($id);
			$salida = SalidaProducto::find($devolucion->id_salida);
			$orden_compra = OrdenCompra::find($salida->id_orden_compra);
		}else{
			$devolucion = new Devolucione;
			$salida = new SalidaProducto;
			$orden_compra = new OrdenCompra;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $motivo_devolucion = $tablaMaestra_model->getMaestroByTipo(74);
        $marca = $marca_model->getMarcaAll();
        $almacen_destino = $almacen_model->getAlmacenAll();
        $empresa = Empresa::All();
		//var_dump($id);exit();

		return view('frontend.devolucion.modal_devolucion_nuevoDevolucion',compact('id','devolucion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen_destino','id_user','empresa','igv_compra','motivo_devolucion','salida','orden_compra'));

    }

	public function send_devolucion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			//$devolucion = new Devolucione;
			$salida_producto = new SalidaProducto;
			$salida_producto_ = SalidaProducto::find($request->id_salida);
		}else{
			//$devolucion = Devolucione::find($request->id);
			$salida_producto = SalidaProducto::find($request->id);
		}

		$descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad_ingreso');
		$precio_venta = $request->input('precio_unitario');
		$precio_unitario = $request->input('precio_unitario_');
		$valor_venta_bruto = $request->input('valor_venta_bruto');
		$valor_venta = $request->input('valor_venta');
		$descuento = $request->input('descuento');
		$id_descuento = $request->input('id_descuento');
		$sub_total = $request->input('sub_total');
		$igv = $request->input('igv');
		$total = $request->input('total');
		$id_devolucion_detalle =$request->id_devolucion_detalle;

		$salida_producto->fecha_salida = $request->fecha_devolucion;
		$salida_producto->id_tipo_documento = $salida_producto_->id_tipo_documento;
		$salida_producto->unidad_destino = "2";
		//$salida_producto->numero_comprobante = "";
		$salida_producto->fecha_comprobante = "18/08/2024";
		$salida_producto->id_moneda = $request->moneda;
		//$salida_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
		$salida_producto->sub_total_compra = round($request->sub_total_general,2);
		$salida_producto->igv_compra = round($request->igv_general,2);
		$salida_producto->total_compra = round($request->total_general,2);
		$salida_producto->descuento = round($request->descuento_general,2);
		$moneda_descripcion="";
		if($request->moneda==1){$moneda_descripcion="SOLES";}
		else if($request->moneda==2){$moneda_descripcion="DOLARES";}
		else {$moneda_descripcion="SOLES";}
		$salida_producto->moneda = $moneda_descripcion;
		$salida_producto->cerrado = "2";
		//$salida_producto->observacion = $request->observacion;
		$salida_producto->id_almacen_salida = $request->almacen;
		$salida_producto->estado = 1;
		$salida_producto->id_orden_compra = $salida_producto_->id_orden_compra;
		//$salida_producto->id_proveedor = $request->proveedor;
		$salida_producto->id_empresa_compra = $request->empresa;
		$salida_producto->codigo = $salida_producto_->codigo;
		//$salida_producto->id_usuario_recibe = $id_user;
		//$salida_producto->id_persona_recibe = $request->persona_recibe;
		$salida_producto->tipo_devolucion = "2";
		$salida_producto->save();

		$array_salida_detalle = array();

		foreach($descripcion as $index => $value) {
            
            //if($id_devolucion_detalle[$index] == 0){
            $salida_producto_detalle = new SalidaProductoDetalle;
            //}else{
        	//    $salida_producto_detalle = SalidaProductoDetalle::find($id_devolucion_detalle[$index]);
            ///}
            
            $salida_producto_detalle->id_salida_productos = $salida_producto->id;
            $salida_producto_detalle->id_producto = $descripcion[$index];
            $salida_producto_detalle->cantidad = $cantidad[$index];
            $salida_producto_detalle->id_um = $unidad[$index];
            $salida_producto_detalle->costo = $precio_unitario[$index];
            $salida_producto_detalle->valor_venta_bruto = $valor_venta_bruto[$index];
            $salida_producto_detalle->precio_venta = $precio_venta[$index];
            $salida_producto_detalle->valor_venta = $valor_venta[$index];
            $salida_producto_detalle->cerrado = "2";
            $salida_producto_detalle->id_descuento = $id_descuento[$index];
            $salida_producto_detalle->descuento = $descuento[$index];
            $salida_producto_detalle->sub_total = $sub_total[$index];
            $salida_producto_detalle->igv = $igv[$index];
            $salida_producto_detalle->total = $total[$index];
            //$salida_producto_detalle->id_moneda = $request->moneda;
            //$salida_producto_detalle->moneda = $moneda_descripcion;
			$salida_producto_detalle->tipo_devolucion = "2";
			if($marca[$index]!=null && $marca[$index] !=0){
				$salida_producto_detalle->id_marca = (int)$marca[$index];
			}
            $salida_producto_detalle->estado = 1;
            //$salida_producto_detalle->id_usuario_inserta = $id_user;

            $salida_producto_detalle->save();

			//$array_salida_detalle_producto[] = $salida_producto_detalle->id_producto;
			//$array_salida_detalle_id[] = $salida_producto_detalle->id;

			$array_salida_detalle[] = [
				'id_producto' => $salida_producto_detalle->id_producto,
				'cantidad' => $salida_producto_detalle->cantidad,
				'id' => $salida_producto_detalle->id
			];
		}

		$salida_producto_final = SalidaProducto::where('codigo',$salida_producto->codigo)->where('tipo_devolucion',3)->where('estado',1)->first();

		$sub_total_final = $salida_producto_final->sub_total_compra - $salida_producto->sub_total_compra;
		$igv_final = $salida_producto_final->igv_compra - $salida_producto->igv_compra;
		$total_final = $salida_producto_final->total_compra - $salida_producto->total_compra;

		$salida_producto_final->sub_total_compra = $sub_total_final;
		$salida_producto_final->igv_compra = $igv_final;
		$salida_producto_final->total_compra = $total_final;
		$salida_producto_final->save();

		$salida_producto_detalle_final = SalidaProductoDetalle::where('id_salida_productos',$salida_producto_final->id)->where('tipo_devolucion',3)->where('estado',1)->get();

		$array_id_productos = array_column($array_salida_detalle, 'id_producto');

		foreach ($salida_producto_detalle_final as $row) {
			if (in_array($row->id_producto, $array_id_productos)) {
				// Buscar el registro dentro de $array_salida_detalle para obtener la cantidad
				foreach ($array_salida_detalle as $detalle) {
					if ($detalle['id_producto'] == $row->id_producto) {
						$salida_detalle_3 = SalidaProductoDetalle::find($row->id);
						$salida_detalle_2 = SalidaProductoDetalle::find($detalle['id']);
		
						if ($salida_detalle_3->cantidad != $detalle['cantidad']) {
							$cantidad_salida_final = $salida_detalle_3->cantidad - $detalle['cantidad'];
							$salida_detalle_3->cantidad = $cantidad_salida_final;
							$valor_venta_bruta_final = $salida_detalle_3->valor_venta_bruto - $salida_detalle_2->valor_venta_bruto;
							$valor_venta_final = $salida_detalle_3->valor_venta - $salida_detalle_2->valor_venta;
							$sub_total_final = $salida_detalle_3->sub_total - $salida_detalle_2->sub_total;
							$igv_final = $salida_detalle_3->igv - $salida_detalle_2->igv;
							$total_final = $salida_detalle_3->total - $salida_detalle_2->total;
							$salida_detalle_3->valor_venta_bruto = $valor_venta_bruta_final;
							$salida_detalle_3->valor_venta = $valor_venta_final;
							$salida_detalle_3->sub_total = $sub_total_final;
							$salida_detalle_3->igv = $igv_final;
							$salida_detalle_3->total = $total_final;

							$kardex_buscar = Kardex::where("id_producto",$detalle['id_producto'])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
							$kardex = new Kardex;
							$kardex->id_producto = $detalle['id_producto'];
							$kardex->entradas_cantidad = $detalle['cantidad'];
							if($kardex_buscar){
								$cantidad_saldo = $kardex_buscar->saldos_cantidad + $detalle['cantidad'];
								$kardex->saldos_cantidad = $cantidad_saldo;
							}else{
								$kardex->saldos_cantidad = $detalle['cantidad'];
							}
							$kardex->id_salida_producto = $salida_producto_final->id;
							$kardex->id_almacen_destino = $request->almacen;
	
							$kardex->save();

						} else {
							$salida_detalle_3->estado = 0;
							$kardex_buscar = Kardex::where("id_producto",$detalle['id_producto'])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
							$kardex = new Kardex;
							$kardex->id_producto = $detalle['id_producto'];
							$kardex->entradas_cantidad = $detalle['cantidad'];
							if($kardex_buscar){
								$cantidad_saldo = $kardex_buscar->saldos_cantidad + $detalle['cantidad'];
								$kardex->saldos_cantidad = $cantidad_saldo;
							}else{
								$kardex->saldos_cantidad = $detalle['cantidad'];
							}
							$kardex->id_salida_producto = $salida_producto_final->id;
							$kardex->id_almacen_destino = $request->almacen;
	
							$kardex->save();
						}
		
						$salida_detalle_3->save();
						//break;
					}
				}
			}
		}
			/*if($id_devolucion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->entradas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				$kardex->id_almacen_destino = $request->almacen_destino;
				$kardex->id_ingreso_produccion = $ingreso_produccion->id;

				$kardex->save();
			}else{
				/*$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex_dispensacion = Kardex::where("id_dispensacion",$dispensacion->id)->where("id_producto",$descripcion[$index])->orderBy('id', 'desc')->first();
				//dd($kardex_dispensacion);exit();
				$kardex = kardex::find($kardex_dispensacion->id);

				//$kardex->id_producto = $descripcion[$index];
				//$kardex->salidas_cantidad = $cantidad[$index];
				if($kardex_dispensacion->salidas_cantidad>$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad - ($kardex_dispensacion->salidas_cantidad - $cantidad[$index]);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad<$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad + ($cantidad[$index] - $kardex_dispensacion->salidas_cantidad);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad==$cantidad[$index]){
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				//$kardex->saldos_cantidad = $cantidad[$index];
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;

				$kardex->save();*/
			//}
        //}

        /*$descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad_ingreso');
		$precio_venta = $request->input('precio_unitario');
		$precio_unitario = $request->input('precio_unitario_');
		$valor_venta_bruto = $request->input('valor_venta_bruto');
		$valor_venta = $request->input('valor_venta');
		$descuento = $request->input('descuento');
		$id_descuento = $request->input('id_descuento');
		$sub_total = $request->input('sub_total');
		$igv = $request->input('igv');
		$total = $request->input('total');
        $id_devolucion_detalle =$request->id_devolucion_detalle;

		$devolucion_model = new Devolucione;
		$codigo_devolucion = $devolucion_model->getCodigoDevolucion();
		
		$devolucion->id_salida = $request->id_salida;
        $devolucion->numero_devolucion = $codigo_devolucion[0]->codigo;
        $devolucion->id_moneda = $request->moneda;
        if($request->moneda==1){$moneda_descripcion="SOLES";}
		else if($request->moneda==2){$moneda_descripcion="DOLARES";}
		else {$moneda_descripcion="SOLES";}
		$devolucion->moneda = $moneda_descripcion;
        $devolucion->fecha = $request->fecha_devolucion;
		$devolucion->sub_total = $request->sub_total_general;
		$devolucion->igv = $request->igv_general;
		$devolucion->total = $request->total_general;
		$devolucion->descuento = $request->descuento_general;
		$devolucion->id_almacen = $request->almacen;
		$devolucion->igv_compra = $request->igv_compra;
		$devolucion->motivo_devolucion = $request->motivo_devolucion;
        $devolucion->id_usuario_inserta = $id_user;
		//$devolucion->estado = 1;
		$devolucion->save();

		foreach($descripcion as $index => $value) {
            
            if($id_devolucion_detalle[$index] == 0){
                $devolucion_detalle = new DevolucionDetalle;
            }else{
                $devolucion_detalle = DevolucionDetalle::find($id_devolucion_detalle[$index]);
            }
            
            $devolucion_detalle->id_devolucion = $devolucion->id;
            $devolucion_detalle->id_producto = $descripcion[$index];
            $devolucion_detalle->cantidad = $cantidad[$index];
            $devolucion_detalle->id_unidad_medida = $unidad[$index];
            $devolucion_detalle->precio_unitario = $precio_unitario[$index];
            $devolucion_detalle->valor_venta_bruto = $valor_venta_bruto[$index];
            $devolucion_detalle->precio_venta = $precio_venta[$index];
            $devolucion_detalle->valor_venta = $valor_venta[$index];
            $devolucion_detalle->id_descuento = $id_descuento[$index];
            $devolucion_detalle->descuento = $descuento[$index];
            $devolucion_detalle->sub_total = $sub_total[$index];
            $devolucion_detalle->igv = $igv[$index];
            $devolucion_detalle->total = $total[$index];
            $devolucion_detalle->id_moneda = $request->moneda;
            $devolucion_detalle->moneda = $moneda_descripcion;
			if($marca[$index]!=null && $marca[$index] !=0){
				$devolucion_detalle->id_marca = (int)$marca[$index];
			}
            $devolucion_detalle->estado = 1;
            $devolucion_detalle->id_usuario_inserta = $id_user;

            $devolucion_detalle->save();*/

			/*if($id_devolucion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->entradas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				$kardex->id_almacen_destino = $request->almacen_destino;
				$kardex->id_ingreso_produccion = $ingreso_produccion->id;

				$kardex->save();
			}else{
				/*$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex_dispensacion = Kardex::where("id_dispensacion",$dispensacion->id)->where("id_producto",$descripcion[$index])->orderBy('id', 'desc')->first();
				//dd($kardex_dispensacion);exit();
				$kardex = kardex::find($kardex_dispensacion->id);

				//$kardex->id_producto = $descripcion[$index];
				//$kardex->salidas_cantidad = $cantidad[$index];
				if($kardex_dispensacion->salidas_cantidad>$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad - ($kardex_dispensacion->salidas_cantidad - $cantidad[$index]);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad<$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad + ($cantidad[$index] - $kardex_dispensacion->salidas_cantidad);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad==$cantidad[$index]){
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				//$kardex->saldos_cantidad = $cantidad[$index];
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;

				$kardex->save();*/
			//}
        //}

        return response()->json(['success' => 'Devolucion guardada exitosamente.']);

    }

    public function cargar_salida($numero_salida)
    {

        $devolucion_model = new Devolucione;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $devolucion = $devolucion_model->getDetalleDevolucionId($numero_salida);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        return response()->json([
            'devolucion' => $devolucion,
            'marca' => $marca,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento
        ]);
    }

	public function cargar_detalle($id)
    {

        $devolucion_model = new Devolucione;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $devolucion = $devolucion_model->getDetalleDevolucionIdCargar($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        return response()->json([
            'devolucion' => $devolucion,
            'marca' => $marca,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento
        ]);
    }

}
