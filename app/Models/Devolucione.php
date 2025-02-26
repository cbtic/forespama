<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Devolucione extends Model
{

    protected $table = 'devolucione';

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

    function getDetalleDevolucionId($codigo_salida){

        $cad = "select spd.id,  ROW_NUMBER() OVER (PARTITION BY spd.id_salida_productos) AS row_num, p.numero_serie item, spd.id_producto, p.codigo, p.denominacion nombre_producto, spd.id_marca, spd.id_um, 
        spd.cantidad, spd.costo, spd.sub_total, spd.igv, spd.total, spd.id_descuento, sp.id_almacen_salida, sp.unidad_destino,
        m.denominiacion marca, spd.valor_venta_bruto, precio_venta, valor_venta, spd.id_descuento, spd.descuento, oc.numero_orden_compra_cliente, sp.id_empresa_compra, sp.id_moneda, oc.igv_compra, sp.id id_salida
        from salida_producto_detalles spd 
        inner join productos p on spd.id_producto = p.id
        inner join salida_productos sp on spd.id_salida_productos = sp.id
        inner join orden_compras oc on sp.id_orden_compra = oc.id
        left join marcas m on spd.id_marca=m.id
        where  sp.codigo ='".$codigo_salida."'
        and spd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getCodigoDevolucion(){

        $cad = "select lpad(coalesce(max(d.numero_devolucion ::int) + 1, 1)::varchar, 6, '0') codigo
        from devolucione d ";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleDevolucionIdCargar($id){

        $cad = "select dd.id,  ROW_NUMBER() OVER (PARTITION BY dd.id_devolucion) AS row_num, p.numero_serie item, dd.id_producto, p.codigo, p.denominacion nombre_producto, dd.id_marca, dd.id_unidad_medida, 
        dd.cantidad, dd.precio_unitario, dd.sub_total, dd.igv, dd.total, dd.id_descuento, d.id_almacen, sp.unidad_destino,
        m.denominiacion marca, dd.valor_venta_bruto, dd.precio_venta, dd.valor_venta, dd.id_descuento, dd.descuento, oc.numero_orden_compra_cliente, sp.id_empresa_compra, d.id_moneda, d.igv_compra , sp.id id_salida 
        from devolucion_detalle dd 
        inner join productos p on dd.id_producto = p.id
        inner join devolucione d on dd.id_devolucion = d.id
        inner join salida_productos sp on d.id_salida = sp.id 
        inner join orden_compras oc on sp.id_orden_compra = oc.id
        left join marcas m on dd.id_marca=m.id
        where  dd.id_devolucion ='".$id."'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }
}
