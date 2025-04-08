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
        //echo $id_user;
        //$id_rol = auth()->user()->roles->first()->id ?? null;
        //echo $rol;
        //exit();

		$tablaMaestra_model = new TablaMaestra;
        $almacen_user_model = new Almacen_usuario;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $almacen = Almacene::all();
        $almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);
        $vendedor = $user_model->getUserByRol(7);
        //$almacen_usuario2 = $almacen_user_model->getUsersByAlmacen($id_user);
        //dd($almacen_usuario);exit();
		
		return view('frontend.orden_compra.create',compact('tipo_documento','cerrado_orden_compra','proveedor','almacen','almacen_usuario','vendedor'));

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
        //$almacen_usuario2 = $almacen_user_model->getUsersByAlmacen($id_user);
        //dd($almacen_usuario);exit();
		
		return view('frontend.orden_compra.consulta_stock_pedido',compact('tipo_documento','cerrado_orden_compra','proveedor','almacen','almacen_usuario'));

	}

    public function listar_orden_compra_ajax(Request $request){

        //$id_rol = auth()->user()->roles->first()->id ?? null;

        $id_user = Auth::user()->id;

		$orden_compra_model = new OrdenCompra;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]=$request->empresa_vende;
        $p[]=$request->fecha;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
        $p[]=$id_user;
        $p[]=$request->vendedor;
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

    public function modal_orden_compra($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
        $persona_model = new Persona;
        $empresa_model = new Empresa;
		
		if($id>0){

            $orden_compra = OrdenCompra::find($id);
            //$proveedor = Empresa::all();
			
		}else{
			$orden_compra = new OrdenCompra;
            //$proveedor = Empresa::all();
		}

        $proveedor = $empresa_model->getEmpresaAll();
        //$orden_compra_model = new OrdenCompra;
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        //$moneda = $tablaMaestra_model->getMaestroByTipo(1);
        //$unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        //$cerrado_entrada = $tablaMaestra_model->getMaestroByTipo(52);
        //$igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        //$descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        //$almacen = Almacene::all();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

        $vendedor = $user_model->getUserByRol(7);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        $persona = $persona_model->obtenerPersonaAll();

        //$codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra();
        
        //dd($proveedor);exit();

		return view('frontend.orden_compra.modal_orden_compra_nuevoOrdenCompra',compact('id','orden_compra','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen','id_user','moneda','vendedor','tipo_documento_cliente','persona'));

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
		    $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra($request->tipo_documento);
        }else{
            $orden_compra = OrdenCompra::find($request->id);
            $codigo_orden_compra = $request->numero_orden_compra;
        }

        //dd($codigo_orden_compra[0]->codigo);exit();

        $item = $request->input('item');
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
        $id_orden_compra_detalle =$request->id_orden_compra_detalle;

        $orden_compra->id_empresa_compra = $request->empresa_compra;
        $orden_compra->id_empresa_vende = $request->empresa_vende;
        $orden_compra->id_tipo_cliente = $request->tipo_documento_cliente;
        $orden_compra->id_persona = $request->persona_compra;
        $orden_compra->fecha_orden_compra = $request->fecha_orden_compra;
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
        $orden_compra->estado = 1;
        $orden_compra->save();

        $array_orden_compra_detalle = array();

        foreach($item as $index => $value) {
            
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
            $orden_compra_detalle->id_estado_producto = $estado_bien[$index];
            $orden_compra_detalle->id_unidad_medida = $unidad[$index];
            $orden_compra_detalle->id_marca = $marca[$index];
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
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
            
            if($detalle->id_unidad_origen==2){$id_almacen_bus = $detalle->id_almacen_destino;}
            if($detalle->id_unidad_origen==4){$id_almacen_bus = $detalle->id_almacen_salida;}
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $id_almacen_bus);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['saldos_cantidad'=>0];
            }
            
            //var_dump($producto_stock);
        }
        
        //exit();

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

        //$orden_compra_model = new OrdenCompra;
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        //$moneda = $tablaMaestra_model->getMaestroByTipo(1);
        //$unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        //$cerrado_entrada = $tablaMaestra_model->getMaestroByTipo(52);
        //$igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        //$descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);
        $almacen = $almacen_model->getAlmacenAll();
        //$almacen = Almacene::all();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        //$codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra();
        
        //dd($proveedor);exit();

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
                // Manejar el caso en que no haya productos para una tienda específica
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
        $id_vendedor = 17;
        $id_tipo_cliente = 5;

        // Ruta del archivo
        //$filePath = storage_path('app/datos.txt');
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

        // Procesa cada línea del archivo
        $count = 0; // Contador de filas exitosas

        // Iterar sobre cada fila
        while (($line = fgets($file)) !== false) {
            // Quitar posibles caracteres no deseados
            $line = trim($line);

            // Dividir en columnas
            $data = str_getcsv($line, '|');
            
            // Asegurarse de que ambas tengan la misma cantidad de elementos
            $data = array_pad($data, count($header), null);

            // Validar si la cantidad de columnas coincide con el encabezado
            if (count($data) !== count($header)) {
                continue; // Ignorar filas mal formateadas
            }

            // Asociar columnas del encabezado con valores de la fila
            $row = array_combine($header, $data);

            $empresa = Empresa::where("ruc",str_replace("-","",$row['RUT_PROVEEDOR']))->first();

            $id_empresa_vende = $empresa->id;
            $fecha_orden_compra = Carbon::createFromFormat('d/m/Y', $row['FECHA_AUTORIZACION']);
            $numero_orden_compra_cliente = $row['NRO_OC'];
            $fecha_vencimiento = Carbon::createFromFormat('d/m/Y', $row['FECHA_HASTA']);

            if($count == 0){

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
                $ordenCompra->save();
                $id_orden_compra = $ordenCompra->id;

            }
            
            $equivalenciaProducto = EquivalenciaProducto::where("codigo_empresa",trim($row['SKU']))->first();
            $id_producto = $equivalenciaProducto->id_producto;
            $producto = Producto::find($id_producto);
            $cantidad_requerida = $row['CANTIDAD_PROD'];
            $id_unidad_medida = $producto->id_unidad_producto;

            /*
            $precio_venta = $row['COSTO_UNI'];

            //$total = $sub_total + $igv;
            $total = round($precio_venta * $cantidad_requerida, 2);
            $valor_unitario = round($precio_venta / 1.18, 2);
            //$igv = round(0.18 * $total,2);
            $valor_venta_bruto = round($total / 1.18, 2);
            $igv = round($valor_venta_bruto * 0.18, 2);
            $sub_total = round($total - $igv, 2);

            $sub_total_general += $sub_total;
            $igv_general += $igv;
            $total_general += $total;
            */

            $valor_unitario = $row['COSTO_UNI'];
            $precio_venta = 1.18*$valor_unitario;

            /*$total = round($precio_venta * $cantidad_requerida, 2);
            $valor_venta_bruto = round($total / 1.18, 2);
            $igv = round($valor_venta_bruto * 0.18, 2);
            $sub_total = round($total - $igv, 2);

            $sub_total_general += $sub_total;
            $igv_general += $igv;
            $total_general += $total;*/

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

            /*
            //OrdenCompra::create([
            $detalle = array(
                'nro_oc' => $row['NRO_OC'],
                'rut_proveedor' => $row['RUT_PROVEEDOR'],
                'razon_social' => $row['RAZON_SOCIAL'],
                'direccion' => $row['DIRECCION'],
                'fono' => $row['FONO'] ?? null,
                'comprador' => $row['COMPRADOR'],
                'fecha_autorizacion' => Carbon::createFromFormat('d/m/Y', $row['FECHA_AUTORIZACION']),
                'estado' => $row['ESTADO'],
                'dias_pago' => $row['DIAS_PAGO'],
                'total_venta' => $row['TOTAL_VENTA'] ?? null,
                'total_costo' => $row['TOTAL_COSTO'] ?? null,
                'costo_uni' => $row['COSTO_UNI'] ?? null,
                'precio_uni' => $row['PRECIO_UNI'] ?? null,
                'cantidad_prod' => $row['CANTIDAD_PROD'] ?? null,
                'upc' => $row['UPC'] ?? null,
                'sku' => $row['SKU'] ?? null,
                'descripcion_larga' => $row['DESCRIPCION_LARGA'] ?? null,
                'marca' => $row['MARCA'] ?? null,
                'departamento' => $row['DEPARTAMENTO'] ?? null,
            //]);
            );
            print_r($detalle);echo "<br>";
            */
            $count++;
        }

        $ordenCompraTotales = OrdenCompra::find($id_orden_compra);
        $ordenCompraTotales->sub_total = round($sub_total_general, 2);
        $ordenCompraTotales->igv = round($igv_general, 2);
        $ordenCompraTotales->total = round($total_general, 2);
        $ordenCompraTotales->save();

        fclose($file);

        return response()->json([
            'message' => 'Datos importados correctamente.',
            'filas_importadas' => $count,
        ], 200);

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
		
        //echo $archivo;
		$this->importar_archivo($archivo);
		
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

    public function exportar_listar_orden_compra($tipo_documento, $empresa_compra, $empresa_vende, $fecha, $numero_orden_compra, $numero_orden_compra_cliente, $almacen_origen, $almacen_destino, $situacion, $estado, $vendedor) {

        $id_user = Auth::user()->id;
        
		if($tipo_documento==0)$tipo_documento = "";
        if($empresa_compra==0)$empresa_compra = "";
        if($empresa_vende==0)$empresa_vende = "";
        if($fecha=="0")$fecha = "";
        if($numero_orden_compra=="0")$numero_orden_compra = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($almacen_origen==0)$almacen_origen = "";
        if($almacen_destino==0)$almacen_destino = "";
        if($situacion==0)$situacion = "";
        if($estado==0)$estado = "";
        if($vendedor==0)$vendedor = "";

        $orden_compra_model = new OrdenCompra;
		$p[]=$tipo_documento;
        $p[]=$empresa_compra;
        $p[]=$empresa_vende;
        $p[]=$fecha;
        $p[]=$numero_orden_compra;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$situacion;
        $p[]=$almacen_origen;
        $p[]=$almacen_destino;
        $p[]=$estado;
		$p[]=$id_user;
        $p[]=$vendedor;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_orden_compra_ajax($p);
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Id","Tipo Documento","Empresa Compra","N° OC Cliente","Empresa Vende","Fecha","Numero OC","Almacen Origen","Almacen Destino","Situacion","Vendedor","Estado"));
		
		foreach ($data as $r) {

            if($r->estado==1){$estado='ACTIVO';}
            if($r->estado==0){$estado='INACTIVO';}

			array_push($variable, array($n++,$r->id, $r->tipo_documento, $r->cliente, $r->numero_orden_compra_cliente, $r->empresa_vende, $r->fecha_orden_compra, $r->numero_orden_compra, $r->almacen_origen, $r->almacen_destino, $r->cerrado, $r->vendedor, $estado));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'Reporte_orden_compra.xlsx');
		
    }  

    public function modal_datos_pedido_orden_compra($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $ubigeo_model = new Ubigeo;
        //$id_orden_compra = $id;

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

        //dd($request->id_datos_pedido);exit();

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
        $vendedor = $user_model->getUserByRol(7);

		return view('frontend.orden_compra.create_reporte_comercializacion',compact('tipo_documento','cerrado_orden_compra','proveedor','tiendas','productos','vendedor'));

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
        $p[]=1;
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

    public function exportar_reporte_comercializacion($empresa_compra, $fecha_inicio, $fecha_fin, $numero_orden_compra_cliente, $situacion, $codigo_producto, $producto) {

        if($empresa_compra==0)$empresa_compra = "";
        if($fecha_inicio=="0")$fecha_inicio = "";
        if($fecha_fin=="0")$fecha_fin = "";
        if($numero_orden_compra_cliente=="0")$numero_orden_compra_cliente = "";
        if($situacion==0)$situacion = "";
        if($codigo_producto=="0")$codigo_producto = "";
        if($producto==0)$producto = "";
        
        $orden_compra_model = new OrdenCompra;
		$p[]=$empresa_compra;
        $p[]=$fecha_inicio;
        $p[]=$fecha_fin;
        $p[]=$numero_orden_compra_cliente;
        $p[]=$situacion;
        $p[]=$codigo_producto;
        $p[]=$producto;
        $p[]=1;
        $p[]=1;
		$p[]=10000;
		$data = $orden_compra_model->listar_reporte_comercializacion_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Empresa","Orden Compra","Pedido","Fecha Pedido","Fecha Vencimiento","Codigo Interno","Descripcion","Precio Unitario","Cantidad Pedida","Cantidad Entregada","Cantidad Cancelada","Pendiente Entrega"));
		
		foreach ($data as $r) {

            if($r->cerrado==1){$cerrado='SI';}
            if($r->cerrado==2){$cerrado='NO';}

			array_push($variable, array($n++,$r->razon_social, $r->numero_orden_compra_cliente, $r->pedido, $r->fecha_orden_compra, $r->fecha_vencimiento, $r->codigo, $r->producto, $r->precio, $r->cantidad_requerida, $r->cantidad_despacho, $r->cantidad_cancelada, $cerrado));
		}
		
		$export = new InvoicesExport2([$variable]);
		return Excel::download($export, 'Reporte_comercializacion.xlsx');
		
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
		
        //echo $archivo;
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

        return response()->json([
            'message' => 'Datos importados correctamente.',
            'filas_importadas' => $count,
        ], 200);

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
        return ["N", "Id", "Tipo Documento", "Empresa Compra", "N° OC Cliente", "Empresa Vende", "Fecha", "Numero OC", "Almacen Origen", "Almacen Destino", "Situacion", "Vendedor", "Estado"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:M1');

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

        $sheet->getStyle('A2:M2')->applyFromArray([
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
        
        foreach (range('A', 'M') as $col) {
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
        return ["N°", "Empresa", "Orden Compra", "Pedido", "Fecha Pedido", "Fecha Vencimiento", "Codigo Interno", "Descripcion", "Precio Unitario", "Cantidad Pedida", "Cantidad Entregada", "Cantidad Cancelada", "Pendiente Entrega"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:M1');

        $sheet->setCellValue('A1', "REPORTE DE COMERCIALIZACION - FORESPAMA");
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

        $sheet->getStyle('A2:M2')->applyFromArray([
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
        
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}