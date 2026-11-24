<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FingerJointProceso extends Model
{
    use HasFactory;

    public function listar_finger_joint_proceso_ajax($p){

        return $this->readFuntionPostgres('sp_listar_finger_joint_proceso_paginado',$p);

    }

    public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;

    }

    function getDetalleFingerJointById($id){

        $cad = "select ed.id,  ROW_NUMBER() OVER (PARTITION BY ed.id_empaquetado) AS row_num, p.numero_serie item, ed.id_producto, p.codigo, ed.id_unidad_medida, ed.cantidad 
        from empaquetado_detalle ed
        inner join productos p on ed.id_producto = p.id
        inner join empaquetado e on ed.id_empaquetado = e.id
        where e.id ='".$id."'
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
