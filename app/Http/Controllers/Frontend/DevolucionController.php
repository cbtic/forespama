<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Devolucione;
use App\Models\DevolucionDetalle;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Kardex;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use Auth;

class DevolucionController extends Controller
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

		$empresa = Empresa::all();
		
		return view('frontend.devolucion.create',compact('empresa'));

	}

    public function listar_devolucion_ajax(Request $request){

		$devolucion_model = new Devolucione;
		$p[]=$request->empresa;
		$p[]=$request->fecha;
        $p[]=$request->numero_devolucion;
        $p[]=$request->numero_orden_compra_cliente;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $devolucion_model->listar_devolucion_ajax($p);
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

    public function modal_devolucion($id){
		
		$id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
		
		if($id>0){
			$devolucion = Devolucione::find($id);
		}else{
			$devolucion = new Devolucione;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(31);
        $producto = $producto_model->getProductoExterno();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
        $almacen_destino = $almacen_model->getAlmacenAll();
        $empresa = Empresa::All();
		//var_dump($id);exit();

		return view('frontend.devolucion.modal_devolucion_nuevoDevolucion',compact('id','devolucion','unidad_medida','moneda','estado_bien','tipo_producto','unidad','marca','producto','tipo_documento','almacen_destino','id_user','empresa','igv_compra'));

    }

	public function send_devolucion(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$devolucion = new Devolucione;
            //$dispensacion_model = new Dispensacione;
            //$correlativo = $dispensacion_model->getCorrelativo();
            //$dispensacion->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$devolucion = Devolucione::find($request->id);
		}

		$item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $id_ingreso_produccion_detalle =$request->id_ingreso_produccion_detalle;
		
		$ingreso_produccion->id_tipo_documento = $request->tipo_documento;
        $ingreso_produccion->id_almacen_destino = $request->almacen_destino;
        $ingreso_produccion->fecha = $request->fecha;
        $ingreso_produccion->codigo = $request->numero_ingreso_produccion;
        $ingreso_produccion->producto_defectuoso = $request->input('producto_defectuoso', 0) == '1' ? 1 : 0;
		$ingreso_produccion->observacion = $request->observacion;
        $ingreso_produccion->id_usuario_inserta = $id_user;
		$ingreso_produccion->estado = 1;
		$ingreso_produccion->save();

		foreach($item as $index => $value) {
            
            if($id_ingreso_produccion_detalle[$index] == 0){
                $ingreso_produccion_detalle = new IngresoProduccionDetalle;
            }else{
                $ingreso_produccion_detalle = IngresoProduccionDetalle::find($id_ingreso_produccion_detalle[$index]);
            }
            
            $ingreso_produccion_detalle->id_ingreso_produccion = $ingreso_produccion->id;
            $ingreso_produccion_detalle->id_producto = $descripcion[$index];
            $ingreso_produccion_detalle->cantidad = $cantidad[$index];
            $ingreso_produccion_detalle->id_estado_producto = $estado_bien[$index];
            $ingreso_produccion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$ingreso_produccion_detalle->id_marca = (int)$marca[$index];
			}
            $ingreso_produccion_detalle->estado = 1;
            $ingreso_produccion_detalle->id_usuario_inserta = $id_user;

            $ingreso_produccion_detalle->save();

			if($id_ingreso_produccion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->entradas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				$kardex->id_almacen_destino = $request->almacen_destino;
				$kardex->id_ingreso_produccion = $ingreso_produccion->id;

				$kardex->save();
			}else{
				/*$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex_dispensacion = Kardex::where("id_dispensacion",$dispensacion->id)->where("id_producto",$descripcion[$index])->orderBy('id', 'desc')->first();
				//dd($kardex_dispensacion);exit();
				$kardex = kardex::find($kardex_dispensacion->id);

				//$kardex->id_producto = $descripcion[$index];
				//$kardex->salidas_cantidad = $cantidad[$index];
				if($kardex_dispensacion->salidas_cantidad>$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad - ($kardex_dispensacion->salidas_cantidad - $cantidad[$index]);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad<$cantidad[$index]){
					$cantidad_saldo = $kardex_dispensacion->saldos_cantidad + ($cantidad[$index] - $kardex_dispensacion->salidas_cantidad);
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else if($kardex_dispensacion->salidas_cantidad==$cantidad[$index]){
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				//$kardex->saldos_cantidad = $cantidad[$index];
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;

				$kardex->save();*/
			}
        }

        return response()->json(['success' => 'Ingreso a Produccion guardado exitosamente.']);

    }

    public function cargar_salida($numero_salida)
    {

        $devolucion_model = new Devolucione;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $devolucion = $devolucion_model->getDetalleDevolucionId($numero_salida);
        $marca = $marca_model->getMarcaAll();
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $descuento = $tablaMaestra_model->getMaestroByTipo(55);

        return response()->json([
            'devolucion' => $devolucion,
            'marca' => $marca,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida,
            'descuento' => $descuento
        ]);
    }
}
