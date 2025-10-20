<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reuso;
use App\Models\Almacene;
use Auth;

class ReusoController extends Controller
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

        $almacen_model = new Almacene;

        $almacen = $almacen_model->getAlmacenAll();
		
		return view('frontend.reuso.create',compact('almacen'));

	}

    public function listar_reuso_ajax(Request $request){

		$reuso_model = new Reuso;
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
		$data = $reuso_model->listar_reuso_ajax($p);
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

    public function modal_reuso($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $familia_model = new Familia;
		
		if($id>0){
			$producto = Producto::find($id);
            //$imagenes = ProductoImagene::where('id_producto', $id)->pluck('ruta_imagen');
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
        
		//var_dump($id);exit();

		return view('frontend.reuso.modal_reuso_nuevoReuso',compact('id','producto','unidad_medida','moneda','estado_bien','tipo_producto','unidad_producto','marca','tipo_origen_producto','imagenes','bien_servicio','familia'));

    }

    public function send_reuso(Request $request){

        //$btnFichaTecnica = $request->btnFichaTecnica;

        //dd($btnFichaTecnica);exit();

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
        //$producto->id_tipo_producto = $request->tipo_producto;
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
        $id_img_foto = $request->id_img_foto;
        /*
		if(isset($img_foto) && is_array($img_foto) && count($img_foto) > 0){
			$path = "img/productos/".$producto->id."/".$request->denominacion;
			if (!is_dir($path)) {
				mkdir($path);
			}
		}
        */
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
}
