<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests\KardexRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use App\Models\Kardex;
use App\Models\Producto;
use App\Models\Almacene;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
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
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
        $producto = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		
		return view('frontend.kardex.create',compact('producto','almacen'));

	}

    public function listar_kardex_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->producto;
		$p[]=$request->almacen;
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

	public function create_consulta(){

		//$tablaMaestra_model = new TablaMaestra;
		//$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
		$almacen_model = new Almacene;
        $producto = $producto_model->getProductoAll();
		$almacen = $almacen_model->getAlmacenByUser($id_user);
		
		return view('frontend.kardex.create_consulta',compact('producto','almacen'));

	}

	public function listar_kardex_existencia_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]="";
		$p[]=$request->almacen_existencia;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_existencia_ajax($p);

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

	public function listar_kardex_existencia_producto_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->producto_existencia;
		$p[]=$request->almacen_existencia;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_existencia_producto_ajax($p);
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

	public function exportar_listar_existencia($consulta_almacen) {

		if($consulta_almacen=="0")$consulta_almacen = "";

		$kardex_model = new Kardex;
		$p[]="";
		$p[]=$consulta_almacen;
		$p[]=1;
		$p[]=10000;
		$data = $kardex_model->listar_kardex_existencia_ajax($p);
	
		$variable = [];
		$n = 1;

		array_push($variable, array("N","Codigo","Producto","Saldos","Almacen"));
		
		foreach ($data as $r) {

			array_push($variable, array($n++,$r->codigo, $r->denominacion, $r->saldos_cantidad, $r->almacen_kardex));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'Reporte_existencias.xlsx');
		
    }

	public function create_consulta_productos(){

		//$tablaMaestra_model = new TablaMaestra;
		//$estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
		$id_user = Auth::user()->id;

        $producto_model = new Producto;
        $producto = $producto_model->getProductoExterno();
		
		return view('frontend.kardex.create_consulta_productos',compact('producto'));

	}

	public function listar_kardex_consulta_producto_ajax(Request $request){

		$kardex_model = new Kardex;
		$p[]=$request->consulta_existencia_producto;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_model->listar_kardex_consulta_producto_ajax($p);
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

class InvoicesExport implements FromArray
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

}