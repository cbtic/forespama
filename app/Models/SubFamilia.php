<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SubFamilia extends Model
{
    use HasFactory;

    public function listar_sub_familia_ajax($p){

        return $this->readFuntionPostgres('sp_listar_sub_familia_paginado',$p);

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

    function getCodigoUnico($inicial){

        $cad = "select count(*) cantidad from sub_familias sf  
        where sf.inicial_codigo = '".$inicial."' ";
        
        $data = DB::select($cad);
        return $data;
    }

    function getSubFamilia($familia){

        $cad = "select * from sub_familias sf 
        where sf.id_familia ='".$familia."'
        and sf.estado ='1' ";
                
        $data = DB::select($cad);
        return $data;
    }
}
