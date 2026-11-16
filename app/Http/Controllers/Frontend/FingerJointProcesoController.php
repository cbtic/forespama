<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FingerJointProceso;
use App\Models\User;
use App\Models\Producto;
use App\Models\Almacene;
use App\Models\TablaMaestra;
use Auth;

class FingerJointProcesoController extends Controller
{
    public function __construct(){

		$this->middleware('auth');
		$this->middleware('can:Finger Joint')->only(['create']);
	}

    public function create(){

        $tablaMaestra_model = new TablaMaestra;
        $user_model = new User;

        $situacion = $tablaMaestra_model->getMaestroByTipo(52);
        $responsable_atencion = $user_model->getUserAll();
		
		return view('frontend.finger_joint_proceso.create',compact('situacion','responsable_atencion'));

	}

    public function listar_finger_joint_proceso_ajax(Request $request){

		$finger_joint_proceso_model = new FingerJointProceso;
		$p[]=$request->denominacion;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $finger_joint_proceso_model->listar_finger_joint_proceso_ajax($p);
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

    public function modal_finger_joint_proceso($id){
		
		$tabla_maestra_model = new TablaMaestra;
		$producto_model = new Producto;
		$almacen_model = new Almacene;

		if($id>0){
			$finger_joint_proceso = FingerJointProceso::find($id);
		}else{
			$finger_joint_proceso = new FingerJointProceso;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');
        $producto = $producto_model->getProductoInterno();
        $almacen = $almacen_model->getAlmacenAll();
        $unidad = $tabla_maestra_model->getMaestroByTipo(43);

		return view('frontend.finger_joint_proceso.modal_finger_joint_proceso_nuevoFingerJointProceso',compact('id','finger_joint_proceso','producto','almacen','unidad'));

    }

    public function send_finger_joint_proceso(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$finger_joint_proceso = new FingerJointProceso;
		}else{
			$finger_joint_proceso = FingerJointProceso::find($request->id);
		}
		
        $finger_joint_proceso->denominiacion = $request->denominacion;
		$finger_joint_proceso->id_tipo_marca = $request->tipo_marca;
		$finger_joint_proceso->estado = 1;
        $finger_joint_proceso->id_usuario_inserta = $id_user;
		$finger_joint_proceso->save();

        return response()->json(['success' => 'Marca guardada exitosamente.']);

    }

    public function eliminar_finger_joint_proceso($id,$estado)
    {
		$finger_joint_proceso = FingerJointProceso::find($id);

		$finger_joint_proceso->estado = $estado;
		$finger_joint_proceso->save();

		echo $finger_joint_proceso->id;
    }

    public function obtenerDetalle($id_producto)
    {

        $finger_joint_model = new FingerJointProceso;
        $producto_model = new Producto;
        $tablaMaestra_model = new TablaMaestra;

        $finger_joint_proceso = $finger_joint_model->getDetalleFingerJointByProducto($id_producto);
        $producto = $producto_model->getProductoAll();
        $unidad_medida = $tablaMaestra_model->getMaestroByTipo(43);

        return response()->json([
            'finger_joint_proceso' => $finger_joint_proceso,
            'producto' => $producto,
            'unidad_medida' => $unidad_medida
        ]);
    }
}
