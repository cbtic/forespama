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

class OrdenProduccionController extends Controller
{
    public function create_orden_produccion(){

		$tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $persona_model = new Persona;
        $unidad_trabajo_model = new UnidadTrabajo;

        $productos = $producto_model->getProductoExterno();
        //$encargado = $persona_model->obtenerPersonaAll();
        $area = $unidad_trabajo_model->getUnidadTrabajo(7);
        
		return view('frontend.orden_produccion.create_orden_produccion',compact('productos','area'));

	}

    public function listar_orden_produccion_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_produccion_model = new OrdenProduccion;
        $p[]=$request->numero_orden_produccion;
        $p[]=$request->fecha_inicio;
        $p[]=$request->area;
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

    public function modal_atender_orden_produccion($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
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
        
        return view('frontend.orden_produccion.modal_orden_produccion_atenderOrdenProduccion',compact('id','orden_produccion','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen'));

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

    public function send_orden_produccion_ingreso_produccion(Request $request)
    {
        $id_user = Auth::user()->id;

        $orden_produccion = OrdenProduccion::find($request->id);
        $id_orden_produccion = $orden_produccion->id;

        $ingreso_produccion = new IngresoProduccion;

        $ingreso_produccion_model = new IngresoProduccion;
        $codigo_ingreso_produccion = $ingreso_produccion_model->getCodigoIngresoProduccion(1);

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('codigo');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad_atendida');
        
        $id_orden_produccion_detalle =$request->id_orden_produccion_detalle;
        
        $ingreso_produccion->id_tipo_documento = 1;
        $ingreso_produccion->codigo = $codigo_ingreso_produccion[0]->codigo;
        $ingreso_produccion->fecha = $request->fecha_produccion;
        $ingreso_produccion->id_almacen_destino = $request->almacen_destino;
        $ingreso_produccion->id_area = $orden_produccion->id_area;
        $ingreso_produccion->id_usuario_inserta = $id_user;
        $ingreso_produccion->estado = 1;
        $ingreso_produccion->id_orden_produccion = $id_orden_produccion;
        $ingreso_produccion->save();
        $id_ingreso_produccion = $ingreso_produccion->id;

        $array_ingreso_produccion_detalle = array();

        foreach($descripcion as $index => $value) {

            $ingreso_produccion_detalle = new IngresoProduccionDetalle;

            $ingreso_produccion_detalle->id_ingreso_produccion = $id_ingreso_produccion;
            $ingreso_produccion_detalle->id_producto = $descripcion[$index];
            $ingreso_produccion_detalle->cantidad = $cantidad[$index];
            $ingreso_produccion_detalle->id_estado_producto = 1;
            if($unidad[$index]!=null && $unidad !=0){
				$ingreso_produccion_detalle->id_unidad_medida = (int)$unidad[$index];
			}
			$ingreso_produccion_detalle->id_marca = 278;
            $ingreso_produccion_detalle->estado = 1;
            $ingreso_produccion_detalle->id_usuario_inserta = $id_user;

            $ingreso_produccion_detalle->save();

            $array_ingreso_produccion_detalle[] = $ingreso_produccion_detalle->id;

            $producto = Producto::find($descripcion[$index]);

            $kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
            $kardex = new Kardex;
            $kardex->id_producto = $descripcion[$index];
            $kardex->entradas_cantidad = $cantidad[$index];
            if($kardex_buscar){
                $cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
                $kardex->saldos_cantidad = $cantidad_saldo;
            }else{
                $kardex->saldos_cantidad = $cantidad[$index];
            }
            $kardex->id_almacen_destino = $request->almacen_destino;
            $kardex->id_ingreso_produccion = $id_ingreso_produccion;

            $kardex->save();

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
        }

        return response()->json(['id' => $orden_produccion->id]);
    }
}
