<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductosCompetencia;
use App\Models\TablaMaestra;
use Auth;

class ProductoCompetenciaController extends Controller
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

        $tablaMaestra_model = new TablaMaestra;
        
		$competencia = $tablaMaestra_model->getMaestroByTipo(101);
		
		return view('frontend.producto_competencia.create',compact('competencia'));

	}

    public function listar_producto_competencia_ajax(Request $request){

		$producto_competencia_model = new ProductosCompetencia;
		$p[]=$request->competencia;
		$p[]=$request->denominacion;
		$p[]=$request->codigo;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $producto_competencia_model->listar_producto_competencia_ajax($p);
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

    public function modal_producto_competencia($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$producto_competencia = ProductosCompetencia::find($id);
		}else{
			$producto_competencia = new ProductosCompetencia;
		}

		$competencia = $tabla_maestra_model->getMaestroByTipo(101);

		return view('frontend.producto_competencia.modal_producto_competencia_nuevoProducto_competencia',compact('id','producto_competencia','competencia'));

    }

    public function send_producto_competencia(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$producto_competencia = new ProductosCompetencia;
		}else{
			$producto_competencia = ProductosCompetencia::find($request->id);
		}
		
        $producto_competencia->id_competencia = $request->competencia;
        $producto_competencia->denominacion = $request->denominacion;
        $producto_competencia->codigo = $request->codigo;
		$producto_competencia->estado = 1;
        $producto_competencia->id_usuario_inserta = $id_user;
		$producto_competencia->save();

        return response()->json(['success' => 'Producto Competencia guardado exitosamente.']);

    }

    public function eliminar_producto_competencia($id,$estado)
    {
		$producto_competencia = ProductosCompetencia::find($id);

		$producto_competencia->estado = $estado;
		$producto_competencia->save();

		echo $producto_competencia->id;
    }

    public function obtener_producto_competencia($id_producto){
        
		$producto_competencia_model = new ProductosCompetencia;
		$producto = $producto_competencia_model->getProductoCompetenciaById($id_producto);
		
		echo json_encode($producto);
	}
}
