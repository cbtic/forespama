<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sede;
use App\Models\TablaMaestra;
use Auth;

class SedesController extends Controller
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
		
		return view('frontend.sedes.create');

	}

    public function listar_sede_ajax(Request $request){

		$sede_model = new Sede;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $sede_model->listar_sede_ajax($p);
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

    public function modal_sede($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$sede = Sede::find($id);
		}else{
			$sede = new Sede;
		}

		$serie_factura = $tabla_maestra_model->getMaestroC('95','FT');
		$serie_boleta = $tabla_maestra_model->getMaestroC('95','BV');
		$serie_guia = $tabla_maestra_model->getMaestroC('95','GR');

		return view('frontend.sedes.modal_sedes_nuevoSede',compact('id','sede','serie_factura','serie_boleta','serie_guia'));

    }

    public function send_sede(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$sede = new Sede;
		}else{
			$sede = Sede::find($request->id);
		}
		
        $sede->denominacion = $request->denominacion;
		$sede->id_afectacion = $request->afectacion;
        $sede->serie_factura = $request->serie_factura;
        $sede->serie_boleta = $request->serie_boleta;
        $sede->serie_guia = $request->serie_guia;
		$sede->estado = 1;
        //$sede->id_usuario_inserta = $id_user;
		$sede->save();

        return response()->json(['success' => 'Sede guardada exitosamente.']);

    }

    public function eliminar_sede($id,$estado)
    {
		$sede = Sede::find($id);

		$sede->estado = $estado;
		$sede->save();

		echo $sede->id;
    }
}
