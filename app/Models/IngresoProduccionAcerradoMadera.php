<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoProduccionAcerradoMadera extends Model
{
    use HasFactory;

    public function listar_ingreso_produccion_acerrado_madera_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_produccion_acerrado_madera_paginado',$p);

    }

    function obtenerLote($fecha){

        $cad = "select 'AM' || '-' || '".$fecha."' || '-' || lpad(coalesce(max(split_part(ipam.lote, '-', 3))::int + 1, 1)::text, 2, '0') as lote
        from ingreso_produccion_acerrado_maderas ipam
        where ipam.lote like 'AM' || '-' || '".$fecha."' || '-%'";

		$data = DB::select($cad);
        return $data;
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
}
