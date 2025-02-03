<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenCompra extends Model
{
    use HasFactory;

    public function listar_orden_compra_ajax($p){

        return $this->readFuntionPostgres('sp_listar_orden_compra_paginado',$p);

    }

    public function listar_total_orden_compra_tienda_ajax($p){

        return $this->readFuntionPostgres('sp_listar_total_orden_compra_tienda_paginado',$p);

    }

    public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;

    }

    function getDetalleOrdenCompraId($id){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra ) AS row_num, p.numero_serie item, ocd.id_producto, p.codigo, p.denominacion nombre_producto, ocd.id_marca, ocd.id_unidad_medida, ocd.fecha_fabricacion, ocd.fecha_vencimiento, 
        ocd.id_estado_producto , ocd.cantidad_requerida, 
        coalesce((select sum(cantidad)
        from entrada_productos ep
        inner join entrada_producto_detalles epd on ep.id=epd.id_entrada_productos 
        where id_orden_compra =ocd.id_orden_compra 
        and epd.id_producto=ocd.id_producto),0)cantidad_ingresada,
        ocd.precio, ocd.sub_total, ocd.igv, ocd.total, ocd.id_descuento, oc.id_almacen_salida, oc.id_unidad_origen, oc.id_almacen_destino ,
        m.denominiacion marca,
        coalesce((select k.saldos_cantidad from kardex k where id_producto = ocd.id_producto and id_almacen_destino = 3  order by 1 desc limit 1),0)stock_ves, --ves
        coalesce((select k.saldos_cantidad from kardex k where id_producto = ocd.id_producto and id_almacen_destino = 2  order by 1 desc limit 1),0)stock_oxa, --oxa
        ocd.valor_venta_bruto, precio_venta, valor_venta, ocd.id_descuento, ocd.descuento
        from orden_compra_detalles ocd 
        inner join productos p on ocd.id_producto = p.id
        inner join orden_compras oc on ocd.id_orden_compra = oc.id
        left join marcas m on ocd.id_marca=m.id
        where id_orden_compra ='".$id."'
        and ocd.estado='1'";

		$data = DB::select($cad);
        return $data;
    }

    function getOrdenCompraById($id){

        $cad = "select oc.id, e.razon_social empresa_compra, e2.razon_social empresa_vende, to_char(oc.fecha_orden_compra,'dd-mm-yyyy') fecha_orden_compra , 
            oc.numero_orden_compra, tm.denominacion tipo_documento, oc.estado, tm2.denominacion igv, oc.numero_orden_compra_cliente, 
            oc.total, oc.sub_total, oc.igv, COALESCE (oc.descuento, 0 , oc.descuento) descuento
        from orden_compras oc 
            inner join empresas e on oc.id_empresa_compra = e.id 
            inner join empresas e2 on oc.id_empresa_vende = e2.id 
            inner join tabla_maestras tm on oc.id_tipo_documento = tm.codigo ::int and tm.tipo = '54'
            inner join tabla_maestras tm2 on oc.igv_compra = tm2.codigo ::int and tm2.tipo = '51'
        where oc.id='".$id."'
            and oc.estado='1'
            and oc.cerrado= '2'
        limit 1";

		$data = DB::select($cad);
       // return $data;

        if (!empty($data)) {
            return $data[0];
        } else {
            
            return null;
        }
    }

    function getOrdenCompraByIdPdf($id){

        $cad = "select oc.id, e.razon_social empresa_compra, e2.razon_social empresa_vende, to_char(oc.fecha_orden_compra,'dd-mm-yyyy') fecha_orden_compra , 
            oc.numero_orden_compra, tm.denominacion tipo_documento, oc.estado, tm2.denominacion igv, oc.numero_orden_compra_cliente, 
            oc.total, oc.sub_total, oc.igv, COALESCE (oc.descuento, 0 , oc.descuento) descuento
        from orden_compras oc 
            inner join empresas e on oc.id_empresa_compra = e.id 
            inner join empresas e2 on oc.id_empresa_vende = e2.id 
            inner join tabla_maestras tm on oc.id_tipo_documento = tm.codigo ::int and tm.tipo = '54'
            inner join tabla_maestras tm2 on oc.igv_compra = tm2.codigo ::int and tm2.tipo = '51'
        where oc.id='".$id."'
            and oc.estado='1'";

		$data = DB::select($cad);
        return $data;

    }

    function getOrdenCompraByCod($numero){

        $cad = "select o.id id_orden_compra, e.id id_empresa, e.razon_social, e.direccion, e.representante, e.ruc, e.email, 5 id_tipo_documento,  trim(e.ruc) numero_documento_
                from orden_compras o 
                left join empresas e  on e.id = o.id_empresa_compra 
                where 1=1 
                and o.estado = '1' and o.cerrado = '2' and o.id_tipo_documento = 2
                and o.numero_orden_compra = '".$numero."'
                and (select count(*) 
            		FROM  orden_compra_detalles o_
            		inner join valorizaciones v on v.id_modulo = 1 and v.pk_registro = o_.id 
            		where o_.id_orden_compra = o.id) = 0
                limit 1";
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getCodigoOrdenCompra($tipo_documento){

        $cad = "select lpad(coalesce(max(oc.numero_orden_compra::int) + 1, 1)::varchar, 6, '0') codigo
        from orden_compras oc
        where id_tipo_documento = '".$tipo_documento."'";

		$data = DB::select($cad);
        return $data;
    }

    function getOrdenCompraDetalle($id, $emp){
        $cad = "SELECT pd.id, '' serie, oc.numero_orden_compra, oc.fecha_orden_compra fecha, oc.id_moneda, 'SOLES' moneda, pd.sub_total sub_total_, pd.igv igv_, pd.total total_, 
            '01/01/2025' fecha_vencimiento, pd.id_producto,  pr.codigo, pr.denominacion,
            --case when  oc.id_empresa_compra = ".$emp." then 
            case when  oc.id_empresa_compra = 23 then 
            (SELECT pe.codigo_producto ||'-'|| pr.denominacion ||'('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
            FROM equivalencia_productos pe
            where pe.id_empresa = oc.id_empresa_compra and pe.id_producto = pd.id_producto and pe.estado= '1'            
            )	else pr.codigo ||'-'|| pr.denominacion end  producto_prof,
            um.denominacion um, pd.cantidad_requerida cantidad, pd.id_descuento, pd.precio precio_unitario, pd.sub_total, pd.igv, pd.total, pd.id_unidad_medida, pd.descuento, pd.valor_venta_bruto,
            pd.precio_venta, pd.valor_venta
            FROM orden_compras oc
            inner join orden_compra_detalles pd on pd.id_orden_compra = oc.id 
            inner join productos pr on pr.id = pd.id_producto
            inner join tabla_maestras um on um.codigo::int = pd.id_unidad_medida and um.tipo = '57'
            where oc.id = ".$id."  and pd.estado = '1' and oc.cerrado= '2'
            order by pd.id ";
    
    //echo $cad;
    $data = DB::select($cad);
    return $data;
    }



}
