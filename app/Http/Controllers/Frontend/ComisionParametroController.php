<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionParametro;
use App\Models\TablaMaestra;
use Auth;

class ComisionParametroController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Configuracion Comision Aliado')->only(['create']);
	}

    public function create(){
		
		return view('frontend.comision_parametro.create');

	}

    public function listar_comision_parametro_ajax(Request $request){

		$comision_parametro_model = new ComisionParametro;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $comision_parametro_model->listar_comision_parametro_ajax($p);
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

    public function modal_comision_parametro($id){
		
		if($id>0){
			$comision_parametro = ComisionParametro::find($id);
		}else{
			$comision_parametro = new ComisionParametro;
		}

		return view('frontend.comision_parametro.modal_comision_parametro_nuevoComisionParametro',compact('id','comision_parametro'));

    }

    public function send_comision_parametro(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$comision_parametro = new ComisionParametro;
		}else{
			$comision_parametro = ComisionParametro::find($request->id);
		}
		
        $comision_parametro->porcentaje_comision = $request->porcentaje_comision;
		$comision_parametro->minimo_retiro = $request->retiro_minimo;
		$comision_parametro->estado = 1;
        $comision_parametro->id_usuario_inserta = $id_user;
		$comision_parametro->save();

        return response()->json(['success' => 'Parametro guardado exitosamente.']);

    }
}
