<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use DB;

class CuentaContable extends Model
{
    use HasFactory;

    public function listar_cuenta_contable_ajax($p){

        return $this->readFuntionPostgres('sp_listar_cuenta_contable_paginado',$p);

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

    function getCuentaContables(){

        $cad = "select cc.id, cc.denominacion, cc.cuenta, cc.id_tipo, cc.estado 
        from cuenta_contables cc 
        where cc.estado = '1'";
        
		$data = DB::select($cad);
        return $data;
    }
}
