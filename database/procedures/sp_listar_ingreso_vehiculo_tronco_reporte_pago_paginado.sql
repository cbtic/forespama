CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_pago_paginado(p_fecha_desde character varying, p_fecha_hasta character varying, p_empresa character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$
DECLARE
    v_scad varchar;
    v_count varchar;
    v_col_count varchar;
	v_where_empresa varchar := '';

BEGIN
    -- Calcular el offset para la paginación
    p_pagina := (p_pagina::Integer - 1) * p_limit::Integer;

	IF TRIM(p_empresa) IS NOT NULL AND TRIM(p_empresa) <> '' THEN
        v_where_empresa := ' AND ivt.id_empresa_proveedor = ' || quote_literal(p_empresa);
    END IF;

    -- Obtener el total de registros
    EXECUTE ('SELECT count(1) FROM ingreso_vehiculo_tronco_pagos ivtp 
 			INNER JOIN ingreso_vehiculo_tronco_tipo_maderas ivttm ON ivtp.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id
          	INNER JOIN ingreso_vehiculo_troncos ivt ON ivttm.id_ingreso_vehiculo_troncos = ivt.id
            WHERE ivtp.fecha BETWEEN ''' || p_fecha_desde || ''' AND ''' || p_fecha_hasta || ''''
	|| v_where_empresa) 

    INTO v_count;

    v_col_count := ' ,' || v_count || ' AS TotalRows ';

    -- Consulta principal con WITH (CTE)
    v_scad := 'WITH pagos AS (
        SELECT 
            e.razon_social, 
            tm.denominacion AS tipo_pago, 
            ivtp.fecha AS fecha_pago, 
            SUM(ivtp.importe) AS importe_total,
            ivtp.id_tipodesembolso
        FROM ingreso_vehiculo_troncos ivt
        INNER JOIN empresas e ON ivt.id_empresa_proveedor = e.id
        INNER JOIN ingreso_vehiculo_tronco_tipo_maderas ivttm ON ivt.id = ivttm.id_ingreso_vehiculo_troncos
        INNER JOIN ingreso_vehiculo_tronco_pagos ivtp ON ivtp.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id 
        INNER JOIN tabla_maestras tm ON ivtp.id_tipodesembolso = tm.codigo::int AND tm.tipo = ''65''
        WHERE ivtp.fecha BETWEEN ''' || p_fecha_desde || ''' AND ''' || p_fecha_hasta || ''''
		|| v_where_empresa || '
        GROUP BY e.razon_social, tm.denominacion, ivtp.fecha, ivtp.id_tipodesembolso
    )
    SELECT 
        p.*, 
        SUM(p.importe_total) OVER () AS total_general, 
        SUM(CASE WHEN p.id_tipodesembolso = 1 THEN p.importe_total ELSE 0 END) OVER () AS total_efectivo,
        SUM(CASE WHEN p.id_tipodesembolso = 2 THEN p.importe_total ELSE 0 END) OVER () AS total_cheque,
        SUM(CASE WHEN p.id_tipodesembolso = 3 THEN p.importe_total ELSE 0 END) OVER () AS total_transferencia'
        || v_col_count || 
    ' FROM pagos p
    ORDER BY p.tipo_pago DESC, p.razon_social, p.fecha_pago DESC
    LIMIT ' || p_limit || ' OFFSET ' || p_pagina || ';';

    -- Ejecutar la consulta
    OPEN p_ref FOR EXECUTE(v_scad);
    RETURN p_ref;
END
$function$
;
