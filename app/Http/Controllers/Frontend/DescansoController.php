<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Descanso;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Kardex;
use App\Models\Almacene;
use Auth;

class DescansoController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Descanso')->only(['create']);
	}

    public function create(){
		
        $tablaMaestra_model = new TablaMaestra;

		$cerrado = $tablaMaestra_model->getMaestroByTipo(119);

		return view('frontend.descanso.create',compact('cerrado'));

	}

    public function listar_descanso_ajax(Request $request){

		$descanso_model = new Descanso;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
		$p[]=$request->situacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $descanso_model->listar_descanso_ajax($p);
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

    public function modal_descanso($id){
		
        $almacen_model = new Almacene;
        
		if($id>0){
			$descanso = Descanso::find($id);
		}else{
			$descanso = new Descanso;
		}

        $almacen = $almacen_model->getAlmacenAll();

		return view('frontend.descanso.modal_descanso_nuevoDescanso',compact('id','descanso','almacen'));

    }

    public function send_descanso(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$descanso = new Descanso;
		}else{
			$descanso = Descanso::find($request->id);
		}
		
        $descanso->denominiacion = $request->denominacion;
		$descanso->id_tipo_marca = $request->tipo_marca;
		$descanso->estado = 1;
        $descanso->id_usuario_inserta = $id_user;
		$descanso->save();

        return response()->json(['success' => 'Descanso guardada exitosamente.']);

    }

    public function eliminar_descanso($id,$estado)
    {
		$descanso = Descanso::find($id);

		$descanso->estado = $estado;
		$descanso->save();

		echo $descanso->id;
    }

    public function cargar_detalle($id)
    {

        $descanso_model = new Descanso;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;
        $kardex_model = new Kardex;

        $descanso = $descanso_model->getDetalleDescansoId($id);
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        
        return response()->json([
            'descanso' => $descanso,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida
        ]);
    }
}
