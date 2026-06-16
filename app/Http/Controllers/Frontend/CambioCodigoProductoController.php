<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CambioCodigoProducto;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Kardex;
use Carbon\Carbon;
use Auth;

class CambioCodigoProductoController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Cambio Stock Codigo')->only(['create']);
	}

    public function create(){
	
		$producto_model = New Producto;

		$productos = $producto_model->getProductoAll();

		return view('frontend.cambio_codigo_producto.create',compact('productos'));

	}

    public function listar_cambio_codigo_producto_ajax(Request $request){

		$cambio_codigo_producto_model = new CambioCodigoProducto;
		$p[]=$request->codigo;
		$p[]=$request->producto;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $cambio_codigo_producto_model->listar_cambio_codigo_producto_ajax($p);
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

    public function modal_cambio_codigo_producto($id){
		
		$producto_model = New Producto;
		$almacen_model = New Almacene;

		if($id>0){
			$cambio_codigo_producto = CambioCodigoProducto::find($id);
		}else{
			$cambio_codigo_producto = new CambioCodigoProducto;
		}

		$productos = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenAll();

		return view('frontend.cambio_codigo_producto.modal_cambio_codigo_producto_nuevoCambio',compact('id','cambio_codigo_producto','productos','almacen'));

    }

    public function send_cambio_codigo_producto(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$cambio_codigo_producto = new CambioCodigoProducto;
            $cambio_codigo_producto_model = new CambioCodigoProducto;
            $codigo_cambio_codigo = $cambio_codigo_producto_model->getCodigoCambioCodigo();
		}else{
			$cambio_codigo_producto = CambioCodigoProducto::find($request->id);
            $codigo_cambio_codigo = $request->codigo;
		}
		
		if($request->id == 0){
            $cambio_codigo_producto->codigo = $codigo_cambio_codigo[0]->codigo;
        }else{
            $cambio_codigo_producto->codigo = $codigo_cambio_codigo;
        }
        $cambio_codigo_producto->id_producto = $request->producto_principal;
		$cambio_codigo_producto->cantidad = $request->cantidad_principal;
		$cambio_codigo_producto->id_producto_secundario = $request->producto_secundario;
		$cambio_codigo_producto->id_almacen = $request->almacen;
		$cambio_codigo_producto->estado = 1;
        $cambio_codigo_producto->id_usuario_inserta = $id_user;
		$cambio_codigo_producto->save();

		$id_cambio_codigo_producto = $cambio_codigo_producto->id;

		/*********************** SALIDA ***********************/
		//$producto = Producto::find($producto_principal);
		$idProducto = $request->producto_principal;
	
		$idCorte = Kardex::where('id_producto', $idProducto)->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', Carbon::now())->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
		
		$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

		$kardex = new Kardex;
		$kardex->id_producto = $idProducto;
		$kardex->id_almacen_destino = $request->almacen;
		$kardex->fecha = Carbon::now();

		$kardex->entradas_cantidad = 0;
		$kardex->salidas_cantidad = $request->cantidad_principal;
		//$kardex->costo_salidas_cantidad = $precio_unitario_[$index];
		//$kardex->total_salidas_cantidad = $total[$index];
		
		$kardex->saldos_cantidad = $saldoBase - $request->cantidad_principal;
		//$kardex->costo_saldos_cantidad = $producto->precio_venta;
		//$total_kardex = $cantidad_ingreso[$index] * $producto->precio_venta;
		//$kardex->total_saldos_cantidad = $total_kardex;

		//$kardex->id_entrada_producto = $entrada_producto->id;
		
		$kardex->id_tipo_movimiento = 19;

		$kardex->id_movimiento = $id_cambio_codigo_producto;
		$kardex->codigo_movimiento = $cambio_codigo_producto->codigo;
		$kardex->id_usuario_inserta = $id_user;
		$kardex->save();

		/*********************** INGRESO ***********************/
		$idProductoSecundario = $request->producto_secundario;
	
		$idCorteSecundario = Kardex::where('id_producto', $idProductoSecundario)->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', Carbon::now())->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
		
		$saldoBase = $idCorteSecundario > 0 ? Kardex::where('id', $idCorteSecundario)->value('saldos_cantidad') : 0;

		$kardex = new Kardex;
		$kardex->id_producto = $idProductoSecundario;
		$kardex->id_almacen_destino = $request->almacen;
		$kardex->fecha = Carbon::now();

		$kardex->entradas_cantidad = $request->cantidad_principal;
		$kardex->salidas_cantidad = 0;
		//$kardex->costo_salidas_cantidad = $precio_unitario_[$index];
		//$kardex->total_salidas_cantidad = $total[$index];
		
		$kardex->saldos_cantidad = $saldoBase + $request->cantidad_principal;
		//$kardex->costo_saldos_cantidad = $producto->precio_venta;
		//$total_kardex = $cantidad_ingreso[$index] * $producto->precio_venta;
		//$kardex->total_saldos_cantidad = $total_kardex;

		//$kardex->id_entrada_producto = $entrada_producto->id;
		
		$kardex->id_tipo_movimiento = 3;

		$kardex->id_movimiento = $id_cambio_codigo_producto;
		$kardex->codigo_movimiento = $cambio_codigo_producto->codigo;
		$kardex->id_usuario_inserta = $id_user;
		$kardex->save();
		
        return response()->json(['success' => 'Cambio guardado exitosamente.']);

    }
}
