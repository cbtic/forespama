<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proforma;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\ProformaDetalle;
use App\Models\Kardex;
use App\Models\Almacen_usuario;
use App\Models\Almacene;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;


class ProformaController extends Controller
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
		$tablaMaestra_model = new TablaMaestra;
        $almacen_user_model = new Almacen_usuario;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $cerrado_orden_compra = $tablaMaestra_model->getMaestroByTipo(52);
        $proveedor = Empresa::all();
        $almacen = Almacene::all();
        $almacen_usuario = $almacen_user_model->getAlmacenByUser($id_user);
        //$almacen_usuario2 = $almacen_user_model->getUsersByAlmacen($id_user);
        //dd($almacen_usuario);exit();
		
		return view('frontend.orden_compra.create',compact('tipo_documento','cerrado_orden_compra','proveedor','almacen','almacen_usuario'));

	}

    public function listar_orden_compra_ajax(Request $request){

		$proforma_model = new proforma;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]=$request->empresa_vende;
        $p[]=$request->fecha;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $proforma_model->listar_orden_compra_ajax($p);
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

    public function modal_proforma($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
		
		if($id>0){

            $proforma = Proforma::find($id);
            $proveedor = Empresa::all();
			
		}else{
			$proforma = new Proforma;
            $proveedor = Empresa::all();
		}

        //$proforma_model = new OrdenCompra;
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
        //$codigo_orden_compra = $proforma_model->getCodigoOrdenCompra();
        
        //dd($proveedor);exit();

		return view('frontend.proforma.modal_proforma',compact('id','proforma','tipo_documento','proveedor','producto','marca','estado_bien','unidad','igv_compra','descuento','almacen','unidad_origen'));

    }

    public function send_orden_compra(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $proforma = new Proforma;
        }else{
            $proforma = Proforma::find($request->id);
        }

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $fecha_fabricacion = $request->input('fecha_fabricacion');
        $fecha_vencimiento = $request->input('fecha_vencimiento');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $precio_unitario = $request->input('precio_unitario');
        $descuento = $request->input('descuento');
        $sub_total = $request->input('sub_total');
        $igv = $request->input('igv');
        $total = $request->input('total');
        $id_orden_compra_detalle =$request->id_orden_compra_detalle;
        
        $proforma->id_empresa_compra = $request->empresa_compra;
        $proforma->id_empresa_vende = $request->empresa_vende;
        $proforma->fecha_orden_compra = $request->fecha_orden_compra;
        $proforma->numero_orden_compra = $request->numero_orden_compra;
        $proforma->id_tipo_documento = $request->tipo_documento;
        $proforma->igv_compra = $request->igv_compra;
        $proforma->id_unidad_origen = $request->unidad_origen;
        $proforma->id_almacen_destino = $request->almacen;
        $proforma->id_almacen_salida = $request->almacen_salida;
        $proforma->cerrado = 1;
        $proforma->id_usuario_inserta = $id_user;
        $proforma->estado = 1;
        $proforma->save();

        $array_orden_compra_detalle = array();

        foreach($item as $index => $value) {
            
            if($id_orden_compra_detalle[$index] == 0){
                $proforma_detalle = new Proforma;
            }else{
                $proforma_detalle = Proforma::find($id_orden_compra_detalle[$index]);
            }
            
            $proforma_detalle->id_orden_compra = $proforma->id;
            $proforma_detalle->id_producto = $descripcion[$index];
            $proforma_detalle->cantidad_requerida = $cantidad_ingreso[$index];
            $proforma_detalle->precio = $precio_unitario[$index];
            $proforma_detalle->id_descuento = $descuento[$index];
            $proforma_detalle->sub_total = $sub_total[$index];
            $proforma_detalle->igv = $igv[$index];
            $proforma_detalle->total = $total[$index];
            $proforma_detalle->fecha_fabricacion = $fecha_fabricacion[$index];
            $proforma_detalle->fecha_vencimiento = $fecha_vencimiento[$index];
            $proforma_detalle->id_estado_producto = $estado_bien[$index];
            $proforma_detalle->id_unidad_medida = $unidad[$index];
            $proforma_detalle->id_marca = $marca[$index];
            $proforma_detalle->estado = 1;
            $proforma_detalle->cerrado = 1;
            $proforma_detalle->id_usuario_inserta = $id_user;

            $proforma_detalle->save();

            $array_orden_compra_detalle[] = $proforma_detalle->id;

            $OrdenCompraAll = ProformaDetalle::where("id_orden_compra",$proforma->id)->where("estado","1")->get();
            
            foreach($OrdenCompraAll as $key=>$row){
                
                if (!in_array($row->id, $array_orden_compra_detalle)){
                    $proforma_detalle = ProformaDetalle::find($row->id);
                    $proforma_detalle->estado = 0;
                    $proforma_detalle->save();
                }
            }
        }

        return response()->json(['id' => $proforma->id]);    
        
    }

    public function eliminar_orden_compra($id,$estado)
    {
		$proforma = Proforma::find($id);

		$proforma->estado = $estado;
		$proforma->save();

		echo $proforma->id;
    }

    public function cargar_detalle($id)
    {

        $proforma_model = new Proforma;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $proforma = $proforma_model->getDetalleOrdenCompraId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        $producto_stock = [];

        foreach($proforma as $detalle){

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
            'orden_compra' => $proforma,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function movimiento_pdf($id){

        $proforma_model = new Proforma;
        $proforma_detalle_model = new ProformaDetalle;

        $datos=$proforma_model->getOrdenCompraById($id);
        $datos_detalle=$proforma_detalle_model->getDetalleOrdenCompraPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $empresa_compra=$datos[0]->empresa_compra;
        $empresa_vende=$datos[0]->empresa_vende;
        $fecha_orden_compra = $datos[0]->fecha_orden_compra;
        $numero_orden_compra = $datos[0]->numero_orden_compra;
        $igv=$datos[0]->igv;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha

		 $carbonDate =Carbon::now()->format('d-m-Y');

		 $currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.orden_compra.movimiento_orden_compra_pdf',compact('tipo_documento','empresa_compra','empresa_vende','fecha_orden_compra','numero_orden_compra','igv','datos_detalle'));
		


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
		
		$proforma_model = new Proforma;
		$codigo_orden_compra = $proforma_model->getCodigoOrdenCompra($tipo_documento);
		
		return response()->json($codigo_orden_compra);
	}

}
