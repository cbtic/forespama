<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\PromotorRuta;
use App\Models\Tienda;
use App\Models\User;
use App\Models\AsistenciaPromotore;
use Auth;
use Carbon\Carbon;

class PromotorController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create_ruta(){
		
		return view('frontend.promotores.create_ruta');

	}

    public function listar_promotor_ruta_ajax(Request $request){

		$promotor_ruta_model = new PromotorRuta;
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
		$data = $promotor_ruta_model->listar_promotor_ruta_ajax($p);
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

    public function modal_promotor_ruta($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $tienda_model = new Tienda;
        $user_model = new User;
		
		if($id>0){

            $promotor_ruta = PromotorRuta::find($id);
			
		}else{
			$promotor_ruta = new PromotorRuta;
		}

        $dia_semana = $tablaMaestra_model->getMaestroByTipo(2);
        $tiendas = $tienda_model->getTiendasAll();
        $promotores = $user_model->getUserByRol(7,11);

		return view('frontend.promotores.modal_promotor_nuevoPromotorRuta',compact('id','promotor_ruta','dia_semana','tiendas','promotores'));

    }

	public function send_promotor_ruta(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$promotor_ruta = new PromotorRuta;
		}else{
			$promotor_ruta = PromotorRuta::find($request->id);
		}

		$fecha = $request->input('fecha');
        $tienda = $request->input('tienda');
        $hora_llegada = $request->input('hora_llegada');
        $hora_salida = $request->input('hora_salida');
        $hora_estado_situacional = $request->input('hora_estado_situacional');
        $hora_estado_promocion = $request->input('hora_estado_promocion');

        $id_promotor_ruta_detalle =$request->id_promotor_ruta_detalle;
		
		$promotor_ruta->id_usuario = $request->tipo_documento;
		$promotor_ruta->estado = 1;
        $dispensacion->id_usuario_inserta = $id_user;
		$dispensacion->save();

		foreach($fecha as $index => $value) {
            
            if($id_dispensacion_detalle[$index] == 0){
                $dispensacion_detalle = new DispensacionDetalle;
            }else{
                $dispensacion_detalle = DispensacionDetalle::find($id_dispensacion_detalle[$index]);
            }
            
            $dispensacion_detalle->id_dispensacion = $dispensacion->id;
            $dispensacion_detalle->id_producto = $descripcion[$index];
            $dispensacion_detalle->cantidad = $cantidad[$index];
            //$dispensacion_detalle->precio = $precio_unitario[$index];
            //$dispensacion_detalle->sub_total = $sub_total[$index];
            //$dispensacion_detalle->igv = $igv[$index];
            //$dispensacion_detalle->total = $total[$index];
            //$dispensacion_detalle->fecha_fabricacion = $fecha_fabricacion[$index];
            //$dispensacion_detalle->fecha_vencimiento = $fecha_vencimiento[$index];
            $dispensacion_detalle->id_estado_producto = $estado_bien[$index];
            $dispensacion_detalle->id_unidad_medida = $unidad[$index];
			if($marca[$index]!=null && $marca[$index] !=0){
				$dispensacion_detalle->id_marca = (int)$marca[$index];
			}
            //$dispensacion_detalle->id_marca = $marca[$index] != null ? $marca[$index] : null;
            $dispensacion_detalle->estado = 1;
            //$dispensacion_detalle->cerrado = 1;
            $dispensacion_detalle->id_usuario_inserta = $id_user;

            $dispensacion_detalle->save();

			if($id_dispensacion_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->salidas_cantidad = $cantidad[$index];
				//kardex->costo_salidas_cantidad = $precio_unitario[$index];
				//$kardex->total_salidas_cantidad = $total[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad - $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
					//$kardex->costo_saldos_cantidad = $producto->costo_unitario;
					//$total_kardex = $cantidad_saldo * $producto->costo_unitario;
					//$kardex->total_saldos_cantidad = $total_kardex;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
					//$kardex->costo_saldos_cantidad = $producto->costo_unitario;
					//$total_kardex = $cantidad_ingreso[$index] * $producto->costo_unitario;
					//$kardex->total_saldos_cantidad = $total_kardex;
				}
				//$kardex->id_entrada_producto = $entrada_producto->id;
				$kardex->id_almacen_destino = $request->almacen;
				$kardex->id_dispensacion = $dispensacion->id;

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

        return response()->json(['success' => 'Dispensaci&oacute;n guardada exitosamente.']);

    }

	public function create_asistencia(){

		$tienda_model = new Tienda;

        $tiendas = $tienda_model->getTiendasAll();

	return view('frontend.promotores.create_asistencia',compact('tiendas'));

	}

	public function marcar_asistencia(Request $request)
	{
		$id_user = Auth::user()->id;
		$rutaFinal = null;

		$tienda = Tienda::find($request->id_tienda);

		$distancia = $this->calcularDistancia($tienda->latitud, $tienda->longitud, $request->latitud, $request->longitud);

		if ($distancia > 0.5) { // 0.2 km = 200 metros
			return response()->json(['message' => 'No estás dentro del rango permitido para marcar asistencia.']);
		}

		if ($request->has('foto_base64')) {

			$imageData = $request->foto_base64;
			
			if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
				$extension = strtolower($type[1]);

				if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
					throw new \Exception('Formato de imagen no válido. Solo se permiten JPG o PNG.');
				}

				$imageData = substr($imageData, strpos($imageData, ',') + 1);
				$imageData = base64_decode($imageData);

				if ($imageData === false) {
					throw new \Exception('Error al decodificar la imagen.');
				}

				$path = public_path("img/asistencias/");
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}

				$filename = 'asistencia_' . date("YmdHis") . substr((string)microtime(), 1, 6) . '.' . $extension;

				file_put_contents($path . $filename, $imageData);

				$rutaFinal = "img/asistencias/" . $filename;

				$imagePath = public_path($rutaFinal);
			} else {
				throw new \Exception('El formato base64 de la imagen es incorrecto.');
			}
		}

		//dd($rutaFinal);exit();

		$asistencia_promotor = new AsistenciaPromotore;
		$asistencia_promotor->id_promotor = $id_user;
		$asistencia_promotor->id_tienda = $request->id_tienda;
		$asistencia_promotor->fecha = now()->toDateString();
		$asistencia_promotor->hora_entrada = now()->format('H:i:s');
		//$asistencia->hora_salida = now()->format('H:i:s');
		$asistencia_promotor->ip = $request->ip();
		$asistencia_promotor->latitud = $request->latitud;
		$asistencia_promotor->longitud = $request->longitud;
		$asistencia_promotor->ruta_imagen_ingreso = $rutaFinal;
		$asistencia_promotor->id_usuario_inserta = $id_user;
		$asistencia_promotor->save();

		return response()->json(['message' => 'Asistencia marcada correctamente.']);
	}

	public function listar_asistencia_promotores_ajax(Request $request){

		$id_user = Auth::user()->id;

		$asistencia_promotor_model = new AsistenciaPromotore;
		$p[]=$request->fecha;
		$p[]=$id_user;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asistencia_promotor_model->listar_asistencia_promotores_ajax($p);
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

	public function modal_asistencia_promotor(){
		
        $tienda_model = new Tienda;

        $tiendas = $tienda_model->getTiendasAll();

		return view('frontend.promotores.modal_asistencia_promotor',compact('tiendas'));

    }

	public function calcularDistancia($lat1, $lon1, $lat2, $lon2)
	{
		$radioTierra = 6371;
		$dLat = deg2rad($lat2 - $lat1);
		$dLon = deg2rad($lon2 - $lon1);
		$a = sin($dLat/2) * sin($dLat/2) +
			cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
			sin($dLon/2) * sin($dLon/2);
		$c = 2 * atan2(sqrt($a), sqrt(1-$a));
		return $radioTierra * $c;
	}
}
