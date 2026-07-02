<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionCuenta;
use App\Models\CuentaContable;
use App\Models\TablaMaestra;
use App\Models\CentroCosto;

class AsignacionCuentaController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Asignacion Cuentas')->only(['create']);
	}

    public function create(){
		
        $cuenta_contable_model = new CuentaContable;
        $tabla_maestra_model = new TablaMaestra;
        $centro_costo_model = new CentroCosto;

        $cuenta = $cuenta_contable_model->getCuentaContables();
        $tipo = $tabla_maestra_model->getMaestroByTipo(124);
        $medio_pago = $tabla_maestra_model->getMaestroByTipo(108);
        $centro_costo = $centro_costo_model->getCentroCosto();

		return view('frontend.asignacion_cuenta.create',compact('cuenta','tipo','centro_costo','medio_pago'));

	}

    public function listar_asignacion_cuenta_ajax(Request $request){

		$asignacion_cuenta_model = new AsignacionCuenta;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asignacion_cuenta_model->listar_asignacion_cuenta_ajax($p);
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

    public function modal_asignacion_cuenta($id){
		
		$tabla_maestra_model = new TablaMaestra;

		if($id>0){
			$asignacion_cuenta = AsignacionCuenta::find($id);
		}else{
			$asignacion_cuenta = new AsignacionCuenta;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');

		return view('frontend.asignacion_cuenta.modal_asignacion_cuenta_nuevoAsignacionCuenta',compact('id','asignacion_cuenta','tipo_marca'));

    }

    public function send_asignacion_cuenta(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$asignacion_cuenta = new AsignacionCuenta;
		}else{
			$asignacion_cuenta = AsignacionCuenta::find($request->id);
		}
		
        $asignacion_cuenta->denominiacion = $request->denominacion;
		$asignacion_cuenta->id_tipo_marca = $request->tipo_marca;
		$asignacion_cuenta->estado = 1;
        $asignacion_cuenta->id_usuario_inserta = $id_user;
		$asignacion_cuenta->save();

        return response()->json(['success' => 'Asignacion Cuenta guardada exitosamente.']);

    }
}
