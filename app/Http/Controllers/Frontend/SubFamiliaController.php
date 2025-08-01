<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Familia;
use App\Models\SubFamilia;
use Auth;

class SubFamiliaController extends Controller
{
    public function create(){

        $familia_model = new Familia;

        $familia = $familia_model->getFamiliaAll();

		return view('frontend.sub_familia.create',compact('familia'));

	}

    public function listar_sub_familia_ajax(Request $request){

		$sub_familia_model = new SubFamilia;
        $p[]=$request->familia;
        $p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $sub_familia_model->listar_sub_familia_ajax($p);
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

    public function modal_sub_familia($id){
				
		if($id>0){

            $sub_familia = SubFamilia::find($id);
			
		}else{
			$sub_familia = new SubFamilia;
		}

        $familia_model = new Familia;

        $familia = $familia_model->getFamiliaAll();

		return view('frontend.sub_familia.modal_sub_familia_nuevoSubFamilia',compact('id','sub_familia','familia'));

    }

    public function send_sub_familia(Request $request)
    {
		$id_user = Auth::user()->id;

        if($request->id == 0){
            $sub_familia = new SubFamilia;
        }else{
            $sub_familia = SubFamilia::find($request->id);
        }

        $sub_familia->id_familia = $request->familia;
        $sub_familia->denominacion = $request->denominacion;
        $sub_familia->inicial_codigo = $request->inicial;
        $sub_familia->id_usuario_inserta = $id_user;
        $sub_familia->estado = 1;
        $sub_familia->save();
        $id_sub_familia = $sub_familia->id;
        
		return response()->json(['success' => 'Sub Familia guardada exitosamente.']);  

    }

    public function eliminar_sub_familia($id,$estado)
    {
		$sub_familia = SubFamilia::find($id);

		$sub_familia->estado = $estado;
		$sub_familia->save();

		echo $sub_familia->id;
    }
}
