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
use App\Models\Conductores;
use App\Models\Persona;
use App\Models\EmpresaVehiculo;
use App\Models\Sede;
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

        $tablaMaestra_model = new TablaMaestra;
        $empresa_vehiculo_model = new EmpresaVehiculo;
        $empresa_model = new Empresa;
        $persona_model = new Persona;

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $transporte_razon_social = $empresa_vehiculo_model->getEmpresaTransporte();
        $empresa = $empresa_model->getEmpresaAll();
        $persona = $persona_model->obtenerPersonaAll();

		return view('frontend.guia_interna.create',compact('tipo_documento','transporte_razon_social','empresa','persona'));

	}

    public function listar_guia_interna_ajax(Request $request){

		$guia_interna_model = new GuiaInterna;
        $p[]=$request->fecha;
        $p[]=$request->numero_guia;
        $p[]=$request->numero_documento;
        $p[]=$request->empresa;
        $p[]=$request->persona;
        $p[]=$request->placa;
        $p[]=$request->empresa_transporte;
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
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $empresa_model = new Empresa;
        $ubigeo_model = new Ubigeo;
        $sede_model = new Sede;
        $id_sede = session('id_sede');
		
		if($id>0){
            $guia_interna = GuiaInterna::find($id);
            $guia = Guia::find($id);
		}else{
			$guia_interna = new GuiaInterna;
            $guia = new Guia;
        }

        $tipo_documento_entrada = $tablaMaestra_model->getMaestroByTipo(48);
        $tipo_documento_salida = $tablaMaestra_model->getMaestroByTipo(49);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaVehiculo();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $empresas = Empresa::all();
        $motivo_traslado = $tablaMaestra_model->getMaestroByTipo(63);
        $departamento = $ubigeo_model->getDepartamento();
        //$serie_guia = $tablaMaestra_model->getMaestroC(95,"GR");
        $serie_guia = $sede_model->getSerie($id_sede, 'GR');
        $punto_partida = $tablaMaestra_model->getMaestroByTipo(68);
        $unidad_peso = $tablaMaestra_model->getMaestroByTipo(43);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);

        return view('frontend.guia_interna.modal_guia_interna_nuevoGuiaInterna',compact('id','guia_interna','guia','tipo_documento_entrada','tipo_documento_salida','producto','marca','estado_bien','unidad','empresas',/*'transporte_razon_social',*/'motivo_traslado','departamento','serie_guia','id_user','punto_partida','unidad_peso','tipo_documento_cliente'));

    }

    public function send_guia_interna(Request $request)
    {
        $id_user = Auth::user()->id;
        $tabla_maestra_model = new TablaMaestra;
        $ubigeo = new Ubigeo;

        if($request->id == 0){
            $guia_interna = new GuiaInterna;
            $guia = new Guia;
            $guia_interna_model = new GuiaInterna;
            $numero_guia_interna = $guia_interna_model->getNumeroGuia($request->serie_guia);
            $numero_guia = $numero_guia_interna[0]->codigo;
            
        }else{
            $guia_interna = GuiaInterna::find($request->id);
            $guia = Guia::find($request->id);
            $numero_guia = $request->numero_guia;
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
        $id_guia_interna_detalle =$request->id_guia_interna_detalle;

        $guia_interna->guia_numero = $numero_guia;
        
        $guia_interna->fecha_emision = $request->fecha_emision;
        $guia_interna->fecha_traslado = $request->fecha_inicio_traslado;
        $guia_interna->id_conductor = $request->conductor_guia;
        if($request->tipo_documento_cliente=='1'){

            $guia_interna->id_tipo_cliente = $request->tipo_documento_cliente;
            $guia_interna->dni_destinatario = $request->dni_destinatario;
            $guia_interna->id_persona = $request->persona_destinatario;
            
        }else if($request->tipo_documento_cliente=='5'){
            
            $guia_interna->id_tipo_cliente = $request->tipo_documento_cliente;
            $guia_interna->ruc_destinatario = $request->ruc;
            $guia_interna->id_destinatario = $request->destinatario;
        }
        
        $guia_interna->marca = $request->id_marca_vehiculo;
        $guia_interna->placa = $request->placa_guia;
        $guia_interna->guia_vehiculo_segunda_placa = $request->segunda_placa_guia;
        $guia_interna->constancia_inscripcion = $request->numero_inscripcion;
        $guia_interna->licencia_conducir = $request->numero_licencia;
        $guia_interna->id_empresa_transporte = $request->id_transporte_razon_social;
        $guia_interna->ruc_empresa_transporte = $request->ruc_transporte;
        $guia_interna->id_tipo_documento = $request->tipo_documento;
        $guia_interna->numero_documento = $request->numero_documento;
        $guia_interna->id_motivo_traslado = $request->motivo_traslado;
        if($request->motivo_traslado=='06'){
            $guia_interna->descripcion_motivo = "RECOJO POR DEVOLUCION";
        }
        if($request->motivo_traslado=='13'){
            $guia_interna->descripcion_motivo = $request->descripcion_motivo;
        }
        $guia_interna->id_ubigeo_partida = $request->distrito_partida;
        $guia_interna->id_ubigeo_llegada = $request->distrito_llegada;
        $guia_interna->guia_serie = $request->serie_guia;
        $guia_interna->numero_orden_compra_cliente = $request->orden_compra_cliente;
        $guia_interna->numero_orden_compra = $request->orden_compra;
        $guia_interna->tiendas = $request->tiendas_orden_compra;
        $guia_interna->observacion = $request->observacion_guia;
        $guia_interna->guia_tipo = $tipo_guia[0]->codigo;
        $guia_interna->id_usuario_inserta = $id_user;
        $guia_interna->peso = $request->peso;
        
        $id_ubigeo = $request->distrito_llegada;
        $id_departamento = substr($id_ubigeo,0,2);
        $id_provincia = substr($id_ubigeo,2,2);

        $departamento = $ubigeo->getDepartamentoByUbigeo($id_departamento);
        $provincia = $ubigeo->getProvinciaByUbigeo($id_departamento, $id_provincia);
        $distrito = $ubigeo->getDistritoByUbigeo($id_ubigeo);
        
        $departamento = $departamento[0]->desc_ubigeo ?? '';
        $provincia = $provincia[0]->desc_ubigeo ?? '';
        $distrito = $distrito[0]->desc_ubigeo ?? '';

        if($request->motivo_traslado=='04'){
            $guia_interna->guia_cod_estab_llegada = $request->punto_llegada_select;
            $guia_interna->guia_cod_estab_partida = $request->punto_partida;
            $guia_interna->punto_partida = $request->punto_partida_descripcion;
            $guia_interna->punto_llegada = $request->punto_llegada_descripcion;
        }else if($request->motivo_traslado=='06' || $request->motivo_traslado=='07'){
            $guia_interna->punto_llegada = $request->punto_llegada_descripcion;
            $guia_interna->guia_cod_estab_llegada = $request->punto_llegada_select;
            $guia_interna->punto_partida = $request->punto_partida_input." - ".$departamento." - ".$provincia." - ".$distrito;
        }else{
            $guia_interna->punto_llegada = $request->punto_llegada_input." - ".$departamento." - ".$provincia." - ".$distrito;
            $guia_interna->guia_cod_estab_partida = $request->punto_partida;
            $guia_interna->punto_partida = $request->punto_partida_descripcion;
        }
        $guia_interna->estado = 1;
        $guia_interna->save();
        
        $empresa_destinatario = Empresa::find($request->destinatario);
        $conductores = Conductores::find($request->conductor_guia);
        $personas = Persona::find($conductores->id_personas);

        $guia->guia_serie = $request->serie_guia;
        $guia->guia_numero = $numero_guia;
        
        
        $guia->guia_tipo = $tipo_guia[0]->codigo;
        if($request->tipo_documento_cliente=='1'){
            $guia->guia_receptor_numdoc = $request->dni_destinatario;
            $guia->guia_receptor_razsocial = $request->persona_destinatario_nombre;
            $guia->guia_receptor_tipodoc = $request->tipo_documento_cliente;
        }else if($request->tipo_documento_cliente=='5'){
            $guia->guia_receptor_numdoc = $request->ruc;
            $guia->guia_receptor_razsocial = $request->destinatario_nombre;
            $guia->guia_receptor_tipodoc = $request->tipo_documento_cliente;
        }
        $guia->guia_fecha_emision = $request->fecha_emision;
        $guia->guia_fecha_traslado = $request->fecha_inicio_traslado;
        $guia->guia_vehiculo_placa = $request->placa_guia;
        $guia->guia_vehiculo_segunda_placa = $request->segunda_placa_guia;
        $guia->guia_llegada_ubigeo = $request->distrito_llegada;
        $guia->guia_partida_ubigeo = $request->distrito_partida;
        $guia->guia_transportista_numdoc = $request->ruc_transporte;
        $guia->guia_transportista_tipo_doc = 6;
        $guia->guia_transportista_razsoc = $request->transporte_razon_social;
        $guia->guia_anulado = "N";
        $guia->guia_cod_motivo = $request->motivo_traslado;
        $guia->guia_emisor_numdoc = "20486785994";
        $guia->guia_emisor_razsocial = "FORESTAL PAMA S.A.C.";
        $guia->id_usuario_inserta = $id_user;
        $guia->guia_conductor_tipodoc = $personas->id_tipo_documento;
        $guia->guia_conductor_numdoc = $personas->numero_documento;
        $guia->guia_peso_bruto = $request->peso;
        $observacion ="";
        if($request->orden_compra_cliente!=""){
            $observacion.="Orden Compra Cliente: ".$request->orden_compra_cliente;
        }
        if(!in_array($request->destinatario, [23, 187])){
            if($request->orden_compra!=""){
                if ($observacion != "") {
                    $observacion .= " / ";
                }
                $observacion.=$request->tipo_documento_orden.": ".$request->orden_compra;
            }
        }
        
        if($request->tiendas_orden_compra !=""){
            if ($observacion != "") {
                $observacion .= " / ";
            }
            $observacion.="Tiendas: ".$request->tiendas_orden_compra;
        }
        if($request->observacion_guia !=""){
            if ($observacion != "") {
                $observacion .= " / ";
            }
            $observacion.="Observaciones: ".$request->observacion_guia;
        }
        $guia->guia_observaciones = $observacion;
        if($request->ruc_transporte=='20486785994'){
            $guia->guia_modo_traslado = '02';
        }else{
            $guia->guia_modo_traslado = '01';
        }
        if($request->motivo_traslado=='04'){
            $guia->guia_cod_estab_llegada = $request->punto_llegada_select;
            $guia->guia_cod_estab_partida = $request->punto_partida;
            $guia->guia_partida_direccion = $request->punto_partida_descripcion;
            $guia->guia_llegada_direccion = $request->punto_llegada_descripcion;
        }else if($request->motivo_traslado=='06' || $request->motivo_traslado=='07'){
            $guia->guia_llegada_direccion = $request->punto_llegada_descripcion;
            $guia->guia_cod_estab_llegada = $request->punto_llegada_select;
            $guia->guia_partida_direccion = $request->punto_partida_input." - ".$departamento." - ".$provincia." - ".$distrito;
        }else{
            $guia->guia_llegada_direccion = $request->punto_llegada_input." - ".$departamento." - ".$provincia." - ".$distrito;
            $guia->guia_cod_estab_partida = $request->punto_partida;
            $guia->guia_partida_direccion = $request->punto_partida_descripcion;
        }

        if($request->motivo_traslado=='06'){
            $guia->guia_desc_motivo = "RECOJO POR DEVOLUCION";
        }

        if($request->motivo_traslado=='13'){
            $guia->guia_desc_motivo = $request->descripcion_motivo;
        }

        $guia->save();

        $array_guia_interna_detalle = array();

        if($request->id == 0){

            foreach($item as $index => $value) {

                $guia_interna_detalle = new GuiaInternaDetalle;
                $guia_detalle = new GuiaDetalle;
                $tabla_maestra_model = new TablaMaestra;
                $abreviatura_unidad_medida = $tabla_maestra_model->getMaestroC(43,$unidad[$index]);
                
                $guia_interna_detalle->id_guia_interna = $guia_interna->id;
                $guia_interna_detalle->id_producto = $descripcion[$index];
                $guia_interna_detalle->cantidad = $cantidad[$index];
                $guia_interna_detalle->id_estado_producto = 1;
                $guia_interna_detalle->id_unidad_medida = $unidad[$index];
                $guia_interna_detalle->id_marca = $marca[$index];
                $guia_interna_detalle->estado = 1;
                $guia_interna_detalle->id_usuario_inserta = $id_user;

                $guia_interna_detalle->save();

                $guia_detalle->id_guia = $guia->id;
                $guia_detalle->guiad_serie = $request->serie_guia;
                $guia_detalle->guiad_numero = $numero_guia;
                $guia_detalle->guiad_tipo = $tipo_guia[0]->codigo;
                $guia_detalle->guiad_orden_item = $index+1;
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
        $numero_orden_compra_cliente=$datos[0]->numero_orden_compra_cliente;
        $id_destinatario=$datos[0]->id_destinatario;
        $tiendas=$datos[0]->tiendas;
        $observacion=$datos[0]->observacion;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('d-m-Y');

		 $currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.guia_interna.guia_interna_pdf',compact('fecha_emision', 'punto_partida', 'punto_llegada', 'fecha_traslado', 'costo_minimo', 'destinatario', 'ruc_destinatario', 'marca', 'placa', 'constancia_inscripcion', 'licencia_conducir', 'empresa_transporte', 'ruc_empresa_transporte', 'motivo_traslado', 'conductor', 'guia_serie', 'guia_numero' ,'datos_detalle','numero_orden_compra_cliente','id_destinatario','tiendas','observacion'));
        
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
