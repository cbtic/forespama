<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FamiliaContable extends Model
{
    use HasFactory;

    public function listar_familia_contable_ajax($p){

        return $this->readFuntionPostgres('sp_listar_familia_contable_paginado',$p);

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

    function getFamiliaContables(){

        $cad = " select fc.id, fc.denominacion familia_contable, fc.id_plan_contable, cc.cuenta, fc.estado 
        from familia_contables fc 
        inner join cuenta_contables cc on fc.id_plan_contable = cc.id 
        where fc.estado = '1' ";
        
        $data = DB::select($cad);
        return $data;
    }
}
