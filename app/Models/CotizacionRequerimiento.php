<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CotizacionRequerimiento extends Model
{
    use HasFactory;

    function getCodigoCotizacion(){

        $cad = "select lpad(coalesce(max(cr.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from cotizacion_requerimientos cr ";

		$data = DB::select($cad);
        return $data;
    }

    function getCotizacionByIdRequerimiento($id_requerimiento){

        $cad = "select cr.id, cr.codigo, cr.fecha, e.razon_social empresa, cr.id_moneda, cr.tipo_cambio, cr.sub_total, cr.igv, cr.total, cr.observacion, cr.ruta_cotizacion, cr.estado, cr.id_requerimiento
        from cotizacion_requerimientos cr 
        inner join empresas e on cr.id_empresa = e.id 
        where cr.estado ='1'
        and cr.id_requerimiento ='".$id_requerimiento."'
        order by 1 desc ";

		$data = DB::select($cad);
        return $data;
    }

    function getCotizacionById($id){

        $cad = "select cdr.id, cr.codigo, cr.numero_cotizacion, cr.vendedor, cr.igv_compra, cr.fecha, e.razon_social empresa, cr.telefono, cr.id_empresa, cr.id_moneda, cr.tipo_cambio, cr.sub_total, cr.igv, cr.total, 
        cr.observacion, cr.ruta_cotizacion, cr.estado, cr.id_requerimiento,
        cdr.id_producto, p.denominacion producto, p.id_marca, m.denominiacion marca, cdr.id_unidad_medida, tm.denominacion unidad_medida, cdr.cantidad, cdr.precio_venta, cdr.precio_unitario, cdr.valor_venta_bruto, cdr.valor_venta, cdr.sub_total, cdr.igv, cdr.total 
        from cotizacion_requerimientos cr 
        inner join empresas e on cr.id_empresa = e.id 
        inner join cotizacion_detalle_requerimientos cdr on cr.id = cdr.id_cotizacion_requerimientos 
        inner join productos p on cdr.id_producto = p.id 
        left join marcas m on p.id_marca = m.id 
        left join tabla_maestras tm on cdr.id_unidad_medida = tm.codigo::int and tm.tipo ='43'
        where cr.estado ='1'
        and cr.id ='".$id."'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
