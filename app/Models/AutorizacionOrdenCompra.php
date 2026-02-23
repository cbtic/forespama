<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AutorizacionOrdenCompra extends Model
{
    use HasFactory;

    function getHistorialAutorizacionPedido($id){

        $cad = "select aoc.id, aoc.id_orden_compra, tm.denominacion proceso, tm2.denominacion autorizacion, u.name usuario_autoriza, aoc.estado, to_char(aoc.created_at, 'dd-mm-yyyy') fecha_registro, to_char(aoc.created_at, 'HH24:MI:SS') hora_registro,
        to_char(aoc.updated_at, 'dd-mm-yyyy') fecha_aprobacion, to_char(aoc.updated_at, 'HH24:MI:SS') hora_aprobacion
        from autorizacion_orden_compras aoc 
        left join tabla_maestras tm on aoc.id_proceso_pedido ::int = tm.codigo ::int and tm.tipo = '109'
        left join tabla_maestras tm2 on aoc.id_autorizacion ::int = tm2.codigo ::int and tm2.tipo = '100'
        left join users u on aoc.id_usuario_autoriza = u.id
        where aoc.id_orden_compra ='".$id."' 
        and aoc.estado = '1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

}
