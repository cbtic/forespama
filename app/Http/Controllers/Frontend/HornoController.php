<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\IngresoHorno;
use App\Models\Persona;
use App\Models\Almacene;
use App\Models\ProduccionAcerradoMadera;
use App\Models\ProduccionAcerradoMaderaDetalle;
use App\Models\ProductoAcerrado;
use App\Models\Kardex;
use App\Models\HornoDetalle;
use Auth;
use Carbon\Carbon;

class HornoController extends Controller
{
    public function __construct(){

		/*$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});*/

		$this->middleware('auth');
		$this->middleware('can:Horno')->only(['create']);
	}

    public function create(){
		
		return view('frontend.horno.create');

	}

    public function listar_ingreso_horno_ajax(Request $request){

		$ingreso_horno_model = new IngresoHorno;
		$p[]=$request->fecha;
        $p[]=1;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_horno_model->listar_ingreso_horno_ajax($p);
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

    public function modal_ingreso_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        //$empresa_cubicaje_model = new EmpresaCubicaje;
        $persona_model = new Persona;
		$almacen_model = new Almacene;

		if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();
		$almacen = $almacen_model->getAlmacenAll();

		return view('frontend.horno.modal_horno_nuevoIngresoHorno',compact('id','ingreso_horno','horno','operador','almacen'));

    }

	public function modal_salida_horno($id){
		
		$tabla_maestra_model = new TablaMaestra;
        //$empresa_cubicaje_model = new EmpresaCubicaje;
        $persona_model = new Persona;
		$almacen_model = new Almacene;

		if($id>0){
			$ingreso_horno = IngresoHorno::find($id);
		}else{
			$ingreso_horno = new IngresoHorno;
		}

		$horno = $tabla_maestra_model->getMaestroByTipo('83');
		//$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        //$letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();
        $operador = $persona_model->obtenerPersonaAll();
		$almacen = $almacen_model->getAlmacenAll();

		return view('frontend.horno.modal_horno_nuevoSalidaHorno',compact('id','ingreso_horno','horno','operador','almacen'));

    }

    public function send_ingreso_horno(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$ingreso_horno = new IngresoHorno;
		}else{
			$ingreso_horno = IngresoHorno::find($request->id);
		}

		$fecha_produccion = $request->input('fecha_produccion');
		$tipo_madera = $request->input('tipo_madera');
		$id_tipo_madera = $request->input('id_tipo_madera');
		$medida = $request->input('medida');
		$id_medida = $request->input('id_medida');
		$cantidad_paquete = $request->input('cantidad_paquete');
		$medida1 = $request->input('medida1');
		$medida2 = $request->input('medida2');
		$total_n_piezas = $request->input('total_n_piezas');
		$cantidad_paquete_ingreso = $request->input('cantidad_paquete_ingreso');
		$ingreso_horno_ = $request->input('ingreso_horno');
		$totalIngresoHorno = $request->input('total_ingreso_horno');
        $id_acerrado_detalle =$request->id_acerrado_detalle;

        $ingreso_horno->id_numero_horno = $request->horno;
        $ingreso_horno->fecha_encendido = $request->fecha;
        $ingreso_horno->hora_encendido = $request->hora_encendido;
        $ingreso_horno->temperatura_inicio = $request->temperatura_inicio;
        $ingreso_horno->humedad_inicio = $request->humedad_inicio;
        $ingreso_horno->id_operador_inicio = $request->operador;
        $ingreso_horno->total_ingreso = $totalIngresoHorno;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_inserta = $id_user;
		$ingreso_horno->save();
		$id_ingreso_horno = $ingreso_horno->id;

		$array_ingreso_horno_detalle = array();

		foreach($tipo_madera as $index => $value) {
            
			if($cantidad_paquete_ingreso[$index] != "" || $cantidad_paquete_ingreso[$index] > 0){

				$produccionAcerradoMaderaDetalleAll = ProduccionAcerradoMaderaDetalle::where('id',$id_acerrado_detalle[$index])->where('estado',1)->first();

				if($total_n_piezas[$index] <= $ingreso_horno_[$index]){
					$produccionAcerradoMaderaDetalleAll->estado_produccion_acerrado = 0;
					$produccionAcerradoMaderaDetalleAll->save();
				}else{
					$produccionAcerradoMaderaDetalleAll->cantidad_pendiente = $cantidad_paquete[$index] - $cantidad_paquete_ingreso[$index];
					$produccionAcerradoMaderaDetalleAll->save();
				}

				$producto_acerrado_model = new ProductoAcerrado;
				$producto_acerrado = $producto_acerrado_model->getProductoByTipoMaderaMedida($id_tipo_madera[$index], $id_medida[$index]);

				if (empty($producto_acerrado)) {
					continue;
				}

				$idProducto = $producto_acerrado[0]->id_producto;

				$horno_detalle = new HornoDetalle;
            
				$horno_detalle->id_ingreso_horno = $id_ingreso_horno;
				$horno_detalle->id_producto = $idProducto;
				$horno_detalle->cantidad = $ingreso_horno_[$index];
				$horno_detalle->estado = 1;
				$horno_detalle->id_usuario_inserta = $id_user;
				$horno_detalle->save();

				$array_ingreso_horno_detalle[] = $horno_detalle->id;

				/*$IngresoHornoDetalleAll = HornoDetalle::where('id',$id_ingreso_horno[$index])->where('estado',1)->first();

				if($cantidad_ingreso_produccion[$index] == $cantidad_ingreso[$index]){
					$IngresoVehiculoTroncoTipoMaderaAll->estado_acerrado = 0;
					$IngresoVehiculoTroncoTipoMaderaAll->save();
				}*/

				$idCorte = Kardex::where('id_producto', $idProducto)->where('id_almacen_destino', 22)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
				
				$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

				$kardex = new Kardex;
				$kardex->id_producto = $idProducto;
				$kardex->id_almacen_destino = 22;
				$kardex->fecha = $request->fecha;

				$kardex->entradas_cantidad = 0;
				$kardex->salidas_cantidad = $ingreso_horno_[$index];

				$kardex->saldos_cantidad = $saldoBase - $ingreso_horno_[$index];

				$kardex->id_ingreso_vehiculo_tronco = $id_ingreso_horno;
				//$kardex->fecha = $request->fecha;
				$kardex->id_usuario_inserta = $id_user;
				$kardex->save();

				$idProducto_ = $producto_acerrado[0]->id_producto;

				$idCorte_ = Kardex::where('id_producto', $idProducto_)->where('id_almacen_destino', 23)->whereDate('fecha', '<=', $request->fecha)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
				
				$saldoBase_ = $idCorte_ > 0 ? Kardex::where('id', $idCorte_)->value('saldos_cantidad') : 0;

				$kardex_ = new Kardex;
				$kardex_->id_producto = $idProducto_;
				$kardex_->id_almacen_destino = 23;
				$kardex_->fecha = $request->fecha;

				$kardex_->entradas_cantidad = $ingreso_horno_[$index];
				$kardex_->salidas_cantidad = 0;

				$kardex_->saldos_cantidad = $saldoBase_ + $ingreso_horno_[$index];

				$kardex_->id_ingreso_vehiculo_tronco = $id_ingreso_horno;
				//$kardex->fecha = $request->fecha;
				$kardex_->id_usuario_inserta = $id_user;
				$kardex_->save();
			
			}
		}

        return response()->json(['success' => 'Registro guardado exitosamente.']);

    }

	public function send_salida_horno(Request $request){

        $id_user = Auth::user()->id;

		//if($request->id == 0){
			//$ingreso_horno = new IngresoHorno;
		//}else{
			$ingreso_horno = IngresoHorno::find($request->id);
		//}

        $ingreso_horno->fecha_apagado = $request->fecha_salida;
        $ingreso_horno->hora_apagado = $request->hora_apagado;
        $ingreso_horno->humedad_apagado = $request->humedad_fin;
        $ingreso_horno->id_operador_apagado = $request->operador_salida;
        $ingreso_horno->observacion = $request->observacion;
		$ingreso_horno->estado_ingreso_horno = 0;
		$ingreso_horno->estado = 1;
        $ingreso_horno->id_usuario_actualiza = $id_user;
		$ingreso_horno->save();
		$id_ingreso_horno = $ingreso_horno->id;

		$ingreso_horno_actualizado = HornoDetalle::where('id_ingreso_horno', $id_ingreso_horno)->where('estado', 1)->get();

		foreach($ingreso_horno_actualizado as $detalle) {

			$idProducto = $detalle->id_producto;

			$idCorte = Kardex::where('id_producto', $idProducto)->where('id_almacen_destino', 23)->whereDate('fecha', '<=', $request->fecha_salida)->orderBy('fecha', 'desc')->orderBy('id', 'desc')->value('id');
			
			$saldoBase = $idCorte > 0 ? Kardex::where('id', $idCorte)->value('saldos_cantidad') : 0;

			$kardex = new Kardex;
			$kardex->id_producto = $idProducto;
			$kardex->id_almacen_destino = 23;
			$kardex->fecha = $request->fecha;

			$kardex->entradas_cantidad = 0;
			$kardex->salidas_cantidad = $detalle->cantidad_salida;

			$kardex->saldos_cantidad = $saldoBase -  $detalle->cantidad_salida;

			$kardex->id_ingreso_vehiculo_tronco = $id_ingreso_horno;
			//$kardex->fecha = $request->fecha;
			$kardex->id_usuario_inserta = $id_user;
			$kardex->save();

		}

        return response()->json(['success' => 'Registro guardado exitosamente.']);

    }

    public function cargar_detalle_acerrado(){
		
		$produccion_acerrado_madera_model = new ProduccionAcerradoMadera;
		$detalle_acerrado = $produccion_acerrado_madera_model->getDetalleAcerrado();
		
		return response()->json([
			'detalle_acerrado' => $detalle_acerrado
		]);
	}
}
