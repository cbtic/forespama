<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\OrdenCompraDetalle;
use App\Models\Kardex;
use App\Models\Almacen_usuario;
use App\Models\Almacene;
use App\Models\Tienda;
use App\Models\TiendaDetalleOrdenCompra;
use App\Models\EquivalenciaProducto;
use App\Models\EntradaProducto;
use App\Models\SalidaProducto;
use App\Models\Ubigeo;
use App\Models\Persona;
use App\Models\OrdenCompraContactoEntrega;
use App\Models\OrdenCompraPago;
use App\Models\UsuarioDescuento;
use App\Models\GuiaInterna;
use App\Models\InformeB2bVenta;
use App\Models\AutorizacionOrdenCompra;
use App\Models\PersonaProceso;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OrdenCompraController extends Controller
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
        $user_model = new User;

		$tablaMaestra_model = new TablaMaestra;
        $almacen_user_model = new Almacen_usuario;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $almacen = Almacene::all();
        $almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);
        $vendedor = $user_model->getUserByRol(7,11);
		$estado_pedido = $tablaMaestra_model->getMaestroByTipo(77);
		$prioridad = $tablaMaestra_model->getMaestroByTipo(93);
		$canal = $tablaMaestra_model->getMaestroByTipo(98);
		$bien_servicio = $tablaMaestra_model->getMaestroByTipo(73);
		
		return view('frontend.orden_compra.create',compact('tipo_documento','cerrado_orden_compra','proveedor','almacen','almacen_usuario','vendedor','estado_pedido','prioridad','canal','bien_servicio'));

	}

    public function consulta_stock_pedido(){

        $id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
        $almacen_user_model = new Almacen_usuario;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $almacen = Almacene::all();
        $almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);
		
		return view('frontend.orden_compra.consulta_stock_pedido',compact('tipo_documento','cerrado_orden_compra','proveedor','almacen','almacen_usuario','id_user'));

	}

    public function listar_orden_compra_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]="";//$request->empresa_vende;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
        $p[]=$id_user;
        $p[]=$request->vendedor;
        $p[]=$request->estado_pedido;
        $p[]=$request->prioridad;
        $p[]=$request->canal;
        $p[]=$request->tipo_producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_ajax($p);
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

    public function listar_orden_compra_proceso_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]="";//$request->empresa_vende;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
        $p[]=$id_user;
        $p[]=$request->vendedor;
        $p[]=$request->estado_pedido;
        $p[]=$request->prioridad;
        $p[]=$request->canal;
        $p[]=$request->tipo_producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_proceso_ajax($p);
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

    public function modal_orden_compra($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
        $persona_model = new Persona;
        $empresa_model = new Empresa;
        $usuario_descuento_model = new UsuarioDescuento;
        $id_proceso = null;
        $proceso = null;
        $id_persona_proceso = null;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
            if($orden_compra->id_tipo_documento == '2'){
                $descuento_usuario = $usuario_descuento_model->getDescuentoByUser($orden_compra->id_vendedor);
                $id_descuento_usuario = $descuento_usuario[0]->descuento;
                if($orden_compra->id_canal == 1 || $orden_compra->id_canal == 2 || $orden_compra->id_canal == 3 || $orden_compra->id_canal == 4){
                    $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$orden_compra->id)->where('estado',1)->orderBy('id', 'desc')->first();
                    $id_proceso = $autorizacion_orden_compra->id_proceso_pedido;
                    $data_proceso = $tablaMaestra_model->getMaestroC(109, $id_proceso);
                    $proceso = $data_proceso[0]->denominacion;
                    $persona_proceso = PersonaProceso::where('id_persona',$id_user)->where('estado',1)->first();
                    $id_persona_proceso = $persona_proceso->id_proceso;
                }
            }else{
                $id_descuento_usuario = 0;
            }
            $id_autorizacion = $orden_compra->id_autorizacion;
		}else{
			$orden_compra = new OrdenCompra;
            $id_descuento_usuario = 0;
            $id_autorizacion = 0;
		}

        $proveedor = $empresa_model->getEmpresaAll();
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

        $vendedor = $user_model->getUserByRol(7,11);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        $persona = $persona_model->obtenerPersonaAll();
        $prioridad = $tablaMaestra_model->getMaestroByTipo(93);
        $canal = $tablaMaestra_model->getMaestroByTipo(98);
        //dd($orden_compra->id_tipo_cliente);exit();
        
		return view('frontend.orden_compra.modal_orden_compra_nuevoOrdenCompra',compact('id','orden_compra','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen','id_user','moneda','vendedor','tipo_documento_cliente','persona','prioridad','canal','id_descuento_usuario','id_proceso','id_persona_proceso','proceso','id_autorizacion'));

    }

    public function modal_consulta_orden_compra($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
            $proveedor = Empresa::all();
			
		}else{
			$orden_compra = new OrdenCompra;
            $proveedor = Empresa::all();
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        
		return view('frontend.orden_compra.modal_orden_compra_stock_pedido',compact('id','orden_compra','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen','id_user'));

    }

    public function send_orden_compra(Request $request){

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

    public function eliminar_orden_compra($id,$estado)
    {
		$orden_compra = OrdenCompra::find($id);

		$orden_compra->estado = $estado;
		$orden_compra->save();

		echo $orden_compra->id;
    }

    public function cargar_detalle($id)
    {

        $orden_compra_model = new OrdenCompra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $orden_compra = $orden_compra_model->getDetalleOrdenCompraId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        $producto_stock = [];

        foreach($orden_compra as $detalle){

            $id_almacen_bus = $detalle->id_almacen_salida;
            
            if($detalle->id_unidad_origen==1){$id_almacen_bus = $detalle->id_almacen_salida;}
            if($detalle->id_unidad_origen==2){$id_almacen_bus = $detalle->id_almacen_destino;}
            if($detalle->id_unidad_origen==3){$id_almacen_bus = $detalle->id_almacen_salida;}
            if($detalle->id_unidad_origen==4){$id_almacen_bus = $detalle->id_almacen_salida;}
            
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['stock_comprometido'=>0];
            }
        }
        
        return response()->json([
            'orden_compra' => $orden_compra,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function cargar_detalle_control_produccion($id)
    {

        $orden_compra_model = new OrdenCompra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $orden_compra = $orden_compra_model->getDetalleOrdenCompraIdControlProduccion($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        $producto_stock = [];

        foreach($orden_compra as $detalle){

            $id_almacen_bus = $detalle->id_almacen_salida;
            
            if($detalle->id_unidad_origen==1){$id_almacen_bus = $detalle->id_almacen_salida;}
            if($detalle->id_unidad_origen==2){$id_almacen_bus = $detalle->id_almacen_destino;}
            if($detalle->id_unidad_origen==3){$id_almacen_bus = $detalle->id_almacen_salida;}
            if($detalle->id_unidad_origen==4){$id_almacen_bus = $detalle->id_almacen_salida;}
            
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['stock_comprometido'=>0];
            }
        }
        
        return response()->json([
            'orden_compra' => $orden_compra,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function cargar_detalle_abierto($id, $tipo_movimiento)
    {

        $orden_compra_model = new OrdenCompra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        if($tipo_movimiento=='1'){
            $orden_compra = $orden_compra_model->getDetalleOrdenCompraIdAbiertoEntrada($id);
        }else{
            $orden_compra = $orden_compra_model->getDetalleOrdenCompraIdAbierto($id);
        }
        
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        $producto_stock = [];

        foreach($orden_compra as $detalle){

            $id_almacen_bus = $detalle->id_almacen_salida;
            
            if($detalle->id_unidad_origen==2){$id_almacen_bus = $detalle->id_almacen_destino;}
            if($detalle->id_unidad_origen==4){$id_almacen_bus = $detalle->id_almacen_salida;}
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['stock_comprometido'=>0];
            }
        }
        
        return response()->json([
            'orden_compra' => $orden_compra,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function movimiento_pdf($id){

        $orden_compra_model = new OrdenCompra;
        $orden_compra_detalle_model = new OrdenCompraDetalle;
        $tienda_detalle_orden_compra_model = new TiendaDetalleOrdenCompra;
        $tienda_orden_compra_model = new Tienda;

        $tiendas_orden_compra_detalle = $tienda_detalle_orden_compra_model->getDetalleTiendaOrdenCompraId($id);
        $tiendas_orden_compra = $tienda_orden_compra_model->getTiendaOrdenCompraId($id);

        $datos=$orden_compra_model->getOrdenCompraByIdPdf($id);
        $datos_detalle=$orden_compra_detalle_model->getDetalleOrdenCompraPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $empresa_compra=$datos[0]->cliente;
        $empresa_vende=$datos[0]->empresa_vende;
        $fecha_orden_compra = $datos[0]->fecha_orden_compra;
        $numero_orden_compra = $datos[0]->numero_orden_compra;
        $numero_orden_compra_cliente = $datos[0]->numero_orden_compra_cliente;
        $igv=$datos[0]->igv;
        $direccion=$datos[0]->direccion;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.orden_compra.movimiento_orden_compra_pdf',compact('tipo_documento','empresa_compra','empresa_vende','fecha_orden_compra','numero_orden_compra','igv','datos_detalle','numero_orden_compra_cliente','tiendas_orden_compra_detalle','tiendas_orden_compra','direccion'));

		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'landscape');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

    public function obtener_codigo_orden_compra($tipo_documento){
		
		$orden_compra_model = new OrdenCompra;
		$codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($tipo_documento);
		
		return response()->json($codigo_orden_compra);
	}

    public function modal_orden_compra_tienda($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
            $proveedor = Empresa::all();
			
		}else{
			$orden_compra = new OrdenCompra;
            $proveedor = Empresa::all();
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        
		return view('frontend.orden_compra.modal_orden_compra_tienda',compact('id','orden_compra','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen'));

    }

    public function modal_tiendas_orden_compra($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $tienda_model = new Tienda;
		
        $orden_compra = OrdenCompra::find($id);

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $tiendas = $tienda_model->getTiendasAll();

		return view('frontend.orden_compra.modal_tiendas_orden_compra',compact('id','orden_compra','tipo_documento','producto','marca','estado_bien','unidad','igv_compra','descuento','unidad_origen','tiendas'));

    }

    public function send_tiendas_orden_compra(Request $request)
    {
        $id_user = Auth::user()->id;
    
        $tiendas = $request->input('tiendas', []);
        $productos = $request->input('id_orden_compra_detalle', []);
        $cantidades = $request->input('cantidad_ingreso', []);
        $descripcion = $request->input('descripcion', []);
    
        if (empty($tiendas) || empty($productos) || empty($cantidades) || empty($descripcion)) {
            return response()->json(['success' => false, 'message' => 'Datos incompletos.']);
        }
    
        foreach ($tiendas as $index => $tienda_id) {

            $index_offset = $index + 1;
    
            if (isset($productos[$index_offset]) && is_array($productos[$index_offset])) {
                foreach ($productos[$index_offset] as $producto_index => $producto_id) {
                    
                    $tienda_detalle_orden_compra = new TiendaDetalleOrdenCompra();
                    $tienda_detalle_orden_compra->id_tienda = $tienda_id;
                    $tienda_detalle_orden_compra->id_orden_compra = $request->id;
                    $tienda_detalle_orden_compra->id_producto = $descripcion[$index_offset][$producto_index] ?? null;
                    $tienda_detalle_orden_compra->cantidad = $cantidades[$index_offset][$producto_index] ?? 0;
                    $tienda_detalle_orden_compra->estado = 1;
                    $tienda_detalle_orden_compra->id_usuario_inserta = $id_user;
    
                    $tienda_detalle_orden_compra->save();

                }
                $orden_compra = OrdenCompra::find($request->id);
                $orden_compra->tienda_asignada=1;
                $orden_compra->save();
            } else {
                Log::warning('No hay productos para la tienda con índice ' . $index_offset);
            }
        }
        return response()->json(['success' => true]);
    }

    public function cargar_detalle_tienda($id)
    {

        $orden_compra_model = new OrdenCompra;
        $tienda_detalle_orden_compra_model = new TiendaDetalleOrdenCompra;
        $tienda_orden_compra_model = new Tienda;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $orden_compra = $orden_compra_model->getDetalleOrdenCompraId($id);
        $tienda_detalle_orden_compra = $tienda_detalle_orden_compra_model->getDetalleTiendaOrdenCompraId($id);
        $tienda_orden_compra = $tienda_orden_compra_model->getTiendaOrdenCompraId($id);
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $tiendas = Tienda::all();

        return response()->json([
            'orden_compra' => $orden_compra,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'tienda_orden_compra' => $tienda_orden_compra,
            'tienda_detalle_orden_compra' => $tienda_detalle_orden_compra,
            'tiendas' => $tiendas
        ]);
    }

    public function importar_archivo($archivo)
    {

        $id_user = Auth::user()->id;
        $id_unidad_origen = 4;
        $id_tipo_documento = 2;
        $estado = 1;
        $igv_compra = 2;
        $cerrado = 1;
        $id_almacen_destino = NULL;
        $id_almacen_salida = 3;
        $tienda_asignada = 0;
        $id_empresa_compra = 23;
        $id_marca = 278;
        $id_estado_producto = 1;
        $id_moneda = 1;
        $moneda = "SOLES";
        $sub_total_general = 0;
        $igv_general = 0;
        $total_general = 0;
        $id_vendedor = 35;
        $id_tipo_cliente = 5;
        $id_canal = 4;

        $filePath = public_path('orden_compra/'.$archivo);

        // Verifica si el archivo existe
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado.'], 404);
        }

        // Abre el archivo
        $file = fopen($filePath, 'r');

        // Lee la cabecera
        $header = fgetcsv($file, 0, '|');

        if ($header === false) {
            return response()->json(['error' => 'El archivo está vacío o tiene un formato incorrecto.'], 400);
        }

        $count = 0;

        while (($line = fgets($file)) !== false) {

            $line = trim($line);
            
            $data = str_getcsv($line, '|');
            
            $data = array_pad($data, count($header), null);

            if (count($data) !== count($header)) {
                continue; // Ignorar filas mal formateadas
            }

            $row = array_combine($header, $data);

            $empresa = Empresa::where("ruc",str_replace("-","",$row['RUT_PROVEEDOR']))->first();

            $id_empresa_vende = $empresa->id;
            $fecha_orden_compra = Carbon::createFromFormat('d/m/Y', $row['FECHA_AUTORIZACION']);
            $numero_orden_compra_cliente = $row['NRO_OC'];
            $fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $row['FECHA_DESDE']);

            if($count == 0){

                $OrdenCompraExiste = OrdenCompra::where("numero_orden_compra_cliente",$numero_orden_compra_cliente)->where("estado","1")->get();
            
                if(count($OrdenCompraExiste)>0){
                    $array["cantidad"] = count($OrdenCompraExiste);
                    echo json_encode($array);
                    exit();
                }
                
                $orden_compra_model = new OrdenCompra;
		        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($id_tipo_documento);
                $numero_orden_compra = $codigo_orden_compra[0]->codigo;

                $ordenCompra = new OrdenCompra;
                $ordenCompra->id_unidad_origen = $id_unidad_origen;
                $ordenCompra->id_empresa_vende = $id_empresa_vende;
                $ordenCompra->id_empresa_compra = $id_empresa_compra;
                $ordenCompra->fecha_orden_compra = $fecha_orden_compra;
                $ordenCompra->numero_orden_compra = $numero_orden_compra;
                $ordenCompra->numero_orden_compra_cliente = $numero_orden_compra_cliente;
                $ordenCompra->id_tipo_documento = $id_tipo_documento;
                $ordenCompra->estado = $estado;
                $ordenCompra->igv_compra = $igv_compra;
                $ordenCompra->cerrado = $cerrado;
                $ordenCompra->id_almacen_destino = $id_almacen_destino;
                $ordenCompra->id_almacen_salida = $id_almacen_salida;
                $ordenCompra->tienda_asignada = $tienda_asignada;
                $ordenCompra->id_moneda = $id_moneda;
                $ordenCompra->moneda = $moneda;
                $ordenCompra->id_usuario_inserta = $id_user;
                $ordenCompra->id_vendedor = $id_vendedor;
                $ordenCompra->id_tipo_cliente = $id_tipo_cliente;
                $ordenCompra->fecha_vencimiento = $fecha_vencimiento;
                $ordenCompra->id_canal = $id_canal;
                $ordenCompra->save();
                $id_orden_compra = $ordenCompra->id;

            }
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($row['SKU']))->first();
            $id_producto = $equivalenciaProducto->id_producto;
            $producto = Producto::find($id_producto);
            $cantidad_requerida = $row['CANTIDAD_PROD'];
            $id_unidad_medida = $producto->id_unidad_producto;

            $valor_unitario = $row['COSTO_UNI'];
            $precio_venta = 1.18*$valor_unitario;

            $total = $precio_venta * $cantidad_requerida;
            $valor_venta_bruto = $total / 1.18;
            $igv = $valor_venta_bruto * 0.18;
            $sub_total = $total - $igv;

            $sub_total_general += $sub_total;
            $igv_general += $igv;
            $total_general += $total;

            $ordenCompraDetalle = new OrdenCompraDetalle;
            $ordenCompraDetalle->id_orden_compra = $id_orden_compra;
            $ordenCompraDetalle->id_producto = $id_producto;
            $ordenCompraDetalle->cantidad_requerida = $cantidad_requerida;
            $ordenCompraDetalle->id_marca = $id_marca;
            $ordenCompraDetalle->cerrado = $cerrado;
            $ordenCompraDetalle->estado = $estado;
            $ordenCompraDetalle->id_unidad_medida = $id_unidad_medida;
            $ordenCompraDetalle->id_estado_producto = $id_estado_producto;
            $ordenCompraDetalle->precio_venta = round($precio_venta, 2);
            $ordenCompraDetalle->precio = round($valor_unitario, 2);
            $ordenCompraDetalle->valor_venta_bruto = round($sub_total, 2);
            $ordenCompraDetalle->valor_venta = round($sub_total, 2);
            $ordenCompraDetalle->sub_total = round($sub_total, 2);
            $ordenCompraDetalle->igv = round($igv, 2);
            $ordenCompraDetalle->total = round($total, 2);
            $ordenCompraDetalle->id_usuario_inserta = $id_user;
            $ordenCompraDetalle->save();

            $count++;
        }

        $ordenCompraTotales = OrdenCompra::find($id_orden_compra);
        $ordenCompraTotales->sub_total = round($sub_total_general, 2);
        $ordenCompraTotales->igv = round($igv_general, 2);
        $ordenCompraTotales->total = round($total_general, 2);
        $ordenCompraTotales->save();

        $autorizacion_orden_compra = new AutorizacionOrdenCompra;
        $autorizacion_orden_compra->id_orden_compra = $id_orden_compra;
        $autorizacion_orden_compra->id_proceso_pedido = 4;
        $autorizacion_orden_compra->id_autorizacion = 2;
        $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
        $autorizacion_orden_compra->id_usuario_inserta = $id_user;
        $autorizacion_orden_compra->estado = 1;
        $autorizacion_orden_compra->save();
        
        fclose($file);

        $array["cantidad"] = count($OrdenCompraExiste);
        echo json_encode($array);

    }

    public function importar_archivo_promart($archivo)
    {

        $id_user = Auth::user()->id;
        $id_unidad_origen = 4;
        $id_tipo_documento = 2;
        $estado = 1;
        $igv_compra = 2;
        $cerrado = 1;
        $id_almacen_destino = NULL;
        $id_almacen_salida = 3;
        $tienda_asignada = 1;
        $id_empresa_compra = 459;
        $id_empresa_vende = 30;
        $id_marca = 278;
        $id_estado_producto = 1;
        $id_moneda = 1;
        $moneda = "SOLES";
        $sub_total_general = 0;
        $igv_general = 0;
        $total_general = 0;
        $id_vendedor = 53;
        $id_tipo_cliente = 5;
        $id_canal = 4;

        $spreadsheet = IOFactory::load(public_path("orden_compra_promart/".$archivo));
		$sheet = $spreadsheet->getActiveSheet();

        $numero_orden_compra_cliente = $sheet->getCell("B7")->getCalculatedValue();
		$fecha_ingreso_excel = $sheet->getCell("B8")->getValue();
        $fecha_venc_excel = $sheet->getCell("B9")->getValue();

        $fecha_ingreso = Carbon::instance(Date::excelToDateTimeObject($fecha_ingreso_excel));
        $fecha_vencimiento = Carbon::instance(Date::excelToDateTimeObject($fecha_venc_excel));
		$tienda_completo = $sheet->getCell("B10")->getCalculatedValue();
        $numero_tienda = explode('-', $tienda_completo)[0];

        $tienda = Tienda::where("numero_tienda", $numero_tienda)->where("estado",1)->first();
        $id_tienda = $tienda->id;

        $rowIndex = 18;
		$precio_total_final = 0;
        //dd($numero_orden_compra_cliente+"-"+$fecha_ingreso);exit();

        $OrdenCompraExiste = OrdenCompra::where("numero_orden_compra_cliente",$numero_orden_compra_cliente)->where("id_empresa_compra",459)->where("estado","1")->get();
        
        if(count($OrdenCompraExiste)>0){
            $array["cantidad"] = count($OrdenCompraExiste);
            echo json_encode($array);
            exit();
        }

        $orden_compra_model = new OrdenCompra;
        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($id_tipo_documento);
        $numero_orden_compra = $codigo_orden_compra[0]->codigo;

        $ordenCompra = new OrdenCompra;
        $ordenCompra->id_unidad_origen = $id_unidad_origen;
        $ordenCompra->id_empresa_vende = $id_empresa_vende;
        $ordenCompra->id_empresa_compra = $id_empresa_compra;
        $ordenCompra->fecha_orden_compra = $fecha_ingreso;
        $ordenCompra->numero_orden_compra = $numero_orden_compra;
        $ordenCompra->numero_orden_compra_cliente = $numero_orden_compra_cliente;
        $ordenCompra->id_tipo_documento = $id_tipo_documento;
        $ordenCompra->estado = $estado;
        $ordenCompra->igv_compra = $igv_compra;
        $ordenCompra->cerrado = $cerrado;
        $ordenCompra->id_almacen_destino = $id_almacen_destino;
        $ordenCompra->id_almacen_salida = $id_almacen_salida;
        $ordenCompra->tienda_asignada = $tienda_asignada;
        $ordenCompra->id_moneda = $id_moneda;
        $ordenCompra->moneda = $moneda;
        $ordenCompra->id_usuario_inserta = $id_user;
        $ordenCompra->id_vendedor = $id_vendedor;
        $ordenCompra->id_tipo_cliente = $id_tipo_cliente;
        $ordenCompra->fecha_vencimiento = $fecha_vencimiento;
        $ordenCompra->id_canal = $id_canal;
        $ordenCompra->save();
        $id_orden_compra = $ordenCompra->id;
        
        $items = [];

        while(true){

            $sku = trim($sheet->getCell("A".$rowIndex)->getCalculatedValue());

            if ($sku === null || $sku === "") {
                break;
            }

            $cantidad_requerida = $sheet->getCell("G".$rowIndex)->getCalculatedValue();
            $valor_unitario = $sheet->getCell("I".$rowIndex)->getCalculatedValue();
            
            if (!isset($items[$sku])) {
                $items[$sku] = [
                    "cantidad" => 0,
                    "precio" => $valor_unitario
                ];
            }

            $items[$sku]["cantidad"] += $cantidad_requerida;

            $rowIndex++;
        }

        foreach ($items as $sku => $data) {

            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa", $sku)->first();
            if (!$equivalenciaProducto) continue;

            $id_producto = $equivalenciaProducto->id_producto;
            $producto = Producto::find($id_producto);

            $id_unidad_medida = $producto->id_unidad_producto;

            $cantidad_requerida = $data["cantidad"];
            $valor_unitario = $data["precio"];

            $precio_venta = 1.18 * $valor_unitario;
            $total = $precio_venta * $cantidad_requerida;
            $valor_venta_bruto = $total / 1.18;
            $igv = $valor_venta_bruto * 0.18;
            $sub_total = $total - $igv;

            $sub_total_general += $sub_total;
            $igv_general += $igv;
            $total_general += $total;

            $detalle = new OrdenCompraDetalle;
            $detalle->id_orden_compra = $id_orden_compra;
            $detalle->id_producto = $id_producto;
            $detalle->cantidad_requerida = $cantidad_requerida;
            $detalle->id_marca = $id_marca;
            $detalle->cerrado = $cerrado;
            $detalle->estado = $estado;
            $detalle->id_unidad_medida = $id_unidad_medida;
            $detalle->id_estado_producto = $id_estado_producto;
            $detalle->precio_venta = round($precio_venta, 2);
            $detalle->precio = round($valor_unitario, 2);
            $detalle->sub_total = round($sub_total, 2);
            $detalle->igv = round($igv, 2);
            $detalle->total = round($total, 2);
            $detalle->id_usuario_inserta = $id_user;
            $detalle->save();

        }

        $rowIndex = 18;

        while(true){

            $sku = $sheet->getCell("A".$rowIndex)->getCalculatedValue();

            if ($sku === null || $sku === "") {
                break;
            }
            
			$cantidad_requerida = $sheet->getCell("G".$rowIndex)->getCalculatedValue();
			$valor_unitario  = $sheet->getCell("I".$rowIndex)->getCalculatedValue();
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($sku))->first();
            $id_producto = $equivalenciaProducto->id_producto;

            $tienda_detalle_completo = $sheet->getCell("F".$rowIndex)->getCalculatedValue();
            $numero_tienda_detalle = explode('-', $tienda_detalle_completo)[0];

            $tienda_detalle = Tienda::where("numero_tienda", $numero_tienda_detalle)->where("estado",1)->first();
            $id_tienda = $tienda_detalle->id;
            
            $tienda_detalle_orden_compra = new TiendaDetalleOrdenCompra;
            $tienda_detalle_orden_compra->id_tienda = $id_tienda;
            $tienda_detalle_orden_compra->id_orden_compra = $id_orden_compra;
            $tienda_detalle_orden_compra->id_producto = $id_producto;
            $tienda_detalle_orden_compra->cantidad = $cantidad_requerida;
            $tienda_detalle_orden_compra->estado = $estado;
            $tienda_detalle_orden_compra->id_usuario_inserta = $id_user;
            $tienda_detalle_orden_compra->save();

            $rowIndex++;

        }

        /*while(true){

            $sku = $sheet->getCell("A".$rowIndex)->getCalculatedValue();

            if ($sku === null || $sku === "") {
                break;
            }
            
			$cantidad_requerida = $sheet->getCell("G".$rowIndex)->getCalculatedValue();
			$valor_unitario  = $sheet->getCell("I".$rowIndex)->getCalculatedValue();
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($sku))->first();
            $id_producto = $equivalenciaProducto->id_producto;
            $producto = Producto::find($id_producto);
            //$cantidad_requerida = $row['CANTIDAD_PROD'];
            $id_unidad_medida = $producto->id_unidad_producto;

            //$valor_unitario = $row['COSTO_UNI'];
            $precio_venta = 1.18*$valor_unitario;

            $total = $precio_venta * $cantidad_requerida;
            $valor_venta_bruto = $total / 1.18;
            $igv = $valor_venta_bruto * 0.18;
            $sub_total = $total - $igv;

            $sub_total_general += $sub_total;
            $igv_general += $igv;
            $total_general += $total;

            $ordenCompraDetalle = new OrdenCompraDetalle;
            $ordenCompraDetalle->id_orden_compra = $id_orden_compra;
            $ordenCompraDetalle->id_producto = $id_producto;
            $ordenCompraDetalle->cantidad_requerida = $cantidad_requerida;
            $ordenCompraDetalle->id_marca = $id_marca;
            $ordenCompraDetalle->cerrado = $cerrado;
            $ordenCompraDetalle->estado = $estado;
            $ordenCompraDetalle->id_unidad_medida = $id_unidad_medida;
            $ordenCompraDetalle->id_estado_producto = $id_estado_producto;
            $ordenCompraDetalle->precio_venta = round($precio_venta, 2);
            $ordenCompraDetalle->precio = round($valor_unitario, 2);
            $ordenCompraDetalle->valor_venta_bruto = round($sub_total, 2);
            $ordenCompraDetalle->valor_venta = round($sub_total, 2);
            $ordenCompraDetalle->sub_total = round($sub_total, 2);
            $ordenCompraDetalle->igv = round($igv, 2);
            $ordenCompraDetalle->total = round($total, 2);
            $ordenCompraDetalle->id_usuario_inserta = $id_user;
            $ordenCompraDetalle->save();

            $tienda_detalle_completo = $sheet->getCell("F".$rowIndex)->getCalculatedValue();
            $numero_tienda_detalle = explode('-', $tienda_detalle_completo)[0];

            $tienda_detalle = Tienda::where("numero_tienda", $numero_tienda_detalle)->where("estado",1)->first();
            $id_tienda = $tienda_detalle->id;
            
            $tienda_detalle_orden_compra = new TiendaDetalleOrdenCompra;
            $tienda_detalle_orden_compra->id_tienda = $id_tienda;
            $tienda_detalle_orden_compra->id_orden_compra = $id_orden_compra;
            $tienda_detalle_orden_compra->id_producto = $id_producto;
            $tienda_detalle_orden_compra->cantidad = $cantidad_requerida;
            $tienda_detalle_orden_compra->estado = $estado;
            $tienda_detalle_orden_compra->id_usuario_inserta = $id_user;
            $tienda_detalle_orden_compra->save();

            $rowIndex++;

        }*/

        $ordenCompraTotales = OrdenCompra::find($id_orden_compra);
        $ordenCompraTotales->sub_total = round($sub_total_general, 2);
        $ordenCompraTotales->igv = round($igv_general, 2);
        $ordenCompraTotales->total = round($total_general, 2);
        $ordenCompraTotales->save();

        $autorizacion_orden_compra = new AutorizacionOrdenCompra;
        $autorizacion_orden_compra->id_orden_compra = $id_orden_compra;
        $autorizacion_orden_compra->id_proceso_pedido = 4;
        $autorizacion_orden_compra->id_autorizacion = 2;
        $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
        $autorizacion_orden_compra->id_usuario_inserta = $id_user;
        $autorizacion_orden_compra->estado = 1;
        $autorizacion_orden_compra->save();
        
        $array["cantidad"] = count($OrdenCompraExiste);
        echo json_encode($array);

    }
    
    function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}

    public function upload_orden_compra(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
        $path = "orden_compra";
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $filepath = public_path('orden_compra/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_archivo($archivo);
		
	}

    public function upload_orden_compra_promart(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
        $path = "orden_compra_promart";
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $filepath = public_path('orden_compra_promart/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_archivo_promart($archivo);
		
	}

    public function obtener_orden_compra_id($id){
        $oc_model = new OrdenCompra;

        $sw = true;
        $oc = $oc_model->getOrdenCompraById($id);
        $array["sw"] = $sw;
        $array["oc"] = $oc;

        echo json_encode($array);
    }

    public function obtener_orden_compra_persona_id($id){
        $oc_model = new OrdenCompra;

        $sw = true;
        $oc = $oc_model->getOrdenCompraPersonaById($id);
        $array["sw"] = $sw;
        $array["oc"] = $oc;

        echo json_encode($array);
    }

    public function obtener_entrada_salida($id_orden_compra, $tipo_documento){
		
        if($tipo_documento == 1){

            $entrada_producto_model = new EntradaProducto;
            $codigo = $entrada_producto_model->getCodigoEntradaProductobyOC($id_orden_compra);

        }else if($tipo_documento == 2){

            $salida_producto_model = new SalidaProducto;
            $codigo = $salida_producto_model->getCodigoSalidaProductobyOC($id_orden_compra);

        }
		
		return response()->json($codigo);
	}

    public function obtener_descuento($id_vendedor){
		
        $usuario_descuento_model = new UsuarioDescuento;
        $descuento = $usuario_descuento_model->getDescuentoByUser($id_vendedor);
		
		return response()->json($descuento);
	}
    
    public function obtener_salida_prod_id($id){
        $oc_model = new OrdenCompra;

        $sw = true;
        $oc = $oc_model->getSalidaProdById($id);
        $array["sw"] = $sw;
        $array["oc"] = $oc;

        echo json_encode($array);
    }

    public function listar_salida_prod_det($id, $emp){       
        $orden_compra_model = new OrdenCompra;
        $sw = true;
        $orden_compra = $orden_compra_model->getSalidaProdDetalle($id, $emp);
        
        return view('frontend.ingresos.lista_orden_compra_det',compact('orden_compra'));

    }

    public function exportar_listar_orden_compra($tipo_documento, $empresa_compra, $empresa_vende, $fecha_inicio, $fecha_fin, $numero_orden_compra, $numero_orden_compra_cliente, $almacen_origen, $almacen_destino, $situacion, $estado, $vendedor, $estado_pedido, $prioridad, $canal, $tipo_producto) {

        $id_user = Auth::user()->id;
        
		if($tipo_documento==0)$tipo_documento = "";
        if($empresa_compra==0)$empresa_compra = "";
        if($empresa_vende==0)$empresa_vende = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra=="0")$numero_orden_compra = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($almacen_origen==0)$almacen_origen = "";
        if($almacen_destino==0)$almacen_destino = "";
        if($situacion==0)$situacion = "";
        if($estado==0)$estado = "";
        if($vendedor==0)$vendedor = "";
        if($estado_pedido==0)$estado_pedido = "";
        if($prioridad==0)$prioridad = "";
        if($canal==0)$canal = "";
        if($tipo_producto==0)$tipo_producto = "";

        $orden_compra_model = new OrdenCompra;
		$p[]=$tipo_documento;
        $p[]=$empresa_compra;
        $p[]="";//$empresa_vende;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$situacion;
        $p[]=$almacen_origen;
        $p[]=$almacen_destino;
        $p[]=$estado;
		$p[]=$id_user;
        $p[]=$vendedor;
        $p[]=$estado_pedido;
        $p[]=$prioridad;
        $p[]=$canal;
        $p[]=$tipo_producto;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_orden_compra_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Id","Tipo Documento","Empresa Compra","N° OC Cliente"/*,"Empresa Vende"*/,"Fecha","Numero OC","Almacen Origen","Almacen Destino","Situacion","Vendedor","Total","Estado","Estado Pedido","Prioridad"));
		
		foreach ($data as $r) {

            if($r->estado==1){$estado='ACTIVO';}
            if($r->estado==0){$estado='INACTIVO';}

            if($r->estado_pedido==1){$estado_pedido='ACTIVO';}
            if($r->estado_pedido==2){$estado_pedido='ANULADO';}
            if($r->estado_pedido==3){$estado_pedido='CANCELADO';}

			array_push($variable, array($n++,$r->id, $r->tipo_documento, $r->cliente, $r->numero_orden_compra_cliente/*, $r->empresa_vende*/, $r->fecha_orden_compra, $r->numero_orden_compra, $r->almacen_origen, $r->almacen_destino, $r->cerrado, $r->vendedor, (float)$r->total, $estado, $estado_pedido, $r->prioridad));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'Reporte_orden_compra.xlsx');
		
    }

    public function exportar_listar_orden_compra_detalle($tipo_documento, $empresa_compra, $empresa_vende, $fecha_inicio, $fecha_fin, $numero_orden_compra, $numero_orden_compra_cliente, $almacen_origen, $almacen_destino, $situacion, $estado, $vendedor, $estado_pedido, $prioridad, $canal, $tipo_producto) {

        $id_user = Auth::user()->id;
        
		if($tipo_documento==0)$tipo_documento = "";
        if($empresa_compra==0)$empresa_compra = "";
        if($empresa_vende==0)$empresa_vende = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra=="0")$numero_orden_compra = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($almacen_origen==0)$almacen_origen = "";
        if($almacen_destino==0)$almacen_destino = "";
        if($situacion==0)$situacion = "";
        if($estado==0)$estado = "";
        if($vendedor==0)$vendedor = "";
        if($estado_pedido==0)$estado_pedido = "";
        if($prioridad==0)$prioridad = "";
        if($canal==0)$canal = "";
        if($tipo_producto==0)$tipo_producto = "";

        $orden_compra_model = new OrdenCompra;
		$p[]=$tipo_documento;
        $p[]=$empresa_compra;
        $p[]="";//$empresa_vende;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$situacion;
        $p[]=$almacen_origen;
        $p[]=$almacen_destino;
        $p[]=$estado;
		$p[]=$id_user;
        $p[]=$vendedor;
        $p[]=$estado_pedido;
        $p[]=$prioridad;
        $p[]=$canal;
        $p[]=$tipo_producto;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_orden_compra_detalle_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Vendedor","Empresa","Numero OC","Fecha","Codigo","Producto","Cantidad","Precio Venta","Precio Unitario","Valor Venta Bruto","Valor Venta","Descuento","Sub Total","IGV","Total"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->vendedor, $r->cliente, $r->numero_orden_compra, $r->fecha_orden_compra, $r->codigo, $r->producto, $r->cantidad_requerida, (float)$r->precio_venta, (float)$r->precio, (float)$r->valor_venta_bruto, (float)$r->valor_venta, (float)$r->descuento, (float)$r->sub_total, (float)$r->igv, (float)$r->total));
		}
		
		$export = new InvoicesExport5([$variable]);
		return Excel::download($export, 'Reporte_orden_compra_detallado.xlsx');
		
    }

    public function modal_datos_pedido_orden_compra($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $ubigeo_model = new Ubigeo;

        $existe_orden_compra_contacto_entrega = OrdenCompraContactoEntrega::where('id_orden_compra',$id)->where('estado',1)->first();
		
        if($existe_orden_compra_contacto_entrega){
            $orden_compra_contacto_entrega = OrdenCompraContactoEntrega::find($existe_orden_compra_contacto_entrega->id);
            $orden_compra = OrdenCompra::find($existe_orden_compra_contacto_entrega->id_orden_compra);
		}else{
			$orden_compra_contacto_entrega = new OrdenCompraContactoEntrega;
            $orden_compra = new OrdenCompra;
        }

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $tiendas = Tienda::all();
        $departamento = $ubigeo_model->getDepartamento();

		return view('frontend.orden_compra.modal_datos_pedido_orden_compra',compact('id','orden_compra','orden_compra_contacto_entrega','tipo_documento','producto','marca','estado_bien','unidad','igv_compra','descuento','unidad_origen','tiendas','departamento'));

    }

    public function send_datos_contacto(Request $request){

		$id_user = Auth::user()->id;

		if($request->id_datos_pedido){
            $orden_compra_contacto_entrega = OrdenCompraContactoEntrega::find($request->id_datos_pedido);
		}else{
			$orden_compra_contacto_entrega = new OrdenCompraContactoEntrega;
		}
		
		$orden_compra_contacto_entrega->id_orden_compra = $request->id;
		$orden_compra_contacto_entrega->nombre = $request->nombre_contacto;
		$orden_compra_contacto_entrega->telefono = $request->telefono_contacto;
		$orden_compra_contacto_entrega->direccion = $request->direccion_contacto;
		$orden_compra_contacto_entrega->id_ubigeo = $request->distrito_contacto;
		$orden_compra_contacto_entrega->referencia = $request->referencia_contacto;
		$orden_compra_contacto_entrega->estado = 1;
		$orden_compra_contacto_entrega->id_usuario_inserta = $id_user;
		$orden_compra_contacto_entrega->save();

    }

    public function obtener_provincia_distrito($id){
		
		$orden_compra_contacto_entrega_model = new OrdenCompraContactoEntrega;
		$ubigeo_contacto_entrega = $orden_compra_contacto_entrega_model->getProvinciaDistritoById($id);
		
		echo json_encode($ubigeo_contacto_entrega);
	}

    public function generar_lpn($id_orden_compra){

        $orden_compra_model = new OrdenCompra;
        $orden_compra_detalle_model = new OrdenCompraDetalle;
        $tienda_detalle_orden_compra_model = new TiendaDetalleOrdenCompra;
        $tienda_orden_compra_model = new Tienda;

        $tiendas_orden_compra_detalle = $tienda_detalle_orden_compra_model->getDetalleTiendaOrdenCompraId($id);
        $tiendas_orden_compra = $tienda_orden_compra_model->getTiendaOrdenCompraId($id);

        $datos=$orden_compra_model->getOrdenCompraLpn($id_orden_compra);
        $datos_detalle=$orden_compra_detalle_model->getDetalleOrdenCompraPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $empresa_compra=$datos[0]->empresa_compra;
        $empresa_vende=$datos[0]->empresa_vende;
        $fecha_orden_compra = $datos[0]->fecha_orden_compra;
        $numero_orden_compra = $datos[0]->numero_orden_compra;
        $numero_orden_compra_cliente = $datos[0]->numero_orden_compra_cliente;
        $igv=$datos[0]->igv;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.orden_compra.movimiento_orden_compra_pdf',compact('tipo_documento','empresa_compra','empresa_vende','fecha_orden_compra','numero_orden_compra','igv','datos_detalle','numero_orden_compra_cliente','tiendas_orden_compra_detalle','tiendas_orden_compra'));

		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'landscape');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

    }

    public function create_reporte_comercializacion(){

        $id_user = Auth::user()->id;
        $tienda_model = new Tienda;
        $producto_model = new Producto;
        $user_model = new User;

		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $tiendas = $tienda_model->getTiendasAll();
        $productos = $producto_model->getProductoExterno();
        $vendedor = $user_model->getUserByRol(7,11);
        $estado_pedido = $tablaMaestra_model->getMaestroByTipo(77);
		$canal = $tablaMaestra_model->getMaestroByTipo(98);

		return view('frontend.orden_compra.create_reporte_comercializacion',compact('tipo_documento','cerrado_orden_compra','proveedor','tiendas','productos','vendedor','estado_pedido','canal'));

	}

    public function listar_reporte_comercializacion_ajax(Request $request){

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->empresa_compra;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->codigo_producto;
        $p[]=$request->producto;
        $p[]=$request->vendedor;
        $p[]=$request->estado_pedido;
        $p[]=1;
        $p[]=$request->canal;
        $p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_reporte_comercializacion_ajax($p);
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

    public function exportar_reporte_comercializacion($empresa_compra, $fecha_inicio, $fecha_fin, $numero_orden_compra_cliente, $situacion, $codigo_producto, $producto, $vendedor, $estado_pedido, $canal) {

        if($empresa_compra==0)$empresa_compra = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($situacion==0)$situacion = "";
        if($codigo_producto=="0")$codigo_producto = "";
        if($producto==0)$producto = "";
        if($vendedor==0)$vendedor = "";
        if($estado_pedido==0)$estado_pedido = "";
        if($canal==0)$canal = "";
        
        $orden_compra_model = new OrdenCompra;
		$p[]=$empresa_compra;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$situacion;
        $p[]=$codigo_producto;
        $p[]=$producto;
        $p[]=$vendedor;
        $p[]=$estado_pedido;
        $p[]=1;
        $p[]=$canal;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_reporte_comercializacion_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Empresa","Orden Compra","Pedido","Fecha Pedido","Fecha Vencimiento","Fecha Entrega Real","Fecha Facturado","Codigo Interno","Codigo Retail","Descripcion","Precio Unitario","Descuento","Cantidad Pedida","Cantidad Entregada","Cantidad Cancelada","Pendiente Entrega","Vendedor","Estado Pedido"));
		
		foreach ($data as $r) {

            if($r->cerrado==1){$cerrado='SI';}
            if($r->cerrado==2){$cerrado='NO';}

			array_push($variable, array($n++,$r->cliente, $r->numero_orden_compra_cliente, $r->pedido, $r->fecha_orden_compra, $r->fecha_vencimiento, $r->fecha_salida, $r->fecha_facturado, $r->codigo, $r->codigo_empresa, $r->producto, $r->precio, $r->descuento, $r->cantidad_requerida, $r->cantidad_despacho, $r->cantidad_cancelada, $cerrado, $r->vendedor, $r->estado_pedido));
		}
		
		$export = new InvoicesExport2([$variable]);
		return Excel::download($export, 'Reporte_comercializacion.xlsx');
		
    }

    public function create_reporte_comercializacion_tienda(){

        $id_user = Auth::user()->id;
        $tienda_model = new Tienda;
        $producto_model = new Producto;
        $user_model = new User;
        $tienda_model = new Tienda;

		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $tiendas = $tienda_model->getTiendasAll();
        $productos = $producto_model->getProductoExterno();
        $vendedor = $user_model->getUserByRol(7,11);

		return view('frontend.orden_compra.create_reporte_comercializacion_tienda',compact('tipo_documento','cerrado_orden_compra','proveedor','tiendas','productos','vendedor'));

	}

    public function listar_reporte_comercializacion_tienda_ajax(Request $request){

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->empresa_compra;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->producto;
        $p[]=$request->tienda;
        $p[]=1;
        $p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_reporte_comercializacion_tienda_ajax($p);
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

    public function exportar_reporte_comercializacion_tienda($empresa_compra, $fecha_inicio, $fecha_fin, $numero_orden_compra_cliente, $producto, $tienda) {

        if($empresa_compra==0)$empresa_compra = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($producto==0)$producto = "";
        if($tienda==0)$tienda = "";
        
        $orden_compra_model = new OrdenCompra;
		$p[]=$empresa_compra;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$producto;
        $p[]=$tienda;
        $p[]=1;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_reporte_comercializacion_tienda_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Empresa","Orden Compra","Pedido","Fecha Pedido","Fecha Vencimiento","Codigo Interno","Codigo Sodimac","Descripcion","Precio Unitario","Cantidad Pedida","Cantidad Entregada","Cantidad Cancelada","Tienda"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->razon_social, $r->numero_orden_compra_cliente, $r->pedido, $r->fecha_orden_compra, $r->fecha_vencimiento, $r->codigo, $r->codigo_empresa, $r->producto, $r->precio, $r->cantidad, $r->cantidad_despacho, $r->cantidad_cancelada, $r->tienda));
		}
		
		$export = new InvoicesExport3([$variable]);
		return Excel::download($export, 'Reporte_comercializacion_tienda.xlsx');
		
    }  

    public function upload_orden_distribucion(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
        $path = "orden_distribucion";
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $filepath = public_path('orden_distribucion/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_archivo_od($archivo);
		
	}

    public function importar_archivo_od($archivo)
    {

        $id_user = Auth::user()->id;
        $estado = 1;
        $tienda_asignada = 1;

        $filePath = public_path('orden_distribucion/'.$archivo);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado.'], 404);
        }

        $file = fopen($filePath, 'r');

        $header = fgetcsv($file, 0, '|');

        if ($header === false) {
            return response()->json(['error' => 'El archivo está vacío o tiene un formato incorrecto.'], 400);
        }

        $count = 0;

        while (($line = fgets($file)) !== false) {

            $line = trim($line);

            $data = str_getcsv($line, '|');
            
            $data = array_pad($data, count($header), null);

            if (count($data) !== count($header)) {
                continue;
            }

            $row = array_combine($header, $data);

            $tienda = Tienda::where("numero_tienda",$row['NRO_LOCAL'])->first();
            $orden_compra = OrdenCompra::where("numero_orden_compra_cliente",$row['NRO_OD'])->first();

            $id_tienda = $tienda->id;
            $id_orden_compra = $orden_compra->id;
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($row['SKU']))->first();
            $id_producto = $equivalenciaProducto->id_producto;
            $producto = Producto::find($id_producto);
            $cantidad_requerida = $row['UNIDADES'];

            if($count == 0){
                
                $existeTiendaOrdenCompra = TiendaDetalleOrdenCompra::where("id_orden_compra",$orden_compra->id)->where("estado",1)->get();
                
                if(count($existeTiendaOrdenCompra)>0){
                    $array["cantidad"] = count($existeTiendaOrdenCompra);
                    echo json_encode($array);
                    exit();
                }
            }
                
            $tienda_detalle_orden_compra = new TiendaDetalleOrdenCompra;
            $tienda_detalle_orden_compra->id_tienda = $id_tienda;
            $tienda_detalle_orden_compra->id_orden_compra = $id_orden_compra;
            $tienda_detalle_orden_compra->id_producto = $id_producto;
            $tienda_detalle_orden_compra->cantidad = $cantidad_requerida;
            $tienda_detalle_orden_compra->estado = $estado;
            $tienda_detalle_orden_compra->id_usuario_inserta = $id_user;
            $tienda_detalle_orden_compra->save();

            $count++;
            
        }

        $ordenCompra = OrdenCompra::find($id_orden_compra);
        $ordenCompra->tienda_asignada = $tienda_asignada;
        $ordenCompra->save();

        fclose($file);

        $array["cantidad"] = count($existeTiendaOrdenCompra);
        echo json_encode($array);

    }

    public function modal_anular_orden_compra($id){
		
        $tablaMaestra_model = new TablaMaestra;
		
        $orden_compra = OrdenCompra::find($id);

        $estado_pedido = $tablaMaestra_model->getMaestroByTipo(77);
        
		return view('frontend.orden_compra.modal_anular_orden_compra',compact('id','orden_compra','estado_pedido'));

    }

    public function anular_orden_compra(Request $request)
    {
		$orden_compra = OrdenCompra::find($request->id);

		$orden_compra->estado_pedido = $request->estado;
		$orden_compra->motivo = $request->motivo;
		$orden_compra->save();

		echo $orden_compra->id;
        
    }

    public function create_pago_orden_compra(){

		$tablaMaestra_model = new TablaMaestra;
        $empresa_model = new Empresa;
        $persona_model = new Persona;

		$estado_pago = $tablaMaestra_model->getMaestroByTipo(66);
        $empresa = $empresa_model->getEmpresaAll();
        $persona = $persona_model->obtenerPersonaAll();

		return view('frontend.orden_compra.create_pago_orden_compra',compact('estado_pago','empresa','persona'));

	}

    public function listar_orden_compra_pagos_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
        $p[]=$request->empresa;
        $p[]=$request->persona;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->estado_pago;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_pagos_ajax($p);
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

    public function modal_pago($id, $id_orden_compra){
		
		$tablaMaestra_model = new TablaMaestra;
		$orden_compra_model = new OrdenCompra;
		$fecha_actual = $orden_compra_model->fecha_actual();

		if($id==0){
			$orden_compra_pago = new OrdenCompraPago;
		}else{
			$orden_compra_pago = OrdenCompraPago::find($id);
		}

		$tipo_desembolso = $tablaMaestra_model->getMaestroByTipo(65);
		$banco = $tablaMaestra_model->getMaestroByTipo(16);

		$orden_compra_pago_model = new OrdenCompraPago;
		$data = $orden_compra_pago_model->getImportePago($id_orden_compra);

		$importe = $data->precio-$data->pago;

		return view('frontend.orden_compra.modal_pago',compact('id','orden_compra_pago','id_orden_compra','fecha_actual'/*,'adelantos'*/,'tipo_desembolso','importe','banco'));
	
	}

    public function modal_guia($id, $id_orden_compra){
		
		$tablaMaestra_model = new TablaMaestra;

		if($id==0){
			$guia_interna = new GuiaInterna;
		}else{
			$guia_interna = GuiaInterna::find($id);
		}

		return view('frontend.orden_compra.modal_guia',compact('id','guia_interna','id_orden_compra'));
	
	}

    public function cargar_pago_orden_compra($id){
		 
		$orden_compra_model = new OrdenCompra;
        $pago = $orden_compra_model->getOrdenCompraPagoById($id);
		
        return view('frontend.orden_compra.orden_compra_pago_ajax',compact('pago'));
		
    }

    public function cargar_guia_orden_compra($id){
		
		$orden_compra_model = new OrdenCompra;
        $guia = $orden_compra_model->getOrdenCompraGuiaById($id);
		
        return view('frontend.orden_compra.orden_compra_guia_ajax',compact('guia'));
		
    }

    public function eliminar_pago($id)
    {
		$orden_compra_pago = OrdenCompraPago::find($id);
		$orden_compra_pago->estado = 0;
		$orden_compra_pago->save();

		echo $orden_compra_pago->id;

    }

    public function upload_pago(Request $request){

		$path = "img/tmp_pago_orden_compra";
		if (!is_dir($path)) {
			mkdir($path);
		}

        $filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";

    	$filepath = public_path('img/tmp_pago_orden_compra/');

        $type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);

		echo $filename.".".$type;
	}

    public function upload_guia(Request $request){

		$path = "img/tmp_guia_orden_compra";
		if (!is_dir($path)) {
			mkdir($path);
		}

        $filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";

    	$filepath = public_path('img/tmp_guia_orden_compra/');

        $type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);

		echo $filename.".".$type;
	}

	public function send_pago(Request $request){
		
        $orden_compra_id = $request->id_orden_compra;
		$path = public_path("img/pago_orden_compra/".$orden_compra_id);
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/tmp_pago_orden_compra/');
			$filepath_nuevo = public_path('img/pago_orden_compra/'. $orden_compra_id . '/');
             if (!is_dir($filepath_nuevo)) {
                mkdir($filepath_nuevo, 0777, true);
            }
			if ($request->img_foto != "") {
                if (file_exists($filepath_tmp . $request->img_foto)) {
                    copy($filepath_tmp . $request->img_foto, $filepath_nuevo . $request->img_foto);
                }
            }
		}

		$id_user = Auth::user()->id;
		$maestra_model = new TablaMaestra;
		
		if($request->id==0){
			$pago = new OrdenCompraPago;
			$pago->id_orden_compra = $request->id_orden_compra;
			$pago->id_tipo_desembolso = $request->id_tipodesembolso;
			$pago->importe = $request->importe;
			$pago->nro_guia = $request->nro_guia;
			$pago->nro_cheque = $request->nro_cheque;
			$pago->nro_factura = $request->nro_factura;
			$pago->id_banco = $request->id_banco;
			$pago->nro_operacion = $request->nro_operacion;
			$pago->fecha = $request->fecha;
			$pago->observacion = $request->observacion;
			$pago->foto_desembolso = $request->img_foto;
			$pago->estado = 1;
			$pago->id_usuario_inserta = $id_user;
		}else{
			$pago = OrdenCompraPago::find($request->id);
			$pago->id_tipo_desembolso = $request->id_tipodesembolso;
			$pago->importe = $request->importe;
			$pago->nro_guia = $request->nro_guia;
			$pago->nro_factura = $request->nro_factura;
			$pago->id_banco = $request->id_banco;
			$pago->nro_operacion = $request->nro_operacion;
			$pago->fecha = $request->fecha;
			$pago->observacion = $request->observacion;
			$pago->foto_desembolso = $request->img_foto;
			$pago->estado = 1;
			$pago->id_usuario_inserta = $id_user;
		}

		$pago->save();

		$ordenCompraPago_model = new OrdenCompraPago;
		$data = $ordenCompraPago_model->getImportePago($request->id_orden_compra);

		if($data->pago==0){
			$id_estado_pago = 1;
		}else if($data->precio>$data->pago){
			$id_estado_pago = 2;
		}else if($data->precio<=$data->pago){
			$id_estado_pago = 3;
		}

		$OrdenCompraPagoActual = OrdenCompraPago::where('id_orden_compra', $request->id_orden_compra)->where('estado', 1)->get();
        foreach($OrdenCompraPagoActual as $pago){
            $pago->id_estado_pago=$id_estado_pago;
            $pago->save();
        }
    }

    public function send_orden_compra_guia(Request $request){
		
        $orden_compra_id = $request->id_orden_compra;
		$path = "img/guia_orden_compra/".$orden_compra_id;
		if (!is_dir($path)) {
			mkdir($path, 0777, true);
		}

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/tmp_guia_orden_compra/');
			$filepath_nuevo = public_path('img/guia_orden_compra/'. $orden_compra_id . '/');
             if (!is_dir($filepath_nuevo)) {
                mkdir($filepath_nuevo, 0777, true);
            }
			if ($request->img_foto != "") {
                if (file_exists($filepath_tmp . $request->img_foto)) {
                    copy($filepath_tmp . $request->img_foto, $filepath_nuevo . $request->img_foto);
                }
            }
		}

		$guia_interna = GuiaInterna::find($request->id);
        $guia_interna->ruta_imagen = $request->img_foto;
        $guia_interna->observacion_recepcion = $request->observacion;
		$guia_interna->save();

    }

    public function create_reporte_comercializacion_solicitado_tienda(){

        $id_user = Auth::user()->id;
        $tienda_model = new Tienda;
        $producto_model = new Producto;
        $user_model = new User;
        $tienda_model = new Tienda;

		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $tiendas = $tienda_model->getTiendasAll();
        $productos = $producto_model->getProductoExterno();
        $vendedor = $user_model->getUserByRol(7,11);

		return view('frontend.orden_compra.create_reporte_comercializacion_solicitado_tienda',compact('tipo_documento','cerrado_orden_compra','proveedor','tiendas','productos','vendedor'));

	}

    public function listar_reporte_comercializacion_solicitado_tienda_ajax(Request $request){

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->empresa_compra;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->producto;
        $p[]=$request->tienda;
        $p[]=1;
        $p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_reporte_comercializacion_solicitado_tienda_ajax($p);
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

    public function exportar_reporte_comercializacion_solicitado_tienda($empresa_compra, $fecha_inicio, $fecha_fin, $numero_orden_compra_cliente, $producto, $tienda) {

        if($empresa_compra==0)$empresa_compra = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($producto==0)$producto = "";
        if($tienda==0)$tienda = "";
        
        $orden_compra_model = new OrdenCompra;
		$p[]=$empresa_compra;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$producto;
        $p[]=$tienda;
        $p[]=1;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_reporte_comercializacion_solicitado_tienda_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Empresa","Orden Compra","Pedido","Fecha Pedido","Fecha Vencimiento","Codigo Interno","Codigo Sodimac","Descripcion","Precio Unitario","Cantidad Pedida","Tienda"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->razon_social, $r->numero_orden_compra_cliente, $r->pedido, $r->fecha_orden_compra, $r->fecha_vencimiento, $r->codigo, $r->codigo_empresa, $r->producto, $r->precio, $r->cantidad, $r->tienda));
		}
		
		$export = new InvoicesExport4([$variable]);
		return Excel::download($export, 'Reporte_comercializacion_tienda_solicitada.xlsx');
		
    }

    public function exportar_listar_pagos_orden_compra($empresa, $persona, $fecha_inicio, $fecha_fin, $estado_pago) {


		if($empresa==0)$empresa = "";
		if($persona==0)$persona = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
		if($estado_pago==0)$estado_pago = "";

		$orden_compra_model = new OrdenCompra;
        $p[]=$empresa;
        $p[]=$persona;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$estado_pago;
		$p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_orden_compra_pagos_ajax($p);
	
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Fecha","Cliente","Vendedor","Tipo Producto","N° OC", "Fecha Factura", "N° Factura", "SubTotal", "IGV", "Total", "Abono", "Forma Pago", "Fecha Vencimiento", "Guia", "Estado Pago", "Pagos", "Fecha Pagos", "Guias", "Observacion Guias"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->fecha_ingreso, $r->ruc, $r->razon_social, $r->placa,$r->tipo_madera,$r->cantidad, $r->volumen_total_m3, $r->volumen_total_pies));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_pagos.xlsx');
		
    }

    public function create_control_produccion(){

        $id_user = Auth::user()->id;
        $user_model = new User;

		$tablaMaestra_model = new TablaMaestra;
        $almacen_user_model = new Almacen_usuario;
        $persona_model = new Persona;
        $producto_model = new Producto;

        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $almacen = Almacene::all();
        $almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);
        $vendedor = $user_model->getUserByRol(7,11);
		$estado_pedido = $tablaMaestra_model->getMaestroByTipo(77);
        $persona_compra = $persona_model->obtenerPersonaAll();
        $estado_comprometido = $tablaMaestra_model->getMaestroByTipo(87);
        $producto = $producto_model->getProductoExterno();
        
		return view('frontend.orden_compra.create_control_produccion',compact('cerrado_orden_compra','proveedor','almacen','almacen_usuario','vendedor','estado_pedido','persona_compra','estado_comprometido','producto'));

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
        $p[]=$request->estado_comprometido;
        $p[]=$request->producto;
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

    public function send_comprometer_stock_total($id)
    {
        $kardex_model = new Kardex;

        $detalles = OrdenCompraDetalle::where('id_orden_compra', $id)->where('estado', '1')->get();
        $orden_compra_matriz = OrdenCompra::find($id);
        foreach ($detalles as $detalle) {

            $id_almacen_bus = $orden_compra_matriz->id_almacen_salida;

            if ($orden_compra_matriz->id_unidad_origen == 1) {
                $id_almacen_bus = $orden_compra_matriz->id_almacen_salida;
            }
            if ($orden_compra_matriz->id_unidad_origen == 2) {
                $id_almacen_bus = $orden_compra_matriz->id_almacen_destino;
            }
            if ($orden_compra_matriz->id_unidad_origen == 3) {
                $id_almacen_bus = $orden_compra_matriz->id_almacen_salida;
            }
            if ($orden_compra_matriz->id_unidad_origen == 4) {
                $id_almacen_bus = $orden_compra_matriz->id_almacen_salida;
            }
            
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
            $stock_actual = count($stock) > 0 ? floatval($stock[0]->stock_comprometido) : 0;

            $cantidad_ingreso = floatval($detalle->cantidad_requerida);

            if ($detalle->comprometido != 1 && $cantidad_ingreso <= $stock_actual) {
                $detalle->comprometido = 1;
                $detalle->save();
            }
        }

        $total = OrdenCompraDetalle::where('id_orden_compra', $id)->where('estado', '1')->count();

        $comprometidos = OrdenCompraDetalle::where('id_orden_compra', $id)->where('estado', '1')->where('comprometido', 1)->count();

        $orden_compra = OrdenCompra::find($id);

        if ($comprometidos == 0) {
            $orden_compra->comprometido = 0;
        } elseif ($comprometidos < $total) {
            $orden_compra->comprometido = 1;
        } else {
            $orden_compra->comprometido = 2;
        }

        $orden_compra->save();

        echo $id;
    }

    public function obtener_orden_compra_matriz($numero_orden_compra_matriz){
		
		$orden_compra_model = new OrdenCompra;
		$orden_compra_matriz = $orden_compra_model->getOrdenCompraMatriz($numero_orden_compra_matriz);
		
		return response()->json($orden_compra_matriz);
	}

    public function comprometerStockTotalAutomatico()
    {
        $kardex_model = new Kardex;

        $ordenes = OrdenCompra::where('cerrado', 1)->where('id_tipo_documento', 2)->where('estado_pedido', 1)->where('estado', 1)->whereIn('comprometido', [0, 1])->get();

        foreach ($ordenes as $orden_compra_matriz) {
            $detalles = OrdenCompraDetalle::where('id_orden_compra', $orden_compra_matriz->id)->where('estado', '1')->get();

            foreach ($detalles as $detalle) {
                $id_almacen_bus = $orden_compra_matriz->id_almacen_salida;

                if ($orden_compra_matriz->id_unidad_origen == 2) {
                    $id_almacen_bus = $orden_compra_matriz->id_almacen_destino;
                }

                $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
                $stock_actual = count($stock) > 0 ? floatval($stock[0]->stock_comprometido) : 0;

                $cantidad_ingreso = floatval($detalle->cantidad_requerida);

                if ($detalle->comprometido != 1 && $cantidad_ingreso <= $stock_actual) {
                    $detalle->comprometido = 1;
                    $detalle->save();
                }
            }

            $total = OrdenCompraDetalle::where('id_orden_compra', $orden_compra_matriz->id)->where('estado', '1')->count();
            $comprometidos = OrdenCompraDetalle::where('id_orden_compra', $orden_compra_matriz->id)->where('estado', '1')->where('comprometido', 1)->count();

            if ($comprometidos == 0) {
                $orden_compra_matriz->comprometido = 0;
            } elseif ($comprometidos < $total) {
                $orden_compra_matriz->comprometido = 1;
            } else {
                $orden_compra_matriz->comprometido = 2;
            }

            $orden_compra_matriz->save();
        }

        return "Proceso de compromiso automático finalizado.";
    }

    public function create_autorizacion(){
		
        $user_model = new User;
        $tablaMaestra_model = new TablaMaestra;

        $vendedor = $user_model->getUserByRol(7,11);
		$estado_autorizacion = $tablaMaestra_model->getMaestroByTipo(100);

		return view('frontend.orden_compra.create_autorizacion',compact('vendedor','estado_autorizacion'));

	}

    public function listar_orden_compra_autorizacion_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
        $p[]=$request->empresa_compra;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$id_user;
        $p[]=$request->estado_autorizacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_orden_compra_autorizacion_ajax($p);
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

    public function modal_orden_compra_autorizacion($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
        $persona_model = new Persona;
        $empresa_model = new Empresa;
        $usuario_descuento_model = new UsuarioDescuento;
        $id_proceso = null;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
            $descuento_usuario = $usuario_descuento_model->getDescuentoByUser($orden_compra->id_vendedor);
            $id_descuento_usuario = $descuento_usuario[0]->descuento;

            if($orden_compra->id_canal == 1 || $orden_compra->id_canal == 2 || $orden_compra->id_canal == 3){
                $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$orden_compra->id)->where('estado',1)->orderBy('id', 'desc')->first();
                $id_proceso = $autorizacion_orden_compra->id_proceso_pedido;
            }

		}else{
			$orden_compra = new OrdenCompra;
            $id_descuento_usuario = 0;
		}

        $proveedor = $empresa_model->getEmpresaAll();
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

        $vendedor = $user_model->getUserByRol(7,11);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        $persona = $persona_model->obtenerPersonaAll();
        $prioridad = $tablaMaestra_model->getMaestroByTipo(93);
        $canal = $tablaMaestra_model->getMaestroByTipo(98);

		return view('frontend.orden_compra.modal_orden_compra_autorizacionOrdenCompra',compact('id','orden_compra','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen','id_user','moneda','vendedor','tipo_documento_cliente','persona','prioridad','canal','id_descuento_usuario','id_proceso'));

    }

    public function send_orden_compra_autorizacion(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $orden_compra = new OrdenCompra;
		    
        }else{
            $orden_compra = OrdenCompra::find($request->id);
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

        /*$orden_compra->id_autorizacion = $request->id_autorizacion;
        $orden_compra->id_usuario_autoriza = $id_user;
        $orden_compra->save();*/
        
        if($request->aprobacion_total == 1){

            $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$orden_compra->id)->where('estado',1)->orderBy('id', 'desc')->first();

            //dd($autorizacion_orden_compra->id);exit();

            if($autorizacion_orden_compra->id_proceso_pedido == $request->id_proceso){
                $autorizacion_orden_compra->id_autorizacion = 2;
                $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
                $autorizacion_orden_compra->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra->estado = 1;
                $autorizacion_orden_compra->save();
                
                $autorizacion_orden_compra_siguiente_proceso = new AutorizacionOrdenCompra;
                $autorizacion_orden_compra_siguiente_proceso->id_orden_compra = $orden_compra->id;
                $autorizacion_orden_compra_siguiente_proceso->id_proceso_pedido = $request->id_proceso+1;
                //$autorizacion_orden_compra_siguiente_proceso->id_autorizacion = 1;
                $autorizacion_orden_compra_siguiente_proceso->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra_siguiente_proceso->estado = 1;
                $autorizacion_orden_compra_siguiente_proceso->save();

                $orden_compra_principal = OrdenCompra::find($orden_compra->id);
                $orden_compra_principal->id_autorizacion = 2;
                $orden_compra_principal->id_usuario_autoriza = $id_user;
                $orden_compra_principal->save();
            }
        }

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
            $orden_compra_detalle->estado = 1;
            if($orden_compra_detalle->id_autorizacion == 1){
                $orden_compra_detalle->id_autorizacion = $id_autorizacion_detalle[$index];
                if($id_autorizacion_detalle[$index] == 2){
                    $orden_compra_detalle->id_usuario_autoriza = $id_user;
                }
            }
            $orden_compra_detalle->id_usuario_inserta = $id_user;
            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;
        }

        return response()->json(['id' => $orden_compra->id]);
        
    }

    public function obtener_descuento_usuario($id_user){
        
		$usuario_descuento_model = new UsuarioDescuento;
		$descuento_usuario = $usuario_descuento_model->getDescuentoByUser($id_user);
		
		echo json_encode($descuento_usuario);
	}

    public function create_reporte_comercializacion_general(){

        $id_user = Auth::user()->id;
        $producto_model = new Producto;
        $user_model = new User;

		$tablaMaestra_model = new TablaMaestra;
        $proveedor = Empresa::all();
        $productos = $producto_model->getProductoExterno();
        $vendedor = $user_model->getUserByRol(7,11);
		$canal = $tablaMaestra_model->getMaestroByTipo(98);

		return view('frontend.orden_compra.create_reporte_comercializacion_general',compact('proveedor','productos','vendedor','canal'));

	}

    public function listar_reporte_comercializacion_general_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
        $p[]=$request->canal;
        $p[]=$request->empresa_compra;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->vendedor;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_reporte_comercializacion_general_ajax($p);
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

    public function exportar_reporte_comercializacion_general($empresa_compra, $fecha_inicio, $fecha_fin, $vendedor, $canal) {

        if($empresa_compra==0)$empresa_compra = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($vendedor==0)$vendedor = "";
        if($canal==0)$canal = "";
        
        $orden_compra_model = new OrdenCompra;
		$p[]=$canal;
        $p[]=$empresa_compra;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$vendedor;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_reporte_comercializacion_general_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Cliente","Canal","Vendedor","Monto","Fecha","Numero Orden Compra"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->cliente, $r->canal, $r->vendedor, $r->total_despacho, $r->fecha_orden_compra, $r->pedido));
		}
		
		$export = new InvoicesExport6([$variable]);
		return Excel::download($export, 'Reporte_comercializacion_general.xlsx');
		
    }

    public function create_informe_b2b(){

        $equivalencia_producto_model = new EquivalenciaProducto;
        $tienda_model = new Tienda;

        $equivalencia_producto = $equivalencia_producto_model->getEquivalenciaProductoAll();
        $tienda = $tienda_model->getTiendasAll();

		return view('frontend.orden_compra.create_informe_b2b',compact('equivalencia_producto','tienda'));

	}

    public function listar_informe_b2b_ajax(Request $request){

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->semana;
        $p[]=$request->producto;
        $p[]=$request->tienda;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_informe_b2b_ajax($p);
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

    public function upload_informe_b2b_compra(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		
        $path = "informe_b2b";
        if (!is_dir($path)) {
            mkdir($path);
        }
        
        $filepath = public_path('informe_b2b/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
		$archivo = $filename.".".$type;
		
		$this->importar_informe_b2b($archivo);
		
	}

    public function importar_informe_b2b($archivo)
    {

        $id_user = Auth::user()->id;

        $filePath = public_path('informe_b2b/'.$archivo);

        if (!file_exists($filePath)) {
            return response()->json(['error' => 'Archivo no encontrado.'], 404);
        }
        
        $file = fopen($filePath, 'r');

        // Lee la cabecera
        $header = fgetcsv($file, 0, '|');

        //dd($header); exit();

        if ($header === false) {
            return response()->json(['error' => 'El archivo está vacío o tiene un formato incorrecto.'], 400);
        }

        $cleanHeader = [];
        $semana = null;

        foreach ($header as $col) {
            $col = trim($col);
            
            if (preg_match('/_(\d{2}-\d{2})$/', $col, $matches)) {
                [$nombreCampo, $fechaParte] = explode('_', $col);
                $nombreCampo = strtoupper($nombreCampo);
                [$dia, $mes] = explode('-', $fechaParte);
                $anioActual = date('Y');
                $fecha = DateTime::createFromFormat('d-m-Y', "$dia-$mes-$anioActual");

                if ($fecha && !$semana) {
                    $semana = (int)$fecha->format('W');
                }
            } else {
                $nombreCampo = strtoupper($col);
            }

            $cleanHeader[] = $nombreCampo;
        }

        $header = $cleanHeader;

        $count = 0;
        
        while (($line = fgets($file)) !== false) {

            $line = trim($line);
            
            $data = str_getcsv($line, '|');
            
            $data = array_pad($data, count($header), null);

            if (count($data) !== count($header)) {
                continue; // Ignorar filas mal formateadas
            }

            $row = array_combine($header, $data);

            /*if($count == 0){

                $InformeVentaB2BExiste = InformeVentaB2b::where("numero_orden_compra_cliente",$numero_orden_compra_cliente)->where("estado","1")->get();
            
                if(count($OrdenCompraExiste)>0){
                    $array["cantidad"] = count($OrdenCompraExiste);
                    echo json_encode($array);
                    exit();
                }
                
                $informeVentaB2B = new InformeVentaB2b;
                $informeVentaB2B->id_unidad_origen = $id_unidad_origen;
                $informeVentaB2B->id_empresa_vende = $id_empresa_vende;
                $informeVentaB2B->id_empresa_compra = $id_empresa_compra;
                $informeVentaB2B->fecha_orden_compra = $fecha_orden_compra;
                $informeVentaB2B->numero_orden_compra = $numero_orden_compra;
                $informeVentaB2B->numero_orden_compra_cliente = $numero_orden_compra_cliente;
                $informeVentaB2B->id_tipo_documento = $id_tipo_documento;
                $informeVentaB2B->estado = $estado;
                $informeVentaB2B->igv_compra = $igv_compra;
                $informeVentaB2B->cerrado = $cerrado;
                $informeVentaB2B->id_almacen_destino = $id_almacen_destino;
                $informeVentaB2B->id_almacen_salida = $id_almacen_salida;
                $informeVentaB2B->tienda_asignada = $tienda_asignada;
                $informeVentaB2B->id_moneda = $id_moneda;
                $informeVentaB2B->moneda = $moneda;
                $informeVentaB2B->id_usuario_inserta = $id_user;
                $informeVentaB2B->id_vendedor = $id_vendedor;
                $informeVentaB2B->id_tipo_cliente = $id_tipo_cliente;
                $informeVentaB2B->fecha_vencimiento = $fecha_vencimiento;
                $informeVentaB2B->id_canal = $id_canal;
                $informeVentaB2B->save();
                $id_informeVentaB2B = $informeVentaB2B->id;

            }*/
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($row['SKU']))->first();
            $equivalenciaTienda = Tienda::where("numero_tienda",trim($row['NRO_LOCAL']))->first();
            $id_producto = $equivalenciaProducto->id_producto;
            $id_tienda = $equivalenciaTienda->id;
            $producto = Producto::find($id_producto);
            $upc = $row['UPC'];
            $sku = $row['SKU'];
            $subclase_conjunto = $row['SUBCLASE-CONJUNTO'];
            $desc_subclase_conjunto = $row['DESC_SUBCLASE-DESC_CONJUNTO'];
            //$id_local = $row['NRO_LOCAL'];

            $lunes = $row['LUNES'];
            $martes = $row['MARTES'];
            $miercoles = $row['MIERCOLES'];
            $jueves = $row['JUEVES'];
            $viernes = $row['VIERNES'];
            $sabado = $row['SABADO'];
            $domingo = $row['DOMINGO'];

            $venta_unidades = $row['VENTA_UNIDADES'];
            $venta_soles = $row['VENTA_SOLES'];
            $stock_contable = $row['STOCK_CONTABLE'];

            $oc_pendiente = $row['OC_PENDIENTE'];
            $trf_por_recibir = $row['TRF_POR_RECIBIR'];
            $trf_enviadas = $row['TRF_ENVIADAS'];

            $informeVentaB2B = new InformeB2bVenta;
            $informeVentaB2B->upc = $upc;
            $informeVentaB2B->sku = trim($sku);
            $informeVentaB2B->id_producto = $id_producto;
            $informeVentaB2B->subclase_conjunto = $subclase_conjunto;
            $informeVentaB2B->desc_subclase_conjunto = $desc_subclase_conjunto;
            $informeVentaB2B->id_tienda = $id_tienda;
            $informeVentaB2B->semana = $semana;
            $informeVentaB2B->lunes = $lunes;
            $informeVentaB2B->martes = $martes;
            $informeVentaB2B->miercoles = $miercoles;
            $informeVentaB2B->jueves = $jueves;
            $informeVentaB2B->viernes = $viernes;
            $informeVentaB2B->sabado = $sabado;
            $informeVentaB2B->domingo = $domingo;
            $informeVentaB2B->venta_unidades = $venta_unidades;
            $informeVentaB2B->venta_soles = $venta_soles;
            $informeVentaB2B->stock_contable = $stock_contable;
            $informeVentaB2B->oc_pendiente = $oc_pendiente;
            $informeVentaB2B->trf_por_recibir = $trf_por_recibir;
            $informeVentaB2B->trf_enviadas = $trf_enviadas;
            $informeVentaB2B->id_usuario_inserta = $id_user;
            $informeVentaB2B->save();

            $count++;
        }

        fclose($file);

        $array["cantidad"] = 0;//count($count);
        echo json_encode($array);

    }

    public function send_pedido_orden_compra(Request $request){

        $id_user = Auth::user()->id;

        $id_autorizacion = $request->id_autorizacion;

        $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$request->id)->where('estado',1)->orderBy('id', 'desc')->first();

        //dd($autorizacion_orden_compra);exit();

        if($autorizacion_orden_compra->id_proceso_pedido == $request->id_proceso){
            
            $autorizacion_orden_compra->id_autorizacion = 2;
            $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
            $autorizacion_orden_compra->id_usuario_inserta = $id_user;
            $autorizacion_orden_compra->estado = 1;
            $autorizacion_orden_compra->save();
        
            if($autorizacion_orden_compra->id_proceso_pedido == 1 && $id_autorizacion == 0){
                $autorizacion_orden_compra_siguiente_proceso = new AutorizacionOrdenCompra;
                $autorizacion_orden_compra_siguiente_proceso->id_orden_compra = $request->id;
                $autorizacion_orden_compra_siguiente_proceso->id_proceso_pedido = $request->id_proceso+2;
                //$autorizacion_orden_compra_siguiente_proceso->id_autorizacion = 1;
                $autorizacion_orden_compra_siguiente_proceso->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra_siguiente_proceso->estado = 1;
                $autorizacion_orden_compra_siguiente_proceso->save();
            }else{
                $autorizacion_orden_compra_siguiente_proceso = new AutorizacionOrdenCompra;
                $autorizacion_orden_compra_siguiente_proceso->id_orden_compra = $request->id;
                $autorizacion_orden_compra_siguiente_proceso->id_proceso_pedido = $request->id_proceso+1;
                //$autorizacion_orden_compra_siguiente_proceso->id_autorizacion = 1;
                $autorizacion_orden_compra_siguiente_proceso->id_usuario_inserta = $id_user;
                $autorizacion_orden_compra_siguiente_proceso->estado = 1;
                $autorizacion_orden_compra_siguiente_proceso->save();
            }
        }
        
        return response()->json(['id' => $request->id]);
        
    }

    public function send_denegar_pago_orden_compra(Request $request){

        $id_user = Auth::user()->id;

        $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$request->id)->where('estado',1)->orderBy('id', 'desc')->first();

        if($autorizacion_orden_compra->id_proceso_pedido == $request->id_proceso){
            $autorizacion_orden_compra->id_autorizacion = 1;
            $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
            $autorizacion_orden_compra->id_usuario_inserta = $id_user;
            $autorizacion_orden_compra->estado = 1;
            $autorizacion_orden_compra->save();
            
            $autorizacion_orden_compra_siguiente_proceso = new AutorizacionOrdenCompra;
            $autorizacion_orden_compra_siguiente_proceso->id_orden_compra = $request->id;
            $autorizacion_orden_compra_siguiente_proceso->id_proceso_pedido = 1;
            //$autorizacion_orden_compra_siguiente_proceso->id_autorizacion = 1;
            $autorizacion_orden_compra_siguiente_proceso->id_usuario_inserta = $id_user;
            $autorizacion_orden_compra_siguiente_proceso->estado = 1;
            $autorizacion_orden_compra_siguiente_proceso->save();
        }
        
        return response()->json(['id' => $request->id]);
        
    }

    public function send_denegar_orden_compra_autorizacion(Request $request){

        $id_user = Auth::user()->id;

        $autorizacion_orden_compra = AutorizacionOrdenCompra::where('id_orden_compra',$request->id)->where('estado',1)->orderBy('id', 'desc')->first();

        if($autorizacion_orden_compra->id_proceso_pedido == $request->id_proceso){
            $autorizacion_orden_compra->id_autorizacion = 1;
            $autorizacion_orden_compra->id_usuario_autoriza = $id_user;
            $autorizacion_orden_compra->id_usuario_inserta = $id_user;
            $autorizacion_orden_compra->estado = 1;
            $autorizacion_orden_compra->save();
            
            $autorizacion_orden_compra_siguiente_proceso = new AutorizacionOrdenCompra;
            $autorizacion_orden_compra_siguiente_proceso->id_orden_compra = $request->id;
            $autorizacion_orden_compra_siguiente_proceso->id_proceso_pedido = 1;
            //$autorizacion_orden_compra_siguiente_proceso->id_autorizacion = 1;
            $autorizacion_orden_compra_siguiente_proceso->id_usuario_inserta = $id_user;
            $autorizacion_orden_compra_siguiente_proceso->estado = 1;
            $autorizacion_orden_compra_siguiente_proceso->save();
        }
        
        return response()->json(['id' => $request->id]);
        
    }

    public function exportar_listar_orden_compra_individual($id) {

        $id_user = Auth::user()->id;
        
		if($id==0)$id = "";

        $orden_compra_model = new OrdenCompra;
        $orden_compra_detalle_model = new OrdenCompraDetalle;

        $datos=$orden_compra_model->getOrdenCompraByIdExcel($id);
        $datos_detalle=$orden_compra_detalle_model->getDetalleOrdenCompraExcel($id);
		//dd($datos);exit();
		$variable = [];
		$n = 1;

		array_push($variable, array(""));
		array_push($variable, array("Tipo Documento","Canal","Numero Orden Compra"));
		array_push($variable, array($datos[0]->tipo_documento, $datos[0]->canal, $datos[0]->numero_orden_compra));
		array_push($variable, array(""));

        array_push($variable, array("Empresa Vende","Tipo Documento Cliente","Cliente","RUC"));
		array_push($variable, array($datos[0]->empresa_vende, $datos[0]->tipo_cliente, $datos[0]->cliente, $datos[0]->ruc_empresa_compra));
        array_push($variable, array(""));

        array_push($variable, array("Fecha Orden Compra","Fecha Vencimiento","Unidad Origen"));
		array_push($variable, array($datos[0]->fecha_orden_compra, $datos[0]->fecha_vencimiento, $datos[0]->unidad_origen));
        array_push($variable, array(""));

        array_push($variable, array("Almacen Origen","Aplica IGV","Vendedor"));
		array_push($variable, array($datos[0]->almacen, $datos[0]->aplica_igv, $datos[0]->vendedor));
        array_push($variable, array(""));

        array_push($variable, array("Observacion"));
		array_push($variable, array($datos[0]->observacion_vendedor));
        array_push($variable, array(""));

		array_push($variable, array("#","Descripcion","Marca","Codigo Interno","Unidad","Cantidad","Stock Disponible","Precio Venta", "Precio Unitario", "Valor Venta Bruto", "Valor Venta", "Valor Descuento","Sub Total", "IGV", "Total"));
		
		foreach ($datos_detalle as $r) {

			array_push($variable, array($n, $r->producto, $r->marca, $r->codigo, $r->unidad_medida,$r->cantidad_requerida, $r->cantidad_requerida, $r->precio_venta, $r->precio, $r->valor_venta_bruto, $r->valor_venta, $r->descuento, $r->sub_total, $r->igv, $r->total));
		}
		
		$export = new InvoicesExport7([$variable]);
		return Excel::download($export, 'Reporte_orden_compra_individual.xlsx');
		
    }

    public function send_duplicar_orden_compra(Request $request){

        $id_user = Auth::user()->id;

        $orden_compra_matriz = OrdenCompra::find($request->id);

        $orden_compra_model = new OrdenCompra;
        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($orden_compra_matriz->id_tipo_documento);
        $numero_orden_compra = $codigo_orden_compra[0]->codigo;

        $orden_compra = new OrdenCompra;
        $orden_compra->id_empresa_compra = $orden_compra_matriz->id_empresa_compra;
        $orden_compra->id_empresa_vende = $orden_compra_matriz->id_empresa_vende;
        $orden_compra->fecha_orden_compra = $orden_compra_matriz->fecha_orden_compra;
        $orden_compra->numero_orden_compra = $numero_orden_compra;
        $orden_compra->id_tipo_documento = $orden_compra_matriz->id_tipo_documento;
        $orden_compra->estado = $orden_compra_matriz->estado;
        $orden_compra->id_usuario_inserta = $id_user;
        $orden_compra->igv_compra = $orden_compra_matriz->igv_compra;
        $orden_compra->cerrado = 1;
        $orden_compra->id_unidad_origen = $orden_compra_matriz->id_unidad_origen;
        $orden_compra->id_almacen_destino = $orden_compra_matriz->id_almacen_destino;
        $orden_compra->id_almacen_salida = $orden_compra_matriz->id_almacen_salida;
        $orden_compra->numero_orden_compra_cliente = $orden_compra_matriz->numero_orden_compra_cliente;
        $orden_compra->tienda_asignada = $orden_compra_matriz->tienda_asignada;
        $orden_compra->id_requerimiento = $orden_compra_matriz->id_requerimiento;
        $orden_compra->sub_total = $orden_compra_matriz->sub_total;
        $orden_compra->igv = $orden_compra_matriz->igv;
        $orden_compra->total = $orden_compra_matriz->total;
        $orden_compra->id_moneda = $orden_compra_matriz->id_moneda;
        $orden_compra->moneda = $orden_compra_matriz->moneda;
        $orden_compra->descuento = $orden_compra_matriz->descuento;
        $orden_compra->id_vendedor = $orden_compra_matriz->id_vendedor;
        $orden_compra->id_tipo_cliente = $orden_compra_matriz->id_tipo_cliente;
        $orden_compra->id_persona = $orden_compra_matriz->id_persona;
        $orden_compra->fecha_vencimiento = $orden_compra_matriz->fecha_vencimiento;
        $orden_compra->estado_pedido = $orden_compra_matriz->estado_pedido;
        $orden_compra->motivo = $orden_compra_matriz->motivo;
        $orden_compra->observacion_vendedor = $orden_compra_matriz->observacion_vendedor;
        $orden_compra->observacion_contabilidad = $orden_compra_matriz->observacion_contabilidad;
        $orden_compra->comprometido = 0;
        $orden_compra->id_prioridad = $orden_compra_matriz->id_prioridad;
        $orden_compra->id_canal = $orden_compra_matriz->id_canal;
        $orden_compra->save();
        $id_orden_compra = $orden_compra->id;

        $orden_compra_detalle_matriz = OrdenCompraDetalle::where('id_orden_compra',$request->id)->where('estado',1)->orderBy('id', 'asc')->get();

        //dd($orden_compra_detalle_matriz);exit();

        foreach($orden_compra_detalle_matriz as $detalle){
            $orden_compra_detalle = new OrdenCompraDetalle;
            $orden_compra_detalle->id_orden_compra = $id_orden_compra;
            $orden_compra_detalle->id_producto = $detalle->id_producto;
            $orden_compra_detalle->precio = $detalle->precio;
            $orden_compra_detalle->id_descuento = $detalle->id_descuento;
            $orden_compra_detalle->sub_total = $detalle->sub_total;
            $orden_compra_detalle->igv = $detalle->igv;
            $orden_compra_detalle->total = $detalle->total;
            $orden_compra_detalle->id_unidad_medida = $detalle->id_unidad_medida;
            $orden_compra_detalle->id_marca = $detalle->id_marca;
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->id_usuario_inserta = $id_user;
            $orden_compra_detalle->cantidad_requerida = $detalle->cantidad_requerida;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->valor_venta_bruto = $detalle->valor_venta_bruto;
            $orden_compra_detalle->precio_venta = $detalle->precio_venta;
            $orden_compra_detalle->valor_venta = $detalle->valor_venta;
            $orden_compra_detalle->descuento = $detalle->descuento;
            $orden_compra_detalle->comprometido = 0;
            $orden_compra_detalle->save();
        }

        $autorizacion_orden_compra = new AutorizacionOrdenCompra;
        $autorizacion_orden_compra->id_orden_compra = $id_orden_compra;
        $autorizacion_orden_compra->id_proceso_pedido = 1;
        $autorizacion_orden_compra->id_usuario_inserta = $id_user;
        $autorizacion_orden_compra->estado = 1;
        $autorizacion_orden_compra->save();
        
        return response()->json(['id' => $id_orden_compra]);
        
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
        return ["N", "Id", "Tipo Documento", "Empresa Compra", "N° OC Cliente"/*, "Empresa Vende"*/, "Fecha", "Numero OC", "Almacen Origen", "Almacen Destino", "Situacion", "Vendedor", "Total", "Estado", "Estado Pedido", "Prioridad"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:O1');

        $sheet->setCellValue('A1', "REPORTE DE ORDEN DE COMPRA - FORESPAMA");
        $sheet->getStyle('A1:M1')->applyFromArray([
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

        $sheet->getStyle('A2:O2')->applyFromArray([
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

		$sheet->getStyle('M3:M'.$sheet->getHighestRow())
		->getNumberFormat()
		->setFormatCode('#,##0.00');
        
        foreach (range('A', 'O') as $col) {
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
        return ["N°", "Empresa", "Orden Compra", "Pedido", "Fecha Pedido", "Fecha Vencimiento","Fecha Entrega Real", "Fecha Facturado", "Codigo Interno", "Codigo Retail", "Descripcion", "Precio Unitario", "Descuento", "Cantidad Pedida", "Cantidad Entregada", "Cantidad Cancelada", "Pendiente Entrega", "Vendedor", "Estado Pedido"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:S1');

        $sheet->setCellValue('A1', "REPORTE DE COMERCIALIZACION - FORESPAMA");
        $sheet->getStyle('A1:S1')->applyFromArray([
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

        $sheet->getStyle('A2:S2')->applyFromArray([
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

        foreach (range('A', 'S') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport3 implements FromArray, WithHeadings, WithStyles
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
        return ["N°", "Empresa", "Orden Compra", "Pedido", "Fecha Pedido", "Fecha Vencimiento", "Codigo Interno", "Codigo Sodimac", "Descripcion", "Precio Unitario", "Cantidad Pedida", "Cantidad Entregada", "Cantidad Cancelada", "Tienda"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:N1');

        $sheet->setCellValue('A1', "REPORTE DE COMERCIALIZACION POR TIENDA - FORESPAMA");
        $sheet->getStyle('A1:N1')->applyFromArray([
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

        $sheet->getStyle('A2:N2')->applyFromArray([
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

        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport4 implements FromArray, WithHeadings, WithStyles
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
        return ["N°", "Empresa", "Orden Compra", "Pedido", "Fecha Pedido", "Fecha Vencimiento", "Codigo Interno", "Codigo Sodimac", "Descripcion", "Precio Unitario", "Cantidad Pedida", "Tienda"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:L1');

        $sheet->setCellValue('A1', "REPORTE DE COMERCIALIZACION POR TIENDA - FORESPAMA");
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

class InvoicesExport5 implements FromArray, WithHeadings, WithStyles
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
        return ["N°","Vendedor","Empresa","Numero OC","Fecha","Codigo","Producto","Cantidad","Precio Venta","Precio Unitario","Valor Venta Bruto","Valor Venta","Descuento","Sub Total","IGV","Total"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:P1');

        $sheet->setCellValue('A1', "REPORTE DE ORDEN DE COMPRA DETALLADO- FORESPAMA");
        $sheet->getStyle('A1:P1')->applyFromArray([
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

        $sheet->getStyle('A2:P2')->applyFromArray([
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
        
        foreach (range('A', 'P') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport6 implements FromArray, WithHeadings, WithStyles
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
        return ["N°","Cliente","Canal","Vendedor","Monto","Fecha","Numero Orden Compra"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:G1');

        $sheet->setCellValue('A1', "REPORTE DE COMERCIALIZACION GENERAL - FORESPAMA");
        $sheet->getStyle('A1:G1')->applyFromArray([
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

        $sheet->getStyle('A2:G2')->applyFromArray([
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
        
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}

class InvoicesExport7 implements FromArray, WithStyles
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

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:O1');

        $sheet->setCellValue('A1', "ORDEN DE COMPRA INDIVIDUAL - FORESPAMA");
        $sheet->getStyle('A1:O1')->applyFromArray([
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

        /*$sheet->getStyle('A2:O2')->applyFromArray([
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
        ]);*/

		//$sheet->fromArray($this->headings(), NULL, 'A2');
        
        foreach (range('A', 'O') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
