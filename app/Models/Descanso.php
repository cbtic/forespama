<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Descanso extends Model
{
    use HasFactory;

    public function listar_descanso_ajax($p){

        return $this->readFuntionPostgres('sp_listar_descanso_paginado',$p);

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

    function getDetalleDescansoId($id){

        $cad = "select dd.id,  ROW_NUMBER() OVER (PARTITION BY dd.id_descanso  ) AS row_num, dd.id_producto, p.codigo, p.denominacion nombre_producto, p.id_unidad_medida, 
        dd.cantidad 
        from descanso_detalles dd 
        inner join productos p on dd.id_producto = p.id
        inner join descansos d on dd.id_descanso = d.id
        where dd.id_descanso ='".$id."'
        and dd.estado='1'
        order by dd.id asc";
        
		$data = DB::select($cad);
        return $data;
    }
}
