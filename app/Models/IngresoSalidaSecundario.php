<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoSalidaSecundario extends Model
{
    use HasFactory;

    public function listar_ingreso_salida_secundarios_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_salida_secundario_paginado',$p);

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

    function getCodigoIngresoSalidaB($tipo_documento){

        $cad = "select lpad(coalesce(max(iss.numero_ingreso_salida::int) + 1, 1)::varchar, 6, '0') codigo
        from ingreso_salida_secundarios iss
        where iss.id = '".$tipo_documento."' ";

		$data = DB::select($cad);
        return $data;
    }

}
