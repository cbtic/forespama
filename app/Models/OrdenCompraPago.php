<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenCompraPago extends Model
{
    use HasFactory;

    function getImportePago($id){

        $cad = "select 
        coalesce((select sum(oc.total) 
        from orden_compras oc   
        where oc.id = '".$id."'), 0)precio,
        coalesce((select sum(importe) 
        from orden_compra_pagos ocp  
        where ocp.id_orden_compra = '".$id."'), 0)pago";

		$data = DB::select($cad);
        return $data[0];
    }
}
