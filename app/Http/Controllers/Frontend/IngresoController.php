<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Valorizacione;
//use App\Models\Val_atencion_smodulo;
use App\Models\TablaMaestra;
use App\Models\Factura;
//use App\Models\Negativo;
use App\Models\CajaIngreso;
//use App\Models\Area;
use Carbon\Carbon;
use Storage;
use Auth;
use Session;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

class IngresoController extends Controller
{

	public function __construct(){
		
		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	
    public function index(){ 
        
    }

    public function create(){
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $valorizaciones_model = new Valorizacione;
        $caja = $caja_model->getCaja('CAJA');
        $caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'CAJA');
        //$caja_usuario = $caja_model;
        //print_r($caja_usuario);exit();
        return view('frontend.ingresos.create',compact('persona','caja','caja_usuario'));

    }


	public function listar_estado_cuenta_ajax(Request $request){
		
		$valorizaciones_model = new Valorizacione;
		$p[]=$request->tipo;
		$p[]=$request->afiliado;
		$p[]=$request->numero_documento;
		$p[]=$request->periodo;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->pago;
		$p[]=$request->flag_tarjeta;
		$p[]=$request->order;
		$p[]=$request->sort_;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $valorizaciones_model->listar_estado_cuenta_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		//print_r($afiliacion);exit();
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;
		
		echo json_encode($result);
		
	}
	

	
	public function create_ingreso_almacen(){
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $valorizaciones_model = new Valorizacione;
        $caja = $caja_model->getCaja('CAJA');
        $caja_usuario = $valorizaciones_model->getCajaIngresoByusuario($id_user,'CAJA');
        
        return view('frontend.ingreso.create_almacen',compact('persona','caja','caja_usuario'));

    }
	
    public function obtener_valorizacion($tipo_documento,$persona_id){

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$persona_id);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }
	
	
    public function obtener_pago($tipo_documento,$persona_id){

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $pago = $valorizaciones_model->getPago($tipo_documento,$persona_id);
        return view('frontend.ingreso.lista_pago',compact('pago'));

    }
	
    public function send(Request $request)
    {

        $valorizaciones_model = new Valorizacione;

        /**********RUC***********/

        $tarifa = $request->mov;
        $val_estab = $request->val_estab;
        $val_total = $request->val_total;
        $vsm_smodulod = $request->vsm_smodulod;
        $tipo = $request->tipo;
        $id_factura = $valorizaciones_model->registrar_factura('F001',0,$tipo,$request->id_ubicacion,$request->persona_id,'0','','124554',0,0,'f');

        $factura = Factura::where('id', $id_factura)->get()[0];        
        //$factura = Factura::where('fac_serie', '=', 'F001')->where('fac_numero', '=', $id)->where('fac_tipo', '=', 'FT')->first();
        $fac_serie = $factura->fac_serie;
        $facd_numero = $factura->fac_numero;
        
        foreach ($tarifa as $key => $value) {
            $id_factura_detalle = $valorizaciones_model->registrar_factura('F001',$id_factura,$tipo,0,0,$val_total[$key],$vsm_smodulod[$key],'124554',$value,$val_estab[$key],'d');
        }

        echo $id_factura_detalle;


        //Mail::send(new SendContact($request));

        //return redirect()->back()->withFlashSuccess(__('alerts.frontend.contact.sent'));
    }
	
	public function send_estado(Request $request){
	
		$dudoso = $request->mov_dudoso;
		$detalle_dudoso = $request->detalle_dudoso;
		$activo = $request->factura_detalles;
		$detalle_activo = $request->factura_detalle;
		$estado = $request->estado;
		if($estado == "A"){
			if(isset($dudoso)){
				foreach($dudoso as $key => $value) {
					$lista_valorizacion = Val_atencion_smodulo::where('vsm_vestab', '=', $detalle_dudoso[$key]["vestab"])->where('vsm_vnumero', '=', $detalle_dudoso[$key]["vcodigo"])->where('vsm_modulo', '=', $detalle_dudoso[$key]["modulo"])->where('vsm_smodulo', '=', $detalle_dudoso[$key]["smodulo"])->get();
					
					foreach($lista_valorizacion as $row){
						$valorizacion = Val_atencion_smodulo::find($row->id);
						$valorizacion->vsm_estado = $estado;
						$valorizacion->save();
					}
					
				}
			}
		}
		
		if($estado == "D"){
			if(isset($activo)){
				foreach($activo as $key => $value) {
					$lista_valorizacion = Val_atencion_smodulo::where('vsm_vestab', '=', $detalle_activo[$key]["vestab"])->where('vsm_vnumero', '=', $detalle_activo[$key]["vcodigo"])->where('vsm_modulo', '=', $detalle_activo[$key]["modulo"])->where('vsm_smodulo', '=', $detalle_activo[$key]["smodulo"])->get();
					
					foreach($lista_valorizacion as $row){
						$valorizacion = Val_atencion_smodulo::find($row->id);
						$valorizacion->vsm_estado = $estado;
						$valorizacion->save();
					}
					
					$val = Valorizacione::where('val_estab', '=', $detalle_activo[$key]["vestab"])->where('val_codigo', '=', $detalle_activo[$key]["vcodigo"])->first();
					$id_persona = $val->val_persona;
					
					if($id_persona > 0){
						
						$persona = Persona::find($id_persona);
						$persona->flag_negativo = 1;
						$persona->save();
						
						$negativo = Negativo::where('persona_id',$persona->id)->where('flag_negativo',1)->orderBy('id', 'desc')->first();
						
						if(!$negativo){
							$negativo = new Negativo;
							$negativo->persona_id = $persona->id;
							$negativo->flag_negativo = 1;
							$negativo->observacion = "Cuenta dudosa";
							$negativo->fecha = Carbon::now()->format('Y-m-d');
							$negativo->save();
						}
						
					}
					
				}
				
				
				
			}
		}
		
	}
	
	public function sendCaja(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		
		$datos[] = $request->id_caja_ingreso;
        $datos[] = $request->id_caja;
        $datos[] = ($request->saldo_inicial=='')?0:$request->saldo_inicial;
        $datos[] = ($request->total_recaudado=='')?0:$request->total_recaudado;
        $datos[] = ($request->saldo_total=='')?0:$request->saldo_total;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }
	
    public function sendCajaMoneda(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		/*
		$datos[] = $request->id_caja_ingreso;
        $datos[] = $request->id_caja;
        $datos[] = ($request->saldo_inicial=='')?0:$request->saldo_inicial;
        $datos[] = ($request->total_recaudado=='')?0:$request->total_recaudado;
        $datos[] = ($request->saldo_total=='')?0:$request->saldo_total;
		*/
		
		$datos[] = $request->id_caja_ingreso_soles;
        $datos[] = $request->id_caja_soles;
        $datos[] = ($request->saldo_inicial_soles=='')?0:$request->saldo_inicial_soles;
        $datos[] = ($request->total_recaudado_soles=='')?0:$request->total_recaudado_soles;
        $datos[] = ($request->saldo_total_soles=='')?0:$request->saldo_total_soles;
		
		$datos[] = $request->id_caja_ingreso_dolares;
        $datos[] = $request->id_caja_dolares;
        $datos[] = ($request->saldo_inicial_dolares=='')?0:$request->saldo_inicial_dolares;
        $datos[] = ($request->total_recaudado_dolares=='')?0:$request->total_recaudado_dolares;
        $datos[] = ($request->saldo_total_dolares=='')?0:$request->saldo_total_dolares;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso_moneda($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }


	public function txt(){
		
		$path = public_path('tmp/txt/');
		$persona = Persona::all();
		$content = "";
		foreach ($persona as $per) {
			$content .= trim($per->nombres)."|";
			$content .= trim($per->apellido_paterno)."|";
			$content .= trim($per->apellido_materno);
			$content .= "\r\n";
		}
        $file = Storage::disk('public')->put("facturas_detalle.txt", $content);
		  
	}
	
	public function liquidacion_caja(){
	
		$caja_model = new TablaMaestra;
        $caja = $caja_model->getCajaAll();
		
        return view('frontend.ingreso.all_liquidacion_caja',compact('caja'));

    }
	
	public function modal_liquidacion($id){
		
		$valorizaciones_model = new Valorizacione;
		return view('frontend.ingreso.modal_liquidacion',compact('id'));
	
	}
	
	public function modal_detalle_factura($id){
		
		$cajaIngreso = CajaIngreso::find($id);
		$factura_model = new Factura;
		$fecha_fin=$cajaIngreso->fecha_fin;
		if($cajaIngreso->fecha_fin=="")$fecha_fin=$factura_model->fecha_hora_actual();
		$factura = $factura_model->getFacturaByCaja($cajaIngreso->id_caja,$cajaIngreso->fecha_inicio,$fecha_fin);
		return view('frontend.ingreso.modal_detalle_factura',compact('factura'));
	
	}
	
	public function modal_valorizacion_factura($id){
		
		$valorizaciones_model = new Valorizacione;
		$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_valorizacion_factura',compact('valorizacion'));
	
	}
	
	public function updateCajaLiquidacion(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = "ul";
        $datos[] = $id_user;
        $datos[] = $request->id_caja_ingreso;
		$datos[] = $request->id_caja;
        $datos[] = "";
        $datos[] = "";
        $datos[] = ($request->saldo_liquidado=='')?0:$request->saldo_liquidado;
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        
		//echo $id_caja_ingreso;
        return redirect('/ingreso/liquidacion_caja');
		
    }	
	
	public function listar_liquidacion_caja_ajax(Request $request){
		
		$valorizaciones_model = new Valorizacione;
		$p[]=$request->fecha_inicio_desde;
		$p[]=$request->fecha_inicio_hasta;
		$p[]=$request->fecha_ini;
		$p[]=$request->fecha_fin;
		$p[]=$request->id_caja;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
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
	
	public function exportar_liquidacion_caja($fecha_inicio_desde,$fecha_inicio_hasta,$fecha_ini, $fecha_fin,$id_caja,$estado) {
		
		$valorizaciones_model = new Valorizacione;
		if($fecha_inicio_desde!=0)$fecha_inicio_desde = str_replace("-","/",$fecha_inicio_desde); else $fecha_inicio_desde = "";
		if($fecha_inicio_hasta!=0)$fecha_inicio_hasta = str_replace("-","/",$fecha_inicio_hasta); else $fecha_inicio_hasta = "";
		if($fecha_ini!=0)$fecha_ini = str_replace("-","/",$fecha_ini); else $fecha_ini = "";
		if($fecha_fin!=0)$fecha_fin = str_replace("-","/",$fecha_fin); else $fecha_fin = "";
		$p[]=$fecha_inicio_desde;
		$p[]=$fecha_inicio_hasta;
		$p[]=$fecha_ini;
		$p[]=$fecha_fin;
		$p[]=$id_caja;
		$p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Usuario Caja", "Nombre Caja", "Tipo", "Estado", "Saldo Inicial", "Total Recaudado","Saldo Total","Fecha Inicio","Fecha Cierre","Usuario Contabilidad","Saldo Liquidado","Observacion"));
		foreach ($data as $r) {
			$estado = "";
			$disabled = "";
			if($r->estado == 0){
				$estado = "CERRADO";
				$disabled = "";
			}
			if($r->estado == 1){
				$estado = "ABIERTO";
				$disabled = "disabled='disabled'";
			}
			if($r->saldo_liquidado > 0){
				$estado = "LIQUIDADO";
				$disabled = "disabled='disabled'";
			}
			array_push($variable, array($n++,$r->usuario, $r->caja, $r->tipo,$estado, number_format($r->saldo_inicial,2), number_format($r->total_recaudado,2),number_format($r->saldo_total,2),$r->fecha_inicio, $r->fecha_fin, $r->usuario_contabilidad,($r->saldo_liquidado!="")?number_format($r->saldo_liquidado,2):0,$r->observacion));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'liquidacion_caja.xlsx');
    }
	
	public function exportar_estado_cuenta($tipo,$afiliado,$numero_documento,$periodo,$fecha_inicio,$fecha_fin,$pago,$order,$sort) {
		
		$valorizaciones_model = new Valorizacione;
		if($tipo=="0")$tipo = "";
		if($afiliado=="0")$afiliado = "";
		if($numero_documento=="0")$numero_documento = "";
		if($periodo=="0")$periodo = "";
		if($fecha_inicio!=0)$fecha_inicio = str_replace("-","/",$fecha_inicio); else $fecha_inicio = "";
		if($fecha_fin!=0)$fecha_fin = str_replace("-","/",$fecha_fin); else $fecha_fin = "";
		if($pago=="0")$pago = "";
		if($order=="0")$order = "";
		$p[]=$tipo;
		$p[]=$afiliado;
		$p[]=$numero_documento;
		$p[]=$periodo;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$pago;
		$p[]=$order;
		$p[]=$sort;
		$p[]=1;
		$p[]=10000;
		$data = $valorizaciones_model->listar_estado_cuenta_ajax($p);
		
		$variable = [];
		$n = 1;
		if($pago == "N"){
			array_push($variable, array("N","Fecha", "Tipo Doc.", "Documento", "Nombres Y Apellidos", "Plan", "Periodo", "Concepto Corto", "Concepto Largo","Dscto","Monto"));
			foreach ($data as $r) {
				array_push($variable, array($n++,$r->val_fecha, $r->tipo_documento,$r->numero_documento, $r->val_pac_nombre,$r->plan_denominacion,$r->periodo,$r->smod_control, $r->vsm_smodulod, $r->descuento,$r->vsm_precio));
			}
		}else{
			array_push($variable, array("N", "Tipo Doc.","Documento", "Nombres Y Apellidos", "Plan", "Periodo", "Concepto Corto","Fecha Fac","Tipo","Serie","Numero","Importe"));
			foreach ($data as $r) {
				array_push($variable, array($n++,$r->tipo_documento,$r->numero_documento, $r->val_pac_nombre,$r->plan_denominacion,$r->periodo,$r->smod_control,$r->fac_fecha,$r->fac_tipo,$r->fac_serie,$r->fac_numero,$r->fac_total));
			}
		};
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'estado_cuenta.xlsx');
    }
	
	
	public function eliminar_valorizacion($id)
    {	
		$valorizacion = Valorizacione::find($id);		
		$valorizacion_atencion_smodulo = Val_atencion_smodulo::where('vsm_vnumero', '=', $valorizacion->val_codigo)->where('vsm_modulo', '=', '2')->where('vsm_smodulo', '=', '23')->first();
		$valorizacion_atencion_smodulo->vsm_eliminado = "S";
		$valorizacion_atencion_smodulo->save();

    }
	
	public function eliminar_valorizacion_bloque(Request $request)
    {	
		$mov = $request->mov;
		
		foreach ($mov as $key => $value) {
            $id = $value;
			$valorizacion_atencion_smodulo = Val_atencion_smodulo::find($id);		
			$valorizacion_atencion_smodulo->vsm_eliminado = "S";
			$valorizacion_atencion_smodulo->save();
        }

    }
	
	
	public function modal_responsable($id){
		
		return view('frontend.ingreso.modal_responsable',compact('id'));
	
	}
	
	public function send_responsable(Request $request){
		
		$id_valorizacion = $request->id_valorizacion;
		$observacion_responsable = $request->observacion_responsable;
		
		$valorizacion = Valorizacione::find($id_valorizacion);
		
		$cronogramaDetalle = Val_atencion_smodulo::where('vsm_vestab', '=', $valorizacion->val_estab)->where('vsm_vnumero', '=', $valorizacion->val_codigo)
		->where('vsm_modulo', '=', 2)->where('vsm_smodulo', '=', 23)->first();
		$cronogramaDetalle->observacion_responsable = $request->observacion_responsable;
		$cronogramaDetalle->save(); 
		
	}
	
			
}

class InvoicesExport implements FromArray
	{
    	protected $invoices;

    	public function __construct(array $invoices)
    	{
        	$this->invoices = $invoices;
    	}

    	public function array(): array
    	{
        	return $this->invoices;
    	}
}
