<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Tienda extends Model
{
    use HasFactory;

    public function listar_tienda_ajax($p){

        return $this->readFuntionPostgres('sp_listar_tiendas_paginado',$p);

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

    function getTiendaOrdenCompraId($id){

        $cad = "select tdoc.id as id_tdoc, t.id as id_tienda, t.denominacion as tienda
        FROM tienda_detalle_orden_compras tdoc
        inner join orden_compras oc ON tdoc.id_orden_compra = oc.id
        inner join tiendas t on tdoc.id_tienda = t.id
        where oc.id = '".$id."'
        and tdoc.id in (
            select min(tdoc.id)
            from tienda_detalle_orden_compras tdoc
            inner join orden_compras oc on tdoc.id_orden_compra = oc.id
            where oc.id = '".$id."'
            group by tdoc.id_tienda
        )
        order by tdoc.id";

		$data = DB::select($cad);
        return $data;
    }

    function getProvinciaDistritoById($id){

        $cad = "select u.id_provincia provincia_partida, u.id_ubigeo distrito_partida
        from tiendas t 
        inner join ubigeos u on t.id_ubigeo = u.id_ubigeo 
        where t.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

    function getTiendasAll(){

        $cad = "select * from tiendas t 
        where estado ='1'";

		$data = DB::select($cad);
        return $data;
    }

}
