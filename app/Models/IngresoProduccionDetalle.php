<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoProduccionDetalle extends Model
{
    use HasFactory;

    function getDetalleIngresoProduccionPdf($id){

        $cad = "select ipd.id, ROW_NUMBER() OVER (PARTITION BY ipd.id_ingreso_produccion) AS row_num, p.numero_serie, p.denominacion producto, p.codigo, ipd.cantidad, tm.denominacion estado_producto, tm2.denominacion unidad_medida, m.denominiacion marca 
        from ingreso_produccion_detalles ipd 
        inner join ingreso_produccion ip on ipd.id_ingreso_produccion = ip.id 
        inner join productos p on ipd.id_producto = p.id 
        inner join tabla_maestras tm on ipd.id_estado_producto ::int = tm.codigo::int and tm.tipo = '56'
        inner join tabla_maestras tm2 on ipd.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        left join marcas m on ipd.id_marca = m.id 
        where ip.id ='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
