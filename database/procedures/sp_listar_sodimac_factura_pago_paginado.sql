-- DROP FUNCTION public.sp_listar_sodimac_factura_pago_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_sodimac_factura_pago_paginado(p_fecha_ini character varying, p_fecha_fin character varying, p_tipo character varying, p_serie character varying, p_numero character varying, p_estado_pago character varying, p_observacion_pago character varying, p_dias_pagado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_filtros_fecha varchar;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' id, serie, numero, tipo, fecha, destinatario, cod_tributario, subtotal, impuesto, total, estado_pago, anulado, sunat, numero_orden_compra_cliente, moneda, numero_documento_sodimac, importe_total, importe_inicial, importe_retencion, importe_detraccion, estado_pago_sodimac, coincide_total_inicial ';

	v_filtros_fecha := '';
	
	IF p_fecha_ini <> '' THEN
	  v_filtros_fecha := v_filtros_fecha || ' AND c.fecha >= TO_DATE(''' || p_fecha_ini || ''', ''dd-mm-yyyy'') ';
	END IF;
	
	IF p_fecha_fin <> '' THEN
	  v_filtros_fecha := v_filtros_fecha || ' AND c.fecha <= TO_DATE(''' || p_fecha_fin || ''', ''dd-mm-yyyy'') ';
	END IF;

	v_tabla=' (select c.id, c.serie, c.numero, c.tipo, TO_CHAR(c.fecha,''dd-mm-yyyy'') fecha, c.destinatario, c.cod_tributario, c.subtotal, c.impuesto, c.total, c.estado_pago, c.anulado, c.estado_sunat sunat, (select oc.numero_orden_compra_cliente from orden_compras oc inner join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra left join valorizaciones v on ocd.id = v.pk_registro where v.id_comprobante = c.id and oc.estado =''1'' limit 1) numero_orden_compra_cliente, c.moneda, sfd.numero_documento numero_documento_sodimac, sfd.importe_total, sfd.importe_inicial, abs(sfd.importe_retencion) importe_retencion, sfd.importe_detraccion, case when sfd.importe_total is null then 0 else 1 end as estado_pago_sodimac, CASE when sfd.importe_total is not null and c.total::float = sfd.importe_inicial::float THEN 1 when sfd.importe_total is not null and c.total::float != sfd.importe_inicial::float then 2 else 0 END AS coincide_total_inicial ' ||
              'FROM comprobantes c ' ||
              'left join sodimac_factura_detalles sfd on ''01-'' || c.serie ||''-''|| lpad(coalesce(c.numero::int, 1)::varchar, 8, ''0'') = sfd.numero_documento  '||
              'Where 1 = 1 and  c.id_empresa in (''23'',''187'') '|| v_filtros_fecha || '
               UNION ALL ' ||
              'select csh.id, csh.serie, csh.numero, csh.tipo, TO_CHAR(csh.fecha,''dd-mm-yyyy'') fecha, csh.destinatario, csh.cod_tributario, csh.subtotal, csh.impuesto, csh.total, '''' estado_pago, '''' anulado, '''' sunat, '''' numero_orden_compra_cliente, csh.moneda, sfd2.numero_documento, sfd2.importe_total, sfd2.importe_inicial, abs(sfd2.importe_retencion) importe_retencion, sfd2.importe_detraccion, case when sfd2.importe_total is null then 0 else 1 end as estado_pago_sodimac, CASE WHEN sfd2.importe_total is not null and csh.total::float = sfd2.importe_inicial::float THEN 1 when sfd2.importe_total is not null and csh.total::float != sfd2.importe_inicial::float then 2 else 0 END AS coincide_total_inicial ' ||
              'from comprobante_sodimac_historicos csh ' ||
              'left join sodimac_factura_detalles sfd2 on ''01-'' || csh.serie ||''-''|| lpad(coalesce(csh.numero::int, 1)::varchar, 8, ''0'') = sfd2.numero_documento ) union_table ';
	
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_tipo<>'' Then
	 v_where:=v_where||'And tipo = '''||p_tipo||''' ';
	End If;

	If p_serie<>'' Then
	 v_where:=v_where||'And serie = '''||p_serie||''' ';
	End If;

	If p_numero<>'' Then
	 v_where:=v_where||'And numero = '''||p_numero||''' ';
	End If;

	If p_estado_pago<>'' Then
	 v_where:=v_where||'And estado_pago_sodimac = '''||p_estado_pago||''' ';
	End If;

	If p_observacion_pago<>'' Then
	 v_where:=v_where||'And coincide_total_inicial = '''||p_observacion_pago||''' ';
	End If;
	
	If p_dias_pagado<>'' Then
	 v_where:=v_where||'And estado_pago_sodimac = '''||p_dias_pagado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) from '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
