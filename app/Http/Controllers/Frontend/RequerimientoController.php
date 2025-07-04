<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Marca;
use App\Models\Almacen_usuario;
use App\Models\RequerimientoDetalle;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraDetalle;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RequerimientoController extends Controller
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

        $id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $user_model = new User;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        //$proveedor = Empresa::all();
        $almacen = Almacene::all();
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $responsable_atencion = $user_model->getUserAll();
        $tipo_requerimiento = $tablaMaestra_model->getMaestroByTipo(67);
        $producto = $producto_model->getProductoAll();
        
		return view('frontend.requerimiento.create',compact('tipo_documento','cerrado_requerimiento','almacen','id_user','estado_atencion','responsable_atencion','tipo_requerimiento','producto'));

	}

    public function listar_requerimiento_ajax(Request $request){

		$requerimiento_model = new Requerimiento;
		$p[]=$request->tipo_documento;
        $p[]=$request->fecha;
        $p[]=$request->numero_requerimiento;
        $p[]=$request->almacen;
        $p[]=$request->situacion;
        $p[]=$request->responsable_atencion;
        $p[]=$request->estado_atencion;
        $p[]=$request->tipo_requerimiento;
        $p[]=$request->producto;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $requerimiento_model->listar_requerimiento_ajax($p);
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

    public function modal_requerimiento($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
		if($id>0){

            $requerimiento = Requerimiento::find($id);
		}else{
			$requerimiento = new Requerimiento;
        }

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $almacen = $almacen_model->getAlmacenAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $responsable_atencion = $user_model->getUserAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $tipo_requerimiento = $tablaMaestra_model->getMaestroByTipo(67);

        return view('frontend.requerimiento.modal_requerimiento_nuevoRequerimiento',compact('id','requerimiento','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen','id_user','tipo_requerimiento'));

    }

    public function send_requerimiento(Request $request)
    {
        $id_user = Auth::user()->id;

        if($request->id == 0){
            $requerimiento = new Requerimiento;
            $requerimiento_model = new Requerimiento;
		    $codigo_requerimiento = $requerimiento_model->getCodigoRequerimiento(1);
        }else{
            $requerimiento = Requerimiento::find($request->id);
            $codigo_requerimiento = $request->numero_requerimiento;
        }

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $observacion = $request->input('observacion');
        
        $id_requerimiento_detalle =$request->id_requerimiento_detalle;
        
        $requerimiento->id_tipo_documento = $request->tipo_documento;
        $requerimiento->fecha = $request->fecha_requerimiento;
        if($request->id == 0){
            $requerimiento->codigo = $codigo_requerimiento[0]->codigo;
        }else{
            $requerimiento->codigo = $codigo_requerimiento;
        }
        $requerimiento->id_almacen_destino = $request->almacen;
        $requerimiento->sustento_requerimiento = $request->sustento_requerimiento;
        $requerimiento->responsable_atencion = $request->responsable;
        $requerimiento->estado_atencion = $request->estado_atencion;
        $requerimiento->id_unidad_origen = $request->unidad_origen;
        $requerimiento->id_almacen_salida = $request->almacen_salida;
        $requerimiento->id_tipo_requerimiento = $request->tipo_requerimiento;
        $requerimiento->cerrado = 1;
        $requerimiento->id_usuario_inserta = $id_user;
        $requerimiento->estado = 1;
        $requerimiento->save();

        $id_requerimiento = $requerimiento->id;

        $array_requerimiento_detalle = array();

        foreach($descripcion as $index => $value) {
            
            if($id_requerimiento_detalle[$index] == 0){
                $requerimiento_detalle = new RequerimientoDetalle;
            }else{
                $requerimiento_detalle = RequerimientoDetalle::find($id_requerimiento_detalle[$index]);
            }
            
            $requerimiento_detalle->id_requerimiento = $requerimiento->id;
            $requerimiento_detalle->id_producto = $descripcion[$index];
            $requerimiento_detalle->cantidad = $cantidad_ingreso[$index];
            $requerimiento_detalle->id_estado_producto = $estado_bien[$index];
            $requerimiento_detalle->id_unidad_medida = $unidad[$index];
            $requerimiento_detalle->id_marca = $marca[$index];
            $requerimiento_detalle->estado = 1;
            $requerimiento_detalle->cerrado = 1;
            $requerimiento_detalle->observacion = $observacion[$index];
            $requerimiento_detalle->id_usuario_inserta = $id_user;

            $requerimiento_detalle->save();

            $array_requerimiento_detalle[] = $requerimiento_detalle->id;

            $RequerimientoAll = RequerimientoDetalle::where("id_requerimiento",$requerimiento->id)->where("estado","1")->get();
            
            foreach($RequerimientoAll as $key=>$row){
                
                if (!in_array($row->id, $array_requerimiento_detalle)){
                    $requerimiento_detalle = RequerimientoDetalle::find($row->id);
                    $requerimiento_detalle->estado = 0;
                    $requerimiento_detalle->save();
                }
            }
        }

        return response()->json(['id' => $requerimiento->id]);
    }

    public function eliminar_requerimiento($id,$estado)
    {
		$requerimiento = Requerimiento::find($id);

		$requerimiento->estado = $estado;
		$requerimiento->save();

		echo $requerimiento->id;
    }

    public function obtener_codigo_requerimiento($tipo_documento){
		
		$requerimiento_model = new Requerimiento;
		$codigo_requerimiento = $requerimiento_model->getCodigoRequerimiento($tipo_documento);
		
		return response()->json($codigo_requerimiento);
	}

    public function cargar_detalle($id)
    {

        $requerimiento_model = new Requerimiento;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $requerimiento = $requerimiento_model->getDetalleRequerimientoId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'requerimiento' => $requerimiento,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida
        ]);
    }

    public function cargar_detalle_abierto($id)
    {

        $requerimiento_model = new Requerimiento;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $requerimiento = $requerimiento_model->getDetalleRequerimientoIdAbierto($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'requerimiento' => $requerimiento,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida
        ]);
    }

    public function movimiento_pdf_requerimiento($id){

        $requerimiento_model = new Requerimiento;
        $requerimiento_detalle_model = new RequerimientoDetalle;

        $datos=$requerimiento_model->getRequerimientoById($id);
        $datos_detalle=$requerimiento_detalle_model->getDetalleRequerimientoPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
        $responsable_atencion=$datos[0]->responsable_atencion;
        $sustento_requerimiento=$datos[0]->sustento_requerimiento;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.requerimiento.movimiento_pdf_requerimiento',compact('tipo_documento','almacen','fecha','codigo','datos_detalle','responsable_atencion','sustento_requerimiento'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
        
		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
	}

    public function send_requerimiento_orden_compra(Request $request)
    {
        $id_user = Auth::user()->id;

        $requerimiento = Requerimiento::find($request->id);
        $id_requerimiento = $requerimiento->id;

        $orden_compra = new OrdenCompra;

        $orden_compra_model = new OrdenCompra;
        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra(1);

        //$item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $cantidad_atendida = $request->input('cantidad_atendida');
        
        $id_requerimiento_detalle =$request->id_requerimiento_detalle;
        
        $orden_compra->id_empresa_compra = 30;
        $orden_compra->id_empresa_vende = 30;
        $orden_compra->fecha_orden_compra = Carbon::now()->toDateString();
        $orden_compra->numero_orden_compra = $codigo_orden_compra[0]->codigo;
        $orden_compra->id_tipo_documento = 1;
        $orden_compra->igv_compra = 2;
        $orden_compra->cerrado = 1;
        $orden_compra->id_unidad_origen = $request->unidad_origen;
        $orden_compra->id_almacen_destino = $request->almacen;
        $orden_compra->id_almacen_salida = $request->almacen_salida;
        $orden_compra->id_requerimiento = $request->id;
        $orden_compra->id_tipo_cliente = '5';
        $orden_compra->id_usuario_inserta = $id_user;
        $orden_compra->estado = 1;
        $orden_compra->save();

        $array_orden_compra_detalle = array();

        foreach($descripcion as $index => $value) {
            
            $orden_compra_detalle = new OrdenCompraDetalle;
            
            $orden_compra_detalle->id_orden_compra = $orden_compra->id;
            $orden_compra_detalle->id_producto = $descripcion[$index];
            $orden_compra_detalle->cantidad_requerida = $cantidad_atendida[$index];
            $orden_compra_detalle->id_estado_producto = $estado_bien[$index];
            //$orden_compra_detalle->id_unidad_medida = $unidad[$index];
            if($unidad[$index]!=null && $unidad[$index] !=0){
				$orden_compra_detalle->id_unidad_medida = (int)$unidad[$index];
			}
            //$orden_compra_detalle->id_marca = $marca[$index] ?? '';
            if($marca[$index]!=null && $marca[$index] !=0){
				$orden_compra_detalle->id_marca = (int)$marca[$index];
			}
            
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->id_usuario_inserta = $id_user;

            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;

        }

        $requerimiento_detalle = RequerimientoDetalle::where('id_requerimiento',$id_requerimiento)->where('estado','1')->get();

        $requerimiento_detalle_model = new RequerimientoDetalle;

        foreach($requerimiento_detalle as $index => $detalle){
            
            $detalle_requerimiento = RequerimientoDetalle::where('id_requerimiento',$id_requerimiento)->where('id_producto',$detalle->id_producto)->where('estado','1')->first();

            $cantidad_requerida = $detalle_requerimiento->cantidad;
            
            $cantidad_ingresada = $requerimiento_detalle_model->getCantidadOrdenCompraByRequerimientoProducto($id_requerimiento,$detalle->id_producto);
            
            if($cantidad_requerida - $cantidad_ingresada==0){
                $RequerimientoDetalleObj = RequerimientoDetalle::find($detalle->id);
                $RequerimientoDetalleObj->cerrado = 2;
                $RequerimientoDetalleObj->save();
            }
        }

        $requerimiento_detalle_valida = RequerimientoDetalle::where('id_requerimiento',$id_requerimiento)->where('cerrado','2')->get();

        $requerimiento_detalles_model = new RequerimientoDetalle;
        $cantidadAbierto = $requerimiento_detalles_model->getCantidadAbiertoRequerimientoDetalleByIdRequerimiento($id_requerimiento);

        if($cantidadAbierto==0){

                $RequerimientoObj = Requerimiento::find($id_requerimiento);
                $RequerimientoObj->cerrado = 2;
                $RequerimientoObj->estado_atencion = 3;
                $RequerimientoObj->save();
        }

        /*$requerimiento->cerrado = $request->cerrado;
        $requerimiento->estado_atencion = $request->estado_atencion;
        $requerimiento->save();*/

        return response()->json(['id' => $orden_compra->id]);
    }

    public function modal_atender_requerimiento($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
		if($id>0){

            $requerimiento = Requerimiento::find($id);
            if($requerimiento->estado_atencion==1){
                $requerimiento->estado_atencion = 2;
            }
            $requerimiento->save();
            
		}else{
			$requerimiento = new Requerimiento;
        }

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $almacen = $almacen_model->getAlmacenAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $responsable_atencion = $user_model->getUserAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        
        return view('frontend.requerimiento.modal_requerimiento_atenderRequerimiento',compact('id','requerimiento','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen'));

    }

    public function exportar_listar_requerimiento($tipo_documento, $fecha, $numero_requerimiento, $almacen, $situacion, $responsable_atencion, $estado_atencion, $tipo_requerimiento, $estado, $producto) {

		if($tipo_documento==0)$tipo_documento = "";
		if($fecha=="0")$fecha = "";
		if($numero_requerimiento=="0")$numero_requerimiento = "";
		if($almacen==0)$almacen = "";
		if($situacion==0)$situacion = "";
		if($responsable_atencion==0)$responsable_atencion = "";
        if($estado_atencion==0)$estado_atencion = "";
        if($tipo_requerimiento==0)$tipo_requerimiento = "";
        if($estado==0)$estado = "";
        if($producto==0)$producto = "";

		$requerimiento_model = new Requerimiento;
		$p[]=$tipo_documento;
        $p[]=$fecha;
        $p[]=$numero_requerimiento;
        $p[]=$almacen;
        $p[]=$situacion;
        $p[]=$responsable_atencion;
        $p[]=$estado_atencion;
        $p[]=$tipo_requerimiento;
        $p[]=$producto;
        $p[]=$estado;
		$p[]=1;
		$p[]=1000;
		$data = $requerimiento_model->listar_requerimiento_ajax($p);
		
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Tipo Documento","Fecha","Numero Requerimiento","Almacen","Situacion", "Responsable Atencion", "Estado Atencion", "Tipo Requerimiento"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->tipo_documento, $r->fecha, $r->codigo, $r->almacen,$r->cerrado_situacion,$r->responsable_atencion, $r->estado_atencion, $r->tipo_requerimiento));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_requerimiento.xlsx');	
    }

    public function exportar_listar_requerimiento_reporte($tipo_documento, $fecha, $numero_requerimiento, $almacen, $situacion, $responsable_atencion, $estado_atencion, $tipo_requerimiento, $estado, $producto) {

		if($tipo_documento==0)$tipo_documento = "";
		if($fecha=="0")$fecha = "";
		if($numero_requerimiento=="0")$numero_requerimiento = "";
		if($almacen==0)$almacen = "";
		if($situacion==0)$situacion = "";
		if($responsable_atencion==0)$responsable_atencion = "";
        if($estado_atencion==0)$estado_atencion = "";
        if($tipo_requerimiento==0)$tipo_requerimiento = "";
        if($estado==0)$estado = "";
        if($producto==0)$producto = "";

		$requerimiento_model = new Requerimiento;
		$p[]=$tipo_documento;
        $p[]=$fecha;
        $p[]=$numero_requerimiento;
        $p[]=$almacen;
        $p[]=$situacion;
        $p[]=$responsable_atencion;
        $p[]=$estado_atencion;
        $p[]=$tipo_requerimiento;
        $p[]=$producto;
        $p[]=$estado;
		$p[]=1;
		$p[]=1000;
		$data = $requerimiento_model->listar_reporte_requerimiento_ajax($p);
		
		$variable = [];
		$n = 1;
		
		array_push($variable, array("N","Tipo Documento","Fecha","Numero Requerimiento","Almacen", "Responsable Atencion", "Producto", "Codigo", "Marca", "Cantidad"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->tipo_documento, $r->fecha, $r->numero_requerimiento, $r->almacen_solicitante,$r->responsable_atencion,$r->producto, $r->codigo, $r->marca, $r->cantidad));
		}
		
		$export = new InvoicesExport2([$variable]);
		return Excel::download($export, 'reporte_requerimiento_ejecutivo.xlsx');
    }

    public function modal_control_requerimiento($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
		if($id>0){

            $requerimiento = Requerimiento::find($id);
		}else{
			$requerimiento = new Requerimiento;
        }

        $requerimiento_model = new Requerimiento;
        $datos_requerimiento = $requerimiento_model->getControlRequerimientoById($id);

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $almacen = $almacen_model->getAlmacenAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $responsable_atencion = $user_model->getUserAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $tipo_requerimiento = $tablaMaestra_model->getMaestroByTipo(67);

        return view('frontend.requerimiento.modal_requerimiento_controlRequerimiento',compact('id','requerimiento','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen','id_user','tipo_requerimiento','datos_requerimiento'));

    }

    public function cargar_detalle_control($id)
    {

        $requerimiento_model = new Requerimiento;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $requerimiento = $requerimiento_model->getControlDetalleRequerimientoId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'requerimiento' => $requerimiento,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida
        ]);
    }

    public function send_genera_requerimiento(Request $request)
    {
        //$id_user = Auth::user()->id;

        $requerimiento = Requerimiento::find($request->id);
        $requerimiento_model = new Requerimiento;
        $id_requerimiento = $requerimiento->id;
        
        $cantidad_atendida = $request->input('cantidad_atendida');

        $fecha_actual = Carbon::now();
        $codigo_requerimiento = $requerimiento_model->getCodigoRequerimiento(1);
        
        $requerimiento_nuevo = new Requerimiento;
        $requerimiento_nuevo->id_tipo_documento = $requerimiento->id_tipo_documento;
        $requerimiento_nuevo->fecha = $fecha_actual;
        $requerimiento_nuevo->codigo = $codigo_requerimiento[0]->codigo;
        $requerimiento_nuevo->id_almacen_destino = $requerimiento->id_almacen_destino;
        $requerimiento_nuevo->sustento_requerimiento = $requerimiento->sustento_requerimiento;
        $requerimiento_nuevo->cerrado = 1;
        $requerimiento_nuevo->id_usuario_inserta = $requerimiento->id_usuario_inserta;
        $requerimiento_nuevo->estado = 1;
        $requerimiento_nuevo->responsable_atencion = $requerimiento->responsable_atencion;
        $requerimiento_nuevo->estado_atencion = 1;
        $requerimiento_nuevo->id_unidad_origen = $requerimiento->id_unidad_origen;
        $requerimiento_nuevo->id_almacen_salida = $requerimiento->id_almacen_salida;
        $requerimiento_nuevo->id_tipo_requerimiento = $requerimiento->id_tipo_requerimiento;
        $requerimiento_nuevo->id_requerimiento_matriz = $id_requerimiento;
        $requerimiento_nuevo->save();
        $id_requerimiento_nuevo = $requerimiento_nuevo->id;
        
        $array_requerimiento_detalle = array();

        $req_detalle_abierto = $requerimiento_model->getDetalleRequerimientoIdAbierto($id_requerimiento);

        foreach($req_detalle_abierto as $index => $value) {
            
            //dd($value->id_usuario_inserta);exit();
            $requerimiento_detalle = new RequerimientoDetalle;
            
            $requerimiento_detalle->id_requerimiento = $id_requerimiento_nuevo;
            $requerimiento_detalle->id_producto = $value->id_producto;
            $requerimiento_detalle->cantidad = isset($cantidad_atendida[$index]) ? (float) $cantidad_atendida[$index] : 0;
            $requerimiento_detalle->id_estado_producto = $value->id_estado_producto;
            //$orden_compra_detalle->id_unidad_medida = $unidad[$index];
            if($value->id_unidad_medida!=null && $value->id_unidad_medida !=0){
				$requerimiento_detalle->id_unidad_medida = (int)$value->id_unidad_medida;
			}
            //$orden_compra_detalle->id_marca = $marca[$index] ?? '';
            if($value->id_marca!=null && $value->id_marca !=0){
				$requerimiento_detalle->id_marca = (int)$value->id_marca;
			}
            
            $requerimiento_detalle->estado = 1;
            $requerimiento_detalle->cerrado = 1;
            $requerimiento_detalle->id_usuario_inserta = $value->id_usuario_inserta;

            $requerimiento_detalle->save();

            $requerimiento_detalle_matriz = RequerimientoDetalle::find($value->id);
            $requerimiento_detalle_matriz->cerrado = 2;
            $requerimiento_detalle_matriz->save();

        }

        $requerimiento->cerrado = 2;
        $requerimiento->estado_atencion = 3;
        $requerimiento->save();

        return response()->json(['id' => $requerimiento_nuevo->id]);
    }

    function inhabilitarModificacionRequerimiento(){

        $requerimiento_model = new Requerimiento;

		$requerimiento_model->inhabilitarModificacionRequerimiento();

    }

    public function movimiento_pdf_requerimiento_control($id){

        $requerimiento_model = new Requerimiento;
        $requerimiento_detalle_model = new RequerimientoDetalle;

        $datos=$requerimiento_model->getRequerimientoById($id);
        $datos_detalle=$requerimiento_model->getControlDetalleRequerimientoId($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
        $responsable_atencion=$datos[0]->responsable_atencion;
        $sustento_requerimiento=$datos[0]->sustento_requerimiento;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.requerimiento.movimiento_pdf_requerimiento_control',compact('tipo_documento','almacen','fecha','codigo','datos_detalle','responsable_atencion','sustento_requerimiento'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
        
		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
	}

    public function modal_observacion($id){
		
		$requerimiento_detalle = RequerimientoDetalle::find($id);
        
        return view('frontend.requerimiento.modal_observacion_requerimiento',compact('id','requerimiento_detalle'));

    }

    public function send_observacion_requerimiento(Request $request){

		$id_user = Auth::user()->id;

        //$observacion = $request->input('observacion');

        $requerimiento_detalle = RequerimientoDetalle::find($request->id);
		
		$requerimiento_detalle->observacion_atencion = $request->observacion;
		$requerimiento_detalle->save();

        return response()->json(['success' => 'Observacion guardada exitosamente.']);

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
        return ["N","Tipo Documento","Fecha","Numero Requerimiento","Almacen","Situacion", "Responsable Atencion", "Estado Atencion", "Tipo Requerimiento"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:I1');

        $sheet->setCellValue('A1', "REPORTE DE REQUERIMIENTOS - FORESPAMA");
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

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'I') as $col) {
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
        return ["N","Tipo Documento","Fecha","Numero Requerimiento","Almacen", "Responsable Atencion", "Producto", "Codigo", "Marca", "Cantidad"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:J1');

        $sheet->setCellValue('A1', "REPORTE DE DETALLE DE REQUERIMIENTO - FORESPAMA");
        $sheet->getStyle('A1:J1')->applyFromArray([
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

        $sheet->getStyle('A2:J2')->applyFromArray([
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

		/*$sheet->getStyle('L3:L'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);*/ //SIRVE PARA PONER 2 DECIMALES A ESA COLUMNA
        
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
