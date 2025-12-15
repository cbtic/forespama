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
        and cr.id ='".$id_requerimiento."'
        order by 1 desc ";

		$data = DB::select($cad);
        return $data;
    }

    function getCotizacionById($id_requerimiento){

        $cad = "select cr.id, cr.codigo, cr.fecha, e.razon_social empresa, cr.id_moneda, cr.tipo_cambio, cr.sub_total, cr.igv, cr.total, cr.observacion, cr.ruta_cotizacion, cr.estado, cr.id_requerimiento
        from cotizacion_requerimientos cr 
        inner join empresas e on cr.id_empresa = e.id 
        where cr.estado ='1'
        and cr.id_requerimiento ='".$id_requerimiento."'
        order by 1 desc ";

		$data = DB::select($cad);
        return $data;
    }
}
