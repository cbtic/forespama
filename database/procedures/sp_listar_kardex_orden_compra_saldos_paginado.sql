-- DROP FUNCTION public.sp_listar_kardex_orden_compra_saldos_paginado(varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_kardex_orden_compra_saldos_paginado(p_producto character varying, p_almacen character varying, p_id_user character varying, p_id_empresa character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$
DECLARE
    v_scad TEXT;
    v_where TEXT := 'WHERE 1 = 1 ';
    v_count INTEGER;
    v_col_count TEXT;
    v_id_rol INTEGER;
    v_offset INTEGER;
BEGIN

    SELECT role_id INTO v_id_rol FROM model_has_roles WHERE model_id::varchar = p_id_user;

    v_offset := (p_pagina::INTEGER - 1) * p_limit::INTEGER;

    -- Filtros
    IF v_id_rol = 7 THEN
        v_where := v_where || ' AND p.id_tipo_origen_producto = ''2'' ';
    END IF;

    IF p_producto <> '' THEN
        v_where := v_where || ' AND k.id_producto = ''' || p_producto || ''' ';
    END IF;

    IF p_almacen <> '' THEN
        v_where := v_where || ' AND k.id_almacen_destino = ''' || p_almacen || ''' ';
    END IF;

	/*IF p_id_empresa <> '' THEN
        v_where := v_where || ' AND oc.id_empresa_compra = ''' || p_id_empresa || ''' ';
    END IF;*/

    EXECUTE '
        WITH ordenes_agrupadas AS (
            SELECT ocd.id_producto, oc.id_almacen_salida, SUM(ocd.cantidad_requerida) AS cantidad_orden_compra
            FROM orden_compra_detalles ocd
            INNER JOIN orden_compras oc ON ocd.id_orden_compra = oc.id
            WHERE oc.id_tipo_documento = ''2''
              AND oc.cerrado = ''1''
              AND ocd.cerrado = ''1''
              AND oc.estado = ''1''
			  AND oc.estado_pedido = ''1''
			' || CASE WHEN p_id_empresa <> '' THEN 'AND oc.id_empresa_compra = ''' || p_id_empresa || '''' ELSE '' END || '
            GROUP BY ocd.id_producto, oc.id_almacen_salida
        )
        SELECT COUNT(*) FROM (
            SELECT DISTINCT ON (k.id_producto, k.id_almacen_destino) k.id,
 			a.denominacion AS almacen_kardex
            FROM kardex k
			INNER JOIN almacenes a ON k.id_almacen_destino = a.id
            INNER JOIN productos p ON k.id_producto = p.id AND p.id_tipo_origen_producto = 2
            LEFT JOIN ordenes_agrupadas oa 
                ON oa.id_producto = k.id_producto 
                AND oa.id_almacen_salida = k.id_almacen_destino
            ' || v_where || '
            ORDER BY k.id_producto, k.id_almacen_destino, k.id DESC
        ) sub_count
    ' INTO v_count;

    v_col_count := ', ' || v_count || ' AS totalrows';

    -- Query principal con paginación
    v_scad := '
        WITH ordenes_agrupadas AS (
            SELECT ocd.id_producto, oc.id_almacen_salida, (SUM(ocd.cantidad_requerida) - SUM(coalesce(ocd.cantidad_despacho,0))) AS cantidad_orden_compra
            FROM orden_compra_detalles ocd
            INNER JOIN orden_compras oc ON ocd.id_orden_compra = oc.id
            WHERE oc.id_tipo_documento = ''2''
              AND oc.cerrado = ''1''
              AND ocd.cerrado = ''1''
              AND oc.estado = ''1''
			  AND oc.estado_pedido = ''1''
			' || CASE WHEN p_id_empresa <> '' THEN 'AND oc.id_empresa_compra = ''' || p_id_empresa || '''' ELSE '' END || '
            GROUP BY ocd.id_producto, oc.id_almacen_salida
        )
        SELECT DISTINCT ON (k.id_producto, k.id_almacen_destino)
            k.*, p.*, p.denominacion producto,
            COALESCE(oa.cantidad_orden_compra, 0) AS cantidad_orden_compra,
            k.saldos_cantidad - COALESCE(oa.cantidad_orden_compra, 0) AS saldo_final,
			a.denominacion AS almacen_kardex
            ' || v_col_count || '
        FROM kardex k
		INNER JOIN almacenes a ON k.id_almacen_destino = a.id
        INNER JOIN productos p ON k.id_producto = p.id and p.id_tipo_origen_producto = 2
        LEFT JOIN ordenes_agrupadas oa 
            ON oa.id_producto = k.id_producto 
            AND oa.id_almacen_salida = k.id_almacen_destino
        ' || v_where || '
        ORDER BY k.id_producto, k.id_almacen_destino, k.id DESC
        LIMIT ' || p_limit || ' OFFSET ' || v_offset || ';';

    -- Ejecutar y retornar
    OPEN p_ref FOR EXECUTE v_scad;
    RETURN p_ref;
END
$function$
;
