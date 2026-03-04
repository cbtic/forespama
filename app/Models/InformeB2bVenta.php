<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class InformeB2bVenta extends Model
{
    use HasFactory;

    function getAnioInformeB2bVenta(){

        $cad = "select distinct ibbv.anio from informe_b2b_ventas ibbv 
        where ibbv.estado ='1'
        and ibbv.anio <>''
        order by anio asc";

		$data = DB::select($cad);
        return $data;
    }
}
