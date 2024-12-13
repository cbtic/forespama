<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Guia;
use Auth;
use Carbon\Carbon;

class GuiaController extends Controller
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

        /*$id_user = Auth::user()->id;
		$tablaMaestra_model = new TablaMaestra;
        $user_model = new User;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $cerrado_requerimiento = $tablaMaestra_model->getMaestroByTipo(52);
        //$proveedor = Empresa::all();
        $almacen = Almacene::all();
        $estado_atencion = $tablaMaestra_model->getMaestroByTipo(60);
        $responsable_atencion = $user_model->getUserAll();*/

        $tablaMaestra_model = new TablaMaestra;
        $empresa_model = new Empresa;

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(59);
        $transporte_razon_social = $empresa_model->obtenerRazonSocialTransporteAll();
        
		return view('frontend.guia.create',compact('tipo_documento','transporte_razon_social'));

	}

    public function listar_guia_ajax(Request $request){

		$guia_model = new Guia;
		$p[]=$request->tipo_documento;
        $p[]=$request->fecha;
        $p[]=$request->numero_requerimiento;
        $p[]=$request->almacen;
        $p[]=$request->situacion;
        $p[]=$request->responsable_atencion;
        $p[]=$request->estado_atencion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $guia_model->listar_guia_ajax($p);
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

    public function modal_guia($id){
		
        $tablaMaestra_model = new TablaMaestra;
        $producto_model = new Producto;
        $marca_model = new Marca;
        $empresa_model = new Empresa;
		
		if($id>0){
            $guia = Guia::find($id);
		}else{
			$guia = new Guia;
        }

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $estado_bien = $tablaMaestra_model->getMaestroByTipo(4);
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $empresas = Empresa::all();
        $transporte_razon_social = $empresa_model->obtenerRazonSocialTransporteAll();

        return view('frontend.guia.modal_guia_nuevoGuia',compact('id','guia','tipo_documento','producto','marca','estado_bien','unidad','empresas','transporte_razon_social'));

    }

    public function send_guia(Request $request)
    {
        $id_user = Auth::user()->id;

        if($request->id == 0){
            $guia = new Guia;
        }else{
            $guia = Guia::find($request->id);
        }

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        
        $id_requerimiento_detalle =$request->id_requerimiento_detalle;
        
        $requerimiento->id_tipo_documento = $request->tipo_documento;
        $requerimiento->fecha = $request->fecha_requerimiento;
        $requerimiento->codigo = $request->numero_requerimiento;
        $requerimiento->id_almacen_destino = $request->almacen;
        $requerimiento->sustento_requerimiento = $request->sustento_requerimiento;
        $requerimiento->responsable_atencion = $request->responsable;
        $requerimiento->estado_atencion = $request->estado_atencion;
        $requerimiento->id_unidad_origen = $request->unidad_origen;
        $requerimiento->id_almacen_salida = $request->almacen_salida;
        $requerimiento->cerrado = 1;
        $requerimiento->id_usuario_inserta = $id_user;
        $requerimiento->estado = 1;
        $requerimiento->save();

        $array_requerimiento_detalle = array();

        foreach($item as $index => $value) {
            
            if($id_requerimiento_detalle[$index] == 0){
                $requerimiento_detalle = new RequerimientoDetalle;
            }else{
                $requerimiento_detalle = RequerimientoDetalle::find($id_requerimiento_detalle[$index]);
            }
            
            $requerimiento_detalle->id_requerimiento = $requerimiento->id;
            $requerimiento_detalle->id_producto = $descripcion[$index];
            $requerimiento_detalle->cantidad = $cantidad_ingreso[$index];
            $requerimiento_detalle->id_estado_producto = $estado_bien[$index];
            $requerimiento_detalle->id_unidad_medida = $unidad[$index];
            $requerimiento_detalle->id_marca = $marca[$index];
            $requerimiento_detalle->estado = 1;
            $requerimiento_detalle->cerrado = 1;
            $requerimiento_detalle->id_usuario_inserta = $id_user;

            $requerimiento_detalle->save();

            $array_requerimiento_detalle[] = $requerimiento_detalle->id;

            $RequerimientoAll = RequerimientoDetalle::where("id_requerimiento",$requerimiento->id)->where("estado","1")->get();
            
            foreach($RequerimientoAll as $key=>$row){
                
                if (!in_array($row->id, $array_requerimiento_detalle)){
                    $requerimiento_detalle = RequerimientoDetalle::find($row->id);
                    $requerimiento_detalle->estado = 0;
                    $requerimiento_detalle->save();
                }
            }
        }

        return response()->json(['id' => $guia->id]);
    }
}
