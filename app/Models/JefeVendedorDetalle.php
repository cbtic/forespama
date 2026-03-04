<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class JefeVendedorDetalle extends Model
{
    use HasFactory;

    function obtenerVendedoresByJefe($id_vendedor_jefe){

        $cad = "select * from jefe_vendedor_detalles jvd 
        where jvd.id_jefe_vendedor = '".$id_vendedor_jefe."'
        and jvd.estado = '1'";

		$data = DB::select($cad);
        return $data;
    }
}
