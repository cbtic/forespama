<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntradaProductoDetalle extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_entrada_productos',
        'id_producto',
        'item',
        'cantidad',
        'numero_lote',
        'fecha_vencimiento',
        'aplica_precio',
        'id_um',
        'id_estado_bien',
        'id_marca',
        'estado'
    ];

    public function productos()
    {
        return $this->hasOne('Producto');
    }

    function getDetalleProductoId($id){

        $cad = "select epd.id,  ROW_NUMBER() OVER (PARTITION BY epd.id_entrada_productos ) AS row_num, epd.numero_serie, epd.id_producto, p.codigo, epd.id_marca, p.id_unidad_medida, epd.fecha_fabricacion, epd.fecha_vencimiento, epd.id_um, epd.id_estado_bien , epd.cantidad, epd.cantidad, epd.cantidad, '12' stock_actual, epd.costo, epd.sub_total , epd.igv , epd.total, ep.id_almacen_destino, p.denominacion nombre_producto, m.denominiacion nombre_marca, tm2.denominacion nombre_estado_bien, tm3.denominacion nombre_unidad_medida, ep.id_empresa_compra, e.ruc, e.razon_social, oc.numero_orden_compra_cliente,
        (select COALESCE(STRING_AGG(DISTINCT t.denominacion ::TEXT, ', '), '') from tienda_detalle_orden_compras tdoc
        inner join tiendas t on tdoc.id_tienda = t.id
        where tdoc.id_orden_compra = oc.id) tiendas, p.peso
        from entrada_producto_detalles epd 
        inner join productos p on epd.id_producto = p.id
        inner join entrada_productos ep on epd.id_entrada_productos = ep.id
        left join marcas m on epd.id_marca = m.id 
        inner join tabla_maestras tm2 on epd.id_estado_bien ::int = tm2.codigo::int and tm2.tipo = '56'
        left join tabla_maestras tm3 on epd.id_um ::int = tm3.codigo::int and tm3.tipo = '43'
        inner join empresas e on ep.id_empresa_compra = e.id
        inner join orden_compras oc on ep.id_orden_compra = oc.id 
        where id_entrada_productos ='".$id."'
        and epd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleProductoPdf($id){

        $cad = "select epd.id,  ROW_NUMBER() OVER (PARTITION BY epd.id_entrada_productos ) AS row_num, epd.numero_serie , p.denominacion producto, p.codigo, m.denominiacion marca, tm2.denominacion unidad_medida, epd.fecha_fabricacion, epd.fecha_vencimiento, tm.denominacion estado_bien, epd.cantidad, epd.cantidad, epd.cantidad, '12' stock_actual, epd.costo, epd.sub_total , epd.igv, epd.total, epd.id_producto   
        from entrada_producto_detalles epd 
        inner join productos p on epd.id_producto = p.id
        left join marcas m on epd.id_marca = m.id
        inner join tabla_maestras tm on epd.id_estado_bien ::int = tm.codigo::int and tm.tipo = '4'
        inner join tabla_maestras tm2 on epd.id_um ::int = tm2.codigo::int and tm2.tipo = '43'
        where id_entrada_productos ='".$id."'
        and epd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getCantidadEntradaProductoByOrdenProducto($id_orden_compra,$id_producto){

        $cad = "select sum(cantidad) cantidad_ingresada
        from entrada_productos ep 
        inner join entrada_producto_detalles epd on ep.id=epd.id_entrada_productos 
        where id_orden_compra =".$id_orden_compra."
        and epd.id_producto=".$id_producto;

		$data = DB::select($cad);
        //return $data;
        if(isset($data[0]))return $data[0]->cantidad_ingresada;
    }

}
