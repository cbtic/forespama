<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StarsoftTipoAnexo extends Model
{
    use HasFactory;

    function getStarsoftTipoAnexos(){

        $cad = "select sta.id, sta.codigo_tipo_anexo, sta.descripcion, sta.estado from starsoft_tipo_anexos sta 
        where sta.estado ='1'
        order by 1 asc ";

		$data = DB::select($cad);
        return $data;
    }
}
