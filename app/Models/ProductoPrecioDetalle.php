<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductoPrecioDetalle extends Model
{
    use HasFactory;

    function getHistorialPrecioByProducto($id){

        $cad = "select ppd.id, ppd.id_producto, p.denominacion producto, ppd.fecha, ppd.precio, ppd.estado from producto_precio_detalles ppd 
        inner join productos p on ppd.id_producto = p.id
        where ppd.id_producto ='".$id."'
        and ppd.estado ='1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }
}
