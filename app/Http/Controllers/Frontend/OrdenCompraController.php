<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Marca;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;


class OrdenCompraController extends Controller
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

		/*$tablaMaestra_model = new TablaMaestra;
		$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);*/
		
		return view('frontend.orden_compra.create');

	}

    public function listar_orden_compra_ajax(Request $request){

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_ajax($p);
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

    public function modal_orden_compra($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $tipo_cambio_model = new TipoCambio;
        $almacen_model = new Almacene;
        $id_user = Auth::user()->id;
		
		if($id>0){

            $entrada_producto = EntradaProducto::find($id);
            $proveedor = Empresa::find($entrada_producto->id_proveedor);
            $tipo_cambio = null;
            //$proveedor = $almacen_model->getAlmacenAll();
            $almacen = null;
			
		}else{
			$entrada_producto = new EntradaProducto;
            $proveedor = Empresa::all();
            $tipo_cambio = $tipo_cambio_model->getTipoCambioUltimo();
            $almacen = $almacen_model->getAlmacenByUser($id_user);
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(48);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $cerrado_entrada = $tablaMaestra_model->getMaestroByTipo(52);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);

        //$producto = $producto_model->getProductoAll();
        
        //dd($proveedor);exit();

		return view('frontend.orden_compra.modal_orden_compra_nuevoOrdenCompra',compact('id','entrada_producto','tipo_documento','moneda','unidad_origen','proveedor','tipo_cambio','cerrado_entrada','igv_compra','almacen'));

    }

    public function send_orden_compra(Request $request){

        if($request->tipo_movimiento==1){

            if($request->id == 0){
                $entrada_producto = new EntradaProducto;
            }else{
                $entrada_producto = EntradaProducto::find($request->id);
            }

            $item = $request->input('item');
            //$cantidad = $request->input('cantidad');
            $descripcion = $request->input('descripcion');
            //$ubicacion_fisica_seccion = $request->input('ubicacion_fisica_seccion');
            //$ubicacion_fisica_anaquel = $request->input('ubicacion_fisica_anaquel');
            $cod_interno = $request->input('cod_interno');
            $marca = $request->input('marca');
            $fecha_fabricacion = $request->input('fecha_fabricacion');
            $fecha_vencimiento = $request->input('fecha_vencimiento');
            $estado_bien = $request->input('estado_bien');
            $unidad = $request->input('unidad');
            $cantidad_ingreso = $request->input('cantidad_ingreso');
            $cantidad_compra = $request->input('cantidad_compra');
            $cantidad_pendiente = $request->input('cantidad_pendiente');
            $stock_actual = $request->input('stock_actual');
            $precio_unitario = $request->input('precio_unitario');
            $sub_total = $request->input('sub_total');
            $igv = $request->input('igv');
            $total = $request->input('total');

            
            $entrada_producto->fecha_ingreso = $request->fecha_entrada;
            $entrada_producto->id_tipo_documento = $request->tipo_documento;
            $entrada_producto->unidad_origen = $request->unidad_origen;
            $entrada_producto->id_proveedor = $request->proveedor;
            $entrada_producto->numero_comprobante = $request->numero_comprobante;
            $entrada_producto->fecha_comprobante = "18/08/2024";
            $entrada_producto->id_moneda = $request->moneda;
            $entrada_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
            $entrada_producto->sub_total_compra = "";
            $entrada_producto->igv_compra = $request->igv_compra;
            $entrada_producto->total_compra = "";
            $entrada_producto->cerrado = $request->cerrado;
            $entrada_producto->observacion = $request->observacion;
            $entrada_producto->estado = 1;
            $entrada_producto->save();

            foreach($item as $index => $value) {
                
                $entradaProducto_detalle = new EntradaProductoDetalle();
                $entradaProducto_detalle->id_entrada_productos = $entrada_producto->id;
                $entradaProducto_detalle->item = $item[$index];
                $entradaProducto_detalle->cantidad = $cantidad_ingreso[$index];

                //$entradaProducto_detalle->numero_lote = "";
                $entradaProducto_detalle->fecha_vencimiento = $fecha_vencimiento[$index];
                $entradaProducto_detalle->aplica_precio = "";
                $entradaProducto_detalle->id_um = $unidad[$index];
                $entradaProducto_detalle->id_marca = $marca[$index];
                $entradaProducto_detalle->estado = 1;
                $entradaProducto_detalle->id_producto = $descripcion[$index];
                $entradaProducto_detalle->costo = $precio_unitario[$index];
                $entradaProducto_detalle->fecha_fabricacion = $fecha_fabricacion[$index];
                $entradaProducto_detalle->id_estado_bien = $estado_bien[$index];

                /*$entradaProducto_detalle->descripcion = $descripcion[$index];
                $entradaProducto_detalle->cod_interno = $cod_interno[$index];
                $entradaProducto_detalle->cantidad_compra = $cantidad_compra[$index];
                $entradaProducto_detalle->cantidad_pendiente = $cantidad_pendiente[$index];
                $entradaProducto_detalle->stock_actual = $stock_actual[$index];
                $entradaProducto_detalle->precio_unitario = $precio_unitario[$index];
                $entradaProducto_detalle->sub_total = $sub_total[$index];
                $entradaProducto_detalle->igv = $igv[$index];
                $entradaProducto_detalle->total = $total[$index];*/

                $entradaProducto_detalle->save();
            }

        }else if($request->tipo_movimiento==2){

            if($request->id == 0){
                $salida_producto = new SalidaProducto;
            }else{
                $salida_producto = SalidaProducto::find($request->id);
            }

            $item = $request->input('item');
            $descripcion = $request->input('descripcion');
            $cod_interno = $request->input('cod_interno');
            $marca = $request->input('marca');
            $fecha_fabricacion = $request->input('fecha_fabricacion');
            $fecha_vencimiento = $request->input('fecha_vencimiento');
            $estado_bien = $request->input('estado_bien');
            $unidad = $request->input('unidad');
            $cantidad_ingreso = $request->input('cantidad_ingreso');
            $cantidad_compra = $request->input('cantidad_compra');
            $cantidad_pendiente = $request->input('cantidad_pendiente');
            $stock_actual = $request->input('stock_actual');
            $precio_unitario = $request->input('precio_unitario');
            $sub_total = $request->input('sub_total');
            $igv = $request->input('igv');
            $total = $request->input('total');
            
            $salida_producto->fecha_salida = $request->fecha_entrada;
            $salida_producto->id_tipo_documento = $request->tipo_documento;
            $salida_producto->unidad_destino = $request->unidad_origen;
            $salida_producto->numero_comprobante = $request->numero_comprobante;
            $salida_producto->fecha_comprobante = "18/08/2024";
            $salida_producto->id_moneda = $request->moneda;
            $salida_producto->tipo_cambio_dolar = $request->tipo_cambio_dolar;
            $salida_producto->sub_total_compra = 100;
            $salida_producto->igv_compra = $request->igv_compra;
            $salida_producto->total_compra = 100;
            $salida_producto->cerrado = $request->cerrado;
            $salida_producto->observacion = $request->observacion;
            $salida_producto->estado = 1;
            $salida_producto->save();

            foreach($item as $index => $value) {
                
                $salida_producto_detalle = new SalidaProductoDetalle();
                $salida_producto_detalle->id_salida_productos = $salida_producto->id;
                $salida_producto_detalle->item = $item[$index];
                $salida_producto_detalle->cantidad = $cantidad_ingreso[$index];

                //$salida_producto_detalle->numero_lote = "";
                $salida_producto_detalle->fecha_vencimiento = $fecha_vencimiento[$index];
                $salida_producto_detalle->aplica_precio = "";
                $salida_producto_detalle->id_um = $unidad[$index];
                $salida_producto_detalle->id_marca = $marca[$index];
                $salida_producto_detalle->estado = 1;
                $salida_producto_detalle->id_producto = $descripcion[$index];
                $salida_producto_detalle->costo = $precio_unitario[$index];
                //$salida_producto_detalle->fecha_fabricacion = "2024-08-18";
                $salida_producto_detalle->id_estado_productos = $estado_bien[$index];

                /*$salida_producto_detalle->descripcion = $descripcion[$index];
                $salida_producto_detalle->cod_interno = $cod_interno[$index];
                $salida_producto_detalle->cantidad_ingreso = $cantidad_ingreso[$index];
                $salida_producto_detalle->cantidad_compra = $cantidad_compra[$index];
                $salida_producto_detalle->cantidad_pendiente = $cantidad_pendiente[$index];
                $salida_producto_detalle->stock_actual = $stock_actual[$index];
                $salida_producto_detalle->sub_total = $sub_total[$index];
                $salida_producto_detalle->igv = $igv[$index];
                $salida_producto_detalle->total = $total[$index];*/

                $salida_producto_detalle->save();
            }

        }
        if($request->tipo_movimiento==1){
            return response()->json(['id' => $entrada_producto->id, 'tipo_movimiento' => $request->tipo_movimiento]);    
        }else{
            return response()->json(['id' => $salida_producto->id, 'tipo_movimiento' => $request->tipo_movimiento]);    
        }
        
    }

    public function eliminar_orden_compra($id,$estado)
    {
		$orden_compra = OrdenCompra::find($id);

		$orden_compra->estado = $estado;
		$orden_compra->save();

		echo $orden_compra->id;
    }
}
