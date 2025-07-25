<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenProduccion extends Model
{
    protected $table = 'orden_produccion';

    use HasFactory;

    public function listar_orden_produccion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_orden_produccion_paginado',$p);

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

    function getCodigoOrdenProduccion(){

        $cad = "select lpad(coalesce(max(op.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from orden_produccion op ";

		$data = DB::select($cad);
        return $data;
    }
}
