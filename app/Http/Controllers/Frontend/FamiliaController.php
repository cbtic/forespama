<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\SubFamilia;
use Auth;

class FamiliaController extends Controller
{
    public function create(){

		return view('frontend.familia.create');

	}

    public function listar_familia_ajax(Request $request){

		$familia_model = new Familia;
        $p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $familia_model->listar_familia_ajax($p);
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

    public function modal_familia($id){
				
		if($id>0){

            $familia = Familia::find($id);
			
		}else{
			$familia = new Familia;
		}

		return view('frontend.familia.modal_familia_nuevoFamilia',compact('id','familia'));

    }

    public function send_familia(Request $request)
    {
		$id_user = Auth::user()->id;

        if($request->id == 0){
            $familia = new Familia;
        }else{
            $familia = Familia::find($request->id);
        }

        $familia->denominacion = $request->denominacion;
        $familia->id_usuario_inserta = $id_user;
        $familia->estado = 1;
        $familia->save();
        $id_familia = $familia->id;
        
		return response()->json(['success' => 'Marca guardada exitosamente.']);  

    }

    public function eliminar_familia($id,$estado)
    {
		$familia = Familia::find($id);

		$familia->estado = $estado;
		$familia->save();

		echo $familia->id;
    }
}
