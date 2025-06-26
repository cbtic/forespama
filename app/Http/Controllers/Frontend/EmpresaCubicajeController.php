<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmpresaCubicaje;
use App\Models\TablaMaestra;
use App\Models\Conductores;
use App\Models\Empresa;
use Auth;
use Carbon\Carbon;

class EmpresaCubicajeController extends Controller
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
        $conductor_model = new Conductores;
        $empresa_model = new Empresa;
		
        $tipo_empresa = $tablaMaestra_model->getMaestroByTipo(79);
        $empresas = $empresa_model->getEmpresaAll();
        $tipo_pago = $tablaMaestra_model->getMaestroByTipo(80);
		
		return view('frontend.empresa_cubicaje.create',compact('tipo_empresa','empresas','tipo_pago'));

	}

    public function listar_empresa_cubicaje_ajax(Request $request){

		$empresa_cubicaje_model = new EmpresaCubicaje;
		$p[]=$request->tipo_empresa;
        $p[]=$request->empresa;
        $p[]=$request->tipo_pago;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_cubicaje_model->listar_empresa_cubicaje_ajax($p);
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

    public function modal_empresa_cubicaje($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $conductor_model = new Conductores;
        $empresa_model = new Empresa;
		
		if($id>0){
            $empresa_cubicaje = EmpresaCubicaje::find($id);
		}else{
			$empresa_cubicaje = new EmpresaCubicaje;
		}

        $tipo_empresa = $tablaMaestra_model->getMaestroByTipo(79);
        $conductor = $conductor_model->getConductoresAll();
        $tipo_pago = $tablaMaestra_model->getMaestroByTipo(80);
        $empresas = $empresa_model->getEmpresaAll();

		return view('frontend.empresa_cubicaje.modal_empresa_cubicaje_nuevoEmpresaCubicaje',compact('id','empresa_cubicaje','tipo_empresa','conductor','tipo_pago','id_user','empresas'));

    }

    public function send_empresa_cubicaje(Request $request){

        $id_user = Auth::user()->id;

        $valida_empresa_cubicaje = EmpresaCubicaje::where('id_tipo_empresa',$request->tipo_empresa)->where('id_empresa',$request->empresa)->where('id_conductor',$request->conductor)->where('estado',1)->first();
        if($valida_empresa_cubicaje){
            $empresa_cubicaje_antigua = EmpresaCubicaje::find($valida_empresa_cubicaje->id);
            $empresa_cubicaje_antigua->estado = 0;
            $empresa_cubicaje_antigua->save();
        }
        

        if($request->id == 0){
            $empresa_cubicaje = new EmpresaCubicaje;
        }else{
            $empresa_cubicaje = EmpresaCubicaje::find($request->id);
        }

        $empresa_cubicaje->id_tipo_empresa = $request->tipo_empresa;
        $empresa_cubicaje->id_empresa = $request->empresa;
        $empresa_cubicaje->id_conductor = $request->conductor;
        $empresa_cubicaje->id_tipo_pago = $request->tipo_pago;
        $empresa_cubicaje->precio_mayor = $request->precio_mayor;
        $empresa_cubicaje->precio_menor = $request->precio_menor;
        $empresa_cubicaje->diametro_dm = $request->diametro_dm;
        $empresa_cubicaje->id_usuario_inserta = $id_user;
        $empresa_cubicaje->estado = 1;
        $empresa_cubicaje->save();

        return response()->json(['id' => $empresa_cubicaje->id]);
        
    }

    public function eliminar_empresa_cubicaje($id,$estado)
    {
		$empresa_cubicaje = EmpresaCubicaje::find($id);

		$empresa_cubicaje->estado = $estado;
		$empresa_cubicaje->save();

		echo $empresa_cubicaje->id;
    }
}
