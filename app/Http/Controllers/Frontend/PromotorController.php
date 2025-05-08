<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromotorRuta;
use App\Models\Tienda;
use Auth;
use Carbon\Carbon;

class PromotorController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create_ruta(){
		
		return view('frontend.promotores.create_ruta');

	}

    public function listar_promotor_ruta_ajax(Request $request){

		$promotor_ruta_model = new PromotorRutas;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]=$request->empresa_vende;
        $p[]=$request->fecha;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $promotor_ruta_model->listar_promotor_ruta_ajax($p);
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

    public function modal_promotor_ruta($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $tienda_model = new Tienda;
        $user_model = new User;
		
		if($id>0){

            $promotor_ruta = PromotorRutas::find($id);
			
		}else{
			$promotor_ruta = new PromotorRutas;
		}

        $dia_semana = $tablaMaestra_model->getMaestroByTipo(2);
        $tiendas = $tienda_model->getTiendasAll();
        $promotores = $user_model->getUserByRol();

		return view('frontend.promotores.modal_promotor_nuevoPromotorRuta',compact('id','promotor_ruta','dia_semana','tiendas','promotores'));

    }
}
