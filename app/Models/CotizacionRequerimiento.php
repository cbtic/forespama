<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CotizacionRequerimiento extends Model
{
    use HasFactory;

    function getCodigoCotizacion(){

        $cad = "select lpad(coalesce(max(cr.codigo::int) + 1, 1)::varchar, 6, '0') codigo
        from cotizacion_requerimientos cr ";

		$data = DB::select($cad);
        return $data;
    }
}
