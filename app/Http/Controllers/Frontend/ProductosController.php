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
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

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
		$estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
		$tipo_origen_producto = $tablaMaestra_model->getMaestroByTipo(58);
		
		return view('frontend.productos.create',compact('estado_bien','tipo_origen_producto'));

	}

    public function listar_producto_ajax(Request $request){

		$producto_model = new Producto;
		$p[]=$request->serie;
		$p[]=$request->denominacion;
        $p[]=$request->codigo;
        $p[]=$request->estado_bien;
        $p[]=$request->tipo_origen_producto;
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
		
		if($id>0){
			$producto = Producto::find($id);
            $imagenes = ProductoImagene::where('id_producto', $id)->pluck('ruta_imagen'); 
		}else{
			$producto = new Producto;
            $imagenes = [];
		}

        $unidad_producto = $tablaMaestra_model->getMaestroByTipo(43);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $tipo_producto = $tablaMaestra_model->getMaestroByTipo(44);
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(57);
        $marca = $marca_model->getMarcaAll();
		$tipo_origen_producto = $tablaMaestra_model->getMaestroByTipo(58);
		//var_dump($id);exit();

		return view('frontend.productos.modal_productos_nuevoProducto',compact('id','producto','unidad_medida','moneda','estado_bien','tipo_producto','unidad_producto','marca','tipo_origen_producto','imagenes'));

    }

    public function send_producto(Request $request){

        $existe_producto_codigo = Producto::where('codigo', $request->codigo)->first();

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

		if($request->id == 0){
			$producto = new Producto;
            $producto_model = new Producto;
            $correlativo = $producto_model->getCorrelativo();
            $producto->numero_corrrelativo = $correlativo[0]->numero_correlativo;
		}else{
			$producto = Producto::find($request->id);
		}

        $producto->id_tipo_origen_producto = $request->tipo_origen_producto;
		$producto->numero_serie = $request->numero_serie;
		$producto->codigo = $request->codigo;
        $producto->denominacion = $request->denominacion;
        $producto->id_unidad_medida = $request->unidad_medida;
        $producto->stock_actual = $request->stock_actual;
        $producto->id_moneda = $request->moneda;
        $producto->id_tipo_producto = $request->tipo_producto;
        $producto->fecha_vencimiento = $request->fecha_vencimiento;
        $producto->id_estado_bien = $request->estado_bien;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->observacion = "";
        $producto->costo_unitario = $request->costo_unitario;
        $producto->contenido = $request->contenido;
        $producto->id_unidad_producto = $request->unidad_producto;
        $producto->id_marca = $request->marca;
        //$producto->numero_corrrelativo = $numero_correlativo;
		$producto->estado = 1;
		$producto->save();
        $id_producto = $producto->id; 

        //////////////////imagenes producto
		
		$path = "img/productos/".$producto->id;
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$img_foto = $request->img_foto;
		
		if(isset($img_foto) && is_array($img_foto) && count($img_foto) > 0){
			$path = "img/productos/".$producto->id."/".$request->denominacion;
			if (!is_dir($path)) {
				mkdir($path);
			}
		}

        $imagenesExistentes = ProductoImagene::where('id_producto', $id_producto)->pluck('ruta_imagen')->toArray();
		
        if (isset($img_foto) && is_array($img_foto)) {

            foreach($img_foto as $row){
                
                if($row!=""){

                    $rutaNuevaImagen = "img/productos/".$producto->id."/".$row;

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
                    
                    $productoImagen = new ProductoImagene;
                    $productoImagen->id_producto = $id_producto;
                    $productoImagen->ruta_imagen = $rutaNuevaImagen;
                    $productoImagen->estado = 1;
                    $productoImagen->save();
                }
                
            }
        }
		//////////////////

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
                $producto_stock[$id_producto] = ['saldos_cantidad'=>0];
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
}
