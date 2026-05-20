<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CentroCosto extends Model
{
    use HasFactory;

    public function listar_centro_costo_ajax($p){

        return $this->readFuntionPostgres('sp_listar_centro_costo_paginado',$p);

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

    function getCentroCostoBySede($sede){

        $cad = "select cc.id, cc.periodo, cc.codigo, cc.denominacion, cc.operacion, s.denominacion sede, cc.estado 
        from centro_costos cc 
        left join sedes s on cc.id_sede = s.id 
        where cc.estado = '1' 
        and s.id = '".$sede."' 
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }
}
