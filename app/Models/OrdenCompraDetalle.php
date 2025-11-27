<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenCompraDetalle extends Model
{
    use HasFactory;

    function getDetalleOrdenCompraPdf($id){

        $cad = "select ocd.id, ocd.id_orden_compra, ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra order by ocd.id ASC) AS row_num, p.denominacion producto, p.numero_serie, p.codigo, ocd.cantidad_requerida, ocd.precio, tm.denominacion descuento, ocd.sub_total, ocd.igv, ocd.total, ocd.fecha_fabricacion, ocd.fecha_vencimiento, tm2.denominacion estado_producto, tm3.denominacion unidad_medida, m.denominiacion marca,ocd.estado
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id 
        left join tabla_maestras tm on ocd.id_descuento = tm.codigo ::int and tm.tipo = '55'
        left join tabla_maestras tm2 on ocd.id_estado_producto = tm2.codigo ::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on ocd.id_unidad_medida = tm3.codigo ::int and tm3.tipo = '43'
        left join marcas m on ocd.id_marca = m.id 
        where ocd.id_orden_compra ='".$id."'
        and ocd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getCantidadAbiertoOrdenCompraDetalleByIdOrdenCompra($id_orden_compra){

        $cad = "select count(id) cantidad
        from orden_compra_detalles ocd 
        where id_orden_compra=".$id_orden_compra."
        and ocd.estado='1'
        and ocd.cerrado!='2'";

		$data = DB::select($cad);
        //return $data;
        if(isset($data[0]))return $data[0]->cantidad;
    }

    function getDetalleProductoId($id){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra) AS row_num, '' numero_serie, ocd.id_producto, p.codigo, ocd.id_marca, p.id_unidad_medida, ocd.fecha_vencimiento, ocd.id_unidad_medida id_um, ocd.id_estado_producto id_estado_bien, ocd.cantidad_requerida cantidad, ocd.cantidad_requerida cantidad, ocd.cantidad_requerida cantidad, '12' stock_actual, ocd.precio, ocd.sub_total , ocd.igv, ocd.total, oc.id_almacen_salida, p.denominacion nombre_producto, m.denominiacion nombre_marca, tm2.denominacion nombre_estado_bien, tm3.denominacion nombre_unidad_medida, 
        case when oc.id_tipo_cliente = 1 then 
        (select p.id from personas p
        where p.id = oc.id_persona)
        else (select e2.id from empresas e2 
        where e2.id = oc.id_empresa_compra) 
        end id_empresa_compra,
        case when oc.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = oc.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = oc.id_empresa_compra) 
        end cliente,
        case when oc.id_tipo_cliente = 1 then 
        (select p.numero_documento from personas p
        where p.id = oc.id_persona)
        else (select e2.ruc from empresas e2 
        where e2.id = oc.id_empresa_compra) 
        end documento_cliente,
        oc.id_tipo_cliente,
        oc.numero_orden_compra_cliente,
        (select COALESCE(STRING_AGG(DISTINCT t.denominacion ::TEXT, ', '), '') from tienda_detalle_orden_compras tdoc
        inner join tiendas t on tdoc.id_tienda = t.id
        where tdoc.id_orden_compra = oc.id) tiendas, ocd.valor_venta_bruto, ocd.precio_venta, ocd.valor_venta, ocd.descuento, ocd.id_descuento, p.peso, oc.id, tm5.denominacion tipo_documento_orden,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = oc.id
        limit 1) 
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = oc.id
        limit 1) 
        else (select occe.direccion from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = oc.id)
        end direccion,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = oc.id
        limit 1)
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = oc.id
        limit 1)
        else (select occe.id_ubigeo from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = oc.id)
        end ubigeo
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id
        inner join orden_compras oc on ocd.id_orden_compra = oc.id
        left join marcas m on ocd.id_marca = m.id 
        left join tabla_maestras tm2 on ocd.id_estado_producto ::int = tm2.codigo::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on ocd.id_unidad_medida ::int = tm3.codigo::int and tm3.tipo = '43'
        left join tabla_maestras tm5 on oc.id_tipo_documento = tm5.codigo::int and tm5.tipo ='54'
        where oc.id ='".$id."'
        and ocd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleOrdenCompraExcel($id){

        $cad = "select ocd.id, ocd.id_orden_compra, ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra order by ocd.id ASC) AS row_num, p.denominacion producto, p.numero_serie, p.codigo, ocd.cantidad_requerida, 
        ocd.precio, tm.denominacion nombre_descuento, ocd.sub_total, ocd.igv, ocd.total, ocd.fecha_fabricacion, ocd.fecha_vencimiento, tm2.denominacion estado_producto, tm3.denominacion unidad_medida, 
        m.denominiacion marca,ocd.estado, ocd.precio_venta, ocd.valor_venta_bruto, ocd.valor_venta, ocd.descuento 
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id 
        left join tabla_maestras tm on ocd.id_descuento = tm.codigo ::int and tm.tipo = '55'
        left join tabla_maestras tm2 on ocd.id_estado_producto = tm2.codigo ::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on ocd.id_unidad_medida = tm3.codigo ::int and tm3.tipo = '43'
        left join marcas m on ocd.id_marca = m.id 
        where ocd.id_orden_compra ='".$id."'
        and ocd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }
}
