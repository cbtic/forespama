<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Marca extends Model
{
    use HasFactory;

    public function listar_marca_ajax($p){

        return $this->readFuntionPostgres('sp_listar_marcas_paginado',$p);

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

    function getMarcaAll(){

        $cad = "select * from marcas m 
        where m.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getMarcaProducto(){

        $cad = "select * from marcas m 
        where m.estado='1' and m.id_tipo_marca = '1'";

		$data = DB::select($cad);
        return $data;
    }

    function getMarcaVehiculo(){

        $cad = "select * from marcas m 
        where m.estado='1' and m.id_tipo_marca = '2'";

		$data = DB::select($cad);
        return $data;
    }

    function getMarcaEquipo(){

        $cad = "select * from marcas m 
        where m.estado='1' and m.id_tipo_marca = '3'";

		$data = DB::select($cad);
        return $data;
    }

    function getMarcaByTipoActivo($tipo_activo){

        $cad = "select * from marcas m 
        where m.id_tipo_marca = '".$tipo_activo."'
        and m.estado = '1'";

		$data = DB::select($cad);
        return $data;
    }
}
