<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DevolucionDetalle extends Model
{
    protected $table = 'devolucion_detalle';

    use HasFactory;

    function getDetalleProductoId($id){

        $cad = "select dd.id,  ROW_NUMBER() OVER (PARTITION BY dd.id_devolucion) AS row_num, '' numero_serie, dd.id_producto, p.codigo, dd.id_marca, p.id_unidad_medida, '' fecha_vencimiento, dd.id_unidad_medida, '' id_estado_bien, dd.cantidad, dd.cantidad, dd.cantidad, '12' stock_actual, dd.precio_unitario, dd.sub_total , dd.igv, dd.total, d.id_almacen id_almacen_salida, p.denominacion nombre_producto, m.denominiacion nombre_marca, '' nombre_estado_bien, tm3.denominacion nombre_unidad_medida, sp.id_empresa_compra, e.ruc, e.razon_social, oc.numero_orden_compra_cliente,
        '' tiendas
        from devolucion_detalle dd 
        inner join productos p on dd.id_producto = p.id
        inner join devolucione d on dd.id_devolucion = d.id
        inner join salida_productos sp on d.id_salida = sp.id 
        left join marcas m on dd.id_marca = m.id 
        left join tabla_maestras tm3 on dd.id_unidad_medida ::int = tm3.codigo::int and tm3.tipo = '43'
        inner join empresas e on e.id = 30
        inner join orden_compras oc on sp.id_orden_compra = oc.id 
        --left join tienda_detalle_orden_compras tdoc on tdoc.id_orden_compra = oc.id
        where dd.id_devolucion ='".$id."'
        and dd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
}
