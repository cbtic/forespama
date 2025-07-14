<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\EmpresaCubicaje;
use App\Models\Acerrado;
use App\Models\IngresoVehiculoTroncoTipoMadera;
use Auth;
use Carbon\Carbon;

class AcerradoMaderaController extends Controller
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
		
		return view('frontend.acerrado_madera.create');

	}

    public function listar_acerrado_madera_ajax(Request $request){

		$acerrado_madera_model = new Acerrado;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $acerrado_madera_model->listar_acerrado_madera_ajax($p);
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

    public function modal_acerrado_madera($id){
		
		$tabla_maestra_model = new TablaMaestra;
        $empresa_cubicaje_model = new EmpresaCubicaje;

		/*if($id>0){
			$acerrado_madera = Acerrado::find($id);
		}else{
			$acerrado_madera = new Acerrado;
		}*/

		$tipo_madera = $tabla_maestra_model->getMaestroByTipo('42');
		$medida_acerrado = $tabla_maestra_model->getMaestroByTipo('82');
        $letra_empresa_cubicaje = $empresa_cubicaje_model->obtenerLetraEmpresa();

		return view('frontend.acerrado_madera.modal_acerrado_madera_nuevoAcerradoMadera',compact('id',/*'acerrado_madera',*/'tipo_madera','medida_acerrado','letra_empresa_cubicaje'));

    }

    public function send_acerrado_madera(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$acerrado_madera = new Acerrado;
		}else{
			$acerrado_madera = Acerrado::find($request->id);
		}
		
        $acerrado_madera->denominiacion = $request->denominacion;
		$acerrado_madera->id_tipo_marca = $request->tipo_marca;
		$acerrado_madera->estado = 1;
        $acerrado_madera->id_usuario_inserta = $id_user;
		$acerrado_madera->save();

        return response()->json(['success' => 'Registro de acerrado guardado exitosamente.']);

    }

    public function cargar_detalle_ingreso_vehiculo_acerrado(){
		
		$ingreso_vehiculo_tronco_tipo_madera_model = new IngresoVehiculoTroncoTipoMadera;
		$detalle_ingreso_acerrado = $ingreso_vehiculo_tronco_tipo_madera_model->getDetalleIngresoVehiculoAcerrado();
		
		return response()->json($detalle_ingreso_acerrado);
	}
}
