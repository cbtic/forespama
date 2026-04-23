<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\Empresa;
use App\Models\Persona;
use App\Models\Marca;
use App\Models\IngresoSalidaSecundario;
use App\Models\IngresoSalidaSecundarioDetalle;
use Auth;
use Carbon\Carbon;

class IngresoSalidaSecundarioController extends Controller
{
    public function __construct(){

        $this->middleware('auth');
		$this->middleware('can:Ingreso Salida Secundario')->only(['create']);
	}

    public function create(){

		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $proveedor = Empresa::all();
		
		return view('frontend.ingreso_salida_secundarios.create',compact('tipo_documento','proveedor'));

	}

    public function listar_ingreso_salida_secundarios_ajax(Request $request){

		$ingreso_salida_secundario_model = new IngresoSalidaSecundario;
		$p[]=$request->tipo_documento;
        $p[]=$request->empresa;
        $p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        $p[]=$request->numero_ingreso_salida;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $ingreso_salida_secundario_model->listar_ingreso_salida_secundarios_ajax($p);
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

    public function modal_ingreso_salida_secundario($id){
		
        $id_user = Auth::user()->id;
        $tablaMaestra_model = new TablaMaestra;
        $marca_model = new Marca;
        $producto_model = new Producto;
        $almacen_model = new Almacene;
        $empresa_model = new Empresa;
        $persona_model = new Persona;
		
        if($id>0){
            $ingreso_salida_secundario = IngresoSalidaSecundario::find($id);
        }else{
            $ingreso_salida_secundario = new IngresoSalidaSecundario;
        }
        
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(53);
        $empresas = $empresa_model->getEmpresaAll();
        $personas = $persona_model->obtenerPersonaAll();
        $producto = $producto_model->getProductoAll();
        $marca = $marca_model->getMarcaAll();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $igv_compra = $tablaMaestra_model->getMaestroByTipo(51);
        $almacen = $almacen_model->getAlmacenB();
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);
        $tipo_documento_cliente = $tablaMaestra_model->getMaestroByTipo(75);
        
		return view('frontend.ingreso_salida_secundarios.modal_ingreso_salida_secundario_nuevoIngresoSalidaSecundario',compact('id','ingreso_salida_secundario','tipo_documento','empresas','personas','producto','marca','unidad','igv_compra','almacen','moneda','unidad_medida','tipo_documento_cliente'));

    }

    public function send_ingreso_salida_secundario(Request $request){

        $id_user = Auth::user()->id;

        if($request->id == 0){
            $ingreso_salida_secundario = new IngresoSalidaSecundario;
            $ingreso_salida_secundario_model = new IngresoSalidaSecundario;
            $codigo_ingreso_salida_secundario = $ingreso_salida_secundario_model->getCodigoIngresoSalidaB($request->tipo_documento);
        }else{
            $ingreso_salida_secundario = IngresoSalidaSecundario::find($request->id);
            $codigo_ingreso_salida_secundario = $request->numero_ingreso_salida;
        }

        $descripcion = $request->input('descripcion');
        $codigo = $request->input('codigo');
        $marca = $request->input('marca');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $precio_unitario = $request->input('precio_unitario');
        $sub_total = $request->input('sub_total');
        $igv = $request->input('igv');
        $total = $request->input('total');
        $id_ingreso_salida_b_detalle =$request->id_ingreso_salida_b_detalle;

        $ingreso_salida_secundario->id_tipo_documento = $request->tipo_documento;
        $ingreso_salida_secundario->id_tipo_cliente = $request->tipo_documento_cliente;
        $ingreso_salida_secundario->id_persona = $request->persona;
        $ingreso_salida_secundario->id_empresa = $request->empresa;
        $ingreso_salida_secundario->id_almacen = $request->almacen;
        $ingreso_salida_secundario->fecha_ingreso_salida = $request->fecha;
        if($request->id == 0){
            $ingreso_salida_secundario->numero_ingreso_salida = $codigo_ingreso_salida_secundario[0]->codigo;
        }else{
            $ingreso_salida_secundario->numero_ingreso_salida = $codigo_ingreso_salida_secundario;
        }
        $ingreso_salida_secundario->observacion = $request->igv_compra;//
        $ingreso_salida_secundario->igv_compra = $request->igv_compra;
        $ingreso_salida_secundario->id_moneda = $request->moneda;
        $ingreso_salida_secundario->sub_total = round($request->sub_total_general,2);
        $ingreso_salida_secundario->igv = round($request->igv_general,2);
        $ingreso_salida_secundario->total = round($request->total_general,2);
        $ingreso_salida_secundario->id_usuario_inserta = $id_user;
        $ingreso_salida_secundario->estado = 1;
        $ingreso_salida_secundario->save();
        $id_ingreso_salida_secundario = $ingreso_salida_secundario->id;
        $array_ingreso_salida_secundario_detalle = array();

        foreach($descripcion as $index => $value) {
            
            if($id_ingreso_salida_b_detalle[$index] == 0){
                $ingreso_salida_secundario_detalle = new IngresoSalidaSecundarioDetalle;
            }else{
                $ingreso_salida_secundario_detalle = IngresoSalidaSecundarioDetalle::find($id_ingreso_salida_b_detalle[$index]);
            }
            
            $ingreso_salida_secundario_detalle->id_ingreso_salida_secundario = $id_ingreso_salida_secundario;
            $ingreso_salida_secundario_detalle->id_producto = $descripcion[$index];
            $ingreso_salida_secundario_detalle->cantidad = $cantidad[$index];
            $ingreso_salida_secundario_detalle->precio = round($precio_unitario[$index],2);
            $ingreso_salida_secundario_detalle->sub_total = round($sub_total[$index],2);
            $ingreso_salida_secundario_detalle->igv = round($igv[$index],2);
            $ingreso_salida_secundario_detalle->total = round($total[$index],2);
            $ingreso_salida_secundario_detalle->id_unidad_medida = $unidad[$index];
            $ingreso_salida_secundario_detalle->id_marca = $marca[$index];
            $ingreso_salida_secundario_detalle->estado = 1;
            $ingreso_salida_secundario_detalle->id_usuario_inserta = $id_user;
            $ingreso_salida_secundario_detalle->save();

            $array_ingreso_salida_secundario_detalle[] = $ingreso_salida_secundario_detalle->id;

            /*$IngresoSalidaSecundarioAll = IngresoSalidaSecundarioDetalle::where("id_ingreso_salida_secundario",$id_ingreso_salida_secundario)->where("estado","1")->get();
            
            foreach($IngresoSalidaSecundarioAll as $key=>$row){
                
                if (!in_array($row->id, $array_ingreso_salida_secundario_detalle)){
                    $ingreso_salida_secundario_detalle = IngresoSalidaSecundarioDetalle::find($row->id);
                    $ingreso_salida_secundario_detalle->estado = 0;
                    $ingreso_salida_secundario_detalle->save();
                }
            }*/
        }
        
        return response()->json(['id' => $ingreso_salida_secundario->id]);
        
    }
}
