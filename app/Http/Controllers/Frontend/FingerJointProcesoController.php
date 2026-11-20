<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FingerJointProceso;
use App\Models\FingerJointProcesoDetalle;
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
		$p[]=$request->fecha_inicio;
        $p[]=$request->fecha_fin;
        //$p[]=$request->operador_bus;
        //$p[]=$request->situacion;
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
		$user_model = new User;

		if($id>0){
			$finger_joint_proceso = FingerJointProceso::find($id);
		}else{
			$finger_joint_proceso = new FingerJointProceso;
		}

		$tipo_marca = $tabla_maestra_model->getMaestroByTipo('64');
        $producto = $producto_model->getProductoInterno();
        $almacen = $almacen_model->getAlmacenAll();
        $unidad = $tabla_maestra_model->getMaestroByTipo(43);
        $responsable_atencion = $user_model->getUserAll();

		return view('frontend.finger_joint_proceso.modal_finger_joint_proceso_nuevoFingerJointProceso',compact('id','finger_joint_proceso','producto','almacen','unidad','responsable_atencion'));

    }

    public function send_finger_joint_proceso(Request $request){

        $id_user = Auth::user()->id;

		if($request->id == 0){
			$finger_joint_proceso = new FingerJointProceso;
            $finger_joint_proceso_model = new FingerJointProceso;
		    $codigo_finger_joint_proceso = $finger_joint_proceso_model->getCodigoFingerJoint();
		}else{
			$finger_joint_proceso = FingerJointProceso::find($request->id);
            $codigo_finger_joint_proceso = $request->numero_requerimiento;
		}

        $descripcion = $request->input('descripcion');
        $cod_interno = $request->input('cod_interno');
        $unidad = $request->input('unidad');
        $cantidad_ingreso = $request->input('cantidad_ingreso');
		
        $id_finger_joint_proceso_detalle =$request->id_finger_joint_proceso_detalle;

        $finger_joint_proceso->id_almacen = $request->almacen_destino;
        $finger_joint_proceso->fecha = $request->fecha;
        $finger_joint_proceso->id_producto_principal = $request->producto;
        $finger_joint_proceso->cantidad = $request->cantidad_producto;
        if($request->id == 0){
            $finger_joint_proceso->codigo = $codigo_finger_joint_proceso[0]->codigo;
        }else{
            $finger_joint_proceso->codigo = $codigo_finger_joint_proceso;
        }
        $finger_joint_proceso->id_operador = $request->operador;
        $finger_joint_proceso->observacion = $request->observacion;
		$finger_joint_proceso->estado = 1;
        $finger_joint_proceso->id_usuario_inserta = $id_user;
		$finger_joint_proceso->save();

        $id_finger_joint_proceso = $finger_joint_proceso->id;

        foreach($descripcion as $index => $value) {
            
            if($id_finger_joint_proceso_detalle[$index] == 0){
                $finger_joint_proceso_detalle = new FingerJointProcesoDetalle;
            }else{
                $finger_joint_proceso_detalle = FingerJointProcesoDetalle::find($id_finger_joint_proceso_detalle[$index]);
            }
            
            $finger_joint_proceso_detalle->id_finger_joint_proceso = $id_finger_joint_proceso;
            $finger_joint_proceso_detalle->id_producto = $descripcion[$index];
            $finger_joint_proceso_detalle->cantidad = $cantidad_ingreso[$index];
            $finger_joint_proceso_detalle->id_unidad_medida = $unidad[$index];
            $finger_joint_proceso_detalle->estado = 1;
            $finger_joint_proceso_detalle->id_usuario_inserta = $id_user;

            $finger_joint_proceso_detalle->save();
        }

        return response()->json(['success' => 'Registro guardado exitosamente.']);

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
