<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SalidaProductoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_salida_productos',
        'id_producto',
        'item',
        'cantidad',
        'numero_lote',
        'fecha_vencimiento',
        'aplica_precio',
        'id_um',
        'id_estado_productos',
        'id_marca',
        'estado'
    ];

    function getDetalleProductoId($id){

        $cad = "select spd.id,  ROW_NUMBER() OVER (PARTITION BY spd.id_salida_productos ) AS row_num, spd.numero_serie, spd.id_producto, p.codigo, spd.id_marca, p.id_unidad_medida, spd.fecha_vencimiento, spd.id_um, spd.id_estado_productos id_estado_bien, spd.cantidad, spd.cantidad, spd.cantidad, '12' stock_actual, spd.costo, spd.sub_total , spd.igv, spd.total, sp.id_almacen_salida, p.denominacion nombre_producto, m.denominiacion nombre_marca, tm2.denominacion nombre_estado_bien, tm3.denominacion nombre_unidad_medida, 
        --sp.id_empresa_compra, 
        --e.ruc, e.razon_social, 
        case when sp.id_tipo_cliente = 1 then 
        (select p.id from personas p
        where p.id = sp.id_persona)
        else (select e2.id from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end id_empresa_compra,
        case when sp.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = sp.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end cliente,
        case when sp.id_tipo_cliente = 1 then 
        (select p.numero_documento from personas p
        where p.id = sp.id_persona)
        else (select e2.ruc from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end documento_cliente,
        sp.id_tipo_cliente,
        oc.numero_orden_compra_cliente,
        (select COALESCE(STRING_AGG(DISTINCT t.denominacion ::TEXT, ', '), '') from tienda_detalle_orden_compras tdoc
        inner join tiendas t on tdoc.id_tienda = t.id
        where tdoc.id_orden_compra = oc.id) tiendas, spd.valor_venta_bruto, spd.precio_venta, spd.valor_venta, spd.descuento, spd.id_descuento, p.peso, sp.id_orden_compra,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1) 
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1) 
        else (select occe.direccion from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = sp.id_orden_compra)
        end direccion,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1)
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1)
        else (select occe.id_ubigeo from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = sp.id_orden_compra)
        end ubigeo
        from salida_producto_detalles spd 
        inner join productos p on spd.id_producto = p.id
        inner join salida_productos sp on spd.id_salida_productos = sp.id
        left join marcas m on spd.id_marca = m.id 
        left join tabla_maestras tm2 on spd.id_estado_productos ::int = tm2.codigo::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on spd.id_um ::int = tm3.codigo::int and tm3.tipo = '43'
        --inner join empresas e on sp.id_empresa_compra = e.id
        inner join orden_compras oc on sp.id_orden_compra = oc.id 
        --left join tienda_detalle_orden_compras tdoc on tdoc.id_orden_compra = oc.id
        where id_salida_productos ='".$id."'
        and spd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleProductoPdf($id){

        $cad = "select spd.id,  ROW_NUMBER() OVER (PARTITION BY spd.id_salida_productos ) AS row_num, spd.numero_serie , p.denominacion producto, p.codigo, m.denominiacion marca, tm2.denominacion unidad_medida, '' fecha_fabricacion, spd.fecha_vencimiento, tm.denominacion estado_bien, spd.cantidad, spd.cantidad, spd.cantidad, '12' stock_actual, spd.costo, spd.sub_total, spd.igv, spd.total, spd.id_producto  
        from salida_producto_detalles spd 
        inner join productos p on spd.id_producto = p.id
        left join marcas m on spd.id_marca = m.id
        left join tabla_maestras tm on spd.id_estado_productos ::int = tm.codigo::int and tm.tipo = '4'
        inner join tabla_maestras tm2 on spd.id_um ::int = tm2.codigo::int and tm2.tipo = '43'
        where id_salida_productos ='".$id."'
        and spd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getCantidadSalidaProductoByOrdenProducto($id_orden_compra,$id_producto){

        $cad = "select sum(cantidad) cantidad_ingresada
        from salida_productos sp 
        inner join salida_producto_detalles spd on sp.id=spd.id_salida_productos 
        where id_orden_compra ='".$id_orden_compra."'
        and spd.id_producto='".$id_producto."'
        and spd.estado='1'
        and spd.tipo_devolucion ='1'";

		$data = DB::select($cad);
        //return $data;
        if(isset($data[0]))return $data[0]->cantidad_ingresada;
    }

    function getDetalleProductoIdGuia($id){

        $cad = "select spd.id,  ROW_NUMBER() OVER (PARTITION BY spd.id_salida_productos ) AS row_num, spd.numero_serie, spd.id_producto, p.codigo, spd.id_marca, p.id_unidad_medida, spd.fecha_vencimiento, spd.id_um, spd.id_estado_productos id_estado_bien, spd.cantidad, spd.cantidad, spd.cantidad, '12' stock_actual, spd.costo, spd.sub_total , spd.igv, spd.total, sp.id_almacen_salida, p.denominacion nombre_producto, m.denominiacion nombre_marca, tm2.denominacion nombre_estado_bien, tm3.denominacion nombre_unidad_medida, 
        case when sp.id_tipo_cliente = 1 then 
        (select p.id from personas p
        where p.id = sp.id_persona)
        else (select e2.id from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end id_empresa_compra,
        case when sp.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = sp.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end cliente,
        case when sp.id_tipo_cliente = 1 then 
        (select p.numero_documento from personas p
        where p.id = sp.id_persona)
        else (select e2.ruc from empresas e2 
        where e2.id = sp.id_empresa_compra) 
        end documento_cliente,
        sp.id_tipo_cliente, oc.numero_orden_compra_cliente, oc.numero_orden_compra,
        (select COALESCE(STRING_AGG(DISTINCT t.denominacion ::TEXT, ', '), '') from tienda_detalle_orden_compras tdoc
        inner join tiendas t on tdoc.id_tienda = t.id
        where tdoc.id_orden_compra = oc.id) tiendas, spd.valor_venta_bruto, spd.precio_venta, spd.valor_venta, spd.descuento, spd.id_descuento, p.peso, sp.id_orden_compra,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1) 
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.direccion from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1) 
        else (select occe.direccion from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = sp.id_orden_compra)
        end direccion,
        case when oc.id_empresa_compra = 23 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1)
        when oc.id_empresa_compra = 187 then 
        (select distinct t2.id_ubigeo from tienda_detalle_orden_compras tdoc2
        inner join tiendas t2 on tdoc2.id_tienda = t2.id
        where tdoc2.id_orden_compra = sp.id_orden_compra
        limit 1)
        else (select occe.id_ubigeo from orden_compra_contacto_entregas occe 
        inner join orden_compras oc2 on occe.id_orden_compra = oc2.id 
        where oc2.id = sp.id_orden_compra)
        end ubigeo
        from salida_producto_detalles spd 
        inner join productos p on spd.id_producto = p.id
        inner join salida_productos sp on spd.id_salida_productos = sp.id
        left join marcas m on spd.id_marca = m.id 
        left join tabla_maestras tm2 on spd.id_estado_productos ::int = tm2.codigo::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on spd.id_um ::int = tm3.codigo::int and tm3.tipo = '43'
        inner join orden_compras oc on sp.id_orden_compra = oc.id 
        where id_salida_productos ='".$id."'
        and spd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
}
