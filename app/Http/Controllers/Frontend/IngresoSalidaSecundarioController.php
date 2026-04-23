<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Marca;
use App\Models\IngresoSalidaSecundario;
use App\Models\IngresoSalidaSecundarioDetalle;
use Auth;
use Carbon\Carbon;

class IngresoSalidaSecundarioController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
		$this->middleware('can:Ingreso Salida Secundario')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $proveedor = Empresa::all();
		
		return view('frontend.ingreso_salida_secundarios.create',compact('tipo_documento','proveedor'));

	}

    public function listar_ingreso_salida_secundarios_ajax(Request $request){

		$ingreso_salida_secundario_model = new IngresoSalidaSecundario;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_ingreso_salida;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_salida_secundario_model->listar_ingreso_salida_secundarios_ajax($p);
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

    public function modal_ingreso_salida_secundario($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
        $empresa_model = new Empresa;
        $persona_model = new Persona;
		
        if($id>0){
            $ingreso_salida_secundario = IngresoSalidaSecundario::find($id);
        }else{
            $ingreso_salida_secundario = new IngresoSalidaSecundario;
        }
        
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $empresas = $empresa_model->getEmpresaAll();
        $personas = $persona_model->obtenerPersonaAll();
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $almacen = $almacen_model->getAlmacenB();
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        
		return view('frontend.ingreso_salida_secundarios.modal_ingreso_salida_secundario_nuevoIngresoSalidaSecundario',compact('id','ingreso_salida_secundario','tipo_documento','empresas','personas','producto','marca','unidad','igv_compra','almacen','moneda','unidad_medida','tipo_documento_cliente'));

    }

    public function send_ingreso_salida_secundario(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $orden_compra = new OrdenCompra;
            $orden_compra_model = new OrdenCompra;

            if($request->tipo_documento != 4){
                $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($request->tipo_documento);
            }else if($request->tipo_documento == 4){
                $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra(2);
            }
		    
        }else{
            $orden_compra = OrdenCompra::find($request->id);
            $codigo_orden_compra = $request->numero_orden_compra;
        }

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $precio_unitario = $request->input('precio_unitario');
        $id_descuento = $request->input('id_descuento');
        $sub_total = $request->input('sub_total');
        $igv = $request->input('igv');
        $total = $request->input('total');
        $precio_unitario_ = $request->input('precio_unitario_');
        $valor_venta_bruto = $request->input('valor_venta_bruto');
        $valor_venta = $request->input('valor_venta');
        $descuento = $request->input('descuento');
        $porcentaje = $request->input('porcentaje');
        $id_autorizacion_detalle = $request->input('id_autorizacion_detalle');
        $id_orden_compra_detalle =$request->id_orden_compra_detalle;

        $orden_compra->id_empresa_compra = $request->empresa_compra;
        $orden_compra->id_empresa_vende = $request->empresa_vende;
        $orden_compra->id_tipo_cliente = $request->tipo_documento_cliente;
        $orden_compra->id_persona = $request->persona_compra;
        $orden_compra->fecha_orden_compra = $request->fecha_orden_compra;
        $orden_compra->fecha_vencimiento = $request->fecha_vencimiento;
        if($request->id == 0){
            $orden_compra->numero_orden_compra = $codigo_orden_compra[0]->codigo;
        }else{
            $orden_compra->numero_orden_compra = $codigo_orden_compra;
        }
        $orden_compra->id_tipo_documento = $request->tipo_documento;
        $orden_compra->igv_compra = $request->igv_compra;
        $orden_compra->id_unidad_origen = $request->unidad_origen;
        $orden_compra->id_almacen_destino = $request->almacen;
        $orden_compra->id_almacen_salida = $request->almacen_salida;
        $orden_compra->numero_orden_compra_cliente = $request->numero_orden_compra_cliente;
        $orden_compra->sub_total = round($request->sub_total_general,2);
        $orden_compra->igv = round($request->igv_general,2);
        $orden_compra->total = round($request->total_general,2);
        $orden_compra->id_moneda = $request->moneda;
        $orden_compra->moneda = $request->moneda_descripcion;
        $orden_compra->descuento = $request->descuento_general;
        $orden_compra->cerrado = 1;
        $orden_compra->id_usuario_inserta = $id_user;
        $orden_compra->id_vendedor = $request->id_vendedor;
        $orden_compra->observacion_vendedor = $request->observacion_vendedor;
        $orden_compra->id_prioridad = $request->prioridad;
        $orden_compra->id_autorizacion = $request->id_autorizacion;
        $orden_compra->id_canal = $request->canal;
        $orden_compra->estado = 1;
        if($request->tipo_documento == 4){
            $orden_compra_matriz = OrdenCompra::where('numero_orden_compra',$request->numero_orden_compra_matriz)->where('id_tipo_documento',2)->where('estado',1)->where('estado_pedido',1)->first();
            $orden_compra->id_orden_compra_matriz = $orden_compra_matriz->id;
        }
        $orden_compra->save();

        $array_orden_compra_detalle = array();

        foreach($descripcion as $index => $value) {
            
            if($id_orden_compra_detalle[$index] == 0){
                $orden_compra_detalle = new OrdenCompraDetalle;
            }else{
                $orden_compra_detalle = OrdenCompraDetalle::find($id_orden_compra_detalle[$index]);
            }
            
            $orden_compra_detalle->id_orden_compra = $orden_compra->id;
            $orden_compra_detalle->id_producto = $descripcion[$index];
            $orden_compra_detalle->cantidad_requerida = $cantidad_ingreso[$index];
            $orden_compra_detalle->precio = round($precio_unitario_[$index],2);
            $orden_compra_detalle->valor_venta_bruto = round($valor_venta_bruto[$index],2);
            $orden_compra_detalle->precio_venta = round($precio_unitario[$index],2);
            $orden_compra_detalle->valor_venta = round($valor_venta[$index],2);
            $orden_compra_detalle->id_descuento = $id_descuento[$index];
            if($id_descuento[$index]==1){
                $orden_compra_detalle->descuento = round($descuento[$index],2);
            }else if($id_descuento[$index]==2){
                $orden_compra_detalle->descuento = $porcentaje[$index];
            }
            $orden_compra_detalle->sub_total = round($sub_total[$index],2);
            $orden_compra_detalle->igv = round($igv[$index],2);
            $orden_compra_detalle->total = round($total[$index],2);
            //$orden_compra_detalle->id_estado_producto = $estado_bien[$index];
            $orden_compra_detalle->id_unidad_medida = $unidad[$index];
            $orden_compra_detalle->id_marca = $marca[$index];
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->id_autorizacion = $id_autorizacion_detalle[$index];
            $orden_compra_detalle->id_usuario_inserta = $id_user;

            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;

            $OrdenCompraAll = OrdenCompraDetalle::where("id_orden_compra",$orden_compra->id)->where("estado","1")->get();
            
            foreach($OrdenCompraAll as $key=>$row){
                
                if (!in_array($row->id, $array_orden_compra_detalle)){
                    $orden_compra_detalle = OrdenCompraDetalle::find($row->id);
                    $orden_compra_detalle->estado = 0;
                    $orden_compra_detalle->save();
                }
            }
        }
        
        if($request->tipo_documento == 2 || $request->tipo_documento == 4){
            if($request->canal == 1 || $request->canal == 2 || $request->canal == 3){
                $autorizacion_orden_compra = new AutorizacionOrdenCompra;
                $autorizacion_orden_compra->id_orden_compra = $orden_compra->id;
                $autorizacion_orden_compra->id_proceso_pedido = 1;
                //$autorizacion_orden_compra->id_autorizacion = 1;
                //$autorizacion_orden_compra->id_usuario_autoriza = $id_user;
                $autorizacion_orden_compra->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra->estado = 1;
                $autorizacion_orden_compra->save();
            }else{
                $autorizacion_orden_compra = new AutorizacionOrdenCompra;
                $autorizacion_orden_compra->id_orden_compra = $orden_compra->id;
                $autorizacion_orden_compra->id_proceso_pedido = 4;
                $autorizacion_orden_compra->id_autorizacion = 2;
                //$autorizacion_orden_compra->id_usuario_autoriza = $id_user;
                $autorizacion_orden_compra->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra->estado = 1;
                $autorizacion_orden_compra->save();
            }
        }
        
        return response()->json(['id' => $orden_compra->id]);
        
    }
}
