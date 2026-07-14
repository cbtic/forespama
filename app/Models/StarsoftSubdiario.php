<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StarsoftSubdiario extends Model
{
    use HasFactory;

    function getStarsoftSubdiario(){

        $cad = "select ss.id, ss.codigo, ss.descripcion, ss.nombre_breve, ss.apertura, ss.codigo_sunat, ss.estado
        from starsoft_subdiarios ss 
        where ss.estado = '1'
        order by ss.codigo asc";

		$data = DB::select($cad);
        return $data;
    }
}
