<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Empaquetado;
use App\Models\TablaMaestra;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\EmpaquetadoDetalle;
use Auth;
use Carbon\Carbon;

class EmpaquetadoController extends Controller
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

        $producto = Producto::all();
		
		return view('frontend.empaquetado.create',compact('producto'));

	}

    public function modal_empaquetado($id){

        $id_user = Auth::user()->id;

		if($id>0){
			$empaquetado = Empaquetado::find($id);
		}else{
			$empaquetado = new Empaquetado;
		}

        $tablaMaestra_model = new TablaMaestra;

        $producto = Producto::all();
        $unidad = $tablaMaestra_model->getMaestroByTipo(43);
        $almacen_destino = Almacene::all();

        //dd($id);exit();
        
		//var_dump($codigo[0]->codigo);exit();

		return view('frontend.empaquetado.modal_empaquetados_nuevoEmpaquetado',compact('id','empaquetado','producto','unidad','almacen_destino','id_user'));

    }

    public function listar_empaquetados_ajax(Request $request){

		$empaquetado_model = new Empaquetado();
		$p[]=$request->producto_empaquetado;
        $p[]=$request->numero_empaquetado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $empaquetado_model->listar_empaquetados_ajax($p);
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

    public function send_empaquetado(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$empaquetado = new Empaquetado;
		}else{
			$empaquetado = Empaquetado::find($request->id);
		}
		
        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $unidad = $request->input('unidad');
        $cantidad = $request->input('cantidad');
        $id_empaquetado_detalle =$request->id_empaquetado_detalle;
		
		$empaquetado->id_producto = $request->producto;
        $empaquetado->codigo = $request->codigo_empaquetado;
        $empaquetado->fecha = $request->fecha;
        //$empaquetado->id_almacen_destino = $request->almacen_destino;
        $empaquetado->id_usuario_inserta = $id_user;
		$empaquetado->estado = 1;
		$empaquetado->save();

		foreach($descripcion as $index => $value) {
            
            if($id_empaquetado_detalle[$index] == 0){
                $empaquetado_detalle = new EmpaquetadoDetalle;
            }else{
                $empaquetado_detalle = EmpaquetadoDetalle::find($id_empaquetado_detalle[$index]);
            }
            
            $empaquetado_detalle->id_empaquetado = $empaquetado->id;
            $empaquetado_detalle->id_producto = $descripcion[$index];
            $empaquetado_detalle->id_unidad_medida = $unidad[$index];
            $empaquetado_detalle->cantidad = $cantidad[$index];
            $empaquetado_detalle->estado = 1;
            $empaquetado_detalle->id_usuario_inserta = $id_user;

            $empaquetado_detalle->save();

            $array_empaquetado_detalle[] = $empaquetado_detalle->id;

            $EmpaquetadoAll = EmpaquetadoDetalle::where("id_empaquetado",$empaquetado->id)->where("estado","1")->get();
            
            foreach($EmpaquetadoAll as $key=>$row){
                
                if (!in_array($row->id, $array_empaquetado_detalle)){
                    $empaquetado_detalle = EmpaquetadoDetalle::find($row->id);
                    $empaquetado_detalle->estado = 0;
                    $empaquetado_detalle->save();
                }
            }
        }
    }

    public function eliminar_empaquetado($id,$estado)
    {
		$empaquetado = Empaquetado::find($id);

		$empaquetado->estado = $estado;
		$empaquetado->save();

		echo $empaquetado->id;
    }

    public function obtener_codigo_empaquetado(){
		
		$empaquetado_model = new Empaquetado;
		$codigo_empaquetado = $empaquetado_model->getCodigoEmpaquetado();
		
		return response()->json($codigo_empaquetado);
	}

    public function cargar_detalle($id)
    {

        $empaquetado_model = new Empaquetado;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $empaquetado = $empaquetado_model->getDetalleEmpaquetadoById($id);
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'empaquetado' => $empaquetado,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida
        ]);
    }

}
