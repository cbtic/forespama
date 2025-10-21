<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Reuso extends Model
{
    use HasFactory;

    public function listar_reuso_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reuso_paginado',$p);

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

    function getCodigoReuso(){

        $cad = "select lpad(coalesce(max(r.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from reusos r
        where r.estado = '1'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleReusoById($id){

        $cad = "select rd.id,  ROW_NUMBER() OVER (PARTITION BY rd.id_reuso ) AS row_num, rd.id_producto, p.codigo, 
        rd.id_estado_producto , rd.cantidad, r.id_almacen_destino 
        from reuso_detalles rd  
        inner join productos p on rd.id_producto = p.id
        inner join reusos r on rd.id_reuso  = r.id
        where rd.id_reuso ='".$id."'
        and rd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
}
