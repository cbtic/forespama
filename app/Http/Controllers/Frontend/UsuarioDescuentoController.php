<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsuarioDescuento;
use App\Models\User;
use App\Models\TablaMaestra;
use Auth;

class UsuarioDescuentoController extends Controller
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
		
        $tabla_maestra_model = new TablaMaestra;
        $usuario_descuento_model = new UsuarioDescuento;

        $descuento = $tabla_maestra_model->getMaestroByTipo('55');
        $tipo_usuario = $tabla_maestra_model->getMaestroByTipo('99');
        $usuario = $usuario_descuento_model->getUsuarioDescuento();

		return view('frontend.usuario_descuento.create',compact('descuento','tipo_usuario','usuario'));

	}

    public function listar_usuario_descuento_ajax(Request $request){

		$usuario_descuento_model = new UsuarioDescuento;
		$p[]=$request->usuario;
		$p[]=$request->descuento;
		$p[]=$request->tipo_usuario;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $usuario_descuento_model->listar_usuario_descuento_ajax($p);
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

    public function modal_usuario_descuento($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $usuario_model = new User;

		if($id>0){
			$usuario_descuento = UsuarioDescuento::find($id);
		}else{
			$usuario_descuento = new UsuarioDescuento;
		}

        $descuento = $tabla_maestra_model->getMaestroByTipo('55');
        $tipo_usuario = $tabla_maestra_model->getMaestroByTipo('99');
        $usuario = $usuario_model->getUserAll();

		return view('frontend.usuario_descuento.modal_usuario_descuento_nuevoUsuarioDescuento',compact('id','usuario_descuento','descuento','tipo_usuario','usuario'));

    }

    public function send_usuario_descuento(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$usuario_descuento = new UsuarioDescuento;
		}else{
			$usuario_descuento = UsuarioDescuento::find($request->id);
		}
		
        $usuario_descuento->id_usuario = $request->usuario;
		$usuario_descuento->id_descuento = $request->descuento;
		$usuario_descuento->id_tipo_usuario = $request->tipo_usuario;
		$usuario_descuento->estado = 1;
        $usuario_descuento->id_usuario_inserta = $id_user;
		$usuario_descuento->save();

        return response()->json(['success' => 'Permiso de Usuario guardado exitosamente.']);

    }

    public function eliminar_usuario_descuento($id,$estado)
    {
		$usuario_descuento = UsuarioDescuento::find($id);

		$usuario_descuento->estado = $estado;
		$usuario_descuento->save();

		echo $usuario_descuento->id;
    }
}
