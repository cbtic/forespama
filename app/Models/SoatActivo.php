<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class SoatActivo extends Model
{
    use HasFactory;

    function getSoatActivo($id){

        $cad = "select * from soat_activos sa 
        where sa.id_activos = '".$id."'
        and sa.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
