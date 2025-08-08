<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ControlMantenimientoActivo extends Model
{
    use HasFactory;

    function getControlMantenimientoActivo($id){

        $cad = "select cma.id, cma.id_activos, cma.fecha_mantenimiento, cma.kilometraje, cma.proximo_kilometraje, tm.denominacion tipo_mantenimiento, cma.costo, cma.fecha_proximo_mantenimiento, cma.observacion, cma.estado from control_mantenimiento_activos cma 
        left join tabla_maestras tm on cma.id_tipo_mantenimiento = tm.codigo::int and tm.tipo ='91'
        where cma.id_activos = '".$id."'
        and cma.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
