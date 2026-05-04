<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StarsoftDetraccione extends Model
{
    use HasFactory;

    function getDetraccionesAll(){

        $cad = "select sd.id, sd.codigo, sd.descripcion, sd.tasa, sd.estado 
        from starsoft_detracciones sd 
        where sd.estado = '1' ";

		$data = DB::select($cad);
        return $data;
    }
}
