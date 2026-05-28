<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RequerimientoDispensacione;
use App\Models\RequerimientoDispensacionDetalle;
use App\Models\TablaMaestra;
use App\Models\AreaTrabajo;
use App\Models\UnidadTrabajo;
use App\Models\Persona;
use App\Models\Almacene;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Sede;
use App\Models\Kardex;
use App\Models\Dispensacione;
use App\Models\DispensacionDetalle;
use Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RequerimientoDispensacionController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Requerimiento Insumos')->only(['create']);
	}

    public function create(){
		
        $tablaMaestra_model = new TablaMaestra;
		$area_trabajo_model = new AreaTrabajo;
		$almacen_model = new Almacene;
		$persona_model = new Persona;
		$sede_model = new Sede;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $almacen = $almacen_model->getAlmacenAll();
		$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$persona = $persona_model->obtenerPersonaAll();
        $sede = $sede_model->getSedeAll();
        $cerrado = $tablaMaestra_model->getMaestroByTipo(52);

		return view('frontend.requerimiento_dispensacion.create',compact('tipo_documento','almacen','sede','persona','cerrado'));

	}

    public function listar_requerimiento_dispensacion_ajax(Request $request){

		$requerimiento_dispensacion_model = new RequerimientoDispensacione;
		$p[]=$request->tipo_documento;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->numero_requerimiento_dispensacion;
		$p[]=$request->almacen;
		$p[]=$request->sede;
		$p[]=$request->centro_costo;
		$p[]=$request->persona_recibe;
		$p[]=$request->situacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $requerimiento_dispensacion_model->listar_requerimiento_dispensacion_ajax($p);
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

    public function modal_requerimiento_dispensacion($id){
		
        $id_user = Auth::user()->id;
		$tabla_maestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
		//$area_trabajo_model = new AreaTrabajo;
		$persona_model = new Persona;
        $sede_model = new Sede;

		if($id>0){
			$requerimiento_dispensacion = RequerimientoDispensacione::find($id);
		}else{
			$requerimiento_dispensacion = new RequerimientoDispensacione;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tabla_maestra_model->getMaestroByTipo(43);
        $tipo_documento = $tabla_maestra_model->getMaestroByTipo(59);
        $almacen = $almacen_model->getAlmacenAll();
		//$area_trabajo = $area_trabajo_model->getAreaTrabajoAll();
		$sede = $sede_model->getSedeAll();
		$persona = $persona_model->obtenerPersonaAll();

		return view('frontend.requerimiento_dispensacion.modal_requerimiento_dispensacion_nuevoRequerimientoDispensacion',compact('id','requerimiento_dispensacion','id_user','tipo_marca','producto','marca','unidad','tipo_documento','almacen',/*'area_trabajo',*/'persona','sede'));

    }

    public function send_requerimiento_dispensacion(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$requerimiento_dispensacion = new RequerimientoDispensacione;
			$requerimiento_dispensacion_model = new RequerimientoDispensacione;
            $codigo_requerimiento_dispensacion = $requerimiento_dispensacion_model->getCodigoRequerimientoDispensacion();
		}else{
			$requerimiento_dispensacion = RequerimientoDispensacione::find($request->id);
            $codigo_requerimiento_dispensacion = $request->numero_requerimiento_insumo;
		}
		
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad');
        
        $id_requerimiento_dispensacion_detalle =$request->id_requerimiento_dispensacion_detalle;
        
        $requerimiento_dispensacion->id_tipo_documento = $request->tipo_documento;
        $requerimiento_dispensacion->fecha = $request->fecha_requerimiento;
        if($request->id == 0){
            $requerimiento_dispensacion->codigo = $codigo_requerimiento_dispensacion[0]->codigo;
        }else{
            $requerimiento_dispensacion->codigo = $codigo_requerimiento_dispensacion;
        }
        $requerimiento_dispensacion->id_almacen = $request->almacen;
        $requerimiento_dispensacion->fecha = $request->fecha;
        $requerimiento_dispensacion->id_sede = $request->sede;
        $requerimiento_dispensacion->id_centro_costo = $request->centro_costo;
        $requerimiento_dispensacion->aprobado = 1;
        $requerimiento_dispensacion->id_usuario_aprueba = $id_user;
        $requerimiento_dispensacion->id_persona = $request->persona_recibe;
        $requerimiento_dispensacion->id_usuario_inserta = $id_user;
        $requerimiento_dispensacion->estado = 1;
        $requerimiento_dispensacion->save();

        $id_requerimiento_dispensacion = $requerimiento_dispensacion->id;

        $array_requerimiento_dispensacion_detalle = array();

        foreach($descripcion as $index => $value) {
            
            if($id_requerimiento_dispensacion_detalle[$index] == 0){
                $requerimiento_dispensacion_detalle = new RequerimientoDispensacionDetalle;
            }else{
                $requerimiento_dispensacion_detalle = RequerimientoDispensacionDetalle::find($id_requerimiento_dispensacion_detalle[$index]);
            }
            
            $requerimiento_dispensacion_detalle->id_requerimiento_dispensacion = $id_requerimiento_dispensacion;
            $requerimiento_dispensacion_detalle->id_producto = $descripcion[$index];
            $requerimiento_dispensacion_detalle->cantidad = $cantidad_ingreso[$index];
            $requerimiento_dispensacion_detalle->id_unidad_medida = $unidad[$index];
            //$requerimiento_dispensacion_detalle->id_marca = $marca[$index];
            if($marca[$index]!=null && $marca[$index] !=0){
				$requerimiento_dispensacion_detalle->id_marca = (int)$marca[$index];
			}
            $requerimiento_dispensacion_detalle->estado = 1;
            $requerimiento_dispensacion_detalle->id_usuario_inserta = $id_user;

            $requerimiento_dispensacion_detalle->save();

            $array_requerimiento_dispensacion_detalle[] = $requerimiento_dispensacion_detalle->id;

            /*$RequerimientoAll = RequerimientoDetalle::where("id_requerimiento",$requerimiento->id)->where("estado","1")->get();
            
            foreach($RequerimientoAll as $key=>$row){
                
                if (!in_array($row->id, $array_requerimiento_detalle)){
                    $requerimiento_detalle = RequerimientoDetalle::find($row->id);
                    $requerimiento_detalle->estado = 0;
                    $requerimiento_detalle->save();
                }
            }*/
        }

        return response()->json(['success' => 'Requerimiento de Insumos guardado exitosamente.']);

    }

    public function cargar_detalle($id)
    {

        $requerimiento_dispensacion_model = new RequerimientoDispensacione;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $requerimiento_dispensacion = $requerimiento_dispensacion_model->getDetalleRequerimientoDispensacionId($id);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        $producto_stock = [];

        foreach($requerimiento_dispensacion as $detalle){
            $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto, $detalle->id_almacen);
            if(count($stock)>0){
                $producto_stock[$detalle->id_producto] = $stock[0];
            }else {
                $producto_stock[$detalle->id_producto] = ['saldos_cantidad'=>0];
            }
        }

        return response()->json([
            'requerimiento_dispensacion' => $requerimiento_dispensacion,
            'marca' => $marca,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function eliminar_requerimiento_dispensacion($id,$estado)
    {
		$requerimiento_dispensacion = RequerimientoDispensacione::find($id);

		$requerimiento_dispensacion->estado = $estado;
		$requerimiento_dispensacion->save();

		echo $requerimiento_dispensacion->id;
    }

    public function modal_atender_requerimiento_dispensacion($id){
        
        $id_user = Auth::user()->id;
		$tabla_maestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $almacen_model = new Almacene;
		$persona_model = new Persona;
        $sede_model = new Sede;

		if($id>0){
			$requerimiento_dispensacion = RequerimientoDispensacione::find($id);
		}else{
			$requerimiento_dispensacion = new RequerimientoDispensacione;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tabla_maestra_model->getMaestroByTipo(43);
        $tipo_documento = $tabla_maestra_model->getMaestroByTipo(53);
        $almacen = $almacen_model->getAlmacenAll();
		$sede = $sede_model->getSedeAll();
		$persona = $persona_model->obtenerPersonaAll();
        
		return view('frontend.requerimiento_dispensacion.modal_requerimiento_dispensacion_detalleAtenderRequerimientoDispensacion',compact('id','requerimiento_dispensacion','id_user','tipo_marca','producto','marca','unidad','tipo_documento','almacen','persona','sede'));

    }

    public function send_aprobar_requerimiento_dispensacion(Request $request){

        $id_user = Auth::user()->id;

        $requerimiento_dispensacion = RequerimientoDispensacione::find($request->id);
        $requerimiento_dispensacion->aprobado = 1;
        $requerimiento_dispensacion->id_usuario_aprueba = $id_user;
        $requerimiento_dispensacion->save();
        
        return response()->json(['id' => $request->id]);
        
    }

    public function send_dispensacion_producto(Request $request){

		$id_user = Auth::user()->id;

		//if($request->id == 0){
			$dispensacion = new Dispensacione;
			$dispensacion_model = new Dispensacione;
		    $codigo_dispensacion = $dispensacion_model->getCodigoDispensacion('2');
		//}else{
			//$dispensacion = Dispensacione::find($request->id);
            //$codigo_dispensacion = $request->numero_dispensacion;
		//}

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $id_requerimiento_dispensacion_detalle =$request->id_requerimiento_dispensacion_detalle;
		
		$dispensacion->id_tipo_documento = $request->tipo_documento;
		$dispensacion->id_requerimiento_dispensacion = $request->id;
		$dispensacion->id_sede = $request->sede;
        $dispensacion->id_almacen = $request->almacen;
        $dispensacion->id_centro_costo = $request->centro_costo;
        $dispensacion->fecha = $request->fecha;
		//if($request->id == 0){
            $dispensacion->codigo = $codigo_dispensacion[0]->codigo;
        //}else{
            //$dispensacion->codigo = $codigo_dispensacion;
        //}
		$dispensacion->id_usuario_recibe = $request->persona_recibe;
        $dispensacion->id_usuario_inserta = $id_user;
		$dispensacion->estado = 1;
		$dispensacion->save();
        $id_dispensacion = $dispensacion->id;

        $requerimiento_dispensacion = RequerimientoDispensacione::find($request->id);
        $requerimiento_dispensacion->cerrado = 2;
        $requerimiento_dispensacion->id_sede = $request->sede;
        $requerimiento_dispensacion->id_centro_costo = $request->centro_costo;
        $requerimiento_dispensacion->id_persona = $request->persona_recibe;
        $requerimiento_dispensacion->save();

		foreach($descripcion as $index => $value) {
            
            //if($id_requerimiento_dispensacion_detalle[$index] == 0){
                $dispensacion_detalle = new DispensacionDetalle;
            //}else{
                //$dispensacion_detalle = DispensacionDetalle::find($id_requerimiento_dispensacion_detalle[$index]);
            //}
            
            $dispensacion_detalle->id_dispensacion = $id_dispensacion;
            $dispensacion_detalle->id_producto = $descripcion[$index];
            $dispensacion_detalle->cantidad = $cantidad[$index];
            $dispensacion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$dispensacion_detalle->id_marca = (int)$marca[$index];
			}
            $dispensacion_detalle->estado = 1;
            $dispensacion_detalle->id_usuario_inserta = $id_user;

            $dispensacion_detalle->save();

			$producto = Producto::find($descripcion[$index]);

			//if($id_requerimiento_dispensacion_detalle[$index] == 0){
				
				$idProducto = $descripcion[$index];
				
				$idCorte = Kardex::where('id_producto', $descripcion[$index])->where('id_almacen_destino', $request->almacen)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
                
				$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

				$kardex = new Kardex;
				$kardex->id_producto = $idProducto;
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->fecha = $request->fecha;

				$kardex->entradas_cantidad = 0;
				$kardex->salidas_cantidad = $cantidad[$index];

				$kardex->saldos_cantidad = $saldoBase - $cantidad[$index];

				$kardex->id_tipo_movimiento = 30;
				$kardex->id_movimiento = $dispensacion->id;
				$kardex->codigo_movimiento = $dispensacion->codigo;
				$kardex->id_usuario_inserta = $id_user;
				$kardex->save();

			//}
        }


        return response()->json(['success' => 'Dispensaci&oacute;n guardada exitosamente.']);

    }

    public function movimiento_pdf_requerimiento_dispensacion($id){

        $requerimiento_dispensacion_model = new RequerimientoDispensacione;
        $requerimiento_dispensacion_detalle_model = new RequerimientoDispensacionDetalle;

        $datos=$requerimiento_dispensacion_model->getRequerimientoDispensacionById($id);
        $datos_detalle=$requerimiento_dispensacion_detalle_model->getRequerimientoDetalleDispensacionPdf($id);

        $tipo_documento=$datos[0]->tipo_documento;
        $sede=$datos[0]->sede;
        $centro_costo = $datos[0]->centro_costo;
        $almacen=$datos[0]->almacen;
        $fecha = $datos[0]->fecha;
        $codigo=$datos[0]->codigo;
		$usuario_recibe=$datos[0]->usuario_recibe;
        
		$year = Carbon::now()->year;

		Carbon::setLocale('es');

		$carbonDate =Carbon::now()->format('d-m-Y');

		$currentHour = Carbon::now()->format('H:i:s');

		$pdf = Pdf::loadView('frontend.requerimiento_dispensacion.movimiento_pdf_requerimiento_dispensacion',compact('tipo_documento','sede','almacen','centro_costo','fecha','codigo','usuario_recibe','datos_detalle'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)

		$pdf->setPaper('A4', 'portrait');
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}
}
