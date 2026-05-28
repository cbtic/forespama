<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Dispensacione;
use App\Models\TablaMaestra;
use App\Models\DispensacionDetalle;
use App\Models\Marca;
use App\Models\Almacene;
use App\Models\Producto;
use App\Models\AreaTrabajo;
use App\Models\UnidadTrabajo;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Kardex;
use App\Models\Persona;
use App\Models\Sede;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class DispensacionController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Dispensacion')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;
		$area_trabajo_model = new AreaTrabajo;
		$almacen_model = new Almacene;
		$persona_model = new Persona;
		$sede_model = new Sede;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        //$cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $almacen = $almacen_model->getAlmacenAll();
		$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$persona = $persona_model->obtenerPersonaAll();
        $sede = $sede_model->getSedeAll();
		
		return view('frontend.dispensacion.create',compact('tipo_documento','almacen','sede','persona'));

	}

    public function listar_dispensacion_ajax(Request $request){

		$dispensacion_model = new Dispensacione;
		$p[]=$request->tipo_documento;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
        $p[]=$request->numero_dispensacion;
        $p[]=$request->almacen;
		$p[]=$request->sede;
		$p[]=$request->centro_costo;
		$p[]=$request->persona_recibe;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $dispensacion_model->listar_dispensacion_ajax($p);
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

    public function modal_dispensacion($id){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		$persona_model = new Persona;
		$sede_model = new Sede;
		
		if($id>0){
			$dispensacion = Dispensacione::find($id);
		}else{
			$dispensacion = new Dispensacione;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $producto = $producto_model->getProductoAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
        $almacen = $almacen_model->getAlmacenAll();
		$persona = $persona_model->obtenerPersonaAll();
        $sede = $sede_model->getSedeAll();

		return view('frontend.dispensacion.modal_dispensacion_nuevoDispensacion',compact('id','dispensacion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen','sede','persona','id_user'));

    }

	public function send_dispensacion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$dispensacion = new Dispensacione;
			$dispensacion_model = new Dispensacione;
		    $codigo_dispensacion = $dispensacion_model->getCodigoDispensacion('2');
            //$dispensacion_model = new Dispensacione;
            //$correlativo = $dispensacion_model->getCorrelativo();
            //$dispensacion->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$dispensacion = Dispensacione::find($request->id);
            $codigo_dispensacion = $request->numero_dispensacion;
		}

		$item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        //$fecha_fabricacion = $request->input('fecha_fabricacion');
        //$fecha_vencimiento = $request->input('fecha_vencimiento');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        //$precio_unitario = $request->input('precio_unitario');
        //$descuento = $request->input('descuento');
        //$sub_total = $request->input('sub_total');
        //$igv = $request->input('igv');
        //$total = $request->input('total');
        $id_dispensacion_detalle =$request->id_dispensacion_detalle;
		
		$dispensacion->id_tipo_documento = $request->tipo_documento;
		$dispensacion->id_sede = $request->sede;
        $dispensacion->id_centro_costo = $request->centro_costo;
        $dispensacion->id_almacen = $request->almacen;
        $dispensacion->fecha = $request->fecha;
        //$dispensacion->codigo = $request->numero_dispensacion;
		if($request->id == 0){
            $dispensacion->codigo = $codigo_dispensacion[0]->codigo;
        }else{
            $dispensacion->codigo = $codigo_dispensacion;
        }
		$dispensacion->id_usuario_recibe = $request->persona_recibe;
        $dispensacion->id_usuario_inserta = $id_user;
		$dispensacion->estado = 1;
		$dispensacion->save();

		foreach($item as $index => $value) {
            
            if($id_dispensacion_detalle[$index] == 0){
                $dispensacion_detalle = new DispensacionDetalle;
            }else{
                $dispensacion_detalle = DispensacionDetalle::find($id_dispensacion_detalle[$index]);
            }
            
            $dispensacion_detalle->id_dispensacion = $dispensacion->id;
            $dispensacion_detalle->id_producto = $descripcion[$index];
            $dispensacion_detalle->cantidad = $cantidad[$index];
            //$dispensacion_detalle->precio = $precio_unitario[$index];
            //$dispensacion_detalle->sub_total = $sub_total[$index];
            //$dispensacion_detalle->igv = $igv[$index];
            //$dispensacion_detalle->total = $total[$index];
            //$dispensacion_detalle->fecha_fabricacion = $fecha_fabricacion[$index];
            //$dispensacion_detalle->fecha_vencimiento = $fecha_vencimiento[$index];
            $dispensacion_detalle->id_estado_producto = $estado_bien[$index];
            $dispensacion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$dispensacion_detalle->id_marca = (int)$marca[$index];
			}
            //$dispensacion_detalle->id_marca = $marca[$index] != null ? $marca[$index] : null;
            $dispensacion_detalle->estado = 1;
            //$dispensacion_detalle->cerrado = 1;
            $dispensacion_detalle->id_usuario_inserta = $id_user;

            $dispensacion_detalle->save();

			$producto = Producto::find($descripcion[$index]);

			if($id_dispensacion_detalle[$index] == 0){
				//$producto = Producto::find($descripcion[$index]);

				/*$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->salidas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad - $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
					//$kardex->costo_saldos_cantidad = $producto->costo_unitario;
					//$total_kardex = $cantidad_saldo * $producto->costo_unitario;
					//$kardex->total_saldos_cantidad = $total_kardex;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
					//$kardex->costo_saldos_cantidad = $producto->costo_unitario;
					//$total_kardex = $cantidad_ingreso[$index] * $producto->costo_unitario;
					//$kardex->total_saldos_cantidad = $total_kardex;
				}
				//$kardex->id_entrada_producto = $entrada_producto->id;
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;
				$kardex->fecha = $request->fecha;
				$kardex->id_usuario_inserta = $id_user;

				$kardex->save();*/

				//$idCorte = Kardex::where('id_producto', $descripcion[$index])->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', $request->fecha)->max('id');
				
				$idProducto = $descripcion[$index];
				
				$idCorte = Kardex::where('id_producto', $descripcion[$index])->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
                
				$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

				$kardex = new Kardex;
				$kardex->id_producto = $idProducto;
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->fecha = $request->fecha;

				$kardex->entradas_cantidad = 0;
				$kardex->salidas_cantidad = $cantidad[$index];

				$kardex->saldos_cantidad = $saldoBase - $cantidad[$index];

				//$kardex->id_dispensacion = $dispensacion->id;
				$kardex->id_tipo_movimiento = 30;
				$kardex->id_movimiento = $dispensacion->id;
				$kardex->codigo_movimiento = $dispensacion->codigo;
				//$kardex->fecha = $request->fecha;
				$kardex->id_usuario_inserta = $id_user;
				$kardex->save();

			}else{
				/*$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex_dispensacion = Kardex::where("id_dispensacion",$dispensacion->id)->where("id_producto",$descripcion[$index])->orderBy('id', 'desc')->first();
				//dd($kardex_dispensacion);exit();
				$kardex = kardex::find($kardex_dispensacion->id);

				//$kardex->id_producto = $descripcion[$index];
				//$kardex->salidas_cantidad = $cantidad[$index];
				if($kardex_dispensacion->salidas_cantidad>$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad - ($kardex_dispensacion->salidas_cantidad - $cantidad[$index]);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad<$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad + ($cantidad[$index] - $kardex_dispensacion->salidas_cantidad);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad==$cantidad[$index]){
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				//$kardex->saldos_cantidad = $cantidad[$index];
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;

				$kardex->save();*/
			}
        }

        return response()->json(['success' => 'Dispensaci&oacute;n guardada exitosamente.']);

    }

	public function obtener_unidad_trabajo($area_trabajo){
        
		$unidad_trabajo_model = new UnidadTrabajo;
		$unidad_trabajo = $unidad_trabajo_model->getUnidadTrabajo($area_trabajo);
		
		echo json_encode($unidad_trabajo);
	}

	public function obtener_codigo_dispensacion($tipo_documento){
		
		$dispensacion_model = new Dispensacione;
		$codigo_dispensacion = $dispensacion_model->getCodigoDispensacion($tipo_documento);
		
		return response()->json($codigo_dispensacion);
	}

	public function eliminar_dispensacion($id,$estado)
    {

		$dispensacion = Dispensacione::find($id);

		$dispensacion->estado = $estado;
		$dispensacion->save();

		if($estado==0){

			$kardexProducto = Kardex::where("id_dispensacion",$dispensacion->id)->get();

			foreach ($kardexProducto as $item) {

                $nuevoKardex = new Kardex;
                $nuevoKardex->id_producto = $item->id_producto;
                $nuevoKardex->id_dispensacion = $dispensacion->id;
                $nuevoKardex->id_almacen_destino = $item->id_almacen_destino;

                $nuevoKardex->entradas_cantidad = $item->salidas_cantidad;
				$kardex_buscar = Kardex::where("id_producto",$item->id_producto)->where("id_almacen_destino",$item->id_almacen_destino)->orderBy('id', 'desc')->first();
                $nuevoKardex->saldos_cantidad = $kardex_buscar->saldos_cantidad + $item->salidas_cantidad;

                $nuevoKardex->save();
            }


		}else if($estado==1){

			$kardexProducto = Kardex::where("id_dispensacion",$dispensacion->id)->get();

			foreach ($kardexProducto as $item) {
                
                $nuevoKardex = new Kardex;
                $nuevoKardex->id_producto = $item->id_producto;
                $nuevoKardex->id_dispensacion = $dispensacion->id;
                $nuevoKardex->id_almacen_destino = $item->id_almacen_destino;

                $nuevoKardex->salidas_cantidad = $item->salidas_cantidad;
				$kardex_buscar = Kardex::where("id_producto",$item->id_producto)->where("id_almacen_destino",$item->id_almacen_destino)->orderBy('id', 'desc')->first();
                $nuevoKardex->saldos_cantidad = $kardex_buscar->saldos_cantidad - $item->salidas_cantidad;

                $nuevoKardex->save();
            }
		}
		
		echo $dispensacion->id;
    }

	public function cargar_detalle($id)
    {

        $dispensacion_model = new Dispensacione;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $dispensacion = $dispensacion_model->getDetalleDispensacionById($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        $producto_stock = [];

        foreach($dispensacion as $detalle){
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $detalle->id_almacen);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['saldos_cantidad'=>0];
            }
        }

        return response()->json([
            'dispensacion' => $dispensacion,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'producto_stock' =>$producto_stock
        ]);
    }

	public function movimiento_pdf_dispensacion($id){

        $dispensacion_model = new Dispensacione;
        $dispensacion_detalle_model = new DispensacionDetalle;

        $datos=$dispensacion_model->getDispensacionById($id);
        $datos_detalle=$dispensacion_detalle_model->getDetalleDispensacionPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $sede=$datos[0]->sede;
        $centro_costo = $datos[0]->centro_costo;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
		$usuario_recibe=$datos[0]->usuario_recibe;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.dispensacion.movimiento_pdf_dispensacion',compact('tipo_documento','sede','almacen','centro_costo','fecha','codigo','usuario_recibe','datos_detalle'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

	public function exportar_listar_dispensacion_reporte($tipo_documento, $fecha_inicio, $fecha_fin, $numero_dispensacion, $almacen, $sede, $centro_costo, $persona_recibe, $estado) {

		if($tipo_documento==0)$tipo_documento = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($numero_dispensacion=="0")$numero_dispensacion = "";
		if($almacen==0)$almacen = "";
		if($sede==0)$sede = "";
        if($centro_costo==0)$centro_costo = "";
        if($persona_recibe==0)$persona_recibe = "";
        if($estado==0)$estado = "";

		$dispensacion_model = new Dispensacione;
		$p[]=$tipo_documento;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
        $p[]=$numero_dispensacion;
        $p[]=$almacen;
		$p[]=$sede;
		$p[]=$centro_costo;
		$p[]=$persona_recibe;
        $p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $dispensacion_model->listar_dispensacion_reporte_ajax($p);
		
		$variable = [];
		$n = 1;
		
		array_push($variable, array("N","Tipo Movimiento","Codigo Dispensacion","Fecha","Almacen","Persona Recibe", "Sede", "Centro Costo", "Codigo Producto", "Producto", "Cantidad"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->tipo_movimiento, $r->codigo_dispensacion, $r->fecha, $r->almacen_salida, $r->usuario_recibe,$r->sede, $r->centro_costo, $r->codigo_producto, $r->producto, $r->cantidad));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_dispensacion_ejecutivo.xlsx');
    }

	public function modal_dispensacion_devolucion($id){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		$area_trabajo_model = new AreaTrabajo;
		$unidad_trabajo_model = new UnidadTrabajo;
		$persona_model = new Persona;
		$sede_model = new Sede;
		
		
		if($id>0){
			$dispensacion = Dispensacione::find($id);
		}else{
			$dispensacion = new Dispensacione;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $producto = $producto_model->getProductoAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
        $almacen = $almacen_model->getAlmacenAll();
		$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$persona = $persona_model->obtenerPersonaAll();
        $sede = $sede_model->getSedeAll();

		return view('frontend.dispensacion.modal_dispensacion_nuevoDispensacionDevolucion',compact('id','dispensacion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen','area_trabajo','persona','id_user','sede'));

    }

	public function send_dispensacion_devolucion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$dispensacion = new Dispensacione;
			$dispensacion_model = new Dispensacione;
		    $codigo_dispensacion = $dispensacion_model->getCodigoDispensacion('1');
		}else{
			$dispensacion = Dispensacione::find($request->id);
            $codigo_dispensacion = $request->numero_dispensacion;
		}

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $id_dispensacion_detalle =$request->id_dispensacion_detalle;
		
		$dispensacion->id_tipo_documento = $request->tipo_documento;
        $dispensacion->id_almacen = $request->almacen;
		$dispensacion->id_sede = $request->sede_;
        $dispensacion->id_centro_costo = $request->centro_costo_;
        $dispensacion->fecha = $request->fecha;
		if($request->id == 0){
            $dispensacion->codigo = $codigo_dispensacion[0]->codigo;
        }else{
            $dispensacion->codigo = $codigo_dispensacion;
        }
		$dispensacion->id_usuario_recibe = $request->persona_recibe;
        $dispensacion->id_dispensacion_matriz = $request->id_dispensacion;
        $dispensacion->id_usuario_inserta = $id_user;
		$dispensacion->estado = 1;
		$dispensacion->save();
		
		$id_dispensacion = $dispensacion->id;

		foreach($descripcion as $index => $value) {
            
            if($id_dispensacion_detalle[$index] == 0){
                $dispensacion_detalle = new DispensacionDetalle;
            }else{
                $dispensacion_detalle = DispensacionDetalle::find($id_dispensacion_detalle[$index]);
            }
            
            $dispensacion_detalle->id_dispensacion = $dispensacion->id;
            $dispensacion_detalle->id_producto = $descripcion[$index];
            $dispensacion_detalle->cantidad = $cantidad[$index];
            $dispensacion_detalle->id_estado_producto = 1;
            $dispensacion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$dispensacion_detalle->id_marca = (int)$marca[$index];
			}
            $dispensacion_detalle->estado = 1;
            $dispensacion_detalle->id_usuario_inserta = $id_user;

            $dispensacion_detalle->save();

			//$producto = Producto::find($descripcion[$index]);
			
			$idProducto = $descripcion[$index];
			
			$idCorte = Kardex::where('id_producto', $descripcion[$index])->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
			
			$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

			$kardex = new Kardex;
			$kardex->id_producto = $idProducto;
			$kardex->id_almacen_destino = $request->almacen;
			$kardex->fecha = $request->fecha;

			$kardex->entradas_cantidad = $cantidad[$index];
			$kardex->salidas_cantidad = 0;

			$kardex->saldos_cantidad = $saldoBase + $cantidad[$index];

			$kardex->id_tipo_movimiento = 8;
			$kardex->id_movimiento = $id_dispensacion;
			$kardex->codigo_movimiento = $dispensacion->codigo;
			$kardex->id_usuario_inserta = $id_user;
			$kardex->save();

        }

        return response()->json(['success' => 'Devoluci&oacute;n de Dispensaci&oacute;n guardada exitosamente.']);

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
        return ["N","Tipo Movimiento","Codigo Dispensacion","Fecha","Almacen","Persona Recibe", "Sede", "Centro Costo", "Codigo Producto", "Producto", "Cantidad"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:K1');

        $sheet->setCellValue('A1', "REPORTE DE DETALLE DE DISPENSACION - FORESPAMA");
        $sheet->getStyle('A1:K1')->applyFromArray([
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

        $sheet->getStyle('A2:K2')->applyFromArray([
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
        
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
