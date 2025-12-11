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
use App\Models\ProductoPrecioDetalle;
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
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_requerimiento;
        $p[]=$request->almacen;
        $p[]=$request->situacion;
        $p[]=$request->responsable_atencion;
        $p[]=$request->estado_atencion;
        $p[]=$request->tipo_requerimiento;
        $p[]=$request->producto;
        $p[]=$request->denominacion_producto;
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
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

        return response()->json([
            'requerimiento' => $requerimiento,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'moneda' => $moneda
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

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $cantidad_atendida = $request->input('cantidad_atendida');
        $moneda = $request->input('moneda');
        $tipo_cambio = $request->input('tipo_cambio');
        $precio_unitario = $request->input('precio_unitario');
        $total_precio = $request->input('total_precio');
        $total = $request->input('total');
        
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
        $id_orden_compra = $orden_compra->id;

        $array_orden_compra_detalle = array();

        $acumulado_sub_total = 0;
        $acumulado_igv = 0;
        $acumulado_total = 0;

        foreach($descripcion as $index => $value) {
            
            $precio_unitario_ = 0;
            $valor_venta_bruto = 0;
            $valor_venta = 0;
            $igv = 0;
            $total = 0;

            $orden_compra_detalle = new OrdenCompraDetalle;

            $precio_unitario_ = $total_precio[$index] / 1.18;
            $valor_venta_bruto = ($cantidad_atendida[$index] * $total_precio[$index]) / 1.18;
            $valor_venta = $valor_venta_bruto;
            $igv = $valor_venta * 0.18;
            $total = $valor_venta + $igv;
            
            $orden_compra_detalle->id_orden_compra = $id_orden_compra;
            $orden_compra_detalle->id_producto = $descripcion[$index];
            $orden_compra_detalle->cantidad_requerida = $cantidad_atendida[$index];
            $orden_compra_detalle->id_estado_producto = $estado_bien[$index];

            $orden_compra_detalle->precio = round($precio_unitario_,3);//$total_precio[$index]

            $orden_compra_detalle->valor_venta_bruto = round($valor_venta_bruto,3);

            $orden_compra_detalle->precio_venta = round($total_precio[$index],3);//$precio_unitario_

            $orden_compra_detalle->valor_venta = round($valor_venta,3);
            $orden_compra_detalle->sub_total = round($valor_venta,3);
            $orden_compra_detalle->igv = round($igv,3);
            $orden_compra_detalle->total = round($total,3);
            if($unidad[$index]!=null && $unidad !=0){
				$orden_compra_detalle->id_unidad_medida = (int)$unidad[$index];
			}

            if($marca[$index]!=null && $marca[$index] !=0){
				$orden_compra_detalle->id_marca = (int)$marca[$index];
			}
            $orden_compra_detalle->id_descuento = 1;
            $orden_compra_detalle->descuento = 0;
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->id_usuario_inserta = $id_user;

            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;

            $producto_precio_detalle = new ProductoPrecioDetalle;
            $producto_precio_detalle->id_producto = $descripcion[$index];
            $producto_precio_detalle->id_moneda = $moneda[$index];
            $producto_precio_detalle->tipo_cambio = $tipo_cambio[$index];
            $producto_precio_detalle->precio_dolares = $precio_unitario[$index];
            $producto_precio_detalle->precio = $total_precio[$index];
            $producto_precio_detalle->fecha = Carbon::now();
            $producto_precio_detalle->estado = '1';
            $producto_precio_detalle->id_usuario_inserta = $id_user;
            $producto_precio_detalle->save();

            $acumulado_sub_total += $valor_venta;
            $acumulado_igv += $igv;
            $acumulado_total += $total;

        }

        $orden_compra_actualizado = OrdenCompra::find($id_orden_compra);
        $orden_compra_actualizado->sub_total = round($acumulado_sub_total, 3);
        $orden_compra_actualizado->igv = round($acumulado_igv, 3);
        $orden_compra_actualizado->total = round($acumulado_total, 3);
        $orden_compra_actualizado->save();

        $requerimiento_detalle = RequerimientoDetalle::where('id_requerimiento',$id_requerimiento)->where('estado','1')->get();

        $requerimiento_detalle_model = new RequerimientoDetalle;

        foreach($requerimiento_detalle as $index => $detalle){
            
            $detalle_requerimiento = RequerimientoDetalle::where('id_requerimiento',$id_requerimiento)->where('id_producto',$detalle->id_producto)->where('estado','1')->first();

            $cantidad_requerida = $detalle_requerimiento->cantidad;
            
            $cantidad_ingresada = $requerimiento_detalle_model->getCantidadOrdenCompraByRequerimientoProducto($id_requerimiento,$detalle->id_producto);
            
            if($cantidad_requerida <= $cantidad_ingresada){
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

        return response()->json(['id' => $orden_compra->id, 'codigo' => $orden_compra->numero_orden_compra]);
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

    public function exportar_listar_requerimiento($tipo_documento, $fecha_inicio, $fecha_fin, $numero_requerimiento, $almacen, $situacion, $responsable_atencion, $estado_atencion, $tipo_requerimiento, $estado, $producto, $denominacion_producto) {

		if($tipo_documento==0)$tipo_documento = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($numero_requerimiento=="0")$numero_requerimiento = "";
		if($almacen==0)$almacen = "";
		if($situacion==0)$situacion = "";
		if($responsable_atencion==0)$responsable_atencion = "";
        if($estado_atencion==0)$estado_atencion = "";
        if($tipo_requerimiento==0)$tipo_requerimiento = "";
        if($estado==0)$estado = "";
        if($producto==0)$producto = "";
        if($denominacion_producto=="0")$denominacion_producto = "";
        
		$requerimiento_model = new Requerimiento;
		$p[]=$tipo_documento;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_requerimiento;
        $p[]=$almacen;
        $p[]=$situacion;
        $p[]=$responsable_atencion;
        $p[]=$estado_atencion;
        $p[]=$tipo_requerimiento;
        $p[]=$producto;
        $p[]=$denominacion_producto;
        $p[]=$estado;
		$p[]=1;
		$p[]=1000;
		$data = $requerimiento_model->listar_requerimiento_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Tipo Documento","Fecha","Numero Requerimiento","Almacen","Situacion", "Responsable Atencion", "Estado Atencion", "Tipo Requerimiento"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->tipo_documento, $r->fecha, $r->codigo, $r->almacen,$r->cerrado_situacion,$r->responsable_atencion, $r->estado_atencion, $r->tipo_requerimiento));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_requerimiento.xlsx');	
    }

    public function exportar_listar_requerimiento_reporte($tipo_documento, $fecha_inicio, $fecha_fin, $numero_requerimiento, $almacen, $situacion, $responsable_atencion, $estado_atencion, $tipo_requerimiento, $estado, $producto, $denominacion_producto) {

		if($tipo_documento==0)$tipo_documento = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($numero_requerimiento=="0")$numero_requerimiento = "";
		if($almacen==0)$almacen = "";
		if($situacion==0)$situacion = "";
		if($responsable_atencion==0)$responsable_atencion = "";
        if($estado_atencion==0)$estado_atencion = "";
        if($tipo_requerimiento==0)$tipo_requerimiento = "";
        if($estado==0)$estado = "";
        if($producto==0)$producto = "";
        if($denominacion_producto=="0")$denominacion_producto = "";

		$requerimiento_model = new Requerimiento;
		$p[]=$tipo_documento;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_requerimiento;
        $p[]=$almacen;
        $p[]=$situacion;
        $p[]=$responsable_atencion;
        $p[]=$estado_atencion;
        $p[]=$tipo_requerimiento;
        $p[]=$producto;
        $p[]=$denominacion_producto;
        $p[]=$estado;
		$p[]=1;
		$p[]=1000;
		$data = $requerimiento_model->listar_reporte_requerimiento_ajax($p);
		
		$variable = [];
		$n = 1;
		
		array_push($variable, array("N","Tipo Documento","Fecha","Numero Requerimiento","Almacen", "Responsable Atencion", "Producto", "Codigo", "Marca", "Cantidad", "Cantidad Atendida", "Estado"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->tipo_documento, $r->fecha, $r->numero_requerimiento, $r->almacen_solicitante,$r->responsable_atencion,$r->producto, $r->codigo, $r->marca, $r->cantidad, $r->cantidad_atendida, $r->cerrado));
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
            
            $requerimiento_detalle = new RequerimientoDetalle;
            
            $requerimiento_detalle->id_requerimiento = $id_requerimiento_nuevo;
            $requerimiento_detalle->id_producto = $value->id_producto;
            $requerimiento_detalle->cantidad = isset($cantidad_atendida[$index]) ? (float) $cantidad_atendida[$index] : 0;
            $requerimiento_detalle->id_estado_producto = $value->id_estado_producto;
            if($value->id_unidad_medida!=null && $value->id_unidad_medida !=0){
				$requerimiento_detalle->id_unidad_medida = (int)$value->id_unidad_medida;
			}
            
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

        $requerimiento_detalle = RequerimientoDetalle::find($request->id);
		
		$requerimiento_detalle->observacion_atencion = $request->observacion;
		$requerimiento_detalle->save();

        return response()->json(['success' => 'Observacion guardada exitosamente.']);

    }

    public function modal_cerrar_antiguedad($id){
		
		$requerimiento = Requerimiento::find($id);
        
        return view('frontend.requerimiento.modal_cerrar_antiguedad_requerimiento',compact('id','requerimiento'));

    }

    public function send_cerrar_antiguedad_requerimiento(Request $request){

		$id_user = Auth::user()->id;

        $requerimiento = Requerimiento::find($request->id);
		
		$requerimiento->cerrado = 2;
		$requerimiento->estado_atencion = 4;
		$requerimiento->motivo_cerrado = $request->motivo;
		$requerimiento->save();

        return response()->json(['success' => 'Observacion guardada exitosamente.']);

    }

    public function modal_agregar_cotizacion($id){
		
        $id_user = Auth::user()->id;
		
		$requerimiento = new Requerimiento;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $empresa_model = new Empresa;

        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $proveedor = $empresa_model->getEmpresaAll();

        return view('frontend.requerimiento.modal_requerimiento_nuevoCotizacion',compact('id','requerimiento','producto','marca','unidad','igv_compra','moneda','proveedor'));

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
        return ["N","Tipo Documento","Fecha","Numero Requerimiento","Almacen", "Responsable Atencion", "Producto", "Codigo", "Marca", "Cantidad", "Cantidad Atendida", "Estado"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:L1');

        $sheet->setCellValue('A1', "REPORTE DE DETALLE DE REQUERIMIENTO - FORESPAMA");
        $sheet->getStyle('A1:L1')->applyFromArray([
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

        $sheet->getStyle('A2:L2')->applyFromArray([
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
        
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
