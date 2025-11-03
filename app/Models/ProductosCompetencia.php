<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductosCompetencia extends Model
{
    use HasFactory;

    public function listar_producto_competencia_ajax($p){

        return $this->readFuntionPostgres('sp_listar_producto_competencia_paginado',$p);

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

    function getProductoDimfer(){

        $cad = "select * from productos_competencias pc 
        where pc.id_competencia ='2'
        and pc.estado ='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoAres(){

        $cad = "select * from productos_competencias pc 
        where pc.id_competencia ='3'
        and pc.estado ='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getProductoCompetenciaById($id_producto){

        $cad = "select * from productos_competencias pc 
        where pc.id='".$id_producto."'";

		$data = DB::select($cad);
        return $data;
    }
}
