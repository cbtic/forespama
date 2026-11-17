<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FingerJointProceso extends Model
{
    use HasFactory;

    function getDetalleFingerJointByProducto($id_producto){

        $cad = "select ed.id,  ROW_NUMBER() OVER (PARTITION BY ed.id_empaquetado) AS row_num, p.numero_serie item, ed.id_producto, p.codigo, ed.id_unidad_medida, ed.cantidad 
        from empaquetado_detalle ed
        inner join productos p on ed.id_producto = p.id
        inner join empaquetado e on ed.id_empaquetado = e.id
        where e.id_producto ='".$id_producto."'
        and ed.estado='1'
        and e.estado ='1' ";

		$data = DB::select($cad);
        return $data;

    }

    function getCodigoFingerJoint(){

        $cad = "select lpad(coalesce(max(fjp.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from finger_joint_procesos fjp
        where fjp.estado ='1'";

		$data = DB::select($cad);
        return $data;
    }
}
