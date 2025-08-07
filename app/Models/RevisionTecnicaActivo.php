<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RevisionTecnicaActivo extends Model
{
    use HasFactory;

    function getRevisionTecnicaActivo($id){

        $cad = "select rta.id, rta.id_activos, rta.numero_certificado, rta.fecha_emision, rta.fecha_vencimiento, tm.denominacion estado_revision, tm2.denominacion resultado_revision, rta.estado from revision_tecnica_activos rta 
        left join tabla_maestras tm on rta.estado_revision = tm.codigo::int and tm.tipo ='89'
        left join tabla_maestras tm2 on rta.id_resultado_revision  = tm2.codigo::int and tm2.tipo ='90'
        where rta.id_activos = '".$id."'
        and rta.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
