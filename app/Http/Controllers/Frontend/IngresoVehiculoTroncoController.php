<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoVehiculoTronco;
use App\Models\IngresoVehiculoTroncoTipoMadera;
use App\Models\IngresoVehiculoTroncoCubicaje;
use App\Models\IngresoVehiculoTroncoImagene;
use App\Models\Vehiculo;
use App\Models\Empresa;
use App\Models\Conductores;
use App\Models\EmpresasConductoresVehiculo;
use App\Models\Pago;
use App\Models\Persona;
use App\Models\IngresoVehiculoTroncoPago;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;

class IngresoVehiculoTroncoController extends Controller
{
    public function index(){

		$tablaMaestra_model = new TablaMaestra;
		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(9);
		
		return view('frontend.ingreso.create',compact('tipo_madera','tipo_documento'));

	}
	
	public function modal_placa($id){
		
		$id_user = Auth::user()->id;
		//$tablaMaestra_model = new TablaMaestra;
		if($id>0) $vehiculo = Vehiculo::find($id);else $vehiculo = new Vehiculo;
		//$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);

		return view('frontend.vehiculo.modal_vehiculo_ingreso',compact('id','vehiculo'/*,'tipo_concurso'*/));

    }
	
	public function modal_empresa($id){
		
		$id_user = Auth::user()->id;
		//$tablaMaestra_model = new TablaMaestra;
		if($id>0) $empresa = Empresa::find($id);else $empresa = new Empresa;
		//$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);

		return view('frontend.empresa.modal_empresa_ingreso',compact('id','empresa'/*,'tipo_concurso'*/));

    }
	
	public function modal_conductor($id){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
		if($id>0){
			$conductor = Conductores::find($id);
			$persona = Persona::find($conductor->id_personas);
		}else{
			$conductor = new Conductores;
			$persona = new Persona;
		} 
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(9);

		return view('frontend.conductores.modal_conductor_ingreso',compact('id','conductor','tipo_documento','persona'));

    }

	public function obtener_datos_vehiculo($placa){

		$sw = true;
		$msg = "";
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
		$vehiculo = $ingresoVehiculoTronco_model->getEmpresaConductorVehiculos($placa);
		
		if(!$vehiculo){
			$vehiculo = Vehiculo::Where("placa",$placa)->Where("estado",1)->first();
			if($vehiculo){
				$vehiculo->id_vehiculos = $vehiculo->id;
			}else{
				$sw = false;
				$msg = "El Vehiculo ingresado no existe !!!";
			}
			
		}
		
		$array["sw"] = $sw;
		$array["msg"] = $msg;
        $array["vehiculo"] = $vehiculo;
        echo json_encode($array);
		
	}

	public function send_ingreso(Request $request){

		$id_user = Auth::user()->id;

		$ingresoVehiculoTronco = new IngresoVehiculoTronco;
		$ingresoVehiculoTronco->fecha_ingreso = $request->fecha_ingreso;
		$ingresoVehiculoTronco->fecha_salida = $request->fecha_ingreso;
		$ingresoVehiculoTronco->id_empresa_transportista = $request->id_empresa_transportista;
		$ingresoVehiculoTronco->id_empresa_proveedor = $request->id_empresa_transportista;//0;
		$ingresoVehiculoTronco->id_vehiculos = $request->id_vehiculos;
		$ingresoVehiculoTronco->id_conductores = $request->id_conductores;
		$ingresoVehiculoTronco->id_encargados = 1;
		$ingresoVehiculoTronco->id_procedencias = 0;
		$ingresoVehiculoTronco->save();
		$id_ingreso_vehiculo_troncos = $ingresoVehiculoTronco->id;
		
		/*************************/
		
		$vehiculo = Vehiculo::find($request->id_vehiculos);
		
		$path = "img/ingreso/".$vehiculo->placa;
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$img_foto = $request->img_foto;
		
		if(count($img_foto)>0){
			$path = "img/ingreso/".$vehiculo->placa."/".str_replace("/","-",$request->fecha_ingreso);
			if (!is_dir($path)) {
				mkdir($path);
			}
		}
		
		foreach($img_foto as $row){
			
			if($row!=""){
				$filepath_tmp = public_path('img/ingreso/tmp/');
				$filepath_nuevo = public_path('img/ingreso/'.$vehiculo->placa.'/'.str_replace("/","-",$request->fecha_ingreso).'/');
				
				if (file_exists($filepath_tmp.$row)) {
					copy($filepath_tmp.$row, $filepath_nuevo.$row);
				}
				
				$ingresoVehiculoTroncoImagen = new IngresoVehiculoTroncoImagene;
				$ingresoVehiculoTroncoImagen->id_ingreso_vehiculo_troncos = $id_ingreso_vehiculo_troncos;
				$ingresoVehiculoTroncoImagen->ruta_imagen = "img/ingreso/".$vehiculo->placa."/".str_replace("/","-",$request->fecha_ingreso)."/".$row;
				$ingresoVehiculoTroncoImagen->id_tipo_maderas = 0;
				$ingresoVehiculoTroncoImagen->estado = 1;
				$ingresoVehiculoTroncoImagen->save();
			}
			
		}
		
		/*************************/
		
		$ingresoVehiculoTroncoTipoMadera = new IngresoVehiculoTroncoTipoMadera;
		$ingresoVehiculoTroncoTipoMadera->id_ingreso_vehiculo_troncos = $id_ingreso_vehiculo_troncos;
		$ingresoVehiculoTroncoTipoMadera->id_tipo_maderas = $request->tipo_maderas_id;
		$ingresoVehiculoTroncoTipoMadera->cantidad = $request->cantidad;
		$ingresoVehiculoTroncoTipoMadera->estado = 1;
		$ingresoVehiculoTroncoTipoMadera->save();
		$id_ingreso_vehiculo_tronco_tipo_maderas = $ingresoVehiculoTroncoTipoMadera->id;
		
		for($i=1;$i<=$request->cantidad;$i++){
			$ingresoVehiculoTroncoCubicaje = new IngresoVehiculoTroncoCubicaje;
			$ingresoVehiculoTroncoCubicaje->id_ingreso_vehiculo_tronco_tipo_maderas=$id_ingreso_vehiculo_tronco_tipo_maderas;
			$ingresoVehiculoTroncoCubicaje->diametro_1= 0;
			$ingresoVehiculoTroncoCubicaje->diametro_2 = 0;
			$ingresoVehiculoTroncoCubicaje->diametro_dm = 0;
			$ingresoVehiculoTroncoCubicaje->longitud = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_m3 = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_pies = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_total_m3 = 0;
			$ingresoVehiculoTroncoCubicaje->volumen_total_pies = 0;
			$ingresoVehiculoTroncoCubicaje->precio_unitario = 0;
			$ingresoVehiculoTroncoCubicaje->precio_total = 0;
			$ingresoVehiculoTroncoCubicaje->save();
		}
		
		
		$empresasConductoresVehiculoExiste = EmpresasConductoresVehiculo::where("id_empresas",$request->id_empresa_transportista)->where("id_vehiculos",$request->id_vehiculos)->where("id_conductores",$request->id_conductores)->where("estado",1)->get();
		if(count($empresasConductoresVehiculoExiste)==0){
			$empresasConductoresVehiculo = new EmpresasConductoresVehiculo;
			$empresasConductoresVehiculo->id_empresas = $request->id_empresa_transportista;
			$empresasConductoresVehiculo->id_vehiculos = $request->id_vehiculos;
			$empresasConductoresVehiculo->id_conductores = $request->id_conductores;
			$empresasConductoresVehiculo->estado = "1";
			$empresasConductoresVehiculo->save();
		}
		
    }

	public function listar_ingreso_vehiculo_tronco_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$request->placa;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_ajax($p);
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

	public function listar_ingreso_vehiculo_tronco_pagos_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$request->ruc;
		$p[]=$request->empresa;
		$p[]=$request->placa;
		$p[]=$request->tipo_madera;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_pagos_ajax($p);
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

	public function modal_pago($id,$id_ingreso_vehiculo_tronco_tipo_maderas){
		
		$tablaMaestra_model = new TablaMaestra;
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
		$fecha_actual = $ingresoVehiculoTronco_model->fecha_actual();

		if($id==0){
			$ingresoVehiculoTroncoPago = new IngresoVehiculoTroncoPago;
		}else{
			$ingresoVehiculoTroncoPago = IngresoVehiculoTroncoPago::find($id);
		}
		//$adelantos = $adelanto_model->getAdelantoByPersona($id_persona);
		$tipo_desembolso = $tablaMaestra_model->getMaestroByTipo(65);
		//print_r($tipo_desembolso);

		$ingresoVehiculoTroncoPago_model = new IngresoVehiculoTroncoPago;
		$data = $ingresoVehiculoTroncoPago_model->getImportePago($id_ingreso_vehiculo_tronco_tipo_maderas);

		$importe = $data->precio-$data->pago;
		//echo $id;
		return view('frontend.pagos.modal_pago',compact('id','ingresoVehiculoTroncoPago','id_ingreso_vehiculo_tronco_tipo_maderas','fecha_actual'/*,'adelantos'*/,'tipo_desembolso','importe'));
	
	}

	public function upload_pago(Request $request){

		$path = "img/tmp_pago";
		if (!is_dir($path)) {
			mkdir($path);
		}

    	$filepath = public_path('img/tmp_pago/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
	}

	public function send_pago(Request $request){
		
		$path = "img/pago";
		if (!is_dir($path)) {
			mkdir($path);
		}

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/tmp_pago/');
			$filepath_nuevo = public_path('img/pago/');
			if (file_exists($filepath_tmp.$request->img_foto)) {
				copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
			}
		}

		//$id_user = Auth::user()->id;
		$maestra_model = new TablaMaestra;
		//$fecha_hora = $maestra_model->getFechaHoraServidor();
		
		//if($request->id_moneda==113)$id_caja=$request->id_caja_soles;
		//if($request->id_moneda==114)$id_caja=$request->id_caja_dolares;
		if($request->id==0){
			$pago = new IngresoVehiculoTroncoPago;
			$pago->id_ingreso_vehiculo_tronco_tipo_maderas = $request->id_ingreso_vehiculo_tronco_tipo_maderas;
			$pago->id_tipodesembolso = $request->id_tipodesembolso;
			$pago->importe = $request->importe;
			$pago->nro_guia = $request->nro_guia;
			$pago->nro_cheque = $request->nro_cheque;
			$pago->nro_factura = $request->nro_factura;
			$pago->fecha = $request->fecha;
			$pago->observacion = $request->observacion;
			$pago->foto_desembolso = $request->img_foto;
			//$adelanto->fecha_hora = $fecha_hora;
			//$pago->id_usuario = $id_user;
			//$pago->id_caja = $id_caja;
			//$pago->estado = "A";
		}else{
			$pago = IngresoVehiculoTroncoPago::find($request->id);
			$pago->id_tipodesembolso = $request->id_tipodesembolso;
			$pago->importe = $request->importe;
			$pago->nro_guia = $request->nro_guia;
			$pago->nro_factura = $request->nro_factura;
			$pago->fecha = $request->fecha;
			$pago->observacion = $request->observacion;
			$pago->foto_desembolso = $request->img_foto;
		}

		$pago->save();

		$ingresoVehiculoTroncoPago_model = new IngresoVehiculoTroncoPago;
		$data = $ingresoVehiculoTroncoPago_model->getImportePago($request->id_ingreso_vehiculo_tronco_tipo_maderas);

		if($data->pago==0){
			$id_estado_pago = 1;
		}else if($data->precio>$data->pago){
			$id_estado_pago = 2;
		}else if($data->precio<=$data->pago){
			$id_estado_pago = 3;
		}

		$ingresoVehiculoTroncoTipoMadera = IngresoVehiculoTroncoTipoMadera::find($request->id_ingreso_vehiculo_tronco_tipo_maderas);
		$ingresoVehiculoTroncoTipoMadera->id_estado_pago=$id_estado_pago;
		$ingresoVehiculoTroncoTipoMadera->save();

    }

	public function cubicaje(){

		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);

		return view('frontend.cubicaje.create'/*,compact('tipo_madera')*/);

	}

	public function pagos(){

		$tablaMaestra_model = new TablaMaestra;

		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);

		return view('frontend.pagos.create',compact('tipo_madera'));

	}

	public function cargar_cubicaje($id){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
        $cubicaje = $ingresoVehiculoTronco_model->getIngresoVehiculoTroncoCubicajeById($id);

        return view('frontend.cubicaje.cubicaje_ajax',compact('cubicaje'));

    }
	
	public function cargar_reporte_cubicaje($id){
		 
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
        $cubicaje = $ingresoVehiculoTronco_model->getIngresoVehiculoTroncoCubicajeReporteById($id);
		
        return view('frontend.cubicaje.cubicaje_reporte_ajax',compact('cubicaje'));
		
    }

	public function cargar_pago_cubicaje($id){
		 
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
        $pago = $ingresoVehiculoTronco_model->getIngresoVehiculoTroncoPagoById($id);
		
        return view('frontend.pagos.cubicaje_pago_ajax',compact('pago'));
		
    }
	
	public function send_cubicaje(Request $request){
		
		$id_user = Auth::user()->id;
		
		$id_ingreso_vehiculo_tronco_cubicaje = $request->id_ingreso_vehiculo_tronco_cubicaje;
		$diametro_1 = $request->diametro_1;
		$diametro_2 = $request->diametro_2;
		$diametro_dm = $request->diametro_dm;
		$longitud = $request->longitud;
		$volumen_m3 = $request->volumen_m3;
		$volumen_pies = $request->volumen_pies;
		$volumen_total_m3 = $request->volumen_total_m3;
		$volumen_total_pies = $request->volumen_total_pies;
		$precio_unitario = $request->precio_unitario;
		$precio_total = $request->precio_total;
		$precio_total_final = 0;
		

		foreach($id_ingreso_vehiculo_tronco_cubicaje as $key=>$row){

			$ingresoVehiculoTroncoCubicaje = IngresoVehiculoTroncoCubicaje::find($row);
			$ingresoVehiculoTroncoCubicaje->diametro_1= $diametro_1[$key];
			$ingresoVehiculoTroncoCubicaje->diametro_2 = $diametro_2[$key];
			$ingresoVehiculoTroncoCubicaje->diametro_dm = $diametro_dm[$key];
			$ingresoVehiculoTroncoCubicaje->longitud = $longitud[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_m3 = $volumen_m3[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_pies = $volumen_pies[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_total_m3 = $volumen_total_m3[$key];
			$ingresoVehiculoTroncoCubicaje->volumen_total_pies = $volumen_total_pies[$key];
			$ingresoVehiculoTroncoCubicaje->precio_unitario = $precio_unitario[$key];
			$ingresoVehiculoTroncoCubicaje->precio_total = $precio_total[$key];
			$ingresoVehiculoTroncoCubicaje->save();
			
			$precio_total_final+=$precio_total[$key];
		}
		
		$ingresoVehiculoTroncoTipoMadera = IngresoVehiculoTroncoTipoMadera::find($request->id_ingreso_vehiculo_tronco_tipo_maderas);
		$ingresoVehiculoTroncoTipoMadera->total = $precio_total_final;
		$ingresoVehiculoTroncoTipoMadera->save();
		
		/**************************************/
		
		$id_ingreso_vehiculo_troncos = $ingresoVehiculoTroncoTipoMadera->id_ingreso_vehiculo_troncos;
		$ingresoVehiculoTronco = IngresoVehiculoTronco::find($id_ingreso_vehiculo_troncos);
		
		$empresa = Empresa::find($ingresoVehiculoTronco->id_empresa_transportista);
		
		$pago = new Pago;
		$pago->id_modulo = 1;
		$pago->pk_registro = $id_ingreso_vehiculo_troncos;
		$pago->fecha = Carbon::now()->format('Y-m-d');
		$pago->comprobante_destinatario = $empresa->razon_social;
		$pago->comprobante_direccion = $empresa->direccion;
		$pago->comprobante_ruc = $empresa->ruc;
		$pago->subtotal = $precio_total_final;
		$pago->impuesto = 0;
		$pago->total = $precio_total_final;
		$pago->letras = "";
		$pago->id_moneda = 1;
		$pago->estado_pago = "N";
		$pago->estado = "1";
		$pago->id_usuario_inserta = $id_user;
		$pago->save();

    }
	
	public function upload_imagen_ingreso(Request $request){
		
		$path = "img/ingreso";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$path = "img/ingreso/tmp";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		/*
        $path = "files/" . $ht . "/resolucion";
        if (!is_dir($path)) {
            mkdir($path);
        }
		*/
		
    	$filepath = public_path('img/ingreso/tmp/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
		
	}
	
	public function modal_ingreso_imagen($id){
		 
		$ingresoVehiculoTroncoImagene_model = new IngresoVehiculoTroncoImagene;
        $ingresoVehiculoTroncoImagen = $ingresoVehiculoTroncoImagene_model->getIngresoVehiculoTroncoImagenById($id);
		
        return view('frontend.ingreso.modal_ingreso_imagen',compact('ingresoVehiculoTroncoImagen'));
		
    }
		
	public function cubicaje_pdf($id){


		$vehiculo_tronco_model = new IngresoVehiculoTronco;
		//$salida_producto_detalle_model = new IngresoVehiculoTronco;
		$datos=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeCabeceraById($id);
		$datos_detalle=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeReporteById($id);

		//dd($datos_detalle);exit();

		$fecha_ingreso=$datos[0]->fecha_ingreso;
		$ruc=$datos[0]->ruc;
		$razon_social=$datos[0]->razon_social;
		$placa=$datos[0]->placa;
		$ejes=$datos[0]->ejes;
		$numero_documento = $datos[0]->numero_documento;
		$conductor = $datos[0]->conductor;
		$tipo_madera=$datos[0]->tipo_madera;
		$cantidad=$datos[0]->cantidad;
	 
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.ingreso.cubicaje_pdf',compact('fecha_ingreso','ruc','razon_social','placa','ejes','numero_documento','conductor','tipo_madera','cantidad','datos_detalle'));
		
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

	public function exportar_listar_pagos($ruc, $empresa, $placa, $tipo_madera, $fecha_inicio, $fecha_fin) {


		if($ruc=="0")$ruc = "";
		if($empresa=="0")$empresa = "";
		if($placa=="0")$placa = "";
		if($tipo_madera==0)$tipo_madera = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$ruc;
		$p[]=$empresa;
		$p[]=$placa;
		$p[]=$tipo_madera;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=1;
		$p[]=10000;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_pagos_ajax($p);
	
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Fecha","Ruc","Empresa","Placa","Tipo Madera", "Cantidad", "Volumen Total M3", "Volumen Total Pies"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->fecha_ingreso, $r->ruc, $r->razon_social, $r->placa,$r->tipo_madera,$r->cantidad, $r->volumen_total_m3, $r->volumen_total_pies));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_pagos.xlsx');
		
    }

	public function obtener_datos_vehiculo_guia($placa){

		$sw = true;
		$msg = "";
		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco;
		$vehiculo = $ingresoVehiculoTronco_model->getEmpresaConductorVehiculos($placa);
		$conductores = $ingresoVehiculoTronco_model->getEmpresaConductoresVehiculos($vehiculo->id_empresas);
		
		if(!$vehiculo){
			$vehiculo = Vehiculo::Where("placa",$placa)->Where("estado",1)->first();
			if($vehiculo){
				$vehiculo->id_vehiculos = $vehiculo->id;
			}else{
				$sw = false;
				$msg = "El Vehiculo ingresado no existe !!!";
			}
			
		}

		if(!$conductores){
		
			$sw = false;
			$msg = "El Conductor no existe !!!";
			
		}

		
		$array["sw"] = $sw;
		$array["msg"] = $msg;
        $array["vehiculo"] = $vehiculo;
		$array["conductores"] = $conductores;
        echo json_encode($array);
		
	}

	public function reporte_pagos(){

		$tablaMaestra_model = new TablaMaestra;

		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);

		return view('frontend.pagos.create_reporte',compact('tipo_madera'));

	}

	public function listar_ingreso_vehiculo_tronco_reporte_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		/*$p[]=$request->ruc;
		$p[]=$request->empresa;
		$p[]=$request->placa;
		$p[]=$request->tipo_madera;*/
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_reporte_ajax($p);
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

	public function listar_ingreso_vehiculo_tronco_reporte_pago_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		/*$p[]=$request->ruc;
		$p[]=$request->empresa;
		$p[]=$request->placa;
		$p[]=$request->tipo_madera;*/
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_reporte_pago_ajax($p);
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
