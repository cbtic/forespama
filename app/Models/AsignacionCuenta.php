<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AsignacionCuenta extends Model
{
    use HasFactory;

    public function listar_asignacion_cuenta_ajax($p){

        return $this->readFuntionPostgres('sp_listar_asignacion_cuenta_paginado',$p);

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

    function obtenerAsignacionCuentaVenta(){

        $cad = "select *
        from asignacion_cuentas ac 
        where ac.id_origen = '2'
        and ac.id_tipo_cuenta = '1'";

		$data = DB::select($cad);
        return $data;
    }
}
