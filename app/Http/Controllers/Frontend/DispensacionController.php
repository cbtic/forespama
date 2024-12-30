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
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DispensacionController extends Controller
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
		$area_trabajo_model = new AreaTrabajo;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        //$cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $almacen = Almacene::all();
		$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$persona = Persona::all();
		
		return view('frontend.dispensacion.create',compact('tipo_documento','almacen','area_trabajo','persona'));

	}

    public function listar_dispensacion_ajax(Request $request){

		$dispensacion_model = new Dispensacione;
		$p[]=$request->tipo_documento;
		$p[]=$request->fecha;
        $p[]=$request->numero_dispensacion;
        $p[]=$request->almacen;
		$p[]=$request->area_trabajo;
		$p[]=$request->unidad_trabajo;
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
		$area_trabajo_model = new AreaTrabajo;
		$unidad_trabajo_model = new UnidadTrabajo;
		
		if($id>0){
			$dispensacion = Dispensacione::find($id);
		}else{
			$dispensacion = new Dispensacione;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $producto = $producto_model->getProductoInterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
        $almacen = $almacen_model->getAlmacenAll();
		$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$persona = Persona::all();
		//var_dump($id);exit();

		return view('frontend.dispensacion.modal_dispensacion_nuevoDispensacion',compact('id','dispensacion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen','area_trabajo','persona','id_user'));

    }

	public function send_dispensacion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$dispensacion = new Dispensacione;
            //$dispensacion_model = new Dispensacione;
            //$correlativo = $dispensacion_model->getCorrelativo();
            //$dispensacion->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$dispensacion = Dispensacione::find($request->id);
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
		$dispensacion->id_area_trabajo = $request->area_trabajo;
        $dispensacion->id_almacen = $request->almacen;
        $dispensacion->id_unidad_trabajo = $request->unidad_trabajo;
        $dispensacion->fecha = $request->fecha;
        $dispensacion->codigo = $request->numero_dispensacion;
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

			if($id_dispensacion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
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
        $area_trabajo=$datos[0]->area_trabajo;
        $almacen=$datos[0]->almacen;
        $unidad_trabajo = $datos[0]->unidad_trabajo;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
		$usuario_recibe=$datos[0]->usuario_recibe;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.dispensacion.movimiento_pdf_dispensacion',compact('tipo_documento','area_trabajo','almacen','unidad_trabajo','fecha','codigo','usuario_recibe','datos_detalle'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

}
