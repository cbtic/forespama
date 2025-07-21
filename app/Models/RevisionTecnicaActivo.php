<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class RevisionTecnicaActivo extends Model
{
    use HasFactory;

    function getRevisionTecnicaActivo($id){

        $cad = "select * from revision_tecnica_activos rta 
        where rta.id_activos = '".$id."'
        and rta.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
