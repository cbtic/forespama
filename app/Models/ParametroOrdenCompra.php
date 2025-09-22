<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ParametroOrdenCompra extends Model
{
    use HasFactory;

    public function listar_parametro_validacion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_parametro_validacion_paginado',$p);

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

    function getParametroOrdenCompraById($id){

        $cad = "select poc.id, oc.id id_orden_compra, oc.numero_orden_compra, oc.total, p.nombre_acuerdo_comercial, poc.valor, poc.aplica_parametro, poc.estado_validacion from parametro_orden_compras poc 
        inner join orden_compras oc on poc.id_orden_compra = oc.id 
        inner join parametros p on poc.id_parametro = p.id 
        where poc.id_orden_compra ='".$id."'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }

}
