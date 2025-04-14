-- DROP FUNCTION public.sp_listar_sodimac_factura_pago_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_sodimac_factura_pago_paginado(p_fecha_ini character varying, p_fecha_fin character varying, p_tipo character varying, p_serie character varying, p_numero character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' id, serie, numero, tipo, fecha, destinatario, cod_tributario, subtotal, impuesto, total, estado_pago, anulado, sunat, numero_orden_compra_cliente, moneda, numero_documento_sodimac, importe_total ';

	v_tabla=' (select c.id, c.serie, c.numero, c.tipo, TO_CHAR(c.fecha,''dd-mm-yyyy'') fecha, c.destinatario, c.cod_tributario, c.subtotal, c.impuesto, c.total, c.estado_pago, c.anulado, c.estado_sunat sunat, (select oc.numero_orden_compra_cliente from orden_compras oc inner join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra left join valorizaciones v on ocd.id = v.pk_registro where v.id_comprobante = c.id and oc.estado =''1'' limit 1) numero_orden_compra_cliente, c.moneda, sfd.numero_documento numero_documento_sodimac, sfd.importe_total  ' ||
              'FROM comprobantes c ' ||
              'left join sodimac_factura_detalles sfd on ''01-'' || c.serie ||''-''|| lpad(coalesce(c.numero::int, 1)::varchar, 8, ''0'') = sfd.numero_documento  '||
              'Where 1 = 1 and  c.id_empresa in (''23'',''187'') '||
              'UNION ALL ' ||
              'select csh.id, csh.serie, csh.numero, csh.tipo, TO_CHAR(csh.fecha,''dd-mm-yyyy'') fecha, csh.destinatario, csh.cod_tributario, csh.subtotal, csh.impuesto, csh.total, '''' estado_pago, '''' anulado, '''' sunat, '''' numero_orden_compra_cliente, csh.moneda, sfd2.numero_documento, sfd2.importe_total ' ||
              'from comprobante_sodimac_historicos csh ' ||
              'left join sodimac_factura_detalles sfd2 on ''01-'' || csh.serie ||''-''|| lpad(coalesce(csh.numero::int, 1)::varchar, 8, ''0'') = sfd2.numero_documento ) union_table ';
	
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_fecha_ini<>'' Then
	 v_where:=v_where||'And fecha >= '''||p_fecha_ini||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And fecha <= '''||p_fecha_fin||''' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||'And tipo = '''||p_tipo||''' ';
	End If;

	If p_serie<>'' Then
	 v_where:=v_where||'And serie = '''||p_serie||''' ';
	End If;

	If p_numero<>'' Then
	 v_where:=v_where||'And numero = '''||p_numero||''' ';
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
