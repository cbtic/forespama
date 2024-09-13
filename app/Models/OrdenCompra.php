<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenCompra extends Model
{
    use HasFactory;

    public function listar_orden_compra_ajax($p){

        return $this->readFuntionPostgres('sp_listar_orden_compra_paginado',$p);

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

    function getDetalleOrdenCompraId($id){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra ) AS row_num, p.numero_serie item, ocd.id_producto, p.codigo, ocd.id_marca, ocd.id_unidad_medida, ocd.fecha_fabricacion, ocd.fecha_vencimiento, 
        ocd.id_estado_producto , ocd.cantidad, ocd.precio, ocd.sub_total, ocd.igv, ocd.total, ocd.id_descuento 
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id
        where id_orden_compra ='".$id."'
        and ocd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getOrdenCompraAll(){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra ) AS row_num, p.numero_serie item, ocd.id_producto, p.codigo, ocd.id_marca, ocd.id_unidad_medida, ocd.fecha_fabricacion, ocd.fecha_vencimiento, 
        ocd.id_estado_producto , ocd.cantidad, ocd.precio, ocd.sub_total, ocd.igv, ocd.total, ocd.id_descuento 
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id
        where id_orden_compra ='".$id."'
        and ocd.estado='1'";

		$data = DB::select($cad);
        return $data;
        
    }
}
