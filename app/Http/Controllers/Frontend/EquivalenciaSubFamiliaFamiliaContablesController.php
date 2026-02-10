<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EquivalenciaSubFamiliaFamiliaContable;
use App\Models\TablaMaestra;
use App\Models\SubFamilia;
use App\Models\FamiliaContable;
use Auth;

class EquivalenciaSubFamiliaFamiliaContablesController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Equivalencia Sub Familia Familia Contable')->only(['create']);
	}

    public function create(){
		
		$sub_familia_model = new SubFamilia;
		$familia_contable_model = new FamiliaContable;

		$sub_familia = $sub_familia_model->getSubFamilias();
		$familia_contable = $familia_contable_model->getFamiliaContables();

		return view('frontend.equivalencia_sub_familia_familia_contable.create',compact('sub_familia','familia_contable'));
	}

    public function listar_equivalencia_sub_familia_familia_contable_ajax(Request $request){

		$equivalencia_sub_familia_familia_contable_model = new EquivalenciaSubFamiliaFamiliaContable;
		$p[]=$request->sub_familia;
		$p[]=$request->familia_contable;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $equivalencia_sub_familia_familia_contable_model->listar_equivalencia_sub_familia_familia_contable_ajax($p);
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

    public function modal_equivalencia_sub_familia_familia_contable($id){
		
		$sub_familia_model = new SubFamilia;
		$familia_contable_model = new FamiliaContable;

		if($id>0){
			$equivalencia_sub_familia_familia_contable = EquivalenciaSubFamiliaFamiliaContable::find($id);
		}else{
			$equivalencia_sub_familia_familia_contable = new EquivalenciaSubFamiliaFamiliaContable;
		}

		$sub_familia = $sub_familia_model->getSubFamilias();
		$familia_contable = $familia_contable_model->getFamiliaContables();

		return view('frontend.equivalencia_sub_familia_familia_contable.modal_equivalenciaSubFamiliaFamiliaContable_nuevoEquivalenciaSubFamiliaFamiliaContable',compact('id','equivalencia_sub_familia_familia_contable','sub_familia','familia_contable'));

    }

    public function send_equivalencia_sub_familia_familia_contable(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$equivalencia_sub_familia_familia_contable = new EquivalenciaSubFamiliaFamiliaContable;
		}else{
			$equivalencia_sub_familia_familia_contable = EquivalenciaSubFamiliaFamiliaContable::find($request->id);
		}
		
        $equivalencia_sub_familia_familia_contable->id_sub_familia = $request->sub_familia;
        $equivalencia_sub_familia_familia_contable->id_familia_contable = $request->familia_contable;
		$equivalencia_sub_familia_familia_contable->estado = 1;
        $equivalencia_sub_familia_familia_contable->id_usuario_inserta = $id_user;
		$equivalencia_sub_familia_familia_contable->save();

        return response()->json(['success' => 'Equivalencia guardada exitosamente.']);

    }

    public function eliminar_equivalencia_sub_familia_familia_contable($id,$estado)
    {
		$equivalencia_sub_familia_familia_contable = EquivalenciaSubFamiliaFamiliaContable::find($id);

		$equivalencia_sub_familia_familia_contable->estado = $estado;
		$equivalencia_sub_familia_familia_contable->save();

		echo $equivalencia_sub_familia_familia_contable->id;
    }
}
