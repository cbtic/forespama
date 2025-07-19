<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Activo extends Model
{
    use HasFactory;

    public function listar_activos_ajax($p){

        return $this->readFuntionPostgres('sp_listar_activos_paginado',$p);

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
    
    function getProvinciaDistritoById($id){

        $cad = "select u.id_provincia provincia_partida, u.id_ubigeo distrito_partida from activos a 
        inner join ubigeos u on a.id_ubigeo = u.id_ubigeo::int
        where a.id = '".$id."' ";

		$data = DB::select($cad);
        return $data;
    }
}
