<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenProduccionDetalle extends Model
{
    use HasFactory;

    function getDetalleOrdenProduccionPdf($id){

        $cad = "select opd.id, opd.id_orden_produccion, ROW_NUMBER() OVER (PARTITION BY opd.id_orden_produccion) AS row_num, p.denominacion producto, p.numero_serie, p.codigo, opd.cantidad, tm.denominacion unidad_medida, opd.estado
        from orden_produccion_detalles opd 
        inner join productos p on opd.id_producto = p.id 
        inner join tabla_maestras tm on p.id_unidad_producto = tm.codigo ::int and tm.tipo = '43'
        where opd.id_orden_produccion ='".$id."'
        and opd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getCantidadOrdenCompraByOrdenProduccionProducto($id_orden_produccion,$id_producto){

        $cad = "select sum(ocd.cantidad_requerida) cantidad_ingresada
        from orden_compras oc  
        inner join orden_compra_detalles ocd on oc.id=ocd.id_orden_compra and ocd.estado = '1'
        where oc.id_orden_produccion = '".$id_orden_produccion."'
        and ocd.id_producto= '".$id_producto."' 
        and oc.estado = '1' ";

		$data = DB::select($cad);
        //return $data;
        if(isset($data[0]))return $data[0]->cantidad_ingresada;
    }

    function getCantidadAbiertoOrdenProduccionDetalleByIdOrdenProduccion($id_orden_produccion){

        $cad = "select count(id) cantidad
        from orden_produccion_detalles opd  
        where opd.id_orden_produccion = '".$id_orden_produccion."'
        and opd.estado='1'
        and opd.cerrado!='2' ";

		$data = DB::select($cad);
        //return $data;
        if(isset($data[0]))return $data[0]->cantidad;
    }
}
