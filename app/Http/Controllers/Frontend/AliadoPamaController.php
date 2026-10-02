<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AliadoPama;
use App\Models\TablaMaestra;
use App\Models\Ubigeo;
use App\Models\Persona;
use Auth;

class AliadoPamaController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Aliado Pama')->only(['create']);
	}

    public function create(){
		
		return view('frontend.aliado_pama.create');

	}

    public function listar_aliado_pama_ajax(Request $request){

		$aliado_pama_model = new AliadoPama;
		$p[]=$request->numero_documento;
		$p[]=$request->aliado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $aliado_pama_model->listar_aliado_pama_ajax($p);
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

    public function modal_aliado_pama($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $ubigeo_model = new Ubigeo;

		if($id>0){
			$aliado_pama = AliadoPama::find($id);
			$persona = Persona::where('id',$aliado_pama->id_persona)->where('estado',1)->first();
		}else{
			$aliado_pama = new AliadoPama;
            $persona = null;
		}
        $tipo_documento = $tabla_maestra_model->getMaestroByTipo('9');
		$departamento = $ubigeo_model->getDepartamento();

		return view('frontend.aliado_pama.modal_aliado_pama_nuevoAliadoPama',compact('id','aliado_pama','persona','tipo_documento','departamento'));

    }

    public function send_aliado_pama(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$aliado_pama = new AliadoPama;
		}else{
			$aliado_pama = AliadoPama::find($request->id);
			$persona = Persona::where('id',$aliado_pama->id_persona)->where('estado',1)->first();
		}
		
        $aliado_pama->porcentaje_comision = $request->porcentaje_comision;
		$aliado_pama->fecha_inicio = $request->fecha_inicio;
        $aliado_pama->id_usuario_actualiza = $id_user;
		$aliado_pama->porcentaje_personalizado = $request->input('porcentaje_personalizado', 0);
		$aliado_pama->save();

        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->id_ubigeo_nacimiento = $request->id_distrito_nacimiento;
        $persona->email = $request->correo;
        $persona->telefono = $request->numero_celular;
        $persona->direccion = $request->direccion;
        $persona->save();

        return response()->json(['success' => 'Aliado Pama guardada exitosamente.']);

    }

    public function eliminar_aliado_pama($id,$estado)
    {
		$aliado_pama = AliadoPama::find($id);

		$aliado_pama->estado = $estado;
		$aliado_pama->save();

		echo $aliado_pama->id;
    }

	public function actualizar_porcentaje_general($porcentaje_general){

        $id_user = Auth::user()->id;

		AliadoPama::where('porcentaje_personalizado', 0)->where('estado',1)->update([
            'porcentaje_comision' => $porcentaje_general,
            'id_usuario_actualiza' => $id_user
        ]);

        return response()->json(['success' => 'Porcentaje general actualizado exitosamente.']);

    }
}
