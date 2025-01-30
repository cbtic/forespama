<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parametro;
use App\Models\Empresa;
use App\Models\OrdenCompra;
use App\Models\ParametroOrdenCompra;
use App\Models\TablaMaestra;
use Auth;
use Carbon\Carbon;

class ParametroController extends Controller
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
		
		return view('frontend.parametro.create');

	}

    public function modal_parametro($id){

		if($id>0){
			$parametro = Parametro::find($id);
		}else{
			$parametro = new Parametro;
		}

        $tabla_maestra_model = new TablaMaestra;

        $tipo_parametro = $tabla_maestra_model->getMaestroByTipo(72);

        $empresa = Empresa::all();
		//var_dump($codigo[0]->codigo);exit();

		return view('frontend.parametro.modal_parametros_nuevoParametro',compact('id','parametro','empresa','tipo_parametro'));

    }

    public function listar_parametros_ajax(Request $request){

		$parametro_model = new Parametro();
		$p[]=$request->denominacion;
		$p[]=$request->empresa;
		$p[]=$request->anio;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $parametro_model->listar_parametros_ajax($p);
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

    public function send_parametro(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$parametro = new Parametro;
		}else{
			$parametro = Parametro::find($request->id);
		}
		
		$parametro->id_empresa = $request->empresa;
		$parametro->anio = $request->anio;
		$parametro->nombre_acuerdo_comercial = $request->nombre_comercial;
		$parametro->porcentaje_valor = $request->procentaje_valor;
        $parametro->id_tipo = $request->tipo;
		$parametro->aplica_detalle = $request->aplica_detalle;
		$parametro->general_especifico = $request->general_especifico;
        $parametro->estado = 1;
		$parametro->id_usuario_inserta = $id_user;
		$parametro->save();

    }

    public function eliminar_parametro($id,$estado)
    {
		$parametro = Parametro::find($id);

		$parametro->estado = $estado;
		$parametro->save();

		echo $parametro->id;
    }

    public function create_valida_parametro(){

		return view('frontend.parametro.create_valida_parametro');

	}

    public function listar_parametro_validacion_ajax(Request $request){

		$parametro_validacion_model = new ParametroValidacion();
		$p[]=$request->orden_compra;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $parametro_validacion_model->listar_parametro_validacion_ajax($p);
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

    public function listar_total_orden_compra_tienda_ajax(Request $request){

		$orden_compra_model = new OrdenCompra();
		$p[]=$request->numero_orden_compra;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $orden_compra_model->listar_total_orden_compra_tienda_ajax($p);
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

    public function cargar_parametro_orden_compra($id){
		 
		$parametro_orden_compra_model = new ParametroOrdenCompra;
        $parametro_orden_compra = $parametro_orden_compra_model->getParametroOrdenCompraById($id);

        //dd($parametro_orden_compra);exit();
		
        return view('frontend.parametro.parametro_orden_compra_ajax',compact('parametro_orden_compra'));
		
    }

}
