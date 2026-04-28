<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KardexSecundario;
use App\Models\Producto;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Almacene;

class KardexSecundarioController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
		$this->middleware('can:Kardex Secundario')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;
		$empresa_model = new Empresa;
		$persona_model = new Persona;
		$producto_model = new Producto;
		$almacen_model = new Almacene;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $proveedor = $empresa_model->getEmpresaAll();
        $persona = $persona_model->obtenerPersonaAll();
        $producto = $producto_model->getProductoAll();
        $almacen = $almacen_model->getAlmacenB();
		
		return view('frontend.kardex_secundarios.create',compact('tipo_documento','proveedor','persona','producto','almacen'));

	}

    public function listar_kardex_secundario_ajax(Request $request){

		$kardex_secundario_model = new KardexSecundario;
        $p[]=$request->producto;
        $p[]=$request->almacen;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $kardex_secundario_model->listar_kardex_secundario_ajax($p);
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

    public function obtener_precio_salida($producto){
		
		$kardex_secundario_model = new KardexSecundario;
		$ultimo_precio_salida = $kardex_secundario_model->getUltimoPrecioSalida($producto);
		
		return response()->json($ultimo_precio_salida);
	}
}
