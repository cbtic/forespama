<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CambioCodigoProducto extends Model
{
    use HasFactory;

    public function listar_cambio_codigo_producto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_cambio_codigo_producto_paginado',$p);

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

    function getCodigoCambioCodigo(){

        $cad = "select lpad(coalesce(max(ccp.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from cambio_codigo_productos ccp ";

		$data = DB::select($cad);
        return $data;
    }
}
