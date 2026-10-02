<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionParametro extends Model
{
    use HasFactory;

    public function listar_comision_parametro_ajax($p){

        return $this->readFuntionPostgres('sp_listar_comision_parametro_paginado',$p);

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

    function getUltimoParametro(){

        $cad = "select cp.id, cp.porcentaje_comision, cp.minimo_retiro, cp.estado 
        from comision_parametros cp 
        where cp.estado ='1'
        order by 1 desc
        limit 1";

		$data = DB::select($cad);
        return $data;
    }

}
