<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsultaOxapampaMovimiento;
use App\Models\TablaMaestra;
use App\Models\Almacene;
use Auth;

class ConsultaOxapampaMovimientoController extends Controller
{
    public function __construct(){
		$this->middleware('auth');
		$this->middleware('can:Consulta Oxapampa Movimientos')->only(['create']);
	}

    public function create(){
		
        $almacen_model = new Almacene;

        $almacen = $almacen_model->getAlmacenAll();

		return view('frontend.consulta_oxapampa_movimiento.create',compact('almacen'));

	}

    public function listar_oxapampa_movimiento_ajax(Request $request){

		$consulta_oxapampa_movimiento_model = new ConsultaOxapampaMovimiento;
		$p[]=$request->almacen;
		$p[]=$request->producto;
		$p[]=$request->fecha_inicio;
		$p[]=$request->fecha_fin;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $consulta_oxapampa_movimiento_model->listar_oxapampa_movimiento_ajax($p);
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
}
