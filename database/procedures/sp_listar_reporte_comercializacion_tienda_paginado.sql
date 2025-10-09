-- DROP FUNCTION public.sp_listar_reporte_comercializacion_tienda_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_reporte_comercializacion_tienda_paginado(p_empresa_compra character varying, p_fecha_desde character varying, p_fecha_hasta character varying, p_numero_orden_compra_cliente character varying, p_producto character varying, p_tienda character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

DECLARE
    v_scad varchar;
    v_campos varchar;
    v_tabla varchar;
    v_where varchar;
    v_count varchar;
    v_col_count varchar;
BEGIN
    p_pagina := (p_pagina::Integer - 1) * p_limit::Integer;

    v_campos := ' distinct oc.id, e.razon_social, oc.numero_orden_compra_cliente, oc.numero_orden_compra pedido,
    to_char(oc.fecha_orden_compra, ''dd-mm-yyyy'') fecha_orden_compra,
    to_char(oc.fecha_vencimiento, ''dd-mm-yyyy'') fecha_vencimiento,
    p.codigo, ep.codigo_empresa,  p.denominacion producto, ocd.precio,
    case when oc.id_canal = 4 then
		case 
		    when om.id_orden_compra is not null then cp.suma_cantidad
		    else tdoc.cantidad
		end 
		else ocd.cantidad_requerida 
	end as cantidad,
    coalesce(ocd.cantidad_despacho, 0) as cantidad_despacho,
    coalesce(ocd.cantidad_requerida - coalesce(ocd.cantidad_despacho, 0), 0) as cantidad_cancelada,
    ocd.cerrado, u."name" vendedor,
    case 
        when om.id_orden_compra is not null then ''CONSTRANS''
        else t.denominacion
    end as tienda ';

    v_tabla := ' from orden_compras oc
    left join empresas e on oc.id_empresa_compra = e.id
    left join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra
    left join tienda_detalle_orden_compras tdoc on tdoc.id_orden_compra = oc.id and tdoc.id_producto = ocd.id_producto
    left join tiendas t on tdoc.id_tienda = t.id
    left join users u on oc.id_vendedor = u.id
    left join productos p on ocd.id_producto = p.id
	left join equivalencia_productos ep on ep.codigo_producto = p.codigo 
    left join (
        select distinct id_orden_compra
		from tienda_detalle_orden_compras tdoc
		left join tiendas t on tdoc.id_tienda = t.id
		where t.id_zona = ''2''
    ) om on om.id_orden_compra = oc.id
    left join (
        select id_orden_compra, id_producto, sum(cantidad) as suma_cantidad
        from tienda_detalle_orden_compras
        group by id_orden_compra, id_producto
    ) cp on cp.id_orden_compra = oc.id and cp.id_producto = ocd.id_producto ';

    v_where := ' WHERE 1=1 and (oc.id_tipo_documento = ''2'' or oc.id_tipo_documento = ''4'') and oc.estado_pedido =''1'' ';

    IF p_empresa_compra <> '' THEN
        v_where := v_where || ' and oc.id_empresa_compra = ''' || p_empresa_compra || ''' ';
    END IF;

    IF p_fecha_desde <> '' THEN
        v_where := v_where || ' and oc.fecha_orden_compra >= ''' || p_fecha_desde || ''' ';
    END IF;

    IF p_fecha_hasta <> '' THEN
        v_where := v_where || ' and oc.fecha_orden_compra <= ''' || p_fecha_hasta || ''' ';
    END IF;

    IF p_numero_orden_compra_cliente <> '' THEN
        v_where := v_where || ' and oc.numero_orden_compra_cliente = ''' || p_numero_orden_compra_cliente || ''' ';
    END IF;

    IF p_producto <> '' THEN
        v_where := v_where || ' and ocd.id_producto = ''' || p_producto || ''' ';
    END IF;

    IF p_tienda <> '' THEN
        v_where := v_where || ' and tdoc.id_tienda = ''' || p_tienda || ''' ';
    END IF;

    IF p_estado <> '' THEN
        v_where := v_where || ' and oc.estado = ''' || p_estado || ''' ';
    END IF;

    EXECUTE ('SELECT COUNT(1) ' || v_tabla || v_where) INTO v_count;
    v_col_count := ' ,' || v_count || ' AS TotalRows ';

    IF v_count::INTEGER > p_limit::INTEGER THEN
        v_scad := 'SELECT ' || v_campos || v_col_count || v_tabla || v_where || ' ORDER BY oc.id DESC LIMIT ' || p_limit || ' OFFSET ' || p_pagina || ';';
    ELSE
        v_scad := 'SELECT ' || v_campos || v_col_count || v_tabla || v_where || ' ORDER BY oc.id DESC;';
    END IF;

    OPEN p_ref FOR EXECUTE v_scad;
    RETURN p_ref;
END;
$function$
;
