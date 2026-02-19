<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProductoAcerrado extends Model
{
    use HasFactory;

    function getProductoByTipoMaderaMedida($tipo_madera, $medida){

        $cad = "select pa.id, pa.id_producto, pa.estado from producto_acerrados pa 
        where pa.id_tipo_madera ='".$tipo_madera."'
        and pa.id_medida ='".$medida."'
        and pa.estado ='1'";

		$data = DB::select($cad);
        return $data;
    }

}
