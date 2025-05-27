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

    v_campos := ' DISTINCT oc.id, e.razon_social, oc.numero_orden_compra_cliente, oc.numero_orden_compra pedido,
    to_char(oc.fecha_orden_compra, ''dd-mm-yyyy'') fecha_orden_compra,
    to_char(oc.fecha_vencimiento, ''dd-mm-yyyy'') fecha_vencimiento,
    p.codigo, p.denominacion producto, ocd.precio,
    CASE 
        WHEN om.id_orden_compra IS NOT NULL THEN cp.suma_cantidad
        ELSE tdoc.cantidad
    END AS cantidad,
    coalesce(ocd.cantidad_despacho, 0) AS cantidad_despacho,
    coalesce(ocd.cantidad_requerida - coalesce(ocd.cantidad_despacho, 0), 0) AS cantidad_cancelada,
    ocd.cerrado, u."name" vendedor,
    CASE 
        WHEN om.id_orden_compra IS NOT NULL THEN ''CONSTRANS''
        ELSE t.denominacion
    END AS tienda ';

    v_tabla := ' FROM orden_compras oc
    LEFT JOIN empresas e ON oc.id_empresa_compra = e.id
    LEFT JOIN orden_compra_detalles ocd ON oc.id = ocd.id_orden_compra
    LEFT JOIN tienda_detalle_orden_compras tdoc ON tdoc.id_orden_compra = oc.id AND tdoc.id_producto = ocd.id_producto
    LEFT JOIN tiendas t ON tdoc.id_tienda = t.id
    LEFT JOIN users u ON oc.id_vendedor = u.id
    LEFT JOIN productos p ON ocd.id_producto = p.id
    LEFT JOIN (
        SELECT id_orden_compra
        FROM tienda_detalle_orden_compras
        GROUP BY id_orden_compra
        HAVING COUNT(DISTINCT id_tienda) > 1
    ) om ON om.id_orden_compra = oc.id
    LEFT JOIN (
        SELECT id_orden_compra, id_producto, SUM(cantidad) AS suma_cantidad
        FROM tienda_detalle_orden_compras
        GROUP BY id_orden_compra, id_producto
    ) cp ON cp.id_orden_compra = oc.id AND cp.id_producto = ocd.id_producto ';

    v_where := ' WHERE 1=1 AND oc.id_tipo_documento = ''2'' ';

    IF p_empresa_compra <> '' THEN
        v_where := v_where || ' AND oc.id_empresa_compra = ''' || p_empresa_compra || ''' ';
    END IF;

    IF p_fecha_desde <> '' THEN
        v_where := v_where || ' AND oc.fecha_orden_compra >= ''' || p_fecha_desde || ''' ';
    END IF;

    IF p_fecha_hasta <> '' THEN
        v_where := v_where || ' AND oc.fecha_orden_compra <= ''' || p_fecha_hasta || ''' ';
    END IF;

    IF p_numero_orden_compra_cliente <> '' THEN
        v_where := v_where || ' AND oc.numero_orden_compra_cliente = ''' || p_numero_orden_compra_cliente || ''' ';
    END IF;

    IF p_producto <> '' THEN
        v_where := v_where || ' AND ocd.id_producto = ''' || p_producto || ''' ';
    END IF;

    IF p_tienda <> '' THEN
        v_where := v_where || ' AND tdoc.id_tienda = ''' || p_tienda || ''' ';
    END IF;

    IF p_estado <> '' THEN
        v_where := v_where || ' AND oc.estado = ''' || p_estado || ''' ';
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
$function$;
