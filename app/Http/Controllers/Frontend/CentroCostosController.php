<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentroCosto;
use App\Models\TablaMaestra;
use Auth;

class CentroCostosController extends Controller
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
		
		return view('frontend.centro_costo.create');

	}

    public function listar_centro_costo_ajax(Request $request){

		$centro_costo_model = new CentroCosto;
		$p[]=$request->periodo;
		$p[]=$request->denominacion;
		$p[]=$request->codigo;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $centro_costo_model->listar_centro_costo_ajax($p);
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

    public function modal_centro_costo($id){
				
		if($id>0){
			$centro_costo = CentroCosto::find($id);
		}else{
			$centro_costo = new CentroCosto;
		}

		return view('frontend.centro_costo.modal_centroCosto_nuevoCentroCosto',compact('id','centro_costo'));

    }

    public function send_centro_costo(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$centro_costo = new CentroCosto;
		}else{
			$centro_costo = CentroCosto::find($request->id);
		}
		
        $centro_costo->periodo = $request->periodo;
        $centro_costo->denominacion = $request->denominacion;
		$centro_costo->codigo = $request->codigo;
		$centro_costo->estado = 1;
        $centro_costo->id_usuario_inserta = $id_user;
		$centro_costo->save();

        return response()->json(['success' => 'Centro de Costo guardada exitosamente.']);

    }

    public function eliminar_centro_costo($id,$estado)
    {
		$centro_costo = CentroCosto::find($id);

		$centro_costo->estado = $estado;
		$centro_costo->save();

		echo $centro_costo->id;
    }
}
