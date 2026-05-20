<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RequerimientoDispensacionDetalle extends Model
{
    use HasFactory;

    function getRequerimientoDetalleDispensacionPdf($id){

        $cad = "select rdd.id, ROW_NUMBER() OVER (PARTITION BY rdd.id_requerimiento_dispensacion ) AS row_num, p.numero_serie, p.denominacion producto, p.codigo, rdd.cantidad, tm2.denominacion unidad_medida, m.denominiacion marca 
        from requerimiento_dispensacion_detalles rdd 
        inner join requerimiento_dispensaciones rd on rdd.id_requerimiento_dispensacion = rd.id 
        inner join productos p on rdd.id_producto = p.id 
        left join tabla_maestras tm2 on rdd.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        left join marcas m on rdd.id_marca = m.id 
        where rd.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }
}
