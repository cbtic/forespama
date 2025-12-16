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
use App\Models\EntradaProducto;
use App\Models\EntradaProductoDetalle;
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

    public function modal_devolucion($id, $id_tipo_documento){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		
		if($id>0){
			$salida = EntradaProducto::find($id);
			/*$devolucion = Devolucione::find($id);
			$salida = SalidaProducto::find($devolucion->id_salida);*/
			$orden_compra = OrdenCompra::find($salida->id_orden_compra);
		}else{
			$salida = new EntradaProducto;
			/*$devolucion = new Devolucione;
			$salida = new SalidaProducto;*/
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

		return view('frontend.devolucion.modal_devolucion_nuevoDevolucion',compact('id','id_tipo_documento','salida','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen_destino','id_user','empresa','igv_compra','motivo_devolucion','orden_compra'));

    }

	public function send_devolucion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			//$devolucion = new Devolucione;
			$entrada_producto = new EntradaProducto;
			$salida_producto_ = SalidaProducto::find($request->id_salida);
		}else{
			//$devolucion = Devolucione::find($request->id);
			$entrada_producto = EntradaProducto::find($request->id);
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

		$entrada_producto->fecha_ingreso = $request->fecha_devolucion;
		$entrada_producto->id_tipo_documento = $salida_producto_->id_tipo_documento;
		$entrada_producto->unidad_origen = "2";
		//$salida_producto->numero_comprobante = "";
		$entrada_producto->fecha_comprobante = "18/08/2024";
		$entrada_producto->id_moneda = $request->moneda;
		//$salida_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
		$entrada_producto->sub_total_compra = round($request->sub_total_general,2);
		$entrada_producto->igv_compra = round($request->igv_general,2);
		$entrada_producto->total_compra = round($request->total_general,2);
		$entrada_producto->descuento = round($request->descuento_general,2);
		$moneda_descripcion="";
		if($request->moneda==1){$moneda_descripcion="SOLES";}
		else if($request->moneda==2){$moneda_descripcion="DOLARES";}
		else {$moneda_descripcion="SOLES";}
		$entrada_producto->moneda = $moneda_descripcion;
		$entrada_producto->cerrado = "2";
		//$salida_producto->observacion = $request->observacion;
		$entrada_producto->id_almacen_destino = $request->almacen;
		$entrada_producto->estado = 1;
		$entrada_producto->id_orden_compra = $salida_producto_->id_orden_compra;
		//$salida_producto->id_proveedor = $request->proveedor;
		$entrada_producto->id_empresa_compra = $request->empresa;
		$entrada_producto->id_proveedor = 30;
		$entrada_producto->id_tipo_cliente = $salida_producto_->id_tipo_cliente;
		$entrada_producto->id_persona = $salida_producto_->id_persona;
		$entrada_producto->codigo = $salida_producto_->codigo;
		//$salida_producto->id_usuario_recibe = $id_user;
		//$salida_producto->id_persona_recibe = $request->persona_recibe;
		$entrada_producto->tipo_devolucion = "2";
		$entrada_producto->id_usuario_inserta = $id_user;
		$entrada_producto->save();

		$array_salida_detalle = array();

		foreach($descripcion as $index => $value) {
            
            //if($id_devolucion_detalle[$index] == 0){
            $entrada_producto_detalle = new EntradaProductoDetalle;
            //}else{
        	//    $salida_producto_detalle = SalidaProductoDetalle::find($id_devolucion_detalle[$index]);
            ///}
            
            $entrada_producto_detalle->id_entrada_productos = $entrada_producto->id;
            $entrada_producto_detalle->id_producto = $descripcion[$index];
            $entrada_producto_detalle->cantidad = $cantidad[$index];
            $entrada_producto_detalle->id_um = $unidad[$index];
            $entrada_producto_detalle->costo = $precio_unitario[$index];
            $entrada_producto_detalle->valor_venta_bruto = $valor_venta_bruto[$index];
            $entrada_producto_detalle->precio_venta = $precio_venta[$index];
            $entrada_producto_detalle->valor_venta = $valor_venta[$index];
            $entrada_producto_detalle->cerrado = "2";
            $entrada_producto_detalle->id_descuento = $id_descuento[$index];
            $entrada_producto_detalle->descuento = $descuento[$index];
            $entrada_producto_detalle->sub_total = $sub_total[$index];
            $entrada_producto_detalle->igv = $igv[$index];
            $entrada_producto_detalle->total = $total[$index];
            //$salida_producto_detalle->id_moneda = $request->moneda;
            //$salida_producto_detalle->moneda = $moneda_descripcion;
			//$entrada_producto_detalle->tipo_devolucion = "2";
			if($marca[$index]!=null && $marca[$index] !=0){
				$entrada_producto_detalle->id_marca = (int)$marca[$index];
			}
            $entrada_producto_detalle->estado = 1;
            //$salida_producto_detalle->id_usuario_inserta = $id_user;

            $entrada_producto_detalle->save();

			//$array_salida_detalle_producto[] = $salida_producto_detalle->id_producto;
			//$array_salida_detalle_id[] = $salida_producto_detalle->id;

			$array_entrada_detalle[] = [
				'id_producto' => $entrada_producto_detalle->id_producto,
				'cantidad' => $entrada_producto_detalle->cantidad,
				'id' => $entrada_producto_detalle->id
			];
		}

		$salida_producto_final = SalidaProducto::where('codigo',$salida_producto_->codigo)->where('tipo_devolucion',3)->where('estado',1)->first();

		$sub_total_final = $salida_producto_final->sub_total_compra - $entrada_producto->sub_total_compra;
		$igv_final = $salida_producto_final->igv_compra - $entrada_producto->igv_compra;
		$total_final = $salida_producto_final->total_compra - $entrada_producto->total_compra;

		$salida_producto_final->sub_total_compra = $sub_total_final;
		$salida_producto_final->igv_compra = $igv_final;
		$salida_producto_final->total_compra = $total_final;
		$salida_producto_final->save();

		$salida_producto_detalle_final = SalidaProductoDetalle::where('id_salida_productos',$salida_producto_final->id)->where('tipo_devolucion',3)->where('estado',1)->get();

		$array_id_productos = array_column($array_entrada_detalle, 'id_producto');

		foreach ($salida_producto_detalle_final as $row) {
			if (in_array($row->id_producto, $array_id_productos)) {
				// Buscar el registro dentro de $array_salida_detalle para obtener la cantidad
				foreach ($array_entrada_detalle as $detalle) {
					if ($detalle['id_producto'] == $row->id_producto) {
						$salida_detalle_3 = SalidaProductoDetalle::find($row->id);
						$entrada_detalle_2 = EntradaProductoDetalle::find($detalle['id']);
		
						if ($salida_detalle_3->cantidad != $detalle['cantidad']) {
							$cantidad_salida_final = $salida_detalle_3->cantidad - $detalle['cantidad'];
							$salida_detalle_3->cantidad = $cantidad_salida_final;
							$valor_venta_bruta_final = $salida_detalle_3->valor_venta_bruto - $entrada_detalle_2->valor_venta_bruto;
							$valor_venta_final = $salida_detalle_3->valor_venta - $entrada_detalle_2->valor_venta;
							$sub_total_final = $salida_detalle_3->sub_total - $entrada_detalle_2->sub_total;
							$igv_final = $salida_detalle_3->igv - $entrada_detalle_2->igv;
							$total_final = $salida_detalle_3->total - $entrada_detalle_2->total;
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
							$kardex->id_entrada_producto = $entrada_producto->id;
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
							$kardex->id_entrada_producto = $entrada_producto->id;
							$kardex->id_almacen_destino = $request->almacen;
	
							$kardex->save();
						}
		
						$salida_detalle_3->save();
					}
				}
			}
		}

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

	public function cargar_detalle($id, $id_tipo_documento)
    {

		if ($id_tipo_documento == 2){
			$salida_model = new SalidaProductoDetalle;
			$devolucion = $salida_model->getDetalleProductoId($id);
		}else if ($id_tipo_documento == 1){
			$entrada_model = new EntradaProductoDetalle;
			$devolucion = $entrada_model->getDetalleProductoId($id);
		}

        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        
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
