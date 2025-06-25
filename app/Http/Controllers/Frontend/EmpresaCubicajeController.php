<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmpresaCubicaje;
use App\Models\TablaMaestra;
use Auth;
use Carbon\Carbon;

class EmpresaCubicajeController extends Controller
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

        $id_user = Auth::user()->id;

		$tablaMaestra_model = new TablaMaestra;

		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
		
		return view('frontend.empresa_cubicaje.create',compact('tipo_documento'));

	}

    public function listar_empresa_cubicaje_ajax(Request $request){

		$empresa_cubicaje_model = new EmpresaCubicaje;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa_compra;
        $p[]="";//$request->empresa_vende;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_orden_compra;
        $p[]=$request->numero_orden_compra_cliente;
        $p[]=$request->situacion;
        $p[]=$request->almacen_origen;
        $p[]=$request->almacen_destino;
        $p[]=$request->estado;
        $p[]=$id_user;
        $p[]=$request->vendedor;
        $p[]=$request->estado_pedido;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empresa_cubicaje_model->listar_empresa_cubicaje_ajax($p);
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

    public function modal_empresa_cubicaje($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
            $empresa_cubicaje = EmpresaCubicaje::find($id);
		}else{
			$empresa_cubicaje = new EmpresaCubicaje;
		}

        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(54);
        $almacen = $almacen_model->getAlmacenAll();
        $unidad_origen = $tablaMaestra_model->getMaestroByTipo(50);
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

		return view('frontend.empresa_cubicaje.modal_empresa_cubicaje_nuevoEmpresaCubicaje',compact('id','empresa_cubicaje','tipo_documento','almacen','unidad_origen','id_user','moneda'));

    }

    public function send_empresa_cubicaje(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $empresa_cubicaje = new EmpresaCubicaje;
        }else{
            $empresa_cubicaje = EmpresaCubicaje::find($request->id);
        }

        //dd($codigo_orden_compra[0]->codigo);exit();

        $item = $request->input('item');
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $marca = $request->input('marca');
        $estado_bien = $request->input('estado_bien');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
        $precio_unitario = $request->input('precio_unitario');
        $id_descuento = $request->input('id_descuento');
        $sub_total = $request->input('sub_total');
        $igv = $request->input('igv');
        $total = $request->input('total');
        $precio_unitario_ = $request->input('precio_unitario_');
        $valor_venta_bruto = $request->input('valor_venta_bruto');
        $valor_venta = $request->input('valor_venta');
        $descuento = $request->input('descuento');
        $porcentaje = $request->input('porcentaje');
        $id_orden_compra_detalle =$request->id_orden_compra_detalle;

        $empresa_cubicaje->id_empresa_compra = $request->empresa_compra;
        $empresa_cubicaje->id_empresa_vende = $request->empresa_vende;
        $empresa_cubicaje->id_tipo_cliente = $request->tipo_documento_cliente;
        $empresa_cubicaje->id_persona = $request->persona_compra;
        $empresa_cubicaje->fecha_orden_compra = $request->fecha_orden_compra;
        $empresa_cubicaje->id_usuario_inserta = $id_user;
        $empresa_cubicaje->id_vendedor = $request->id_vendedor;
        $empresa_cubicaje->estado = 1;
        $empresa_cubicaje->save();

        return response()->json(['id' => $empresa_cubicaje->id]);    
        
    }

    public function eliminar_empresa_cubicaje($id,$estado)
    {
		$empresa_cubicaje = EmpresaCubicaje::find($id);

		$empresa_cubicaje->estado = $estado;
		$empresa_cubicaje->save();

		echo $empresa_cubicaje->id;
    }
}
