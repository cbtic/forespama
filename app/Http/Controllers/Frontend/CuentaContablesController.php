<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CuentaContable;
use App\Models\TablaMaestra;
use Auth;

class CuentaContablesController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Mantenimiento Cuenta Contable')->only(['create']);
	}

    public function create(){
		
		$tabla_maestra_model = new TablaMaestra;

		$tipo = $tabla_maestra_model->getMaestroByTipo('118');

		return view('frontend.cuenta_contable.create',compact('tipo'));
	}

    public function listar_cuenta_contable_ajax(Request $request){

		$cuenta_contable_model = new CuentaContable;
		$p[]=$request->tipo;
		$p[]=$request->denominacion;
		$p[]=$request->cuenta;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $cuenta_contable_model->listar_cuenta_contable_ajax($p);
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

    public function modal_cuenta_contable($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$cuenta_contable = CuentaContable::find($id);
		}else{
			$cuenta_contable = new CuentaContable;
		}

		$tipo = $tabla_maestra_model->getMaestroByTipo('118');

		return view('frontend.cuenta_contable.modal_cuentaContable_nuevoCuentaContable',compact('id','cuenta_contable','tipo'));

    }

    public function send_cuenta_contable(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$cuenta_contable = new CuentaContable;
		}else{
			$cuenta_contable = CuentaContable::find($request->id);
		}
		
        $cuenta_contable->id_tipo = $request->tipo;
        $cuenta_contable->denominacion = $request->denominacion;
        $cuenta_contable->cuenta = $request->cuenta;
		$cuenta_contable->estado = 1;
        $cuenta_contable->id_usuario_inserta = $id_user;
		$cuenta_contable->save();

        return response()->json(['success' => 'Cuenta Contable guardado exitosamente.']);

    }

    public function eliminar_cuenta_contable($id,$estado)
    {
		$cuenta_contable = CuentaContable::find($id);

		$cuenta_contable->estado = $estado;
		$cuenta_contable->save();

		echo $cuenta_contable->id;
    }
}
