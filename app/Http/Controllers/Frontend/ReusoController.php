<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reuso;
use App\Models\ReusoDetalle;
use App\Models\Kardex;
use App\Models\Almacene;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\TablaMaestra;
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
		$p[]=$request->fecha;
		$p[]=$request->numero_reuso;
        $p[]=$request->almacen_destino;
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
		
        $id_user = Auth::user()->id;

        $almacen_model = new Almacene;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$reuso = Reuso::find($id);
		}else{
			$reuso = new Reuso;
		}

        $almacen = $almacen_model->getAlmacenAll();
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);

		return view('frontend.reuso.modal_reuso_nuevoReuso',compact('id','reuso','almacen','producto','marca','estado_bien','id_user'));

    }

    public function send_reuso(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$reuso = new Reuso;
            $reuso_model = new Reuso;
            $codigo_reuso = $reuso_model->getCodigoReuso();
		}else{
			$reuso = Reuso::find($request->id);
            $codigo_reuso = $request->numero_reuso;
		}

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $estado_bien = $request->input('estado_bien');
        $cantidad = $request->input('cantidad');
        $id_reuso_detalle = $request->id_reuso_detalle;
		
		$reuso->id_tipo_documento = 1;
        if($request->id == 0){
            $reuso->codigo = $codigo_reuso[0]->codigo;
        }else{
            $reuso->codigo = $codigo_reuso;
        }
        $reuso->fecha = $request->fecha;
        $reuso->id_almacen_destino = $request->almacen_destino;
        $reuso->id_usuario_inserta = $id_user;
		$reuso->estado = 1;
		$reuso->save();
        $id_reuso = $reuso->id;

		foreach($descripcion as $index => $value) {
            
            if($id_reuso_detalle[$index] == 0){
                $reuso_detalle = new ReusoDetalle;
            }else{
                $reuso_detalle = ReusoDetalle::find($id_reuso_detalle[$index]);
            }
            
            $reuso_detalle->id_reuso = $id_reuso;
            $reuso_detalle->id_producto = $descripcion[$index];
            $reuso_detalle->cantidad = $cantidad[$index];
            $reuso_detalle->id_estado_producto = $estado_bien[$index];
            $reuso_detalle->estado = 1;
            $reuso_detalle->id_usuario_inserta = $id_user;
            $reuso_detalle->save();

			if($id_reuso_detalle[$index] == 0){
				$producto = Producto::find($descripcion[$index]);

				$kardex_buscar = Kardex::where("id_producto",$descripcion[$index])->where("id_almacen_destino",$request->almacen_destino)->orderBy('id', 'desc')->first();
				$kardex = new Kardex;
				$kardex->id_producto = $descripcion[$index];
				$kardex->entradas_cantidad = $cantidad[$index];
				if($kardex_buscar){
					$cantidad_saldo = $kardex_buscar->saldos_cantidad + $cantidad[$index];
					$kardex->saldos_cantidad = $cantidad_saldo;
				}else{
					$kardex->saldos_cantidad = $cantidad[$index];
				}
				$kardex->id_almacen_destino = $request->almacen_destino;
				$kardex->id_reuso = $id_reuso;

				$kardex->save();
			}else{

			}
        }
        
        return response()->json(['success' => 'Reuso guardado exitosamente.']);

    }

    public function cargar_detalle($id)
    {

        $reuso_model = new Reuso;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $reuso = $reuso_model->getDetalleReusoById($id);
        $producto = $producto_model->getProductoAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(56);

        return response()->json([
            'reuso' => $reuso,
            'producto' => $producto,
            'estado_bien' => $estado_bien
        ]);
    }
}
