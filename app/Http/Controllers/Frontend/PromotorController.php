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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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

		$id_user = Auth::user()->id;

		$tienda_model = new Tienda;
		$asistencia_promotor_model = new AsistenciaPromotore;
		$tablaMaestra_model = new TablaMaestra;

		$fecha_actual = Carbon::now()->format('d-m-Y');

		$asistencia_diaria = $asistencia_promotor_model->getHoraIngresoDiario($id_user,$fecha_actual);
        $empresa_retail = $tablaMaestra_model->getMaestroByTipo(110);

		$hora_ingreso = count($asistencia_diaria) > 0 ? $asistencia_diaria[0]->hora_entrada : '';
		//dd($hora_ingreso);exit();
        $tiendas = $tienda_model->getTiendasAll();

		$id=0;

		return view('frontend.promotores.create_asistencia',compact('tiendas','id','hora_ingreso','empresa_retail'));

	}

	public function marcar_asistencia(Request $request)
	{
		$id_user = Auth::user()->id;
		$rutaFinal = null;

		$tienda = Tienda::find($request->id_tienda);

		$distancia = $this->calcularDistancia($tienda->latitud, $tienda->longitud, $request->latitud, $request->longitud);

		if ($distancia > 0.5) { // 0.5 km = 500 metros
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

	public function marcar_asistencia_salida(Request $request)
	{
		$id_user = Auth::user()->id;
		$rutaFinal = null;

		$tienda = Tienda::find($request->id_tienda_salida);

		$distancia = $this->calcularDistancia($tienda->latitud, $tienda->longitud, $request->latitud, $request->longitud);

		if ($distancia > 0.5) { // 0.5 km = 500 metros
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

				$path = public_path("img/asistencias_salida/");
				if (!is_dir($path)) {
					mkdir($path, 0777, true);
				}

				$filename = 'asistencia_salida_' . date("YmdHis") . substr((string)microtime(), 1, 6) . '.' . $extension;

				file_put_contents($path . $filename, $imageData);

				$rutaFinal = "img/asistencias_salida/" . $filename;

				$imagePath = public_path($rutaFinal);
			} else {
				throw new \Exception('El formato base64 de la imagen es incorrecto.');
			}
		}

		//dd($request->id);exit();

		$asistencia_promotor = AsistenciaPromotore::find($request->id);

		//$asistencia_promotor = new AsistenciaPromotore;
		//$asistencia_promotor->id_promotor = $id_user;
		//$asistencia_promotor->id_tienda = $request->id_tienda;
		//$asistencia_promotor->fecha = now()->toDateString();
		//$asistencia_promotor->hora_entrada = now()->format('H:i:s');
		$asistencia_promotor->hora_salida = now()->format('H:i:s');
		$asistencia_promotor->ip = $request->ip();
		$asistencia_promotor->latitud_salida = $request->latitud;
		$asistencia_promotor->longitud_salida = $request->longitud;
		//$asistencia_promotor->ruta_imagen_ingreso = $rutaFinal;
		$asistencia_promotor->ruta_imagen_salida = $rutaFinal;
		$asistencia_promotor->id_usuario_actualiza = $id_user;
		$asistencia_promotor->save();

		return response()->json(['message' => 'Asistencia marcada correctamente.']);
	}

	public function listar_asistencia_promotores_ajax(Request $request){

		$id_user = Auth::user()->id;

		$asistencia_promotor_model = new AsistenciaPromotore;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$id_user;
		$p[]=$request->empresa_retail;
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

	public function modal_asistencia_promotor_salida(){
		
        $tienda_model = new Tienda;

        $tiendas = $tienda_model->getTiendasAll();

		return view('frontend.promotores.modal_asistencia_promotor_salida',compact('tiendas'));

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

	public function exportar_asistencia($empresa_retail, $fecha_inicio, $fecha_fin, $estado) {

		$id_user = Auth::user()->id;

		if($empresa_retail==0)$empresa_retail = "";
		if($fecha_inicio=="0")$fecha_inicio = "";
		if($fecha_fin=="0")$fecha_fin = "";
        if($estado==0)$estado = "";
        
		$asistencia_promotor_model = new AsistenciaPromotore;
		$p[]=$fecha_inicio;
		$p[]=$fecha_fin;
		$p[]=$id_user;
        $p[]=$empresa_retail;
        $p[]=$estado;
		$p[]=1;
		$p[]=1000;
		$data = $asistencia_promotor_model->listar_asistencia_promotores_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Promotor","Tienda","Fecha","Hora Ingreso","Hora Salida"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->promotor, $r->tienda, $r->fecha, $r->hora_entrada,$r->hora_salida));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_asistencia.xlsx');
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
        return ["N","Promotor","Tienda","Fecha","Hora Ingreso","Hora Salida"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:F1');

        $sheet->setCellValue('A1', "REPORTE DE ASISTENCIA PROMOTORES - FORESPAMA");
        $sheet->getStyle('A1:F1')->applyFromArray([
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

        $sheet->getStyle('A2:F2')->applyFromArray([
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

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
