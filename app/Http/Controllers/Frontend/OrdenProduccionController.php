<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;

class OrdenProduccionController extends Controller
{
    public function create_orden_produccion(){

		$tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;

        $productos = $producto_model->getProductoExterno();
        
		return view('frontend.orden_produccion.create_orden_produccion',compact('productos'));

	}

    public function listar_orden_compra_control_produccion_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
        $p[]=$request->empresa_compra;
        $p[]=$request->persona_compra;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->estado;
        $p[]=$request->vendedor;
        $p[]=$request->estado_pedido;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_control_produccion_ajax($p);
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

    public function modal_orden_compra_control_produccion($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
        $user_model = new User;
        $persona_model = new Persona;
        $empresa_model = new Empresa;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
			
		}else{
			$orden_compra = new OrdenCompra;
		}

        $proveedor = $empresa_model->getEmpresaAll();
        $producto = $producto_model->getProductoAll();
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);

        $vendedor = $user_model->getUserByRol(7,11);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        $persona = $persona_model->obtenerPersonaAll();

		return view('frontend.orden_compra.modal_orden_compra_nuevoOrdenCompraControlProduccion',compact('id','orden_compra','proveedor','producto','igv_compra','almacen','unidad_origen','id_user','vendedor','tipo_documento_cliente','persona'));

    }

    public function send_comprometer_stock($id_orden_compra_detalle)
    {
		$orden_compra_detalle = OrdenCompraDetalle::find($id_orden_compra_detalle);
		$orden_compra_detalle->comprometido = 1;
		$orden_compra_detalle->save();

        $orden_compra = OrdenCompra::find($orden_compra_detalle->id_orden_compra);
        $id_orden_compra = $orden_compra->id;
        $orden_compra_detalle_total = OrdenCompraDetalle::where('id_orden_compra',$id_orden_compra)->where('estado','1')->get();
        
        $total = count($orden_compra_detalle_total);
        $comprometidos = 0;

        $orden_compra->comprometido = "1";
        $orden_compra->save();

        foreach($orden_compra_detalle_total as $detalle){
            if($detalle->comprometido == 1){
                $comprometidos++;
            }
        }

        if ($comprometidos == 0) {
            $orden_compra->comprometido = 0;
        } elseif ($comprometidos < $total) {
            $orden_compra->comprometido = 1;
        } else {
            $orden_compra->comprometido = 2;
        }

        $orden_compra->save();

		echo $orden_compra_detalle->id;

    }
    
}
