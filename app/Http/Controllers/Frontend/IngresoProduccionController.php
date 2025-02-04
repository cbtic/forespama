<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IngresoProduccion;
use App\Models\TablaMaestra;
use App\Models\IngresoProduccionDetalle;
use App\Models\Marca;
use App\Models\Almacene;
use App\Models\Producto;
use App\Models\Kardex;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class IngresoProduccionController extends Controller
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
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        //$cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $almacen_destino = Almacene::all();
		
		return view('frontend.ingreso_produccion.create',compact('tipo_documento','almacen_destino'));

	}

    public function listar_ingreso_produccion_ajax(Request $request){

		$ingreso_produccion_model = new IngresoProduccion;
		$p[]=$request->tipo_documento;
		$p[]=$request->fecha;
        $p[]=$request->numero_ingreso_produccion;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_produccion_model->listar_ingreso_produccion_ajax($p);
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

    public function modal_ingreso_produccion($id){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		
		if($id>0){
			$ingreso_produccion = IngresoProduccion::find($id);
		}else{
			$ingreso_produccion = new IngresoProduccion;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
        $almacen_destino = $almacen_model->getAlmacenAll();
		//var_dump($id);exit();

		return view('frontend.ingreso_produccion.modal_ingreso_produccion_nuevoIngresoProduccion',compact('id','ingreso_produccion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen_destino','id_user'));

    }

	public function send_ingreso_produccion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$ingreso_produccion = new IngresoProduccion;
            //$dispensacion_model = new Dispensacione;
            //$correlativo = $dispensacion_model->getCorrelativo();
            //$dispensacion->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$ingreso_produccion = IngresoProduccion::find($request->id);
		}

		$item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $id_ingreso_produccion_detalle =$request->id_ingreso_produccion_detalle;
		
		$ingreso_produccion->id_tipo_documento = $request->tipo_documento;
        $ingreso_produccion->id_almacen_destino = $request->almacen_destino;
        $ingreso_produccion->fecha = $request->fecha;
        $ingreso_produccion->codigo = $request->numero_ingreso_produccion;
        $ingreso_produccion->producto_defectuoso = $request->input('producto_defectuoso', 0) == '1' ? 1 : 0;
		$ingreso_produccion->observacion = $request->observacion;
        $ingreso_produccion->id_usuario_inserta = $id_user;
		$ingreso_produccion->estado = 1;
		$ingreso_produccion->save();

		foreach($item as $index => $value) {
            
            if($id_ingreso_produccion_detalle[$index] == 0){
                $ingreso_produccion_detalle = new IngresoProduccionDetalle;
            }else{
                $ingreso_produccion_detalle = IngresoProduccionDetalle::find($id_ingreso_produccion_detalle[$index]);
            }
            
            $ingreso_produccion_detalle->id_ingreso_produccion = $ingreso_produccion->id;
            $ingreso_produccion_detalle->id_producto = $descripcion[$index];
            $ingreso_produccion_detalle->cantidad = $cantidad[$index];
            $ingreso_produccion_detalle->id_estado_producto = $estado_bien[$index];
            $ingreso_produccion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$ingreso_produccion_detalle->id_marca = (int)$marca[$index];
			}
            $ingreso_produccion_detalle->estado = 1;
            $ingreso_produccion_detalle->id_usuario_inserta = $id_user;

            $ingreso_produccion_detalle->save();

			if($id_ingreso_produccion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->entradas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				$kardex->id_almacen_destino = $request->almacen_destino;
				$kardex->id_ingreso_produccion = $ingreso_produccion->id;

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

        return response()->json(['success' => 'Ingreso a Produccion guardado exitosamente.']);

    }

    public function eliminar_ingreso_produccion($id,$estado)
    {

		$ingreso_produccion = IngresoProduccion::find($id);

		$ingreso_produccion->estado = $estado;
		$ingreso_produccion->save();

		if($estado==0){

			$kardexProducto = Kardex::where("id_dispensacion",$ingreso_produccion->id)->get();

			foreach ($kardexProducto as $item) {

                $nuevoKardex = new Kardex;
                $nuevoKardex->id_producto = $item->id_producto;
                $nuevoKardex->id_ingreso_produccion = $ingreso_produccion->id;
                $nuevoKardex->id_almacen_destino = $item->id_almacen_destino;

                $nuevoKardex->entradas_cantidad = $item->salidas_cantidad;
				$kardex_buscar = Kardex::where("id_producto",$item->id_producto)->where("id_almacen_destino",$item->id_almacen_destino)->orderBy('id', 'desc')->first();
                $nuevoKardex->saldos_cantidad = $kardex_buscar->saldos_cantidad + $item->salidas_cantidad;

                $nuevoKardex->save();
            }


		}else if($estado==1){

			$kardexProducto = Kardex::where("id_dispensacion",$ingreso_produccion->id)->get();

			foreach ($kardexProducto as $item) {
                
                $nuevoKardex = new Kardex;
                $nuevoKardex->id_producto = $item->id_producto;
                $nuevoKardex->id_ingreso_produccion = $ingreso_produccion->id;
                $nuevoKardex->id_almacen_destino = $item->id_almacen_destino;

                $nuevoKardex->salidas_cantidad = $item->salidas_cantidad;
				$kardex_buscar = Kardex::where("id_producto",$item->id_producto)->where("id_almacen_destino",$item->id_almacen_destino)->orderBy('id', 'desc')->first();
                $nuevoKardex->saldos_cantidad = $kardex_buscar->saldos_cantidad - $item->salidas_cantidad;

                $nuevoKardex->save();
            }
		}
		
		echo $ingreso_produccion->id;
    }

    public function obtener_codigo_ingreso_produccion($tipo_documento){
		
		$ingreso_produccion_model = new IngresoProduccion;
		$codigo_ingreso_produccion = $ingreso_produccion_model->getCodigoIngresoProduccion($tipo_documento);
		
		return response()->json($codigo_ingreso_produccion);
	}

    public function cargar_detalle($id)
    {

        $ingreso_produccion_model = new IngresoProduccion;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $ingreso_produccion = $ingreso_produccion_model->getDetalleIngresoProduccionById($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'ingreso_produccion' => $ingreso_produccion,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida
        ]);
    }

	public function movimiento_pdf_ingreso_produccion($id){

        $ingreso_produccion_model = new IngresoProduccion;
        $ingreso_produccion_detalle_model = new IngresoProduccionDetalle;

        $datos=$ingreso_produccion_model->getIngresoProduccionById($id);
        $datos_detalle=$ingreso_produccion_detalle_model->getDetalleIngresoProduccionPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
        $usuario_ingreso=$datos[0]->usuario_ingreso;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.ingreso_produccion.movimiento_pdf_ingreso_produccion',compact('tipo_documento','almacen','fecha','codigo','datos_detalle','usuario_ingreso'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

}
