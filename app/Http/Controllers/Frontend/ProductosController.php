<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests\ProductoRequest;
use App\Models\Producto;
use App\Models\TablaMaestra;
use App\Models\Marca;
use App\Models\EntradaProductoDetalle;
use App\Models\SalidaProductoDetalle;
use App\Models\Kardex;
use App\Models\ProductoImagene;
use App\Models\Familia;
use App\Models\SubFamilia;
use App\Models\Tienda;
use App\Models\Chopeo;
use App\Models\ChopeoDetalle;
use App\Models\EquivalenciaProducto;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use GuzzleHttp\Client;

class ProductosController extends Controller
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

		$tablaMaestra_model = new TablaMaestra;
        $familia_model = new Familia;

		$estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
		$tipo_origen_producto = $tablaMaestra_model->getMaestroByTipo(58);
		$tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $familia = $familia_model->getFamiliaAll();
		
		return view('frontend.productos.create',compact('estado_bien','tipo_origen_producto','tipo_producto','familia'));

	}

    public function listar_producto_ajax(Request $request){

		$producto_model = new Producto;
		$p[]=$request->serie;
		$p[]=$request->denominacion;
        $p[]=$request->codigo;
        $p[]=$request->estado_bien;
        $p[]=$request->tipo_origen_producto;
        $p[]=$request->tiene_imagen;
        $p[]=$request->familia;
        $p[]=$request->sub_familia;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $producto_model->listar_producto_ajax($p);
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

    public function modal_producto($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $familia_model = new Familia;
		
		if($id>0){
			$producto = Producto::find($id);
            $imagenes = ProductoImagene::where('id_producto', $id)->get();
		}else{
			$producto = new Producto;
            $imagenes = [];
		}

        $unidad_producto = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaProducto();
		$tipo_origen_producto = $tablaMaestra_model->getMaestroByTipo(58);
		$bien_servicio = $tablaMaestra_model->getMaestroByTipo(73);
        $familia = $familia_model->getFamiliaAll();
		$categoria = $tablaMaestra_model->getMaestroByTipo(102);
		$sub_categoria = $tablaMaestra_model->getMaestroByTipo(103);
		$modelo = $tablaMaestra_model->getMaestroByTipo(104);
		$packet = $tablaMaestra_model->getMaestroByTipo(105);
		$medida = $tablaMaestra_model->getMaestroByTipo(106);
        
		return view('frontend.productos.modal_productos_nuevoProducto',compact('id','producto','unidad_medida','moneda','estado_bien','tipo_producto','unidad_producto','marca','tipo_origen_producto','imagenes','bien_servicio','familia','categoria','sub_categoria','modelo','packet','medida'));

    }

    public function send_producto(Request $request){

		if($request->id == 0){
			$producto = new Producto;
            $producto_model = new Producto;
            $correlativo = $producto_model->getCorrelativo();
            $producto->numero_corrrelativo = $correlativo[0]->numero_correlativo;
            $codigo_producto = $producto_model->getCodigoProducto($request->familia, $request->sub_familia);
		}else{
			$producto = Producto::find($request->id);
            $codigo_producto = $request->codigo;
		}

        if($request->id == 0){

            $existe_producto_codigo = Producto::where('codigo', $codigo_producto[0]->codigo)->first();

            $existe_producto_serie = Producto::where('numero_serie', $request->numero_serie)->whereNotNull('numero_serie')->where('numero_serie', '!=', '')->first();

            if ($existe_producto_serie && $existe_producto_serie->id != $request->id) {
                return response()->json([
                'error' => 'El número de serie ya está registrado.'
                ]);
            }

            if ($existe_producto_codigo && $existe_producto_codigo->id != $request->id) {
                return response()->json([
                'error' => 'El código ya está registrado.'
                ]);
            }
        }

        $producto->id_tipo_origen_producto = $request->tipo_origen_producto;
		$producto->numero_serie = $request->numero_serie;
		if($request->id == 0){
            $producto->codigo = $codigo_producto[0]->codigo;
        }else{
            $producto->codigo = $codigo_producto;
        }
        $producto->denominacion = $request->denominacion;
        $producto->id_unidad_medida = $request->unidad_medida;
        $producto->stock_actual = $request->stock_actual;
        $producto->id_moneda = $request->moneda;
        $producto->id_familia = $request->familia;
        $producto->id_sub_familia = $request->sub_familia;
        $producto->fecha_vencimiento = $request->fecha_vencimiento;
        $producto->id_estado_bien = $request->estado_bien;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->observacion = "";
        $producto->costo_unitario = $request->costo_unitario;
        $producto->contenido = $request->contenido;
        $producto->id_unidad_producto = $request->unidad_producto;
        $producto->id_marca = $request->marca;
        $producto->bien_servicio = $request->bien_servicio;
        $producto->peso = $request->peso;
        $producto->id_categoria = $request->categoria;
        $producto->id_sub_categoria = $request->sub_categoria;
        $producto->id_modelo = $request->modelo;
        $producto->id_packet = $request->packet;
        $producto->id_medida = $request->medida;
		$producto->estado = 1;
		$producto->save();
        $id_producto = $producto->id; 

        //////////////////imagenes producto
		
		$path = "img/productos/".$producto->id;
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$img_foto = $request->img_foto;
        $id_img_foto = $request->id_img_foto;
        $imagenesExistentes = ProductoImagene::where('id_producto', $id_producto)->pluck('ruta_imagen')->toArray();
		
        if (isset($img_foto) && is_array($img_foto)) {
            $rutaNuevaImagen="";
            foreach($img_foto as $key=>$row){
                $rutaNuevaImagen="";
                if($row!=""){

                    //$rutaNuevaImagen = "img/productos/".$producto->id."/".$row;
                    $rutaNuevaImagen = $row;
                    /*
                    if(isset($id_img_foto[$key])){
                        $rutaNuevaImagen = $row;
                    }else{
                        $rutaNuevaImagen = "img/productos/".$producto->id."/".$row;
                    }
                    */

                    if (in_array($rutaNuevaImagen, $imagenesExistentes)) {
                        continue;
                    }
                    

                    $rutaImagenCompleta = public_path($rutaNuevaImagen);
                    if (file_exists($rutaImagenCompleta)) {
                        continue;
                    }
                    
                    $filepath_tmp = public_path('img/productos/tmp/');
                    $filepath_nuevo = public_path('img/productos/'.$producto->id.'/');
                    
                    if (file_exists($filepath_tmp.$row)) {
                        copy($filepath_tmp.$row, $filepath_nuevo.$row);
                    }
                    

                    if(isset($id_img_foto[$key])){
                        $id_img = $id_img_foto[$key];
                        $productoImagen = ProductoImagene::find($id_img);
                    }else{
                        $productoImagen = new ProductoImagene;
                    }
                    
                    $productoImagen->id_producto = $id_producto;
                    $productoImagen->ruta_imagen = $rutaNuevaImagen;
                    $productoImagen->estado = 1;
                    $productoImagen->save();
                }
                
            }
        }
		//////////////////

        $producto_ficha_tecnica = Producto::find($id_producto);

        $path = "img/ficha_tecnica_productos/";

        if(!is_dir($path)) {
            mkdir($path);
        }

        if(isset($_FILES["btnFichaTecnica"]) && $_FILES["btnFichaTecnica"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/ficha_tecnica_productos/".$producto->id;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "ficha_tecnica_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["btnFichaTecnica"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["btnFichaTecnica"]["tmp_name"], $filepath.$filenamefirma);

            $producto_ficha_tecnica->ruta_ficha_tecnica = $path."/".$filenamefirma;
            $producto_ficha_tecnica->save();
        }
        
        return response()->json(['success' => 'Producto guardado exitosamente.']);

    }

    public function eliminar_producto($id,$estado)
    {
		$producto = Producto::find($id);

		$producto->estado = $estado;
		$producto->save();

		echo $producto->id;
    }

    public function obtener_producto($id_producto){
        
		$producto_model = new Producto;
		$producto = $producto_model->getProductoById($id_producto);
		
		echo json_encode($producto);
	}

    public function obtener_producto_stock($id_producto, $tipo_movimiento){
        
        if($tipo_movimiento==1){

            /*$entrada_producto_detalle_model = new EntradaProductoDetalle;
            $kardex_model = new Kardex;

            $entrada_producto = $entrada_producto_detalle_model->getDetalleProductoId($id_producto);

            $producto_stock = [];

            foreach($entrada_producto as $detalle){
                $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto);
                if(count($stock)>0){
                    $producto_stock[$detalle->id_producto] = $stock[0];
                }else {
                    $producto_stock[$detalle->id_producto] = ['saldos_cantidad'=>0];
                }
            }*/

            $kardex_model = new Kardex;

            $stock = $kardex_model->getExistenciaProductoById($id_producto);

            $producto_stock = [];

            if(count($stock)>0){
                $producto_stock[$stock[0]->id_producto] = $stock[0];
            }else {
                $producto_stock[$stock[0]->id_producto] = ['saldos_cantidad'=>0];
            }

            return response()->json([
                'producto_stock' =>$producto_stock
            ]);
        }else if ($tipo_movimiento==2){

            $salida_producto_detalle_model = new SalidaProductoDetalle;
            $kardex_model = new Kardex;

            $entrada_producto = $salida_producto_detalle_model->getDetalleProductoId($id_producto);

		    $producto_stock = [];

            foreach($entrada_producto as $detalle){
                $stock = $kardex_model->getExistenciaProductoById($detalle->id_producto);
                if(count($stock)>0){
                    $producto_stock[$detalle->id_producto] = $stock[0];
                }else {
                    $producto_stock[$detalle->id_producto] = ['saldos_cantidad'=>0];
                }
            }
            return response()->json([
                'producto_stock' =>$producto_stock
            ]);
        }
	}

    public function obtener_producto_almacen($id_almacen){
        
		$producto_model = new Producto;
		$producto = $producto_model->getProductoByIdAlmacen($id_almacen);
		//dd($producto);exit();
		return response()->json($producto);
	}

    public function obtener_stock_producto($almacen, $id_producto)
    {

		$kardex_model = new Kardex;

        $producto_stock = [];

        //foreach($dispensacion as $detalle){
            $stock = $kardex_model->getExistenciaProductoById($id_producto, $almacen);
            if(count($stock)>0){
                $producto_stock[$id_producto] = $stock[0];
            }else {
                $producto_stock[$id_producto] = ['stock_comprometido'=>0];
            }
        //}

        return response()->json([
            //'dispensacion' => $dispensacion,
            'producto_stock' =>$producto_stock
        ]);
    }

    public function upload_producto(Request $request){
		
		$path = "img/productos";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$path = "img/productos/tmp";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
    	$filepath = public_path('img/productos/tmp/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
		
	}
	
	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}

    public function modal_ver_productos($id){
		 
		$producto_model = new Producto;
        $imagen_producto = $producto_model->getImagenProducto($id);
		
        return view('frontend.productos.modal_ver_productos',compact('imagen_producto'));
		
    }
    
    public function obtener_producto_tipo_denominacion($tipo, $denominacion){
        
		$producto_model = new Producto;
		$producto = $producto_model->getProductoTipoDen($tipo, $denominacion);
		//dd($producto);exit();
		return response()->json($producto);
	}

    public function exportar_listar_productos($tipo_origen_producto, $serie, $codigo, $denominacion, $estado_bien, $tipo_producto, $tiene_imagen, $estado, $familia, $sub_familia) {

		if($tipo_origen_producto==0)$tipo_origen_producto = "";
        if($serie=="0")$serie = "";
        if($codigo=="0")$codigo = "";
        if($denominacion=="0")$denominacion = "";
        if($estado_bien==0)$estado_bien = "";
        if($tipo_producto==0)$tipo_producto = "";
        if($tiene_imagen==0)$tiene_imagen = "";
        if($estado==0)$estado = "";
        if($familia==0)$familia = "";
        if($sub_familia==0)$sub_familia = "";

        $producto_model = new Producto;
		$p[]=$serie;
		$p[]=$denominacion;
        $p[]=$codigo;
        $p[]=$estado_bien;
        $p[]=$tipo_origen_producto;
        $p[]=$tiene_imagen;
        $p[]=$familia;
        $p[]=$sub_familia;
        $p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $producto_model->listar_producto_ajax($p);

		$variable = [];
		$n = 1;

		array_push($variable, array("N°","Id","Bien/Servicio","Tipo Origen Producto","Serie","Denominación","Código","Unidad Producto","Contenido","Unidad Medida","Marca","Familia","Sub Familia","Estado Bien","F. Vencimiento","Stock Minimo","Tiene Imagen","Estado"));
		
		foreach ($data as $r) {

            if($r->estado==1){$estado='ACTIVO';}
            if($r->estado==0){$estado='INACTIVO';}

            if($r->tiene_imagen==1){$tiene_imagen='SI';}
            if($r->tiene_imagen==0){$tiene_imagen='NO';}

			array_push($variable, array($n++,$r->id, $r->bien_servicio, $r->tipo_origen_producto, $r->numero_serie, $r->denominacion, $r->codigo, $r->unidad, $r->contenido, $r->unidad_medida, $r->marca, $r->familia, $r->sub_familia, $r->estado_bien, $r->fecha_vencimiento, $r->stock_minimo, $tiene_imagen, $estado));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'Lista_productos.xlsx');
		
    }

    public function create_chopeo_producto(){

		$tablaMaestra_model = new TablaMaestra;
        $tienda_model = new Tienda;
        $producto_model = new Producto;

		$competencia = $tablaMaestra_model->getMaestroByTipo(101);
        $tienda = $tienda_model->getTiendasAll();
        $producto = $producto_model->getProductoRetail();

		
		return view('frontend.productos.create_chopeo_producto',compact('competencia','tienda','producto'));

	}

    public function listar_chopeo_producto_ajax(Request $request){

		$producto_model = new Producto;
		$p[]=$request->tienda;
		$p[]=$request->producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $producto_model->listar_chopeo_producto_ajax($p);
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

    public function modal_chopeo_producto($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $tienda_model = new Tienda;
        $producto_model = new Producto;
		
		$chopeo = new Chopeo;

        $competencia = $tablaMaestra_model->getMaestroByTipo(101);
        $tienda = $tienda_model->getTiendasAll();
        $producto = $producto_model->getProductoRetail();
        
		return view('frontend.productos.modal_chopeo_productos_nuevoChopeoProducto',compact('id','chopeo','producto','competencia','tienda','producto'));

    }
    
    public function send_chopeo_producto(Request $request)
    {
        $id_user = Auth::user()->id;

        try {
            $request->validate([
                'btnPrecioDimfer' => 'file|mimes:jpg,jpeg,png',
            ]);

            //$path = $request->file('btnPrecioDimfer')->store('chopeos', 'public');

            if ($request->hasFile('btnPrecioDimfer')) {

                $path = public_path("img/chopeos/");
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }

                $filename = date("YmdHis") . substr((string)microtime(), 1, 6);
                $extension = $this->extension($_FILES["btnPrecioDimfer"]["name"]);

                move_uploaded_file($_FILES["btnPrecioDimfer"]["tmp_name"], $path . $filename . "." . $extension);

                $rutaFinal = "img/chopeos/" . $filename . "." . $extension;
            }

            $imagePath = public_path($rutaFinal);
            
            /*$keyFile = storage_path('app/google-key.json');

            //dd($rutaFinal);exit();

            $vision = new ImageAnnotatorClient([
                'credentials' => $keyFile,
            ]);

            $image = file_get_contents($imagePath);
            $response = $vision->textDetection($image);
            $texts = $response->getTextAnnotations();

            $vision->close();

            if (count($texts) === 0) {
                return response()->json(['error' => 'No se detectó texto en la imagen.']);
            }

            $texto = $texts[0]->getDescription();

            preg_match('/\b\d{6}[A-Za-z0-9]\b/', $texto, $matchNumero);
            $numero = $matchNumero[0] ?? null;

            preg_match('/S[\/I]?\s*([\d.,]+)/i', $texto, $matchPrecio);
            $precio = isset($matchPrecio[1]) ? str_replace(',', '.', $matchPrecio[1]) : null;

            if (!$numero || !$precio) {
                return response()->json(['error' => 'No se encontraron datos válidos en la imagen.']);
            }

            $equivalencia_producto = EquivalenciaProducto::where('codigo_empresa',$numero)->where('estado',1)->first();

            if (!$equivalencia_producto) {
                return response()->json(['error' => 'No se encontró el producto con el código detectado.']);
            }*/

            $chopeo = new Chopeo();
            $chopeo->id_tienda = $request->tienda;
            $chopeo->id_competencia = $request->competencia;
            $chopeo->fecha_chopeo = $request->fecha_chopeo;
            $chopeo->id_usuario_responsable = $id_user;
            $chopeo->ruta_imagen = $rutaFinal;
            $chopeo->estado = 1;
            $chopeo->id_usuario_inserta = $id_user;
            $chopeo->save();
            $id_chopeo = $chopeo->id;

            $chopeo_detalle = new ChopeoDetalle();
            $chopeo_detalle->id_chopeo = $id_chopeo;
            $chopeo_detalle->id_producto = $equivalencia_producto->id_producto;
            $chopeo_detalle->precio_competencia = $precio;
            $chopeo_detalle->estado = 1;
            $chopeo_detalle->id_usuario_inserta = $id_user;
            $chopeo_detalle->save();

            return response()->json(['success' => 'Chopeo registrado correctamente.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => $e->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function testVision()
    {
        $imagePath = public_path('prueba.jpeg');
        $keyFile = storage_path('app/google-key.json');

        $visionClient = new ImageAnnotatorClient([
            'credentials' => $keyFile,
        ]);

        $image = file_get_contents($imagePath);
        $response = $visionClient->textDetection($image);
        $texts = $response->getTextAnnotations();

        if (count($texts) > 0) {
            $texto = $texts[0]->getDescription();
            preg_match('/\b\d{7}\b/', $texto, $match);
            return $match[0] ?? 'No se encontró número de 7 dígitos';
        } else {
            return 'No se detectó texto en la imagen.';
        }
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
        return ["N°","Id","Bien/Servicio","Tipo Origen Producto","Serie","Denominación","Código","Unidad Producto","Contenido","Unidad Medida","Marca","Familia","Sub Familia","Estado Bien","F. Vencimiento","Stock Minimo","Tiene Imagen","Estado"];
    }

	public function styles(Worksheet $sheet)
    {

		$sheet->mergeCells('A1:R1');

        $sheet->setCellValue('A1', "LISTA DE PRODUCTOS - FORESPAMA");
        $sheet->getStyle('A1:R1')->applyFromArray([
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

        $sheet->getStyle('A2:R2')->applyFromArray([
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
        
        foreach (range('A', 'R') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}