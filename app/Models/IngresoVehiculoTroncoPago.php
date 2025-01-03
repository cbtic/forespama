<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoVehiculoTroncoPago extends Model
{
    use HasFactory;

    function getImportePago($id){

        $cad = "select 
coalesce((select sum(precio_total) 
from ingreso_vehiculo_tronco_cubicajes ivtc 
where id_ingreso_vehiculo_tronco_tipo_maderas=".$id."),0)precio,
coalesce((select sum(importe) 
from ingreso_vehiculo_tronco_pagos 
where id_ingreso_vehiculo_tronco_tipo_maderas=".$id."),0)pago";

		$data = DB::select($cad);
        return $data[0];
    }

}
