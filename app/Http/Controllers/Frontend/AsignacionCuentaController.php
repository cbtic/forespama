<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsignacionCuenta;
use App\Models\CuentaContable;
use App\Models\TablaMaestra;
use App\Models\CentroCosto;
use App\Models\StarsoftSubdiario;
use Auth;

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
        $starsoft_subdiario_model = new StarsoftSubdiario;

        $cuenta = $cuenta_contable_model->getCuentaContables();
        $tipo = $tabla_maestra_model->getMaestroByTipo(124);
        $medio_pago = $tabla_maestra_model->getMaestroByTipo(108);
        $centro_costo = $centro_costo_model->getCentroCosto();
        $origen = $starsoft_subdiario_model->getStarsoftSubdiario();

		return view('frontend.asignacion_cuenta.create',compact('cuenta','tipo','centro_costo','medio_pago','origen'));

	}

    public function listar_asignacion_cuenta_ajax(Request $request){

		$asignacion_cuenta_model = new AsignacionCuenta;
		$p[]=$request->cuenta;
        $p[]=$request->tipo;
        $p[]=$request->centro_costo;
        $p[]=$request->medio_pago;
        $p[]=$request->origen;
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
        $cuenta_contable_model = new CuentaContable;
        $centro_costo_model = new CentroCosto;
        $starsoft_subdiario_model = new StarsoftSubdiario;

		if($id>0){
			$asignacion_cuenta = AsignacionCuenta::find($id);
		}else{
			$asignacion_cuenta = new AsignacionCuenta;
		}

		$cuenta = $cuenta_contable_model->getCuentaContables();
        $tipo = $tabla_maestra_model->getMaestroByTipo(124);
        $medio_pago = $tabla_maestra_model->getMaestroByTipo(108);
        $centro_costo = $centro_costo_model->getCentroCosto();
        $origen = $starsoft_subdiario_model->getStarsoftSubdiario();
		$moneda = $tabla_maestra_model->getMaestroByTipo('1');

		return view('frontend.asignacion_cuenta.modal_asignacion_cuenta_nuevoAsignacionCuenta',compact('id','asignacion_cuenta','cuenta','tipo','medio_pago','centro_costo','origen','moneda'));

    }

    public function send_asignacion_cuenta(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$asignacion_cuenta = new AsignacionCuenta;
		}else{
			$asignacion_cuenta = AsignacionCuenta::find($request->id);
		}
		
        $asignacion_cuenta->id_plan_contable = $request->cuenta;
		$asignacion_cuenta->id_tipo_cuenta = $request->tipo;
		$asignacion_cuenta->id_centro_costo = $request->centro_costo;
		$asignacion_cuenta->id_medio_pago = $request->medio_pago;
		$asignacion_cuenta->id_origen = $request->origen;
        $asignacion_cuenta->id_moneda = $request->moneda;
		$asignacion_cuenta->estado = 1;
        $asignacion_cuenta->id_usuario_inserta = $id_user;
		$asignacion_cuenta->save();

        return response()->json(['success' => 'Asignacion Cuenta guardada exitosamente.']);

    }

    public function eliminar_asignacion_cuenta($id,$estado)
    {
		$asignacion_cuenta = AsignacionCuenta::find($id);

		$asignacion_cuenta->estado = $estado;
		$asignacion_cuenta->save();

		echo $asignacion_cuenta->id;
    }
}
