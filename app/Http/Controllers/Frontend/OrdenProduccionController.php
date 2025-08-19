<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Persona;
use App\Models\OrdenCompra;
use App\Models\IngresoProduccion;
use App\Models\IngresoProduccionDetalle;
use App\Models\OrdenProduccion;
use App\Models\OrdenProduccionDetalle;
use App\Models\TipoEncargado;
use App\Models\UnidadTrabajo;
use App\Models\OrdenCompraDetalle;
use App\Models\Marca;
use App\Models\Almacene;
use App\Models\Kardex;
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

class OrdenProduccionController extends Controller
{
    public function create_orden_produccion(){

		$tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $persona_model = new Persona;
        $unidad_trabajo_model = new UnidadTrabajo;

        $producto = $producto_model->getProductoExterno();
        //$encargado = $persona_model->obtenerPersonaAll();
        $area = $unidad_trabajo_model->getUnidadTrabajo(7);
        $situacion = $tablaMaestra_model->getMaestroByTipo(92);
        $cerrado = $tablaMaestra_model->getMaestroByTipo(52);
        //$producto = $producto_model->getProductoAll();
        
		return view('frontend.orden_produccion.create_orden_produccion',compact('area','situacion','producto','cerrado'));

	}

    public function listar_orden_produccion_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_produccion_model = new OrdenProduccion;
        $p[]=$request->numero_orden_produccion;
        $p[]=$request->fecha_inicio;
        $p[]=$request->area;
        $p[]=$request->situacion;
        $p[]=$request->producto;
        $p[]=$request->cerrado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_produccion_model->listar_orden_produccion_ajax($p);
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

    public function modal_orden_produccion($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $encargado_model = new TipoEncargado;
        $unidad_trabajo_model = new UnidadTrabajo;
		
		if($id>0){

            $orden_produccion = OrdenProduccion::find($id);
			
		}else{
			$orden_produccion = new OrdenProduccion;
		}

        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$encargado = $encargado_model->obtenerEncargadoByTipo(2);
        $area = $unidad_trabajo_model->getUnidadTrabajo(7);

		return view('frontend.orden_produccion.modal_orden_produccion_nuevoOrdenProduccion',compact('id','orden_produccion','producto','unidad','area'));

    }

    public function modal_orden_produccion_planeamiento($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $encargado_model = new TipoEncargado;
        $unidad_trabajo_model = new UnidadTrabajo;
		
		if($id>0){

            $orden_produccion = OrdenProduccion::find($id);
			
		}else{
			$orden_produccion = new OrdenProduccion;
		}

        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        //$encargado = $encargado_model->obtenerEncargadoByTipo(2);
        $area = $unidad_trabajo_model->getUnidadTrabajo(7);

		return view('frontend.orden_produccion.modal_orden_produccion_nuevoOrdenProduccionPlaneamiento',compact('id','orden_produccion','producto','unidad','area'));

    }

    public function send_orden_produccion(Request $request)
    {
		$id_user = Auth::user()->id;

        if($request->id == 0){
            $orden_produccion = new OrdenProduccion;
            $orden_produccion_model = new OrdenProduccion;
		    $codigo_orden_produccion = $orden_produccion_model->getCodigoOrdenProduccion();
        }else{
            $orden_produccion = OrdenCompra::find($request->id);
            $codigo_orden_produccion = $request->numero_orden_produccion;
        }

        $id_producto = $request->input('id_producto');
        $cantidad_producir = $request->input('cantidad_producir');

        $orden_produccion->id_area = $request->area;
        $orden_produccion->fecha_orden_produccion = $request->fecha_orden_produccion;
        if($request->id == 0){
            $orden_produccion->codigo = $codigo_orden_produccion[0]->codigo;
        }else{
            $orden_produccion->codigo = $codigo_orden_produccion;
        }
        $orden_produccion->id_situacion = 1;
        $orden_produccion->id_usuario_inserta = $id_user;
        $orden_produccion->estado = 1;
        $orden_produccion->save();
        $id_orden_produccion = $orden_produccion->id;
        
        $array_orden_produccion_detalle = array();

        foreach($id_producto as $index => $value) {
            
            //if($id_orden_compra_detalle[$index] == 0){
                $orden_produccion_detalle = new OrdenProduccionDetalle;
            //}else{
            //    $orden_compra_detalle = OrdenCompraDetalle::find($id_orden_compra_detalle[$index]);
            //}
            
            $orden_produccion_detalle->id_orden_produccion = $id_orden_produccion;
            $orden_produccion_detalle->id_producto = $id_producto[$index];
            $orden_produccion_detalle->cantidad = $cantidad_producir[$index];
            $orden_produccion_detalle->estado = 1;
            $orden_produccion_detalle->id_usuario_inserta = $id_user;

            $orden_produccion_detalle->save();

            $array_orden_produccion_detalle[] = $orden_produccion_detalle->id;

            /*$OrdenCompraAll = OrdenCompraDetalle::where("id_orden_compra",$orden_compra->id)->where("estado","1")->get();
            
            foreach($OrdenCompraAll as $key=>$row){
                
                if (!in_array($row->id, $array_orden_compra_detalle)){
                    $orden_compra_detalle = OrdenCompraDetalle::find($row->id);
                    $orden_compra_detalle->estado = 0;
                    $orden_compra_detalle->save();
                }
            }*/
        }

		return response()->json(['id' => $orden_produccion->id]);  

    }

    public function cargar_detalle()
    {

        $orden_compra_model = new OrdenCompra;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $orden_produccion = $orden_compra_model->getDetalleProductosNoComprometidosId();
        $producto = $producto_model->getProductoExterno();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        $producto_stock = [];

        return response()->json([
            'orden_produccion' => $orden_produccion,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function cargar_detalle_guardado($id)
    {

        $orden_produccion_model = new OrdenProduccion;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $orden_produccion = $orden_produccion_model->getDetalleOrdenProduccionById($id);
        $producto = $producto_model->getProductoExterno();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        $producto_stock = [];

        return response()->json([
            'orden_produccion' => $orden_produccion,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function movimiento_pdf($id){

        $orden_compra_model = new OrdenProduccion;
        $orden_compra_detalle_model = new OrdenProduccionDetalle;

        $datos=$orden_compra_model->getOrdenProduccionByIdPdf($id);
        $datos_detalle=$orden_compra_detalle_model->getDetalleOrdenProduccionPdf($id);

        $id_situacion=$datos[0]->id_situacion;
        $fecha_orden_produccion=$datos[0]->fecha_orden_produccion;
        $codigo=$datos[0]->codigo;
        $area = $datos[0]->area;
        $usuario = $datos[0]->usuario;
                
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.orden_produccion.movimiento_orden_produccion_pdf',compact('id_situacion','fecha_orden_produccion','codigo','area','usuario','datos_detalle'));

		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait'); //landscape horizontal
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function movimiento_pdf_detallado($id){

        $orden_compra_model = new OrdenProduccion;
        $orden_compra_detalle_model = new OrdenProduccionDetalle;

        $datos=$orden_compra_model->getOrdenProduccionByIdPdf($id);
        $datos_detalle=$orden_compra_detalle_model->getDetalleOrdenProduccionPdf($id);

        $id_situacion=$datos[0]->id_situacion;
        $fecha_orden_produccion=$datos[0]->fecha_orden_produccion;
        $codigo=$datos[0]->codigo;
        $area = $datos[0]->area;
        $usuario = $datos[0]->usuario;
                
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.orden_produccion.movimiento_orden_produccion_pdf',compact('id_situacion','fecha_orden_produccion','codigo','area','usuario','datos_detalle'));

		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait'); //landscape horizontal
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function modal_atender_orden_produccion($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
        $unidad_trabajo_model = new UnidadTrabajo;
		
		if($id>0){
            $orden_produccion = OrdenProduccion::find($id);
        }else{
			$orden_produccion = new OrdenProduccion;
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
        $area = $unidad_trabajo_model->getUnidadTrabajo(7);
        
        return view('frontend.orden_produccion.modal_orden_produccion_atenderOrdenProduccion',compact('id','orden_produccion','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen','area'));

    }

    public function cargar_detalle_orden_produccion($id)
    {

        $orden_produccion_model = new OrdenProduccion;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $orden_produccion = $orden_produccion_model->getDetalleOrdenProduccionId($id);
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'orden_produccion' => $orden_produccion,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida
        ]);
    }

    public function send_orden_produccion_orden_compra(Request $request)
    {
        $id_user = Auth::user()->id;

        $orden_produccion = OrdenProduccion::find($request->id);
        $id_orden_produccion = $orden_produccion->id;

        $orden_compra = new OrdenCompra;

        $orden_compra_model = new OrdenCompra;
        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra(1);

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('codigo');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad_atendida');
        
        $id_orden_produccion_detalle =$request->id_orden_produccion_detalle;
        
        $orden_compra->id_empresa_compra = 30;
        $orden_compra->id_empresa_vende = 30;
        $orden_compra->fecha_orden_compra = $request->fecha_produccion;
        $orden_compra->numero_orden_compra = $codigo_orden_compra[0]->codigo;
        $orden_compra->id_tipo_documento = 1;
        $orden_compra->igv_compra = 1;
        $orden_compra->cerrado = 1;
        $orden_compra->id_unidad_origen = 3;
        $orden_compra->id_almacen_destino = $request->almacen_destino;
        $orden_compra->id_almacen_salida = $request->almacen_origen;
        $orden_compra->id_tipo_cliente = '5';
        $orden_compra->id_usuario_inserta = $id_user;
        $orden_compra->observacion_vendedor = $request->observacion;
        $orden_compra->id_orden_produccion = $id_orden_produccion;
        $orden_compra->fecha_produccion = $request->fecha_produccion;
        $orden_compra->estado = 1;
        $orden_compra->save();
        $id_orden_compra = $orden_compra->id;

        $array_orden_compra_detalle = array();

        foreach($descripcion as $index => $value) {

            $orden_compra_detalle = new OrdenCompraDetalle;
            
            $orden_compra_detalle->id_orden_compra = $id_orden_compra;
            $orden_compra_detalle->id_producto = $descripcion[$index];
            $orden_compra_detalle->cantidad_requerida = $cantidad[$index];
            $orden_compra_detalle->id_estado_producto = 1;
            if($unidad[$index]!=null && $unidad !=0){
				$orden_compra_detalle->id_unidad_medida = (int)$unidad[$index];
			}
			$orden_compra_detalle->id_marca = 278;
            $orden_compra_detalle->id_descuento = 1;
            $orden_compra_detalle->descuento = 0;
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->id_usuario_inserta = $id_user;

            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;

        }

        $orden_produccion_detalle = OrdenProduccionDetalle::where('id_orden_produccion',$id_orden_produccion)->where('estado','1')->get();

        $orden_produccion_detalle_model = new OrdenProduccionDetalle;

        foreach($orden_produccion_detalle as $index => $detalle){
            
            $detalle_orden_produccion = OrdenProduccionDetalle::where('id_orden_produccion',$id_orden_produccion)->where('id_producto',$detalle->id_producto)->where('estado','1')->first();

            $cantidad_requerida = $detalle_orden_produccion->cantidad;
            
            $cantidad_ingresada = $orden_produccion_detalle_model->getCantidadIngresoProduccionByOrdenProduccionProducto($id_orden_produccion,$detalle->id_producto);
            
            if($cantidad_requerida <= $cantidad_ingresada){
                $OrdenProduccionDetalleObj = OrdenProduccionDetalle::find($detalle->id);
                $OrdenProduccionDetalleObj->cerrado = 2;
                $OrdenProduccionDetalleObj->save();
            }
        }

        $orden_produccion_detalle_valida = OrdenProduccionDetalle::where('id_orden_produccion',$id_orden_produccion)->where('cerrado','2')->get();

        $orden_produccion_detalles_model = new OrdenProduccionDetalle;
        $cantidadAbierto = $orden_produccion_detalles_model->getCantidadAbiertoOrdenProduccionDetalleByIdOrdenProduccion($id_orden_produccion);

        if($cantidadAbierto==0){

            $OrdenProduccionObj = OrdenProduccion::find($id_orden_produccion);
            $OrdenProduccionObj->cerrado = 2;
            $OrdenProduccionObj->id_situacion = 3;
            $OrdenProduccionObj->save();
        }else{
            $OrdenProduccionObj = OrdenProduccion::find($id_orden_produccion);
            $OrdenProduccionObj->id_situacion = 2;
            $OrdenProduccionObj->save();
        }

        return response()->json(['id' => $orden_produccion->id]);
    }

    public function exportar_listar_orden_produccion($id) {
        
		$orden_produccion_model = new OrdenProduccion;

		$data_cabecera = $orden_produccion_model->getOrdenProduccionByIdPdf($id);

        $fecha_orden_produccion=$data_cabecera[0]->fecha_orden_produccion;
        $codigo=$data_cabecera[0]->codigo;
        $area = $data_cabecera[0]->area;
		
		$data_detalle = $orden_produccion_model->getDetalleOrdenProduccionById($id);
		
		$variable = [];
		$n = 1;
		
		foreach ($data_detalle as $r) {

			$variable[] = [$n++, $r->nombre_producto, $r->codigo, $r->unidad_medida, $r->cantidad];
		}
		
		$export = new InvoicesExport($variable, $codigo, $fecha_orden_produccion, $area);
		return Excel::download($export, 'orden_produccion.xlsx');
    }

    public function cerrar_orden_produccion($id)
    {
		$orden_produccion = OrdenProduccion::find($id);

		$orden_produccion->cerrado = 2;
		$orden_produccion->save();

		echo $orden_produccion->id;
    }
}

class InvoicesExport implements FromArray, WithStyles
{
	protected $invoices;
    protected $codigo;
    protected $fecha;
    protected $area;

	public function __construct(array $invoices, $codigo, $fecha, $area)
	{
		$this->invoices = $invoices;
		$this->codigo = $codigo;
        $this->fecha = $fecha;
        $this->area = $area;
	}

	public function array(): array
    {
        $data = [];
        
        $data[] = ["",""];

        $data[] = ["Fecha Orden Producción", "Área"];

        $data[] = [$this->fecha, $this->area];

        $data[] = ["#", "Descripción", "Código", "Unidad", "Cantidad"];

        foreach ($this->invoices as $row) {
            $data[] = $row;
        }

        return $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:E1');
        $sheet->setCellValue('A1', "ORDEN DE FABRICACION N° {$this->codigo} - FORESPAMA");

        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 14,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '246257'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->getStyle('A2:B2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);

        $sheet->getStyle('A4:E4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2EB85C'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
