<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquivalenciaProducto;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\ProductosCompetencia;
use Auth;

class EquivalenciaProductosController extends Controller
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

        $producto_model = new Producto;
		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        //$cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $empresa = Empresa::all();
        $producto = $producto_model->getProductoExterno();
		
		return view('frontend.equivalencia_producto.create',compact('empresa','producto'));

	}

    public function listar_equivalencia_producto_ajax(Request $request){

		$equivalencia_producto_model = new EquivalenciaProducto;
		$p[]=$request->producto;
		$p[]=$request->codigo_producto;
        $p[]=$request->descripcion_producto;
        $p[]=$request->empresa;
        $p[]=$request->codigo_empresa;
        $p[]=$request->descripcion_empresa;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $equivalencia_producto_model->listar_equivalencia_producto_ajax($p);
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

    public function modal_equivalencia_producto($id){
		
        $producto_model = new Producto;
        $empresa_model = new Empresa;
        $producto_competencia_model = new ProductosCompetencia;
		
		
		if($id>0){
			$equivalencia_producto = EquivalenciaProducto::find($id);
		}else{
			$equivalencia_producto = new EquivalenciaProducto;
		}

        $producto = $producto_model->getProductoExterno();
        $empresa = Empresa::all();
		$producto_dimfer = $producto_competencia_model->getProductoDimfer();
		$producto_ares = $producto_competencia_model->getProductoAres();

		return view('frontend.equivalencia_producto.modal_equivalencia_producto_nuevoEquivalencia',compact('id','equivalencia_producto','producto','empresa','producto_dimfer','producto_ares'));

    }

    public function send_equivalencia_producto(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$equivalencia_producto = new EquivalenciaProducto;
		}else{
			$equivalencia_producto = EquivalenciaProducto::find($request->id);
		}
		
		$equivalencia_producto->id_producto = $request->producto;
		$equivalencia_producto->codigo_producto = $request->codigo_producto;
        $equivalencia_producto->descripcion_producto = $request->producto_descripcion;
        $equivalencia_producto->id_empresa = $request->empresa;
        $equivalencia_producto->codigo_empresa = $request->codigo_producto_empresa;
        $equivalencia_producto->descripcion_empresa = $request->denominacion_producto_empresa;
        $equivalencia_producto->id_producto_dimfer = $request->producto_dimfer;
        $equivalencia_producto->id_producto_ares = $request->producto_ares;
        //$equivalencia_producto->codigo_dimfer = $request->codigo_producto_dimfer;
        //$equivalencia_producto->descripcion_dimfer = $request->denominacion_producto_dimfer;
        //$equivalencia_producto->codigo_ares = $request->codigo_producto_ares;
        //$equivalencia_producto->descripcion_ares = $request->denominacion_producto_ares;
        //$equivalencia_producto->sku = $request->sku_producto_empresa;
        $equivalencia_producto->id_usuario_inserta = $id_user;
		$equivalencia_producto->estado = 1;
		$equivalencia_producto->save();

        return response()->json(['success' => 'Registro guardado exitosamente.']);

    }

    public function eliminar_equivalencia_producto($id,$estado)
    {

		$equivalencia_producto = EquivalenciaProducto::find($id);

		$equivalencia_producto->estado = $estado;
		$equivalencia_producto->save();
		
		echo $equivalencia_producto->id;
    }
}
