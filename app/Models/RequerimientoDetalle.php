<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RequerimientoDetalle extends Model
{
    function getDetalleRequerimientoPdf($id){

        $cad = "select rd.id, ROW_NUMBER() OVER (PARTITION BY rd.id_requerimiento ) AS row_num, p.numero_serie, p.denominacion producto, p.codigo, rd.cantidad, tm.denominacion estado_producto, tm2.denominacion unidad_medida, m.denominiacion marca 
        from requerimiento_detalles rd 
        inner join requerimientos r on rd.id_requerimiento = r.id 
        inner join productos p on rd.id_producto = p.id 
        left join tabla_maestras tm on rd.id_estado_producto ::int = tm.codigo::int and tm.tipo = '56'
        left join tabla_maestras tm2 on rd.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        left join marcas m on rd.id_marca = m.id 
        where r.id ='".$id."' and rd.estado ='1'
        order by 1 asc ";

		$data = DB::select($cad);
        return $data;
    }
}
