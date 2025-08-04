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

    function getCodigo($sub_familia){

        $cad = "select  sf.inicial_codigo || lpad((coalesce(max(substring(p.codigo from '.{4}$')::int), 0) + 1)::text,4, '0') nuevo_codigo from sub_familias sf 
        inner join productos p on sf.id = p.id_sub_familia 
        where sf.id = '".$sub_familia."'
        and sf.estado ='1'
        group by sf.inicial_codigo";
        
        $data = DB::select($cad);
        return $data;
    }
}
