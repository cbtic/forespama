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
			$devolucion = new Devolucione;
            //$dispensacion_model = new Dispensacione;
            //$correlativo = $dispensacion_model->getCorrelativo();
            //$dispensacion->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$devolucion = Devolucione::find($request->id);
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

            $devolucion_detalle->save();

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
        }

        return response()->json(['success' => 'Ingreso a Produccion guardado exitosamente.']);

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
