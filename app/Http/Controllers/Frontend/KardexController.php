<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests\KardexRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\Kardex;
use App\Models\Producto;
use Auth;

class KardexController extends Controller
{
    /*public function index()
    {
        $kardex = Kardex::latest()->paginate(10);
        return view('frontend.kardex.index', compact('kardex'));
    }*/

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function create(){

		//$tablaMaestra_model = new TablaMaestra;
		//$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);

        $producto_model = new Producto;
        $producto = $producto_model->getProductoAll();
		
		return view('frontend.kardex.create',compact('producto'));

	}

    public function listar_kardex_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_ajax($p);
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
