<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Devolucione extends Model
{
    use HasFactory;

    public function listar_devolucion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_devolucion_paginado',$p);

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

    function getDetalleDevolucionId($id){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra ) AS row_num, p.numero_serie item, ocd.id_producto, p.codigo, p.denominacion nombre_producto, ocd.id_marca, ocd.id_unidad_medida, ocd.fecha_fabricacion, ocd.fecha_vencimiento, 
        ocd.id_estado_producto , ocd.cantidad_requerida, 
        coalesce((select sum(cantidad)
        from entrada_productos ep
        inner join entrada_producto_detalles epd on ep.id=epd.id_entrada_productos 
        where id_orden_compra =ocd.id_orden_compra 
        and epd.id_producto=ocd.id_producto),0)cantidad_ingresada,
        ocd.precio, ocd.sub_total, ocd.igv, ocd.total, ocd.id_descuento, oc.id_almacen_salida, oc.id_unidad_origen, oc.id_almacen_destino ,
        m.denominiacion marca,
        coalesce((select k.saldos_cantidad from kardex k where id_producto = ocd.id_producto and id_almacen_destino = 3  order by 1 desc limit 1),0)stock_ves, --ves
        coalesce((select k.saldos_cantidad from kardex k where id_producto = ocd.id_producto and id_almacen_destino = 2  order by 1 desc limit 1),0)stock_oxa, --oxa
        ocd.valor_venta_bruto, precio_venta, valor_venta, ocd.id_descuento, ocd.descuento
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id
        inner join orden_compras oc on ocd.id_orden_compra = oc.id
        left join marcas m on ocd.id_marca=m.id
        where id_orden_compra ='".$id."'
        and ocd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
}
