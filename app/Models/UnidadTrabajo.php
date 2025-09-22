<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class UnidadTrabajo extends Model
{
    use HasFactory;

    function getUnidadTrabajoAll(){

        $cad = "select * from unidad_trabajo ut 
        where estado = '1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getUnidadTrabajo($area_trabajo){

        $cad = "select ut.id, ut.denominacion from unidad_trabajo ut 
        inner join area_trabajo at on ut.id_area_trabajo = at.id
        where at.id='".$area_trabajo."'
        and ut.estado = '1'
        order by ut.id asc";

		$data = DB::select($cad);
        return $data;
    }
}
