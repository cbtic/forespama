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

    public function send(Request $request){
        $id_user = Auth::user()->id;
        //$proforma_detalle = $request->valorizacion_detalle;
        //print_r($proforma_detalle);
        //exit();
        
        $p_prof ="";
        $p_prof.="{";
		$p_prof.="{";        
        $p_prof.=$request->accion_.",";
        $p_prof.=$id_user.",";        		
        $p_prof.="0".","; //$request->id;
        $p_prof.="T001".","; //$request->serie;
        $p_prof.="0".","; //$request->numero ;
        $p_prof.=($request->empresa_id=="")?"0".",":$request->empresa_id.",";
        $p_prof.=($request->id_persona=="")?"0".",":$request->id_persona.",";
        $p_prof.="01/01/2025".","; //$request->fecha;
        $p_prof.="1".","; //$request->id_moneda;
        $p_prof.="SOLES".","; //$request->moneda;
        $p_prof.=$request->stotal.",";
        $p_prof.=$request->igv.",";
        $p_prof.=$request->total.",";
        $p_prof.="1"; //$request->estado;
        //if(strlen($p_prof)>1)$p_prof=substr($p_prof,0,-1);
        $p_prof.="}";
        $p_prof.="}";
/*
        $datos[] = $request->accion;
        $datos[] = $id_user;        		
		$datos[] = 0; //$request->id;
        $datos[] = "T001"; //$request->serie;
        $datos[] = 0; //$request->numero ;
        $datos[] = $request->empresa_id;
        $datos[] = $request->id_persona;
        $datos[] = "01/01/2025"; //$request->fecha;
        $datos[] = 1; //$request->id_moneda;
        $datos[] = "SOLES"; //$request->moneda;
        $datos[] = ($request->sub_total=="")?0:$request->sub_total;
        $datos[] = ($request->igv=="")?0:$request->igv;
        $datos[] = ($request->total=="")?0:$request->total;
        $datos[] = "1"; //$request->estado;
        $detalle = $request->valorizacion_detalle;
        foreach ($detalle as $key => $value) {
            $ddatos[] = 0; //$request->id;
            $ddatos[] = 0; //$request->id_proforma;
            $ddatos[] = $value['id_producto']; 
            $ddatos[] = $value['cantidad'];
            $ddatos[] = $value['id_unidad_medida'];
            $ddatos[] = $value['id_descuento'];                        
            $ddatos[] = ($value['descuento']=='')?0:$value['descuento'];
            $ddatos[] = ($value['precio_unitario']=='')?0:$value['precio_unitario'];
            $ddatos[] = ($value['valor_venta_bruto']=='')?0:$value['valor_venta_bruto'];
            $ddatos[] = ($value['sub_total']=='')?0:$value['sub_total'];
            $ddatos[] = ($value['igv']=='')?0:$value['igv'];
            $ddatos[] = ($value['total']=='')?0:$value['total'];
            $ddatos[] = $id_user;
            $ddatos[] = "1";           
        }
  */      
        $detalle = $request->valorizacion_detalle;
        $p_dprof ="";
		$p_dprof.="{";  
        foreach ($detalle as $key => $value) {
            $p_dprof.="{";
            $p_dprof.="0".","; //$request->id;
            $p_dprof.="0".","; //$request->id_proforma;
            $p_dprof.=$value['id_producto'].","; 
            $p_dprof.=$value['cantidad'].",";
            $p_dprof.=$value['id_unidad_medida'].",";
            $p_dprof.="1".",";//$value['id_descuento'];                     
            $p_dprof.=$value['descuento'].",";
            $p_dprof.=$value['precio_unitario'].",";
            $p_dprof.=$value['valor_venta_bruto'].",";
            $p_dprof.=$value['sub_total'].",";
            $p_dprof.=$value['igv'].",";
            $p_dprof.=$value['total'].",";
            $p_dprof.=$id_user.",";
            $p_dprof.="1";
            $p_dprof.="},";           
        }
        if(strlen($p_dprof)>1)$p_dprof=substr($p_dprof,0,-1);
		$p_dprof.="}"; 
        //exit($p_dprof);


        $proforma_model = new Proforma;
		$p[]=$p_prof;
        $p[]=$p_dprof;
        //$id_proforma = $proforma_model->registrar_proforma ($p);
        $id_proforma = $proforma_model->registrar_proforma ($p_prof, $p_dprof);
    
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
