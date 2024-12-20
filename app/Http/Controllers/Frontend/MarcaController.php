<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\TablaMaestra;
use Auth;

class MarcaController extends Controller
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
		
		return view('frontend.marcas.create');

	}

    public function listar_marca_ajax(Request $request){

		$marca_model = new Marca;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $marca_model->listar_marca_ajax($p);
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

    public function modal_marca($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$marca = Marca::find($id);
		}else{
			$marca = new Marca;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');

		return view('frontend.marcas.modal_marcas_nuevoMarca',compact('id','marca','tipo_marca'));

    }

    public function send_marca(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$marca = new Marca;
		}else{
			$marca = Marca::find($request->id);
		}
		
        $marca->denominiacion = $request->denominacion;
		$marca->id_tipo_marca = $request->tipo_marca;
		$marca->estado = 1;
        $marca->id_usuario_inserta = $id_user;
		$marca->save();

        return response()->json(['success' => 'Marca guardada exitosamente.']);

    }

    public function eliminar_marca($id,$estado)
    {
		$marca = Marca::find($id);

		$marca->estado = $estado;
		$marca->save();

		echo $marca->id;
    }
}
