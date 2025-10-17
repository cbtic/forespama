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
use App\Models\Almacen_usuario;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use DateTime;
use stdClass;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class IngresoVehiculoTroncoController extends Controller
{
    public function index(){

		$tablaMaestra_model = new TablaMaestra;
		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(9);
		$tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
		
		return view('frontend.ingreso.create',compact('tipo_madera','tipo_documento','tipo_documento_cliente'));

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
		if($request->tipo_documento_empresa == 1){
			$ingresoVehiculoTronco->id_tipo_cliente = $request->tipo_documento_empresa;
			$ingresoVehiculoTronco->id_persona = $request->id_empresa_persona;
		}else{
			$ingresoVehiculoTronco->id_tipo_cliente = $request->tipo_documento_empresa;
			$ingresoVehiculoTronco->id_empresa_transportista = $request->id_empresa_transportista;
			$ingresoVehiculoTronco->id_empresa_proveedor = $request->id_empresa_transportista;//0;
		}
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
		
		if($request->tipo_documento_empresa == 1){
			$personasConductoresVehiculoExiste = EmpresasConductoresVehiculo::where("id_persona",$request->id_empresa_persona)->where("id_vehiculos",$request->id_vehiculos)->where("id_conductores",$request->id_conductores)->where("estado",1)->get();
			if(count($personasConductoresVehiculoExiste)==0){
				$empresasConductoresVehiculo = new EmpresasConductoresVehiculo;
				$empresasConductoresVehiculo->id_tipo_cliente = $request->tipo_documento_empresa;
				$empresasConductoresVehiculo->id_persona = $request->id_empresa_persona;
				$empresasConductoresVehiculo->id_vehiculos = $request->id_vehiculos;
				$empresasConductoresVehiculo->id_conductores = $request->id_conductores;
				$empresasConductoresVehiculo->estado = "1";
				$empresasConductoresVehiculo->save();
			}
		}else{
			$empresasConductoresVehiculoExiste = EmpresasConductoresVehiculo::where("id_empresas",$request->id_empresa_transportista)->where("id_vehiculos",$request->id_vehiculos)->where("id_conductores",$request->id_conductores)->where("estado",1)->get();
			if(count($empresasConductoresVehiculoExiste)==0){
				$empresasConductoresVehiculo = new EmpresasConductoresVehiculo;
				$empresasConductoresVehiculo->id_tipo_cliente = $request->tipo_documento_empresa;
				$empresasConductoresVehiculo->id_empresas = $request->id_empresa_transportista;
				$empresasConductoresVehiculo->id_vehiculos = $request->id_vehiculos;
				$empresasConductoresVehiculo->id_conductores = $request->id_conductores;
				$empresasConductoresVehiculo->estado = "1";
				$empresasConductoresVehiculo->save();
			}
		}
    }

	public function listar_ingreso_vehiculo_tronco_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$request->placa;
		$p[]=$request->ruc;
		$p[]=$request->anio;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
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
		$p[]=$request->estado_pago;
		$p[]=$request->tipo_empresa;
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

		$tipo_desembolso = $tablaMaestra_model->getMaestroByTipo(65);

		$ingresoVehiculoTroncoPago_model = new IngresoVehiculoTroncoPago;
		$data = $ingresoVehiculoTroncoPago_model->getImportePago($id_ingreso_vehiculo_tronco_tipo_maderas);

		$importe = $data->precio-$data->pago;

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

		$maestra_model = new TablaMaestra;
		
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
		}else{
			$pago = IngresoVehiculoTroncoPago::find($request->id);
			$pago->id_tipodesembolso = $request->id_tipodesembolso;
			$pago->importe = $request->importe;
			$pago->nro_guia = $request->nro_guia;
			$pago->nro_cheque = $request->nro_cheque;
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

		echo $ingresoVehiculoTroncoTipoMadera->id;

    }

	public function cubicaje(){

		$id_user = Auth::user()->id;

		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		$ingreso_vehiculo_tronco_model = new IngresoVehiculoTronco;
		$almacen_user_model = new Almacen_usuario;

		$anio = $ingreso_vehiculo_tronco_model->obtenerAniosIngreso();
		$almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);

		return view('frontend.cubicaje.create',compact('anio','almacen_usuario'));

	}

	public function pagos(){

		$tablaMaestra_model = new TablaMaestra;

		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		$estado_pago = $tablaMaestra_model->getMaestroByTipo(66);
		$tipo_empresa = $tablaMaestra_model->getMaestroByTipo(79);

		return view('frontend.pagos.create',compact('tipo_madera','estado_pago','tipo_empresa'));

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

		$items = [];

		foreach ($id_ingreso_vehiculo_tronco_cubicaje as $key => $id) {
			$items[] = [
				'id' => $id,
				'diametro_1' => $diametro_1[$key],
				'diametro_2' => $diametro_2[$key],
				'diametro_dm' => $diametro_dm[$key],
				'longitud' => $longitud[$key],
				'volumen_m3' => $volumen_m3[$key],
				'volumen_pies' => $volumen_pies[$key],
				'volumen_total_m3' => $volumen_total_m3[$key],
				'volumen_total_pies' => $volumen_total_pies[$key],
				'precio_unitario' => $precio_unitario[$key],
				'precio_total' => $precio_total[$key],
			];
		}

		usort($items, function($a, $b) {
			return $a['id'] <=> $b['id'];
		});
		
		foreach($items as $item){

			$ingresoVehiculoTroncoCubicaje = IngresoVehiculoTroncoCubicaje::find($item['id']);
			$ingresoVehiculoTroncoCubicaje->diametro_1= $item['diametro_1'];
			$ingresoVehiculoTroncoCubicaje->diametro_2 = $item['diametro_2'];
			$ingresoVehiculoTroncoCubicaje->diametro_dm = $item['diametro_dm'];
			$ingresoVehiculoTroncoCubicaje->longitud = $item['longitud'];
			$ingresoVehiculoTroncoCubicaje->volumen_m3 = $item['volumen_m3'];
			$ingresoVehiculoTroncoCubicaje->volumen_pies = $item['volumen_pies'];
			$ingresoVehiculoTroncoCubicaje->volumen_total_m3 = $item['volumen_total_m3'];
			$ingresoVehiculoTroncoCubicaje->volumen_total_pies = $item['volumen_total_pies'];
			$ingresoVehiculoTroncoCubicaje->precio_unitario = $item['precio_unitario'];
			$ingresoVehiculoTroncoCubicaje->precio_total = $item['precio_total'];
			$ingresoVehiculoTroncoCubicaje->save();
			
			$precio_total_final+=$precio_total[$key];
		}
		
		$ingresoVehiculoTroncoTipoMadera = IngresoVehiculoTroncoTipoMadera::find($request->id_ingreso_vehiculo_tronco_tipo_maderas);
		$ingresoVehiculoTroncoTipoMadera->total = $precio_total_final;
		$ingresoVehiculoTroncoTipoMadera->save();
		
		/**************************************/
		
		$id_ingreso_vehiculo_troncos = $ingresoVehiculoTroncoTipoMadera->id_ingreso_vehiculo_troncos;
		$ingresoVehiculoTronco = IngresoVehiculoTronco::find($id_ingreso_vehiculo_troncos);
		
		if($ingresoVehiculoTronco->id_tipo_cliente == 1){
			$persona = Persona::find($ingresoVehiculoTronco->id_persona);
			$cliente_nombre = $persona->nombres .' '. $persona->apellido_paterno .' '.$persona->apellido_materno;
			$cliente_direccion = $persona->direccion;
			$cliente_numero_documento = $persona->numero_documento;
		}else{
			$empresa = Empresa::find($ingresoVehiculoTronco->id_empresa_transportista);
			$cliente_nombre = $empresa->razon_social;
			$cliente_direccion = $empresa->direccion;
			$cliente_numero_documento = $empresa->ruc;
		}
		
		
		$pago = new Pago;
		$pago->id_modulo = 1;
		$pago->pk_registro = $id_ingreso_vehiculo_troncos;
		$pago->fecha = Carbon::now()->format('Y-m-d');
		$pago->comprobante_destinatario = $cliente_nombre;
		$pago->comprobante_direccion = $cliente_direccion;
		$pago->comprobante_ruc = $cliente_numero_documento;
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
		$datos=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeCabeceraById($id);
		$datos_detalle=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeReporteById($id);

		$fecha_ingreso=$datos[0]->fecha_ingreso;
		$ruc=$datos[0]->ruc;
		$razon_social=$datos[0]->razon_social;
		$placa=$datos[0]->placa;
		$ejes=$datos[0]->ejes;
		$numero_documento = $datos[0]->numero_documento;
		$conductor = $datos[0]->conductor;
		$tipo_madera=$datos[0]->tipo_madera;
		$cantidad=$datos[0]->cantidad;
		$tipo_empresa=$datos[0]->tipo_empresa;

		$precios = array_map(function($item) {
			return $item->precio_unitario;
		}, $datos_detalle);

		$precio_menor = !empty($precios) ? min($precios) : 0;
		$precio_mayor = !empty($precios) ? max($precios) : 0;
	 
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.ingreso.cubicaje_pdf',compact('fecha_ingreso','ruc','razon_social','placa','ejes','numero_documento','conductor','tipo_madera','cantidad','datos_detalle','tipo_empresa','precio_menor','precio_mayor'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper([0, 0, 720, 1000], 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function exportar_listar_pagos($ruc, $empresa, $placa, $tipo_madera, $fecha_inicio, $fecha_fin, $estado_pago, $tipo_empresa) {


		if($ruc=="0")$ruc = "";
		if($empresa=="0")$empresa = "";
		if($placa=="0")$placa = "";
		if($tipo_madera==0)$tipo_madera = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($estado_pago=="0")$estado_pago = "";
		if($tipo_empresa=="0")$tipo_empresa = "";

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$ruc;
		$p[]=$empresa;
		$p[]=$placa;
		$p[]=$tipo_madera;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$estado_pago;
		$p[]=$tipo_empresa;
		$p[]=1;
		$p[]=10000;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_pagos_ajax($p);
	
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Fecha","Ruc","Empresa","Placa","Tipo Madera", "Cantidad", "Volumen Total M3", "Volumen Total Pies", "Precio Total", "Estado Pago", "Fecha Pago", "Numero Factura"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->fecha_ingreso, $r->ruc, $r->razon_social, $r->placa,$r->tipo_madera,$r->cantidad, round($r->volumen_total_m3, 2), round($r->volumen_total_pies, 2), round($r->precio_total, 2), $r->estado_pago, $r->fecha_pago, $r->numero_factura));
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
		$empresa_model = new Empresa;

		$tipo_madera = $tablaMaestra_model->getMaestroByTipo(42);
		$empresas = $empresa_model->getEmpresaAll();
		$tipo_empresa = $tablaMaestra_model->getMaestroByTipo(79);

		return view('frontend.pagos.create_reporte',compact('tipo_madera','empresas','tipo_empresa'));

	}

	public function listar_ingreso_vehiculo_tronco_reporte_ajax(Request $request){

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->tipo_empresa;
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
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->tipo_empresa;
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

	public function exportar_reporte_cubicaje($fecha_inicio, $fecha_fin, $tipo_empresa) {

		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($tipo_empresa==0)$tipo_empresa = "";

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$tipo_empresa;
		$p[]=1;
		$p[]=10000;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_reporte_ajax($p);

		$variable = [];
		$n = 1;

		array_push($variable, array("N","Fecha Recepcion","Proveedor","Cantidad","M3","Pies", "Tabulacion", "Promedio", "Precio Final"));
		
		$groupedData = [];

		foreach ($data as $r) {

			if (!isset($r->fecha_ingreso)) {
				continue; // Saltar registros sin fecha_ingreso
			}

			if (!isset($groupedData[$r->fecha_ingreso])) {
				$groupedData[$r->fecha_ingreso] = [];
			}
			$groupedData[$r->fecha_ingreso][] = $r;
		}

		$cantidadGeneral = 0;
		$m3General = 0;
		$piesGeneral = 0;
		$tabulacionGeneral = 0;
		$promedioGeneral = 0;
		$precioFinalGeneral = 0;
		
		foreach ($groupedData as $fecha => $items) {

			$totalCantidad = 0;
			$totalM3 = 0;
			$totalPies = 0;
			$totalTabulacion = 0;
			$totalPromedio = 0;
			$totalPrecioTotal = 0;

			foreach ($items as $r) {
				array_push($variable, [
					$n++, 
					$r->fecha_ingreso,
					$r->razon_social, 
					$r->cantidad, 
					$r->volumen_total_m3, 
					$r->volumen_total_pies, 
					$r->precio_total, 
					number_format($r->promedio, 2),
					$r->precio_total
				]);
				$totalCantidad += $r->cantidad;
				$totalM3 += $r->volumen_total_m3;
				$totalPies += $r->volumen_total_pies;
				$totalPrecioTotal += $r->precio_total;
			}

			$totalTabulacion = $totalPrecioTotal;
			$totalPromedio = $totalPies > 0 ? ($totalPrecioTotal / $totalPies) : 0;
			
			$fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);
        	$diaSemana = $fechaObj ? ucfirst(strftime('%A', $fechaObj->getTimestamp())) : "Día desconocido";

			array_push($variable, [
				"", "", "Total $diaSemana", $totalCantidad, number_format($totalM3, 2), number_format($totalPies, 2),
				number_format($totalTabulacion, 2), number_format($totalPromedio, 2), number_format($totalPrecioTotal, 2)
			]);
			
			$cantidadGeneral += $totalCantidad;
			$m3General += $totalM3;
			$piesGeneral += $totalPies;
			$tabulacionGeneral += $totalTabulacion;
			$precioFinalGeneral += $totalPrecioTotal;

		}

		$promedioGeneral = $piesGeneral > 0 ? ($tabulacionGeneral / $piesGeneral) : 0;
		
		array_push($variable, [
			"",
			"",
			"Total General",
			$cantidadGeneral,
			number_format($m3General, 2),
			number_format($piesGeneral, 2),
			number_format($tabulacionGeneral, 2),
			number_format($promedioGeneral, 2),
			number_format($precioFinalGeneral, 2)
		]);
				
		$export = new InvoicesExport2([$variable]);
		return Excel::download($export, 'reporte_cubicaje.xlsx');
		
    }

	public function exportar_reporte_pago($fecha_inicio, $fecha_fin, $tipo_empresa) {

		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($tipo_empresa==0)$tipo_empresa = "";

		$ingresoVehiculoTronco_model = new IngresoVehiculoTronco();
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$tipo_empresa;
		$p[]=1;
		$p[]=10000;
		$data = $ingresoVehiculoTronco_model->listar_ingreso_vehiculo_tronco_reporte_pago_ajax($p);

		$variable = [];
		$n = 1;
		$totalGeneral = 0;
		$totalEfectivoGeneral = 0;
		$totalChequeGeneral = 0;
		$totalTransferenciaGeneral = 0;

		array_push($variable, array("N","Empresa","Total","Tipo Pago","Fecha"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->razon_social, $r->importe_total, $r->tipo_pago, $r->fecha_pago));
			$totalGeneral = $r->total_general;
			$totalEfectivoGeneral = $r->total_efectivo;
			$totalChequeGeneral = $r->total_cheque;
			$totalTransferenciaGeneral = $r->total_transferencia;
		}

		array_push($variable, [
			"","Total", floatval($totalGeneral),
		]);

		array_push($variable, [
			"",
		]);

		array_push($variable, [
			"","Resumen",
		]);

		array_push($variable, [
			"","Total Efectivo", floatval($totalEfectivoGeneral),
		]);
		array_push($variable, [
			"","Total Cheque", floatval($totalChequeGeneral),
		]);
		array_push($variable, [
			"","Total Transferencia", floatval($totalTransferenciaGeneral),
		]);
		
		$export = new InvoicesExport3([$variable]);
		return Excel::download($export, 'reporte_pagos.xlsx');
		
    }

	public function upload_cubicaje(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		$filepath = public_path('img/cubicaje/');

		$idIngreso = $request->input('id_ingreso_vehiculo_tronco_tipo_maderas');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;

		$id_ingreso_vehiculo_tronco_tipo_madera = IngresoVehiculoTroncoTipoMadera::where('id_ingreso_vehiculo_troncos', $idIngreso)->where('estado',1)->first();
		
		$modal_ingreso_vehiculo_cubicaje = new IngresoVehiculoTronco;

		$datos_cubicaje = $modal_ingreso_vehiculo_cubicaje->getIngresoVehiculoTroncoCubicajeById($id_ingreso_vehiculo_tronco_tipo_madera->id);

		return $this->importar_cubicaje($archivo, $idIngreso, $datos_cubicaje[0]->diametro_dm_proveedor, $datos_cubicaje[0]->precio_mayor, $datos_cubicaje[0]->precio_menor);
		
	}
	
	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}
	
	public function importar_cubicaje($archivo, $idIngreso, $diametro_dm_, $precio_mayor, $precio_menor)
	{
		$id_user = Auth::user()->id;

		$spreadsheet = IOFactory::load(public_path("img/cubicaje/".$archivo));
		$sheet = $spreadsheet->getActiveSheet();

		// Validaciones de cabecera
		$fecha = null;
		$cellFecha = $sheet->getCell("A2")->getCalculatedValue();
		if (is_numeric($cellFecha)) {
			try {
				$fecha = Date::excelToDateTimeObject($cellFecha)->format('Y-m-d');
			} catch (\Exception $e) {
				$fecha = null;
			}
		} else {
			$fecha = trim($cellFecha);
		}

		$placa = $sheet->getCell("B2")->getCalculatedValue();
		$ruc = $sheet->getCell("C2")->getCalculatedValue();
		$cantidad = $sheet->getCell("D2")->getCalculatedValue();

		$ingreso_vehiculo = IngresoVehiculoTronco::find($idIngreso);
		$vehiculo = Vehiculo::find($ingreso_vehiculo->id_vehiculos);

		if($ingreso_vehiculo->id_tipo_cliente == 1){
			$persona = Persona::find($ingreso_vehiculo->id_persona);
			$ruc = $persona->numero_documento;
		}else{
			$empresa = Empresa::find($ingreso_vehiculo->id_empresa_proveedor);
			$ruc = $empresa->ruc;
		}

		$ingreso_vehiculo_tronco_tipo_madera = IngresoVehiculoTroncoTipoMadera::where("id_ingreso_vehiculo_troncos",$idIngreso)->where("estado",1)->first();
		$id_ingreso_vehiculo_tronco_tipo_madera = $ingreso_vehiculo_tronco_tipo_madera->id;

		// Validaciones
		$errores = [];
		if($fecha != $ingreso_vehiculo->fecha_ingreso) $errores[] = "La fecha no coincide.\n";
		if($placa != $vehiculo->placa) $errores[] = "La Placa no coincide.\n";
		if($ruc != $ruc) $errores[] = "El RUC no coincide.\n";
		if($cantidad != $ingreso_vehiculo_tronco_tipo_madera->cantidad) $errores[] = "La Cantidad no coincide.\n";

		if (!empty($errores)) {
			return response()->json(['success' => false, 'message' => implode("", $errores)], 422);
		}

		// Troncos existentes
		$id_ingreso_vehiculo_tronco_cubicaje = IngresoVehiculoTroncoCubicaje::where("id_ingreso_vehiculo_tronco_tipo_maderas",$id_ingreso_vehiculo_tronco_tipo_madera)->where("estado",1)->get()->values();

		$rowIndex = 5;
		$precio_total_final = 0;

		foreach($id_ingreso_vehiculo_tronco_cubicaje as $registro){
			$diametro1 = $sheet->getCell("A".$rowIndex)->getCalculatedValue();
			$diametro2 = $sheet->getCell("B".$rowIndex)->getCalculatedValue();
			$longitud  = $sheet->getCell("C".$rowIndex)->getCalculatedValue();
			$rowIndex++; // AVANZAR FILA SIEMPRE

			if (!$diametro1 || !$diametro2 || !$longitud) continue;

			$diametro_dm = (((float)$diametro1 + (float)$diametro2) / 2) / 100;
			$radio = $diametro_dm / 2;
			$volumen_m3 = 3.1416 * $radio * $radio * (float)$longitud;
			$volumen_pies = 220 * $volumen_m3;
			$volumen_total_pies = $volumen_pies;

			$precio_unitario = ($diametro_dm >= $diametro_dm_) ? $precio_mayor : $precio_menor;
			if ($longitud < 1.22) $precio_unitario = 1.20;

			$precio_total = $volumen_total_pies * $precio_unitario;

			$registro->diametro_1 = $diametro1;
			$registro->diametro_2 = $diametro2;
			$registro->diametro_dm = number_format($diametro_dm,3);
			$registro->longitud = $longitud;
			$registro->volumen_m3 = number_format($volumen_m3,2);
			$registro->volumen_pies = number_format($volumen_pies,2);
			$registro->volumen_total_m3 = number_format($volumen_m3,2);
			$registro->volumen_total_pies = number_format($volumen_total_pies,2);
			$registro->precio_unitario = $precio_unitario;
			$registro->precio_total = number_format($precio_total,2);
			$registro->save();

			$precio_total_final += $precio_total;
		}

		$ingresoVehiculoTroncoTipoMadera = IngresoVehiculoTroncoTipoMadera::find($id_ingreso_vehiculo_tronco_tipo_madera);
		$ingresoVehiculoTroncoTipoMadera->total = round($precio_total_final,2);
		$ingresoVehiculoTroncoTipoMadera->save();

		$ingresoVehiculoTronco = IngresoVehiculoTronco::find($ingresoVehiculoTroncoTipoMadera->id_ingreso_vehiculo_troncos);
		//$empresa = Empresa::find($ingresoVehiculoTronco->id_empresa_transportista);

		if($ingresoVehiculoTronco->id_tipo_cliente == 1){
			$persona = Persona::find($ingresoVehiculoTronco->id_persona);
			$cliente_nombre = $persona->nombres .' '. $persona->apellido_paterno .' '.$persona->apellido_materno;
			$cliente_direccion = $persona->direccion;
			$cliente_numero_documento = $persona->numero_documento;
		}else{
			$empresa = Empresa::find($ingresoVehiculoTronco->id_empresa_transportista);
			$cliente_nombre = $empresa->razon_social;
			$cliente_direccion = $empresa->direccion;
			$cliente_numero_documento = $empresa->ruc;
		}

		$pago = new Pago;
		$pago->id_modulo = 1;
		$pago->pk_registro = $ingresoVehiculoTronco->id;
		$pago->fecha = Carbon::now()->format('Y-m-d');
		$pago->comprobante_destinatario = $cliente_nombre;
		$pago->comprobante_direccion = $cliente_direccion;
		$pago->comprobante_ruc = $cliente_numero_documento;
		$pago->subtotal = round($precio_total_final,2);
		$pago->impuesto = 0;
		$pago->total = round($precio_total_final,2);
		$pago->letras = "";
		$pago->id_moneda = 1;
		$pago->estado_pago = "N";
		$pago->estado = "1";
		$pago->id_usuario_inserta = $id_user;
		$pago->save();

		return response()->json(['success' => true, 'message' => 'Archivo procesado correctamente.','id_ingreso_vehiculo_tronco_tipo_madera'=>$id_ingreso_vehiculo_tronco_tipo_madera]);
	}


	public function exportar_listar_reporte_anual($placa, $ruc, $anio) {

		if($placa=="0")$placa = "";
		if($ruc=="0")$ruc = "";
		if($anio==0)$anio = "";

		$requerimiento_model = new IngresoVehiculoTronco;
		$p[]=$placa;
        $p[]=$ruc;
        $p[]=$anio;
		$p[]=1;
		$p[]=1000;
		$data = $requerimiento_model->listar_ingreso_vehiculo_reporte_anual_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("Mes","Trozas","M3","Pies","Soles"));
		
		foreach ($data as $r) {

			array_push($variable, array($r->mes,$r->total_trozas, $r->total_m3, $r->total_pies, $r->total_precio_total));
		}
		
		$export = new InvoicesExport4([$variable],$anio);
		return Excel::download($export, 'reporte_compra_anual.xlsx');
    }

	public function exportar_listar_reporte_excel($placa, $ruc, $anio, $fecha_inicio, $fecha_fin) {

		if($placa=="0")$placa = "";
		if($ruc=="0")$ruc = "";
		if($anio=="0")$anio = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";

		$ingreso_vehiculo_tronco_model = new IngresoVehiculoTronco;
		$p[]=$placa;
        $p[]=$ruc;
        $p[]=$anio;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
		$p[]=1;
		$p[]=1000;
		$data = $ingreso_vehiculo_tronco_model->listar_ingreso_vehiculo_tronco_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Fecha","Placa","RUC","Empresa","Documento Conductor","Tipo Madera","Cantidad"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->fecha_ingreso,$r->placa, $r->ruc, $r->razon_social, $r->numero_documento, $r->tipo_madera, $r->cantidad));
		}
		
		$export = new InvoicesExport6([$variable]);
		return Excel::download($export, 'reporte_ingreso_camion.xlsx');
    }

	public function exportar_listar_cubicaje_excel($id) {

		$vehiculo_tronco_model = new IngresoVehiculoTronco;

		$datos=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeCabeceraById($id);
		$datos_detalle=$vehiculo_tronco_model->getIngresoVehiculoTroncoCubicajeReporteById($id);

		$fecha_ingreso=$datos[0]->fecha_ingreso;
		$ruc=$datos[0]->ruc;
		$razon_social=$datos[0]->razon_social;
		$placa=$datos[0]->placa;
		$ejes=$datos[0]->ejes;
		$numero_documento = $datos[0]->numero_documento;
		$conductor = $datos[0]->conductor;
		$tipo_madera=$datos[0]->tipo_madera;
		$cantidad=$datos[0]->cantidad;
		$tipo_empresa=$datos[0]->tipo_empresa;
		$titulo = "Ingreso de Camiones - Cubicaje";
		$titulo2 = "Cubicaje";

		$cantidad_suma=0;
		$volumen_pies_suma=0;
		$volumen_total_m3_suma=0;
		$volumen_total_pies_suma=0;
		$precio_total_suma=0;
		$suma_cantidad_reporte_1_2=0;
		$suma_cantidad_reporte_1_7=0;
		$suma_cantidad_reporte_interno=0;
		$suma_volumen_m3_1_2=0;
		$suma_volumen_m3_1_7=0;
		$suma_volumen_m3_interno=0;
		$suma_volumen_pies_1_2=0;
		$suma_volumen_pies_1_7=0;
		$suma_volumen_pies_interno=0;
		$suma_total_1_2=0;
		$suma_total_1_7=0;
		$suma_total_interno=0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array($titulo));
		
		array_push($variable, array($fecha_ingreso,$placa,$ruc,$razon_social,$tipo_madera,$cantidad));
		
		array_push($variable, array(""));

		array_push($variable, array($titulo2));
		
		array_push($variable, array("Cantidad","Diametro DM(M)","Longitud(M)","Volumen M3","Volumen Pies", "Volumen Total M3", "Volumen Total Pies", "Precio Unitario", "Precio Total"));
		
		foreach ($datos_detalle as $r) {

			array_push($variable, array($r->cantidad, number_format($r->diametro_dm,3), $r->longitud, number_format($r->volumen_m3,2), number_format($r->volumen_pies,2),number_format($r->volumen_total_m3,2),number_format($r->volumen_total_pies,2), number_format($r->precio_unitario,2), number_format($r->precio_total,2)));
		
			$cantidad_suma+=$r->cantidad;
			$volumen_pies_suma+=$r->volumen_pies;
			$volumen_total_m3_suma+=$r->volumen_total_m3;
			$volumen_total_pies_suma+=$r->volumen_total_pies;
			$precio_total_suma+=$r->precio_total;

			if($tipo_empresa==1){
				if($r->precio_unitario==1.20){
					$suma_cantidad_reporte_1_2+=$r->cantidad;
					$suma_volumen_m3_1_2+=$r->volumen_total_m3;
					$suma_volumen_pies_1_2+=$r->volumen_total_pies;
					$suma_total_1_2+=$r->precio_total;
				}else{
					$suma_cantidad_reporte_1_7+=$r->cantidad;
					$suma_volumen_m3_1_7+=$r->volumen_total_m3;
					$suma_volumen_pies_1_7+=$r->volumen_total_pies;
					$suma_total_1_7+=$r->precio_total;
				}
			}else if($tipo_empresa==2){
				$suma_cantidad_reporte_interno+=$r->cantidad;
				$suma_volumen_m3_interno+=$r->volumen_total_m3;
				$suma_volumen_pies_interno+=$r->volumen_total_pies;
				$suma_total_interno+=$r->precio_total;
			}
		}

		array_push($variable, array($cantidad_suma,"","","",number_format($volumen_pies_suma,2),number_format($volumen_total_m3_suma,2),number_format($volumen_total_pies_suma,2),"",number_format($precio_total_suma,2)));
		
		array_push($variable, array(""));
	
		array_push($variable, array("Troncos","M3","Pies","Precio Unitario","Total"));

		if($tipo_empresa==1){
			
			array_push($variable, array($suma_cantidad_reporte_1_2,number_format($suma_volumen_m3_1_2,2),number_format($suma_volumen_pies_1_2,2),1.20,number_format($suma_total_1_2,2)));
			array_push($variable, array($suma_cantidad_reporte_1_7,number_format($suma_volumen_m3_1_7,2),number_format($suma_volumen_pies_1_7,2),1.70,number_format($suma_total_1_7,2)));
			array_push($variable, array($suma_cantidad_reporte_1_2+$suma_cantidad_reporte_1_7,number_format($suma_volumen_m3_1_2+$suma_volumen_m3_1_7,2),number_format($suma_volumen_pies_1_2+$suma_volumen_pies_1_7,2),"",number_format($suma_total_1_2+$suma_total_1_7,2)));

		}else if($tipo_empresa==2){
			
			array_push($variable, array($suma_cantidad_reporte_interno,number_format($suma_volumen_m3_interno,2),number_format($suma_volumen_pies_interno,2),number_format($r->precio_unitario,2),number_format($suma_total_interno,2)));
			array_push($variable, array($suma_cantidad_reporte_interno,number_format($suma_volumen_m3_interno,2),number_format($suma_volumen_pies_interno,2),"",number_format($suma_total_interno,2)));
			
		}

		$export = new InvoicesExport5([$variable]);
		return Excel::download($export, 'reporte_cubicaje.xlsx');
    }

	public function eliminar_pago($id)
    {
		$ingreso_vehiculo_tronco_pago = IngresoVehiculoTroncoPago::find($id);
		$ingreso_vehiculo_tronco_pago->estado = 0;
		$ingreso_vehiculo_tronco_pago->save();

		echo $ingreso_vehiculo_tronco_pago->id_ingreso_vehiculo_tronco_tipo_maderas;

    }

	public function eliminar_ingreso_vehiculo($id)
    {
		$ingreso_vehiculo_tronco_tipo_maderas = IngresoVehiculoTroncoTipoMadera::find($id);
		$ingreso_vehiculo_tronco_tipo_maderas->estado = 0;
		$ingreso_vehiculo_tronco_tipo_maderas->save();

		echo $ingreso_vehiculo_tronco_tipo_maderas->id;

    }
}

class InvoicesExport implements FromArray, WithHeadings, WithStyles
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

    public function headings(): array
    {
        return ["N","Fecha","Ruc","Empresa","Placa","Tipo Madera", "Cantidad", "Volumen Total M3", "Volumen Total Pies", "Precio Total", "Estado Pago", "Fecha Pago", "Numero Factura"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:M1');

        $sheet->setCellValue('A1', "REPORTE DE PAGOS - FORESPAMA");
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:M2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
		
    }

}

class InvoicesExport2 implements FromArray, WithHeadings, WithStyles
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

    public function headings(): array
    {
        return ["N","Fecha Recepcion","Proveedor","Cantidad","M3","Pies", "Tabulacion", "Promedio", "Precio Final"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A1', "REPORTE DE CUBICAJE - FORESPAMA");
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

		$lastRow = $sheet->getHighestRow();

		$sheet->getStyle("A{$lastRow}:I{$lastRow}")->applyFromArray([
			'font' => [
				'bold' => true,
			],
			'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D9D9D9'],
            ],
		]);
    }

}

class InvoicesExport3 implements FromArray, WithHeadings, WithStyles
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

    public function headings(): array
    {
        return ["N","Empresa","Total","Tipo Pago","Fecha"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A1', "REPORTE DE PAGOS - FORESPAMA");
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

		$sheet->getStyle('C3:C'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00); //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

		$lastRow = $sheet->getHighestRow();

        return [
        	"B{$lastRow}" => ['font' => ['bold' => true]],
            "B" . ($lastRow - 1) . ":C" . ($lastRow - 1) => ['font' => ['bold' => true]],
            "B" . ($lastRow - 2) . ":C" . ($lastRow - 2) => ['font' => ['bold' => true]],
            "B" . ($lastRow - 3) . ":C" . ($lastRow - 3) => ['font' => ['bold' => true]],
            "B" . ($lastRow - 4) . ":C" . ($lastRow - 4) => ['font' => ['bold' => true]],
            "B" . ($lastRow - 5) . ":C" . ($lastRow - 5) => ['font' => ['bold' => true]],
        ];
    }
}

class InvoicesExport4 implements FromArray, WithHeadings, WithStyles
{
	protected $invoices;
	protected $anio;

	public function __construct(array $invoices, $anio)
	{
		$this->invoices = $invoices;
		$this->anio = $anio;
	}

	public function array(): array
	{
		return $this->invoices;
	}

    public function headings(): array
    {
        return ["Mes","Trozas","M3","Pies","Soles"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:E1');

        $sheet->setCellValue('A1', "RESUMEN DE COMPRAS DE MADERA {$this->anio} - FORESPAMA");
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

		$lastRow = $sheet->getHighestRow();

    }
}

class InvoicesExport5 implements FromArray, WithHeadings, WithStyles
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

    public function headings(): array
    {
        return ["Fecha","Placa","RUC","Empresa","Tipo Madera","Cantidad"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A1', "Ingreso de Camiones - Cubicaje");
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:I2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->mergeCells('A5:I5');
		$sheet->setCellValue('A5', "Cubicaje");
		$sheet->getStyle('A5:I5')->applyFromArray([
			'font' => [
				'bold' => true,
				'color' => ['rgb' => 'FFFFFF'],
			],
			'fill' => [
				'fillType' => Fill::FILL_SOLID,
				'startColor' => ['rgb' => '246257'],
			],
			'alignment' => [
				'horizontal' => Alignment::HORIZONTAL_CENTER,
			],
		]);
		$sheet->getRowDimension(5)->setRowHeight(30);
		$sheet->getStyle('A5')->getAlignment()->setWrapText(true);

		// 👉 Cabecera secundaria en A6:I6
		$sheet->getStyle('A6:I6')->applyFromArray([
			'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
			'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2EB85C']],
			'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
		]);

		$sheet->fromArray($this->headings(), NULL, 'A2');
		
		foreach (range('A', 'I') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$lastRow = $sheet->getHighestRow();

    }
}

class InvoicesExport6 implements FromArray, WithHeadings, WithStyles
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

    public function headings(): array
    {
        return ["N°","Fecha","Placa","RUC","Empresa","Documento Conductor","Tipo Madera","Cantidad"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:H1');

        $sheet->setCellValue('A1', "REPORTE DE CUBICAJE POR FECHAS- FORESPAMA");
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

		$sheet->getStyle('A1')->getAlignment()->setWrapText(true);
		$sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:H2')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
			'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    		],
        ]);

		$sheet->fromArray($this->headings(), NULL, 'A2');

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
