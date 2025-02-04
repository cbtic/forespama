<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TiendaDetalleOrdenCompra extends Model
{
    use HasFactory;

    function getDetalleTiendaOrdenCompraId($id){

        $cad = "select distinct tdoc.id, t.id id_tienda, t.denominacion tienda, p.denominacion producto,
        tm.denominacion unidad_medida, 
<<<<<<< HEAD
        tdoc.cantidad 
=======
        tdoc.cantidad, oc.id id_orden_compra, p.id id_producto
>>>>>>> c168beb62a1672adb0e4eaf15974c844377964bb
        from tienda_detalle_orden_compras tdoc 
        inner join orden_compras oc on tdoc.id_orden_compra = oc.id 
        left join orden_compra_detalles ocd on ocd.id_orden_compra = oc.id 
        inner join productos p on tdoc.id_producto = p.id 
        inner join tiendas t on tdoc.id_tienda = t.id
        left join tabla_maestras tm on p.id_unidad_producto ::int = tm.codigo::int and tm.tipo = '43'
        where oc.id='".$id."'
        order by tdoc.id asc";

		$data = DB::select($cad);
        return $data;
    }
}
