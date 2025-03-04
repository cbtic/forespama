<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenCompraContactoEntrega extends Model
{
    use HasFactory;

    function getProvinciaDistritoById($id){

        $cad = "select u.id_provincia provincia_partida, u.id_ubigeo distrito_partida
        from orden_compra_contacto_entregas occe
        inner join ubigeos u on occe.id_ubigeo = u.id_ubigeo 
        where occe.id='$id'";

		$data = DB::select($cad);
        return $data;
    }
}
