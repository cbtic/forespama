<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tienda;
use App\Models\Empresa;
use App\Models\TiendaDetalle;
use App\Models\TablaMaestra;
use App\Models\Ubigeo;
use Auth;

class TiendaController extends Controller
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
        $empresa = Empresa::all();

		$zona = $tablaMaestra_model->getMaestroByTipo(69);
		$tienda_s_m = $tablaMaestra_model->getMaestroByTipo(70);
		$zona_especifica = $tablaMaestra_model->getMaestroByTipo(71);

		return view('frontend.tiendas.create',compact('empresa', 'zona', 'tienda_s_m', 'zona_especifica'));

	}

    public function listar_tienda_ajax(Request $request){

		$tienda_model = new Tienda;
		$p[]=$request->denominacion;
        $p[]=$request->empresa;
		$p[]=$request->zona;
		$p[]=$request->tienda_sm;
		$p[]=$request->zona_especifica;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $tienda_model->listar_tienda_ajax($p);
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

    public function modal_tienda($id){
		
		$tablaMaestra_model = new TablaMaestra;
        $ubigeo_model = new Ubigeo;

		if($id>0){
            $tienda_detalle = TiendaDetalle::find($id);
			$tienda = Tienda::find($tienda_detalle->id_tienda);
		}else{
			$tienda = new Tienda;
            $tienda_detalle = new TiendaDetalle;
		}

        $empresa = Empresa::all();
		$zona = $tablaMaestra_model->getMaestroByTipo(69);
		$tienda_s_m = $tablaMaestra_model->getMaestroByTipo(70);
		$zona_especifica = $tablaMaestra_model->getMaestroByTipo(71);
        $departamento = $ubigeo_model->getDepartamento();

		return view('frontend.tiendas.modal_tiendas_nuevoTienda',compact('id','tienda','empresa','tienda_detalle','zona','tienda_s_m','zona_especifica','departamento'));

    }

    public function send_tienda(Request $request){

        $id_user = Auth::user()->id;

        /*$tienda_detalle_model = new TiendaDetalle;
		$datos_tienda = TiendaDetalle::where("id_empresa",$request->empresa)->where("estado","1")->orderBy('id','desc')->first();
		$id_empresa = $datos_tienda->id_empresa;
        $id_tienda = $datos_tienda->id_tienda;*/

		if($request->id == 0){
            $tienda = new Tienda;
			$tiendaDetalle = new TiendaDetalle;
		}else{
			$tiendaDetalle = TiendaDetalle::find($request->id);
            $tienda = Tienda::find($request->id_tienda);
		}

        $tienda->denominacion = $request->denominacion;
        $tienda->numero_tienda = $request->numero_tienda;
        $tienda->tienda_tmh = $request->tienda_tmh;
        $tienda->id_zona = $request->zona;
        $tienda->id_tienda_s_m = $request->tienda_sm;
        $tienda->id_zona_especifica = $request->zona_especifica;
        $tienda->direccion = $request->direccion;
        $tienda->id_ubigeo = $request->distrito_contacto;
        $tienda->estado = 1;
		$tienda->id_usuario_inserta = $id_user;
		$tienda->save();

        $tiendaDetalle->id_tienda = $tienda->id;
        $tiendaDetalle->id_empresa = $request->empresa;
        $tiendaDetalle->estado = 1;
        $tiendaDetalle->id_usuario_inserta = $id_user;
        $tiendaDetalle->save();

        return response()->json(['success' => 'Tienda guardada exitosamente.']);

    }

    public function eliminar_tienda($id,$estado)
    {
		$tiendaDetalle = TiendaDetalle::find($id);

		$tiendaDetalle->estado = $estado;
		$tiendaDetalle->save();

		echo $tiendaDetalle->id;
    }

    public function obtener_datos_tienda($empresa){

        $tienda_detalle_model = new TiendaDetalle;
        $sw = true;
        $tienda_empresa_lista = $tienda_detalle_model->getTiendaByEmpresa($empresa);
        //print_r($parentesco_lista);exit();
        return view('frontend.tiendas.lista_datos_tienda_empresa',compact('tienda_empresa_lista'));

    }

	public function obtener_provincia_distrito($id){

		$tienda_detalle = TiendaDetalle::find($id);
		$tienda = Tienda::find($tienda_detalle->id_tienda);
		
		$tienda_model = new Tienda;
		$tienda = $tienda_model->getProvinciaDistritoById($tienda->id);
		
		echo json_encode($tienda);
	}
}
