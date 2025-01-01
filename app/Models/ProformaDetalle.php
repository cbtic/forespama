<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProformaDetalle extends Model
{
    use HasFactory;

    function getDetalleProformaPdf($id){

        $cad = "select pd.id, ROW_NUMBER() OVER (PARTITION BY pd.id_proforma ) AS row_num, p2.denominacion producto, pd.cantidad, tm2.denominacion unidad_medida, pd.precio_unitario, pd.sub_total, pd.igv, pd.total, pd.estado 
        from proforma_detalles pd 
        inner join proformas p on pd.id_proforma = p.id
        inner join productos p2 on pd.id_producto = p2.id
        left join tabla_maestras tm2 on pd.id_unidad_medida ::int = tm2.codigo::int and tm2.tipo = '43'
        where p.id='".$id."'";

		$data = DB::select($cad);
        return $data;
    }
}
