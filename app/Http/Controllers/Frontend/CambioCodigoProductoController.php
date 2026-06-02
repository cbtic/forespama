<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CambioCodigoProducto;
use App\Models\TablaMaestra;
use Auth;

class CambioCodigoProductoController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		//$this->middleware('can:Cambio Codigo')->only(['create']);
	}

    public function create(){
		
		return view('frontend.cambio_codigo_producto.create');

	}

    public function listar_cambio_codigo_producto_ajax(Request $request){

		$cambio_codigo_producto_model = new CambioCodigoProducto;
		$p[]=$request->denominacion;
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
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$cambio_codigo_producto = CambioCodigoProducto::find($id);
		}else{
			$cambio_codigo_producto = new CambioCodigoProducto;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');

		return view('frontend.cambio_codigo_producto.modal_cambio_codigo_producto_nuevoCambio',compact('id','marca','tipo_marca'));

    }

    public function send_cambio_codigo_producto(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$cambio_codigo_producto = new CambioCodigoProducto;
		}else{
			$cambio_codigo_producto = CambioCodigoProducto::find($request->id);
		}
		
        $cambio_codigo_producto->denominiacion = $request->denominacion;
		$cambio_codigo_producto->id_tipo_marca = $request->tipo_marca;
		$cambio_codigo_producto->estado = 1;
        $cambio_codigo_producto->id_usuario_inserta = $id_user;
		$cambio_codigo_producto->save();

        return response()->json(['success' => 'Cambio guardado exitosamente.']);

    }
}
