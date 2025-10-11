<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EquivalenciaProducto extends Model
{
    use HasFactory;

    public function listar_equivalencia_producto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_equivalencia_producto_paginado',$p);

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

    function getEquivalenciaProductoAll(){

        $cad = "select * from equivalencia_productos ep 
        where ep.estado ='1' ";

		$data = DB::select($cad);
        return $data;
    }
}
