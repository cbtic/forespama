<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PersonaProceso;
use App\Models\TablaMaestra;
use App\Models\User;
use Auth;

class PersonaProcesoController extends Controller
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
        $user_model = new User;

        $proceso = $tablaMaestra_model->getMaestroByTipo(109);
        $user = $user_model->getUserAll();
		
		return view('frontend.persona_proceso.create',compact('proceso','user'));

	}

    public function listar_persona_proceso_ajax(Request $request){

		$persona_proceso_model = new PersonaProceso;
		$p[]=$request->user;
		$p[]=$request->proceso;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $persona_proceso_model->listar_persona_proceso_ajax($p);
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

    public function modal_persona_proceso($id){
		
		$tablaMaestra_model = new TablaMaestra;
        $user_model = new User;

		if($id>0){
			$persona_proceso = PersonaProceso::find($id);
		}else{
			$persona_proceso = new PersonaProceso;
		}

        $proceso = $tablaMaestra_model->getMaestroByTipo(109);
        $user = $user_model->getUserAll();

		return view('frontend.persona_proceso.modal_persona_proceso_nuevoPersonaProceso',compact('id','persona_proceso','proceso','user'));

    }

    public function send_persona_proceso(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$persona_proceso = new PersonaProceso;
		}else{
			$persona_proceso = PersonaProceso::find($request->id);
		}
		
        $persona_proceso->id_persona = $request->user;
		$persona_proceso->id_proceso = $request->proceso;
		$persona_proceso->estado = 1;
        $persona_proceso->id_usuario_inserta = $id_user;
		$persona_proceso->save();

        return response()->json(['success' => 'Persona Proceso guardado exitosamente.']);

    }

    public function eliminar_persona_proceso($id,$estado)
    {
		$persona_proceso = PersonaProceso::find($id);

		$persona_proceso->estado = $estado;
		$persona_proceso->save();

		echo $persona_proceso->id;
    }
}
