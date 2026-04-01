<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class StarsoftDestinoOperacione extends Model
{
    use HasFactory;

    function getDestinoOperacionesAll(){

        $cad = "select sdo.id, sdo.codigo, sdo.descripcion, sdo.estado 
        from starsoft_destino_operaciones sdo 
        where sdo.estado ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

}
