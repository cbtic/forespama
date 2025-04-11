-- DROP FUNCTION public.sp_listar_entrada_producto_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

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

	v_campos=' id, serie, numero, tipo, fecha, destinatario, subtotal, impuesto, total, estado_pago, anulado, sunat, numero_orden_compra_cliente, moneda, numero_documento_sodimac ';

	v_tabla=' (select c.id, c.serie, c.numero, c.tipo, TO_CHAR(c.fecha,''dd-mm-yyyy'') fecha, c.destinatario, c.subtotal, c.impuesto, c.total, c.estado_pago, c.anulado, c.estado_sunat sunat, (select oc.numero_orden_compra_cliente from orden_compras oc inner join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra left join valorizaciones v on ocd.id = v.pk_registro where v.id_comprobante = c.id limit 1) numero_orden_compra_cliente, c.moneda, sfd.numero_documento numero_documento_sodimac ' ||
              'FROM comprobantes c ' ||
              'left join sodimac_factura_detalles sfd on ''01-'' || c.serie ||''-''|| lpad(coalesce(c.numero::int, 1)::varchar, 8, ''0'') = sfd.numero_documento  '||
              'Where 1 = 1 and  c.id_empresa in (''23'',''187'') '||
              'UNION ALL ' ||
              'select csh.id, csh.serie, csh.numero, csh.tipo, TO_CHAR(csh.fecha,''dd-mm-yyyy'') fecha, csh.destinatario, csh.subtotal, csh.impuesto, csh.total, '''' estado_pago, '''' anulado, '''' sunat, '''' numero_orden_compra_cliente, csh.moneda, sfd2.numero_documento ' ||
              'from comprobante_sodimac_historicos csh ' ||
              'left join sodimac_factura_detalles sfd2 on ''01-'' || csh.serie ||''-''|| lpad(coalesce(csh.numero::int, 1)::varchar, 8, ''0'') = sfd2.numero_documento ) union_table ';
	
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_tipo_movimiento<>'' Then
	 v_where:=v_where||'And id_tipo  = '''||p_tipo_movimiento||''' ';
	End If;

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_unidad_origen<>'' Then
	 v_where:=v_where||'And id_unidad_origen  = '''||p_unidad_origen||''' ';
	End If;

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And id_almacen  = '''||p_almacen_destino||''' ';
	End If;

	If p_proveedor<>'' Then
	 v_where:=v_where||'And id_proveedor  = '''||p_proveedor||''' ';
	End If;

	If p_numero_comprobante<>'' Then
	 v_where:=v_where||'And codigo = '''||p_numero_comprobante||''' ';
	End If;

	If p_cerrado<>'' Then
	 v_where:=v_where||'And cerrado  = '''||p_cerrado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) from '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By created_at desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By created_at desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
