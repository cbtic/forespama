<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\GuiaInterna;
use App\Models\GuiaInternaDetalle;
use App\Models\Ubigeo;
use App\Models\Guia;
use App\Models\GuiaDetalle;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;

class GuiaInternaController extends Controller
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

        /*$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
        $user_model = new User;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        //$proveedor = Empresa::all();
        $almacen = Almacene::all();
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $responsable_atencion = $user_model->getUserAll();*/

        $tablaMaestra_model = new TablaMaestra;
        //$empresa_model = new Empresa;

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        //$transporte_razon_social = $empresa_model->obtenerRazonSocialTransporteAll();

        
		return view('frontend.guia_interna.create',compact('tipo_documento'/*,'transporte_razon_social'*/));

	}

    public function listar_guia_interna_ajax(Request $request){

		$guia_interna_model = new GuiaInterna;
		$p[]=$request->tipo_documento;
        $p[]=$request->fecha;
        $p[]=$request->numero_guia;
        $p[]=$request->numero_documento;
        $p[]=$request->empresa_destino;
        $p[]=$request->placa;
        $p[]=$request->empresa_transporte;
        $p[]=$request->origen;
        $p[]=$request->destino;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $guia_interna_model->listar_guia_interna_ajax($p);
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

    public function modal_guia_interna($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $empresa_model = new Empresa;
        $ubigeo_model = new Ubigeo;
		
		if($id>0){
            $guia_interna = GuiaInterna::find($id);
		}else{
			$guia_interna = new GuiaInterna;
        }

        $tipo_documento_entrada = $tablaMaestra_model->getMaestroByTipo(48);
        $tipo_documento_salida = $tablaMaestra_model->getMaestroByTipo(49);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaVehiculo();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$transporte_razon_social = $empresa_model->obtenerRazonSocialTransporteAll();
        $empresas = Empresa::all();
        $motivo_traslado = $tablaMaestra_model->getMaestroByTipo(63);
        $departamento = $ubigeo_model->getDepartamento();
        $serie_guia = $tablaMaestra_model->getMaestroC(95,"GR");

        return view('frontend.guia_interna.modal_guia_interna_nuevoGuiaInterna',compact('id','guia_interna','tipo_documento_entrada','tipo_documento_salida','producto','marca','estado_bien','unidad','empresas',/*'transporte_razon_social',*/'motivo_traslado','departamento','serie_guia'));

    }

    public function send_guia_interna(Request $request)
    {
        $id_user = Auth::user()->id;
        $tabla_maestra_model = new TablaMaestra;

        if($request->id == 0){
            $guia_interna = new GuiaInterna;
            $guia = new Guia;
            
        }else{
            $guia_interna = GuiaInterna::find($request->id);
            $guia = Guia::find($request->id);
        }

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $descripcion_ = $request->input('descripcion_');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        
        $tipo_guia = $tabla_maestra_model->getMaestroDeno(95,$request->serie_guia);
        //dd($tipo_guia);exit();
        $id_guia_interna_detalle =$request->id_guia_interna_detalle;
        
        $guia_interna->fecha_emision = $request->fecha_emision;
        $guia_interna->punto_partida = $request->punto_partida;
        $guia_interna->punto_llegada = $request->punto_llegada;
        $guia_interna->fecha_traslado = $request->fecha_inicio_traslado;
        $guia_interna->costo_minimo = $request->costo_minimo;
        $guia_interna->id_destinatario = $request->destinatario;
        $guia_interna->id_conductor = $request->id_conductor_guia;
        $guia_interna->ruc_destinatario = $request->ruc;
        $guia_interna->marca = $request->id_marca_vehiculo;
        $guia_interna->placa = $request->placa_guia;
        $guia_interna->constancia_inscripcion = $request->numero_inscripcion;
        $guia_interna->licencia_conducir = $request->numero_licencia;
        $guia_interna->id_empresa_transporte = $request->id_transporte_razon_social;
        $guia_interna->ruc_empresa_transporte = $request->ruc_transporte;
        $guia_interna->id_tipo_documento = $request->tipo_documento;
        $guia_interna->numero_documento = $request->numero_documento;
        $guia_interna->id_motivo_traslado = $request->motivo_traslado;
        $guia_interna->id_ubigeo_partida = $request->distrito_partida;
        $guia_interna->id_ubigeo_llegada = $request->distrito_llegada;
        $guia_interna->guia_serie = $request->serie_guia;
        $guia_interna->guia_numero = $request->numero_guia;
        $guia_interna->guia_tipo = $tipo_guia[0]->codigo;
        $guia_interna->id_usuario_inserta = $id_user;
        $guia_interna->estado = 1;
        $guia_interna->save();        

        $guia->guia_serie = $request->serie_guia;
        $guia->guia_numero = $request->numero_guia;
        $guia->guia_tipo = $tipo_guia[0]->codigo;
        $guia->guia_fecha_emision = $request->fecha_emision;
        $guia->guia_fecha_traslado = $request->fecha_inicio_traslado;
        $guia->guia_vehiculo_placa = $request->placa_guia;
        $guia->guia_llegada_ubigeo = $request->distrito_llegada;
        $guia->guia_llegada_direccion = $request->punto_llegada;
        $guia->guia_partida_ubigeo = $request->distrito_partida;
        $guia->guia_partida_direccion = $request->punto_partida;
        $guia->guia_anulado = "N"; 
        $guia->guia_cod_motivo = $request->motivo_traslado;
        $guia->id_usuario_inserta = $id_user;
        $guia->save();

        $array_guia_interna_detalle = array();

        foreach($item as $index => $value) {
            
            //if($id_guia_interna_detalle[$index] == 0){
                $guia_interna_detalle = new GuiaInternaDetalle;
                $guia_detalle = new GuiaDetalle;
                $tabla_maestra_model = new TablaMaestra;
                $abreviatura_unidad_medida = $tabla_maestra_model->getMaestroC(43,$unidad[$index]);
            //}else{
            //    $guia_interna_detalle = GuiaInternaDetalle::find($id_guia_interna_detalle[$index]);
            //}
            
            $guia_interna_detalle->id_guia_interna = $guia_interna->id;
            $guia_interna_detalle->id_producto = $descripcion[$index];
            $guia_interna_detalle->cantidad = $cantidad[$index];
            $guia_interna_detalle->id_estado_producto = $estado_bien[$index];
            $guia_interna_detalle->id_unidad_medida = $unidad[$index];
            $guia_interna_detalle->id_marca = $marca[$index];
            $guia_interna_detalle->estado = 1;
            $guia_interna_detalle->id_usuario_inserta = $id_user;

            $guia_interna_detalle->save();

            $guia_detalle->guiad_serie = "T001";
            $guia_detalle->guiad_numero = "16";
            $guia_detalle->guiad_tipo = "GR";
            $guia_detalle->guiad_codigo = $cod_interno[$index];
            $guia_detalle->guiad_descripcion = $descripcion_[$index];
            $guia_detalle->guiad_cantidad = $cantidad[$index];
            $guia_detalle->guiad_unid_medida = $abreviatura_unidad_medida[0]->abreviatura;
            $guia_detalle->id_usuario_inserta = $id_user;
            $guia_detalle->save();

            $array_guia_interna_detalle[] = $guia_interna_detalle->id;

            $GuiaInternaAll = GuiaInternaDetalle::where("id_guia_interna",$guia_interna->id)->where("estado","1")->get();
            
            foreach($GuiaInternaAll as $key=>$row){
                
                if (!in_array($row->id, $array_guia_interna_detalle)){
                    $guia_interna_detalle = GuiaInternaDetalle::find($row->id);
                    $guia_interna_detalle->estado = 0;
                    $guia_interna_detalle->save();
                }
            }
        }



        return response()->json(['id' => $guia_interna->id]);
    }

    public function obtener_provincia_distrito($id){
		
		$guia_interna_model = new GuiaInterna;
		$ubigeo_guia_interna = $guia_interna_model->getProvinciaDistritoById($id);
		
		echo json_encode($ubigeo_guia_interna);
	}

    public function obtener_numero_guia($serie_guia){
		
		$guia_interna_model = new GuiaInterna;
		$numero_guia = $guia_interna_model->getNumeroGuia($serie_guia);
		
		echo json_encode($numero_guia);
	}

    public function guia_interna_pdf($id){

        $guia_interna_model = new GuiaInterna;
        $guia_interna_detalle_model = new GuiaInternaDetalle;

        $datos=$guia_interna_model->getGuiaInternaById($id);
        $datos_detalle=$guia_interna_detalle_model->getDetalleGuiaInternaPdf($id);

        $fecha_emision=$datos[0]->fecha_emision;
        $punto_partida=$datos[0]->punto_partida;
        $punto_llegada=$datos[0]->punto_llegada;
        $fecha_traslado=$datos[0]->fecha_traslado;
        $costo_minimo=$datos[0]->costo_minimo;
        $destinatario = $datos[0]->destinatario;
        $ruc_destinatario = $datos[0]->ruc_destinatario;
        $marca=$datos[0]->marca;
        $placa=$datos[0]->placa;
        $constancia_inscripcion=$datos[0]->constancia_inscripcion;
        $licencia_conducir=$datos[0]->licencia_conducir;
        $empresa_transporte=$datos[0]->empresa_transporte;
        $ruc_empresa_transporte=$datos[0]->ruc_empresa_transporte;
        $motivo_traslado=$datos[0]->motivo_traslado;
        $conductor=$datos[0]->conductor;
        $guia_serie=$datos[0]->guia_serie;
        $guia_numero=$datos[0]->guia_numero;
        //$tipo_empresa = 'Vende';

		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('d-m-Y');

		 $currentHour = Carbon::now()->format('H:i:s'); 

		$pdf = Pdf::loadView('frontend.guia_interna.guia_interna_pdf',compact('fecha_emision', 'punto_partida', 'punto_llegada', 'fecha_traslado', 'costo_minimo', 'destinatario', 'ruc_destinatario', 'marca', 'placa', 'constancia_inscripcion', 'licencia_conducir', 'empresa_transporte', 'ruc_empresa_transporte', 'motivo_traslado', 'conductor', 'guia_serie', 'guia_numero' ,'datos_detalle'));

        
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

}
