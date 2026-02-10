<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FamiliaContable;
use App\Models\TablaMaestra;
use Auth;

class FamiliaContablesController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Mantenimiento Familia Contable')->only(['create']);
	}

    public function create(){
		
		$tabla_maestra_model = new TablaMaestra;

		$operacion = $tabla_maestra_model->getMaestroByTipo('115');

		return view('frontend.familia_contable.create',compact('operacion'));
	}

    public function listar_familia_contable_ajax(Request $request){

		$familia_contable_model = new FamiliaContable;
		$p[]=$request->familia_contable;
		$p[]=$request->codigo;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $familia_contable_model->listar_familia_contable_ajax($p);
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

    public function modal_familia_contable($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$familia_contable = FamiliaContable::find($id);
		}else{
			$familia_contable = new FamiliaContable;
		}

		$operacion = $tabla_maestra_model->getMaestroByTipo('115');

		return view('frontend.familia_contable.modal_familiaContable_nuevoFamiliaContable',compact('id','familia_contable','operacion'));

    }

    public function send_familia_contable(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$familia_contable = new FamiliaContable;
		}else{
			$familia_contable = FamiliaContable::find($request->id);
		}
		
        $familia_contable->periodo = $request->periodo;
        $familia_contable->denominacion = $request->denominacion;
        $familia_contable->operacion = $request->operacion;
		$familia_contable->codigo = $request->codigo;
		$familia_contable->estado = 1;
        $familia_contable->id_usuario_inserta = $id_user;
		$familia_contable->save();

        return response()->json(['success' => 'Familia Contable guardado exitosamente.']);

    }

    public function eliminar_familia_contable($id,$estado)
    {
		$familia_contable = FamiliaContable::find($id);

		$familia_contable->estado = $estado;
		$familia_contable->save();

		echo $familia_contable->id;
    }
}
