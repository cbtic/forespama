<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Familia extends Model
{
    use HasFactory;

    public function listar_familia_ajax($p){

        return $this->readFuntionPostgres('sp_listar_familia_paginado',$p);

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

    function getFamiliaAll(){

        $cad = "select f.id, f.denominacion, f.estado from familias f 
        where f.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getFamiliaActivos(){

        $cad = "select f.id, f.denominacion, f.estado from familias f 
        where f.estado='1'
        and f.id='8'";

		$data = DB::select($cad);
        return $data;
    }
}
