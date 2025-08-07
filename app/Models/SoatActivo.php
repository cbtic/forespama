<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SoatActivo extends Model
{
    use HasFactory;

    function getSoatActivo($id){

        $cad = "select sa.id, sa.id_activos, sa.numero_poliza, sa.fecha_emision, sa.fecha_vencimiento, tm.denominacion estado_soat, sa.estado from soat_activos sa 
        left join tabla_maestras tm on sa.estado_soat = tm.codigo::int and tm.tipo ='89'
        where sa.id_activos = '".$id."'
        and sa.estado = '1'
        order by 1 desc";
        
		$data = DB::select($cad);
        return $data;
    }
}
