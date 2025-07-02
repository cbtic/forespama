<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DispensacionDetalle extends Model
{
    use HasFactory;

    function getDetalleDispensacionPdf($id){

        $cad = "select dd.id, ROW_NUMBER() OVER (PARTITION BY dd.id_dispensacion) AS row_num, p.numero_serie, p.denominacion producto, p.codigo, dd.cantidad, tm.denominacion estado_producto, tm2.denominacion unidad_medida, m.denominiacion marca from dispensacion_detalles dd 
        inner join dispensaciones d on dd.id_dispensacion = d.id 
        inner join productos p on dd.id_producto = p.id 
        left join tabla_maestras tm on dd.id_estado_producto ::int = tm.codigo::int and tm.tipo = '56'
        left join tabla_maestras tm2 on dd.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        left join marcas m on dd.id_marca = m.id 
        where d.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }
}
