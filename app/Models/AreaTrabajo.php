<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AreaTrabajo extends Model
{
    use HasFactory;

    function getAreaTrabajoAll(){

        $cad = "select * from area_trabajo at 
        where estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getAreaTrabajoProduccion(){

        $cad = "select * from area_trabajo at 
        where estado='1'
        and at.id in('6','7')
        order by 1 asc";
        
		$data = DB::select($cad);
        return $data;
    }
}
