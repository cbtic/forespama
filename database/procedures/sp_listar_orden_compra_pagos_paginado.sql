-- DROP FUNCTION public.sp_listar_orden_compra_pagos_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_orden_compra_pagos_paginado(p_empresa character varying, p_persona character varying, p_fecha_desde character varying, p_fecha_hasta character varying, p_estado_pago character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$
Declare

v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' oc.id, oc.fecha_orden_compra, 
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	u."name" vendedor,
	(select tm3.denominacion bien_servicio from orden_compra_detalles ocd 
	inner join productos p on ocd.id_producto = p.id
	inner join tabla_maestras tm3 on p.bien_servicio = tm3.codigo::int and tm3.tipo = ''73''
	where ocd.id_orden_compra = oc.id 
	limit 1) bien_servicio,
	oc.numero_orden_compra, to_char(c.fecha,''yyyy-mm-dd'') fecha_factura, c.serie ||''-''|| c.numero numero_factura, oc.sub_total, oc.igv, oc.total, 
	(select sum(ocp2.importe)
	from orden_compra_pagos ocp2
	where ocp2.id_orden_compra = oc.id
	and ocp2.estado=''1'') abono_pago, tm2.denominacion forma_pago, 
	(select cc.fecha_vencimiento  from comprobante_cuotas cc 
	where cc.id_comprobante = c.id)fecha_vencimiento,
	(select string_agg(gi.guia_serie||''-''||gi.guia_numero ,'', '') from salida_productos sp 
	left join guia_internas gi on gi.numero_documento::int = sp.id 
	where sp.tipo_devolucion=''3''
	and gi.id_tipo_documento !=''4''
	and gi.guia_anulado =''N''
	and sp.id_orden_compra = oc.id) guia,
	(select tm.denominacion from orden_compra_pagos ocp
	left join tabla_maestras tm on ocp.id_estado_pago = tm.codigo::int and tm.tipo = ''66''
	where ocp.id_orden_compra = oc.id 
	limit 1) estado_pago ';
	
	v_tabla=' from orden_compras oc 
	left join comprobantes c on c.orden_compra::varchar = oc.id::varchar and c.anulado = ''N''
	left join tabla_maestras tm2 on c.id_forma_pago = tm2.codigo::int and tm2.tipo = ''104''
	left join users u on oc.id_vendedor = u.id ';

	v_where = ' where 1=1 and oc.estado = ''1'' and oc.id_tipo_documento = ''2'' AND (oc.id_empresa_compra IS NULL OR oc.id_empresa_compra NOT IN (''23'',''187'')) ';

	IF p_empresa <> '' THEN
	  v_where := v_where || ' AND oc.id_empresa_compra = ''' || p_empresa || ''' ';
	END IF;

	IF p_persona <> '' THEN
	  v_where := v_where || ' AND oc.id_persona = ''' || p_persona || ''' ';
	END IF;
		
	IF p_fecha_desde <> '' THEN
	  v_where := v_where || ' AND oc.fecha_orden_compra >= ''' || p_fecha_desde || ''' ';
	END IF;

	IF p_fecha_hasta <> '' THEN
	  v_where := v_where || ' AND oc.fecha_orden_compra <= ''' || p_fecha_hasta || ''' ';
	END IF;

	IF p_estado_pago <> '' THEN
	  v_where := v_where || ' AND EXISTS (
	    SELECT 1 FROM orden_compra_pagos ocp_sub 
	    WHERE ocp_sub.id_orden_compra = oc.id 
	    AND ocp_sub.id_estado_pago = ''' || p_estado_pago || '''
	  ) ';
	END IF;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id Desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
