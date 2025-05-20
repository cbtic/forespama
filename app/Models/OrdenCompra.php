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

    public function listar_reporte_comercializacion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reporte_comercializacion_paginado',$p);

    }

    public function listar_reporte_comercializacion_tienda_ajax($p){

        return $this->readFuntionPostgres('sp_listar_reporte_comercializacion_tienda_paginado',$p);

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
        and ocd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleOrdenCompraIdAbierto($id){

        $cad = "select ocd.id,  ROW_NUMBER() OVER (PARTITION BY ocd.id_orden_compra ) AS row_num, p.numero_serie item, ocd.id_producto, p.codigo, p.denominacion nombre_producto, ocd.id_marca, ocd.id_unidad_medida, ocd.fecha_fabricacion, ocd.fecha_vencimiento, 
        ocd.id_estado_producto , ocd.cantidad_requerida, 
        coalesce((select sum(cantidad)
        from salida_productos sp 
        inner join salida_producto_detalles spd on sp.id=spd.id_salida_productos  
        where id_orden_compra =ocd.id_orden_compra 
        and spd.id_producto=ocd.id_producto
        and sp.tipo_devolucion ='1'),0)cantidad_ingresada,
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
        and ocd.cerrado ='1'
        and ocd.estado='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getDetalleOrdenCompraIdAbiertoEntrada($id){

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
        and ocd.cerrado ='1'
        and ocd.estado='1'
        order by 1 asc";

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

    function getOrdenCompraPersonaById($id){

        $cad = "select oc.id, p.nombres empresa_compra, e2.razon_social empresa_vende, to_char(oc.fecha_orden_compra,'dd-mm-yyyy') fecha_orden_compra , 
            oc.numero_orden_compra, tm.denominacion tipo_documento, oc.estado, tm2.denominacion igv, oc.numero_orden_compra_cliente, 
            oc.total, oc.sub_total, oc.igv, COALESCE (oc.descuento, 0 , oc.descuento) descuento
            from orden_compras oc             
            inner join empresas e2 on oc.id_empresa_vende = e2.id
            inner join personas p on p.id = oc.id_persona
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

    function getSalidaProdById($id){

        $cad = "select oc.id, e.razon_social empresa_compra, e2.razon_social empresa_vende, to_char(sp.fecha_salida,'dd-mm-yyyy') fecha_orden_compra , 
            oc.numero_orden_compra, tm.denominacion tipo_documento, oc.estado, tm2.denominacion igv, oc.numero_orden_compra_cliente, 
            sp.total_compra  total, sp.sub_total_compra sub_total, sp.igv_compra igv, COALESCE (sp.descuento, 0 , sp.descuento) descuento
        from orden_compras oc
        	inner join salida_productos sp on sp.id_orden_compra = oc.id 
            inner join empresas e on oc.id_empresa_compra = e.id 
            inner join empresas e2 on oc.id_empresa_vende = e2.id 
            inner join tabla_maestras tm on oc.id_tipo_documento = tm.codigo ::int and tm.tipo = '54'
            inner join tabla_maestras tm2 on oc.igv_compra = tm2.codigo ::int and tm2.tipo = '51'
        where 
        	sp.id = '".$id."'
            and oc.estado='1'
            and sp.cerrado= '2'
        limit 1";

		$data = DB::select($cad);
       // return $data;

        if (!empty($data)) {
            return $data[0];
        } else {
            
            return null;
        }
    }

    function getSalidaProdDetalle($id, $emp){
        $cad = "select oc.id id_oc,  pd.id, '' serie, oc.numero_orden_compra, oc.fecha_orden_compra fecha, oc.id_moneda, 'SOLES' moneda, pd.sub_total sub_total_, pd.igv igv_, pd.total total_, 
            '01/01/2025' fecha_vencimiento, pd.id_producto,  pr.codigo, pr.denominacion, 
            case when  oc.id_empresa_compra = 23 then 
            (select  pr.denominacion ||'('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
            FROM equivalencia_productos pe
            where pe.id_empresa = oc.id_empresa_compra and pe.id_producto = pd.id_producto and pe.estado= '1'            
            )	else  pr.denominacion end  producto_prof,
            um.denominacion um, um.abreviatura, spd.cantidad  cantidad, spd.id_descuento, spd.costo precio_unitario, spd.sub_total, spd.igv, spd.total, spd.id_um id_unidad_medida, spd.descuento, spd.valor_venta_bruto,
            spd.precio_venta, spd.valor_venta
            FROM orden_compras oc
            inner join orden_compra_detalles pd on pd.id_orden_compra = oc.id 
            inner join salida_productos sp on sp.id_orden_compra = oc.id
            inner join salida_producto_detalles spd on spd.id_salida_productos = sp.id and spd.id_producto = pd.id_producto 
            inner join productos pr on pr.id = pd.id_producto
            inner join tabla_maestras um on um.codigo::int = pd.id_unidad_medida and um.tipo = '43'
            where sp.id = ".$id." and pd.estado = '1' and sp.estado = '1' and spd.estado = '1' and sp.cerrado= '2'
            and spd.tipo_devolucion= 3
            order by pd.id ";
    
    //echo $cad;
    $data = DB::select($cad);
    return $data;
    }

    function getOrdenCompraByIdPdf($id){

        $cad = "select oc.id, 
        --e.razon_social empresa_compra, 
        case when oc.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = oc.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = oc.id_empresa_compra) 
        end cliente,
        e2.razon_social empresa_vende, to_char(oc.fecha_orden_compra,'dd-mm-yyyy') fecha_orden_compra , 
        oc.numero_orden_compra, tm.denominacion tipo_documento, oc.estado, tm2.denominacion igv, oc.numero_orden_compra_cliente, 
        oc.total, oc.sub_total, oc.igv, COALESCE (oc.descuento, 0 , oc.descuento) descuento,
        case when oc.id_empresa_compra = 23 or oc.id_empresa_compra = 187  then 
        (select t.direccion || ' - ' || dp.desc_ubigeo || ' - ' || p.desc_ubigeo  || ' - ' || d.desc_ubigeo AS direccion_completa from tienda_detalle_orden_compras tdoc 
        inner join tiendas t on tdoc.id_tienda = t.id 
        inner join ubigeos u on t.id_ubigeo = u.id_ubigeo
        left join ubigeos p on p.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 4) || '00'
        left join ubigeos dp on dp.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 2) || '0000'
        left join ubigeos d on d.id_ubigeo = u.id_ubigeo 
        where tdoc.id_orden_compra = oc.id limit 1) else
        (select occe.direccion || ' - ' ||  dp.desc_ubigeo || ' - ' || p.desc_ubigeo || ' - ' || d.desc_ubigeo || ' - ' ||  COALESCE(occe.referencia,'') from orden_compra_contacto_entregas occe
        inner join ubigeos u on occe.id_ubigeo = u.id_ubigeo
        left join ubigeos p on p.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 4) || '00'
        left join ubigeos dp on dp.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 2) || '0000'
        left join ubigeos d on d.id_ubigeo = u.id_ubigeo 
        where occe.id_orden_compra = oc.id)
        end direccion
        from orden_compras oc 
        --inner join empresas e on oc.id_empresa_compra = e.id 
        inner join empresas e2 on oc.id_empresa_vende = e2.id 
        inner join tabla_maestras tm on oc.id_tipo_documento = tm.codigo ::int and tm.tipo = '54'
        inner join tabla_maestras tm2 on oc.igv_compra = tm2.codigo ::int and tm2.tipo = '51'
        where oc.id='".$id."'
        and oc.estado='1'";

		$data = DB::select($cad);
        return $data;

    }

    function getOrdenCompraByCod($numero){

        $cad = "select o.id id_orden_compra, e.id id_empresa, e.razon_social, e.direccion, e.representante, e.ruc, e.email, 5 id_tipo_documento,  trim(e.ruc) numero_documento_, o.id_tipo_cliente
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

    function getOrdenCompraByCodPersona($numero){

        $cad = "select o.id id_orden_compra, p.id id_persona, p.nombres razon_social, p.direccion, p.nombres representante, p.numero_ruc ruc,  p.email, 1 id_tipo_documento,  p.numero_documento numero_documento_, o.id_tipo_cliente
                from orden_compras o 
                left join personas p  on p.id = o.id_persona  
                where 1=1 
                and o.estado = '1' and o.cerrado = '2' and o.id_tipo_documento = 2
                and o.numero_orden_compra = '".$numero."'
                and (select count(*) 
            		FROM  orden_compra_detalles o_
            		inner join valorizaciones v on v.id_modulo = 1 and v.pk_registro = o_.id 
            		where o_.id_orden_compra = o.id) = 0
                limit 1";

                //echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getPersonaOrdenCompraByCod($numero, $tipo_documento){

        $cad = "select o.id id_orden_compra, p.id id_persona, p.nombres razon_social, p.direccion, p.nombres representante, p.numero_ruc ruc, p.email, p.id_tipo_documento, p.numero_documento  numero_documento_, o.id_tipo_cliente
                from orden_compras o 
                left join personas p  on p.id = o.id_persona  
                where 1=1 
                and o.estado = '1' and o.cerrado = '2' and o.id_tipo_documento = 2
                and p.numero_documento = '".$numero."' and p.id_tipo_documento = '".$tipo_documento."'
                and (select count(*) 
            		FROM  orden_compra_detalles o_
            		inner join valorizaciones v on v.id_modulo = 1 and v.pk_registro = o_.id 
            		where o_.id_orden_compra = o.id) = 0
                limit 1 ";
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getSalidaProductoByCod($numero){

        $cad = "select o.id id_orden_compra, o.numero_orden_compra, sp.id id_salida_prod, sp.codigo,  e.id id_empresa, e.razon_social, e.direccion, e.representante, e.ruc, e.email, 5 id_tipo_documento,  trim(e.ruc) numero_documento_, o.id_tipo_cliente
                from orden_compras o 
                left join empresas e  on e.id = o.id_empresa_compra 
                inner join salida_productos sp on sp.id_orden_compra = o.id 
                where 1=1 
                and o.estado = '1' and o.cerrado = '2' and o.id_tipo_documento = 2 and sp.tipo_devolucion= 3
                and sp.codigo = '".$numero."' 
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
            --(SELECT pe.codigo_producto ||'-'|| pr.denominacion ||'('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'
            (SELECT  pr.denominacion ||'('|| pe.codigo_empresa||'-'|| pe. descripcion_empresa||')'  
            FROM equivalencia_productos pe
            where pe.id_empresa = oc.id_empresa_compra and pe.id_producto = pd.id_producto and pe.estado= '1'            
            --)	else pr.codigo ||'-'|| pr.denominacion end  producto_prof,
            )	else  pr.denominacion end  producto_prof,
            um.denominacion um, um.abreviatura, pd.cantidad_requerida cantidad, pd.id_descuento, pd.precio precio_unitario, pd.sub_total, pd.igv, pd.total, pd.id_unidad_medida, pd.descuento, pd.valor_venta_bruto,
            pd.precio_venta, pd.valor_venta
            FROM orden_compras oc
            inner join orden_compra_detalles pd on pd.id_orden_compra = oc.id 
            inner join productos pr on pr.id = pd.id_producto
            inner join tabla_maestras um on um.codigo::int = pd.id_unidad_medida and um.tipo = '43'
            where oc.id = ".$id."  and pd.estado = '1' and oc.cerrado= '2'
            order by pd.id ";
    
    //echo $cad;
    $data = DB::select($cad);
    return $data;
    }

    function getOrdenCompraLpn($id_orden_compra){

        $cad="";

        $data = DB::select($cad);
        return $data;

    }

    function getDetalleOrdenCompraGuia(){

        $cad = "select oc.id, oc.fecha_orden_compra fecha_movimiento, tm.denominacion tipo_documento, tm2.denominacion unidad_origen, e.razon_social, oc.numero_orden_compra codigo, oc.fecha_orden_compra fecha_comprobante, oc.estado, oc.created_at, tm3.denominacion moneda, '' observacion, tm4.denominacion igv_compra, a.denominacion almacen
        from orden_compras oc
        inner join tabla_maestras tm on oc.id_tipo_documento = tm.codigo ::int and tm.tipo = '54'
        inner join tabla_maestras tm2 on oc.id_unidad_origen::int = tm2.codigo::int and tm2.tipo = '50'
        left join tabla_maestras tm3 on oc.id_moneda ::int = tm3.codigo::int and tm3.tipo = '1'
        inner join empresas e on oc.id_empresa_compra = e.id
        left join tabla_maestras tm4 on oc.igv_compra ::int = tm4.codigo::int and tm4.tipo = '51'
        inner join almacenes a on oc.id_almacen_destino = a.id
        where oc.estado='1'
        and oc.id_tipo_documento ='1'";

		$data = DB::select($cad);
        return $data;
    }

}
