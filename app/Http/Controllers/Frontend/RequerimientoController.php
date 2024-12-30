<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Marca;
use App\Models\Almacen_usuario;
use App\Models\RequerimientoDetalle;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraDetalle;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use Carbon\Carbon;

class RequerimientoController extends Controller
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
        $user_model = new User;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        //$proveedor = Empresa::all();
        $almacen = Almacene::all();
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $responsable_atencion = $user_model->getUserAll();
        
		return view('frontend.requerimiento.create',compact('tipo_documento','cerrado_requerimiento','almacen','id_user','estado_atencion','responsable_atencion'));

	}

    public function listar_requerimiento_ajax(Request $request){

		$requerimiento_model = new Requerimiento;
		$p[]=$request->tipo_documento;
        $p[]=$request->fecha;
        $p[]=$request->numero_requerimiento;
        $p[]=$request->almacen;
        $p[]=$request->situacion;
        $p[]=$request->responsable_atencion;
        $p[]=$request->estado_atencion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $requerimiento_model->listar_requerimiento_ajax($p);
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

    public function modal_requerimiento($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
		if($id>0){

            $requerimiento = Requerimiento::find($id);
		}else{
			$requerimiento = new Requerimiento;
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

        return view('frontend.requerimiento.modal_requerimiento_nuevoRequerimiento',compact('id','requerimiento','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen','id_user'));

    }

    public function send_requerimiento(Request $request)
    {
        $id_user = Auth::user()->id;

        if($request->id == 0){
            $requerimiento = new Requerimiento;
        }else{
            $requerimiento = Requerimiento::find($request->id);
        }

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        
        $id_requerimiento_detalle =$request->id_requerimiento_detalle;
        
        $requerimiento->id_tipo_documento = $request->tipo_documento;
        $requerimiento->fecha = $request->fecha_requerimiento;
        $requerimiento->codigo = $request->numero_requerimiento;
        $requerimiento->id_almacen_destino = $request->almacen;
        $requerimiento->sustento_requerimiento = $request->sustento_requerimiento;
        $requerimiento->responsable_atencion = $request->responsable;
        $requerimiento->estado_atencion = $request->estado_atencion;
        $requerimiento->id_unidad_origen = $request->unidad_origen;
        $requerimiento->id_almacen_salida = $request->almacen_salida;
        $requerimiento->cerrado = 1;
        $requerimiento->id_usuario_inserta = $id_user;
        $requerimiento->estado = 1;
        $requerimiento->save();

        $array_requerimiento_detalle = array();

        foreach($item as $index => $value) {
            
            if($id_requerimiento_detalle[$index] == 0){
                $requerimiento_detalle = new RequerimientoDetalle;
            }else{
                $requerimiento_detalle = RequerimientoDetalle::find($id_requerimiento_detalle[$index]);
            }
            
            $requerimiento_detalle->id_requerimiento = $requerimiento->id;
            $requerimiento_detalle->id_producto = $descripcion[$index];
            $requerimiento_detalle->cantidad = $cantidad_ingreso[$index];
            $requerimiento_detalle->id_estado_producto = $estado_bien[$index];
            $requerimiento_detalle->id_unidad_medida = $unidad[$index];
            $requerimiento_detalle->id_marca = $marca[$index];
            $requerimiento_detalle->estado = 1;
            $requerimiento_detalle->cerrado = 1;
            $requerimiento_detalle->id_usuario_inserta = $id_user;

            $requerimiento_detalle->save();

            $array_requerimiento_detalle[] = $requerimiento_detalle->id;

            $RequerimientoAll = RequerimientoDetalle::where("id_requerimiento",$requerimiento->id)->where("estado","1")->get();
            
            foreach($RequerimientoAll as $key=>$row){
                
                if (!in_array($row->id, $array_requerimiento_detalle)){
                    $requerimiento_detalle = RequerimientoDetalle::find($row->id);
                    $requerimiento_detalle->estado = 0;
                    $requerimiento_detalle->save();
                }
            }
        }

        return response()->json(['id' => $requerimiento->id]);
    }

    public function obtener_codigo_requerimiento($tipo_documento){
		
		$requerimiento_model = new Requerimiento;
		$codigo_requerimiento = $requerimiento_model->getCodigoRequerimiento($tipo_documento);
		
		return response()->json($codigo_requerimiento);
	}

    public function cargar_detalle($id)
    {

        $requerimiento_model = new Requerimiento;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $requerimiento = $requerimiento_model->getDetalleRequerimientoId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'requerimiento' => $requerimiento,
            'marca' => $marca,
            'producto' => $producto,
            'estado_bien' => $estado_bien,
            'unidad_medida' => $unidad_medida
        ]);
    }

    public function movimiento_pdf_requerimiento($id){

        $requerimiento_model = new Requerimiento;
        $requerimiento_detalle_model = new RequerimientoDetalle;

        $datos=$requerimiento_model->getRequerimientoById($id);
        $datos_detalle=$requerimiento_detalle_model->getDetalleRequerimientoPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
        $responsable_atencion=$datos[0]->responsable_atencion;
        $sustento_requerimiento=$datos[0]->sustento_requerimiento;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.requerimiento.movimiento_pdf_requerimiento',compact('tipo_documento','almacen','fecha','codigo','datos_detalle','responsable_atencion','sustento_requerimiento'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
	}

    public function send_requerimiento_orden_compra(Request $request)
    {
        $id_user = Auth::user()->id;

        $requerimiento = Requerimiento::find($request->id);

        $orden_compra = new OrdenCompra;

        $orden_compra_model = new OrdenCompra;
        $codigo_orden_compra = $orden_compra_model->getCodigoOrdenCompra(1);

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $cantidad_atendida = $request->input('cantidad_atendida');
        
        $id_requerimiento_detalle =$request->id_requerimiento_detalle;
        
        $orden_compra->id_empresa_compra = 30;
        $orden_compra->id_empresa_vende = 30;
        $orden_compra->fecha_orden_compra = Carbon::now()->toDateString();
        $orden_compra->numero_orden_compra = $codigo_orden_compra[0]->codigo;
        $orden_compra->id_tipo_documento = 1;
        $orden_compra->igv_compra = 2;
        $orden_compra->cerrado = 1;
        $orden_compra->id_unidad_origen = $request->unidad_origen;
        $orden_compra->id_almacen_destino = $request->almacen;
        $orden_compra->id_almacen_salida = $request->almacen_salida;
        $orden_compra->id_requerimiento = $request->id;
        $orden_compra->id_usuario_inserta = $id_user;
        $orden_compra->estado = 1;
        $orden_compra->save();

        $array_orden_compra_detalle = array();

        foreach($item as $index => $value) {
            
            $orden_compra_detalle = new OrdenCompraDetalle;
            
            $orden_compra_detalle->id_orden_compra = $orden_compra->id;
            $orden_compra_detalle->id_producto = $descripcion[$index];
            $orden_compra_detalle->cantidad_requerida = $cantidad_atendida[$index];
            $orden_compra_detalle->id_estado_producto = $estado_bien[$index];
            $orden_compra_detalle->id_unidad_medida = $unidad[$index];
            //$orden_compra_detalle->id_marca = $marca[$index] ?? '';
            if($marca[$index]!=null && $marca[$index] !=0){
				$orden_compra_detalle->id_marca = (int)$marca[$index];
			}
            $orden_compra_detalle->estado = 1;
            $orden_compra_detalle->cerrado = 1;
            $orden_compra_detalle->id_usuario_inserta = $id_user;

            $orden_compra_detalle->save();

            $array_orden_compra_detalle[] = $orden_compra_detalle->id;

        }

        $requerimiento->cerrado = 2;
        $requerimiento->estado_atencion = 3;
        $requerimiento->save();
        return response()->json(['id' => $orden_compra->id]);
    }

    public function modal_atender_requerimiento($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
        $user_model = new User;
		
		if($id>0){

            $requerimiento = Requerimiento::find($id);
            if($requerimiento->estado_atencion==1){
                $requerimiento->estado_atencion = 2;
            }
            $requerimiento->save();
            
		}else{
			$requerimiento = new Requerimiento;
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
        
        return view('frontend.requerimiento.modal_requerimiento_atenderRequerimiento',compact('id','requerimiento','tipo_documento','producto','marca','unidad','almacen','cerrado_requerimiento','estado_bien','estado_atencion','responsable_atencion','unidad_origen'));

    }

}
