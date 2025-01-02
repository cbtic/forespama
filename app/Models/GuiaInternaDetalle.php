<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class GuiaInternaDetalle extends Model
{
    use HasFactory;

    function getDetalleGuiaInternaPdf($id){

        $cad = "select gid.id, ROW_NUMBER() OVER (PARTITION BY gid.id_guia_interna ) AS row_num, p.denominacion producto, gid.cantidad, tm.denominacion estado_producto, tm2.denominacion unidad_medida, m.denominiacion marca, 
        ep.codigo_producto, ep.codigo_empresa, ep.descripcion_producto, ep.descripcion_empresa, ep.id_producto, ep.id_empresa 
        from guia_interna_detalles gid 
        inner join guia_internas gi on gid.id_guia_interna = gi.id
        inner join productos p on gid.id_producto = p.id
        left join marcas m on gid.id_marca = m.id 
        inner join tabla_maestras tm on gid.id_estado_producto ::int = tm.codigo::int and tm.tipo = '56'
        left join tabla_maestras tm2 on gid.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        left join equivalencia_productos ep on gid.id_producto = ep.id_producto 
        where gi.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }

}
