<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AliadosPamaComisione;
use App\Models\AliadoPama;
use App\Models\TablaMaestra;
use App\Models\User;
use App\Models\Comprobante;
use App\Models\ComisionParametro;
use App\Models\ComisionSolicitude;
use Carbon\Carbon;
use Auth;

class AliadosPamaComisionesController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Estado de Cuenta Aliados Pama')->only(['create']);
		$this->middleware('can:Solicitudes Aliados Pama')->only(['create_solicitud']);
	}

    public function create(){

		$user_model = new User;
		$tablaMaestra_model = new TablaMaestra;

		$id_user = Auth::user()->id;

		$user_roles = $user_model->getRolByUser($id_user);
		$estado_pago_comision = $tablaMaestra_model->getMaestroByTipo(125);
		
		/*foreach($user_roles as $r){
			if($r == '37'){

			}
		}*/
		
		return view('frontend.aliados_pama_comisiones.create',compact('user_roles','id_user','estado_pago_comision'));

	}

    public function listar_aliados_pama_comisiones_ajax(Request $request){

		$id_user = Auth::user()->id;

		$aliados_pama_comisiones_model = new AliadosPamaComisione;
		$p[]=$request->numero_documento;
		$p[]=$id_user;
		//$p[]=$request->estado_pago;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $aliados_pama_comisiones_model->listar_aliados_pama_comisiones_ajax($p);
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

	public function modal_retiro_comision_aliado_pama($id){
		
		$tabla_maestra_model = new TablaMaestra;

		$montos = $tabla_maestra_model->getMaestroByTipo(127);

		return view('frontend.aliados_pama_comisiones.modal_aliado_pama_retiro_nuevoAliadoPamaRetiro',compact('id','montos'));

    }

	public function solicitar_retiro_comision_aliado_pama(Request $request)
    {
		$id_user = Auth::user()->id;
		
		if (empty($request->id)){
			return response()->json([
				'success' => false,
				'message' => 'Debe seleccionar al menos una comisión.'
			]);
		}
		
		$monto_retiro = (double) $request->monto_solicitado;

		if ($monto_retiro <= 0) {
			return response()->json([
				'success' => false,
				'message' => 'El monto seleccionado no es válido.'
			]);
		}

		$aliado_pama = AliadoPama::where('id_persona',$request->id)->where('estado',1)->first();

		if(!$aliado_pama){
			return response()->json([
				'success' => false,
				'message' => 'No se encontró el Aliado PAMA.'
			]);
		}

		$comprobantes = Comprobante::where('id_aliado_pama',$aliado_pama->id)->where('anulado','N')->where('estado',1)->where('estado_pago_comision',1)->orderBy('id', 'asc')->get();

		if($comprobantes->isEmpty()){
			return response()->json([
				'success' => false,
				'message' => 'El aliado no tiene comisiones pendientes de pago.'
			]);
		}
		
		$total_comision_pendiente = 0;

		foreach($comprobantes as $comprobante){

			$comision_total = $comprobante->total * ($comprobante->porcentaje_comision / 100);

			$monto_pagado = (double) $comprobante->monto_pagado_comision;

			$comision_pendiente = $comision_total - $monto_pagado;

			if ($comision_pendiente > 0) {
				$total_comision_pendiente += $comision_pendiente;
			}
		}

		if ($monto_retiro > $total_comision_pendiente) {

			return response()->json([
				'success' => false,
				'message' => 'El monto solicitado de S/ ' . number_format($monto_retiro, 2) . ' supera el monto de comisión pendiente de S/ ' . number_format($total_comision_pendiente, 2) . '.'
			]);
		}

		$comision_parametro_model = new ComisionParametro;

		$ultimo_parametro = $comision_parametro_model->getUltimoParametro();

		$minimo_retiro = (double) $ultimo_parametro[0]->minimo_retiro;
		
		if($monto_retiro < $minimo_retiro){

			return response()->json([
				'success' => false,
				'message' => 'El monto mínimo para solicitar el retiro de comisión es de S/ ' . number_format($minimo_retiro, 2) . '. El monto seleccionado es de S/ ' . number_format($monto_retiro, 2)
			]);
		}

		$monto_por_pagar = $monto_retiro;
		$comprobantes_actualizados = [];

		foreach($comprobantes as $comprobante){

			if($monto_por_pagar <= 0){
				break;
			}

			$comision_total = $comprobante->total * ($comprobante->porcentaje_comision / 100);

			$monto_pagado_actual = (double) $comprobante->monto_pagado_comision;

			$monto_pendiente = $comision_total - $monto_pagado_actual;

			if($monto_pendiente <= 0){
				continue;
			}

			if($monto_por_pagar >= $monto_pendiente){

				$monto_pago = $monto_pendiente;
				$comprobante->monto_pagado_comision = $monto_pagado_actual + $monto_pago;
				$comprobante->estado_pago_comision = 2;
				$monto_por_pagar -= $monto_pago;
			}else{

				$monto_pago = $monto_por_pagar;
				$comprobante->monto_pagado_comision = $monto_pagado_actual + $monto_pago;
				$comprobante->estado_pago_comision = 1;
				$monto_por_pagar = 0;
			}

			$comprobante->fecha_solicitud_retiro_comision = Carbon::now()->format('Y-m-d');
			$comprobante->save();

			$comprobantes_actualizados[] = $comprobante->id;
		
		}

		$comision_solicitud = new ComisionSolicitude;
		$comision_solicitud->id_aliado_pama = $aliado_pama->id;
		$comision_solicitud->monto = $monto_retiro;
		$comision_solicitud->estado_solicitud = 2;
		$comision_solicitud->id_usuario_inserta = $id_user;
		$comision_solicitud->save();
		$id_comision_solicitud = $comision_solicitud->id;

		foreach($comprobantes_actualizados as $id_comprobante){

			$update_comprobante = Comprobante::find($id_comprobante);
			$update_comprobante->id_comision_solicitud = $id_comision_solicitud;
			$update_comprobante->save();
		}

		return response()->json([
			'success' => true,
			'message' => 'Solicitud de retiro enviada correctamente.'
		]);
    }

    public function send_retiro_comision_aliado_pama(Request $request){

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
		$aliado_pama->save();

        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->id_ubigeo_nacimiento = $request->id_distrito_nacimiento;
        $persona->email = $request->correo;
        $persona->telefono = $request->numero_celular;
        $persona->direccion = $request->direccion;
        $persona->save();

        return response()->json(['success' => 'Aliado Pama guardada exitosamente.']);

    }

    public function eliminar_aliados_pama_comisiones($id,$estado)
    {
		$aliados_pama_comisiones = AliadosPamaComisione::find($id);

		$aliados_pama_comisiones->estado = $estado;
		$aliados_pama_comisiones->save();

		echo $aliados_pama_comisiones->id;
    }

	public function obtener_datos_aliado($numero_documento){
		
		$aliado_pama_model = new AliadoPama;
		$aliado_pama = $aliado_pama_model->getDatosAliado($numero_documento);
		
		return response()->json([
			'success' => true,
			'aliado_pama' => $aliado_pama
		]);
	}

	public function modal_aliado_pama_caja(){
		
		return view('frontend.aliados_pama_comisiones.modal_aliado_pama_caja_nuevoAliadoPamaCaja');
	}

	public function modal_detalle_comision_aliado_pama($id){

		//$aliado_pama_model = new AliadosPamaComisione;

		//$detalle_comision_aliado_pama = $aliado_pama_model->getDetalleComisionAliadoPama($id);

		return view('frontend.aliados_pama_comisiones.modal_aliado_pama_detalle_nuevoAliadoPamaDetalle',compact('id'/*,'detalle_comision_aliado_pama'*/));
    }

	public function cargar_detalle($id)
    {

        $aliado_pama_model = new AliadosPamaComisione;

        $detalle_comision_aliado_pama = $aliado_pama_model->getDetalleComisionAliadoPama($id);

        return response()->json([
            'detalle_comision_aliado_pama' => $detalle_comision_aliado_pama,
        ]);
    }

	public function create_solicitud(){

		$tablaMaestra_model = new TablaMaestra;

		$estado_pago_comision = $tablaMaestra_model->getMaestroByTipo(125);
		
		return view('frontend.aliados_pama_comisiones.create_solicitud',compact('estado_pago_comision'));

	}

    public function listar_aliados_pama_solicitud_comisiones_ajax(Request $request){

		$id_user = Auth::user()->id;

		$aliados_pama_solicitud_comisiones_model = new ComisionSolicitude;
		$p[]=$request->numero_documento;
		$p[]=$request->estado_pago;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $aliados_pama_solicitud_comisiones_model->listar_aliados_pama_solicitud_comisiones_ajax($p);
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

	public function aprobar_aliados_pama_solicitud_comisiones(Request $request){

        $id_user = Auth::user()->id;

        $comision_solicitud = ComisionSolicitude::find($request->id);

		$comision_solicitud->estado_solicitud = 3;
		$comision_solicitud->id_usuario_aprueba = $id_user;
		$comision_solicitud->id_usuario_inserta = $id_user;
		$comision_solicitud->estado = 1;
		$comision_solicitud->save();
        
        return response()->json(['id' => $request->id]);
        
    }

	public function rechazar_aliados_pama_solicitud_comisiones(Request $request){

        $id_user = Auth::user()->id;

        $comision_solicitud = ComisionSolicitude::find($request->id);

		$comision_solicitud->estado_solicitud = 5;
		$comision_solicitud->id_usuario_aprueba = $id_user;
		$comision_solicitud->id_usuario_inserta = $id_user;
		$comision_solicitud->estado = 1;
		$comision_solicitud->save();

		$comprobantes = Comprobante::where('id_comision_solicitud',$comision_solicitud->id)->where('estado',1)->get();

		foreach($comprobantes as $comprobante){

			$update_comprobante = Comprobante::find($comprobante->id);
			$update_comprobante->monto_pagado_comision = 0;
			$update_comprobante->estado_pago_comision = 1;
			$update_comprobante->save();
		}
        
        return response()->json(['id' => $request->id]);
        
    }

	public function aprobar_aliados_pama_solicitud_pago(Request $request){

        $id_user = Auth::user()->id;

        $comision_solicitud = ComisionSolicitude::find($request->id);

		$comision_solicitud->estado_solicitud = 4;
		$comision_solicitud->id_usuario_aprueba = $id_user;
		$comision_solicitud->id_usuario_inserta = $id_user;
		$comision_solicitud->estado = 1;
		$comision_solicitud->save();

		$comprobantes = Comprobante::where('id_comision_solicitud',$comision_solicitud->id)->where('estado',1)->where('estado_pago_comision',2)->get();

		foreach($comprobantes as $comprobante){

			$update_comprobante = Comprobante::find($comprobante->id);
			$update_comprobante->estado_pago_comision = 4;
			$update_comprobante->save();
		}
        
        return response()->json(['id' => $request->id]);
        
    }	
}
