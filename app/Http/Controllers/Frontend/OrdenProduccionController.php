<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Persona;
use App\Models\OrdenCompra;
use App\Models\OrdenProduccion;
use App\Models\OrdenProduccionDetalle;
use App\Models\TipoEncargado;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;

class OrdenProduccionController extends Controller
{
    public function create_orden_produccion(){

		$tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $persona_model = new Persona;

        $productos = $producto_model->getProductoExterno();
        $encargado = $persona_model->obtenerPersonaAll();
        
		return view('frontend.orden_produccion.create_orden_produccion',compact('productos','encargado'));

	}

    public function listar_orden_produccion_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_produccion_model = new OrdenProduccion;
        $p[]=$request->codigo;
        $p[]=$request->fecha;
        $p[]=$request->encargado;
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
		
		if($id>0){

            $orden_produccion = OrdenProduccion::find($id);
			
		}else{
			$orden_produccion = new OrdenProduccion;
		}

        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $encargado = $encargado_model->obtenerEncargadoByTipo(2);

		return view('frontend.orden_produccion.modal_orden_produccion_nuevoOrdenProduccion',compact('id','orden_produccion','producto','unidad','encargado'));

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

        $orden_produccion->id_encargado = $request->encargado;
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
}
