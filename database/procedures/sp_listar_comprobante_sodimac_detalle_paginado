-- DROP FUNCTION public.sp_listar_marcas_paginado(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_comprobante_sodimac_detalle_paginado(p_numero_documento character varying, p_tipo_documento_cobro character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' sfd.id, sfd.id_sodimac_factura, sfd.id_tipo_documento, sfd.numero_documento, sfd.importe_inicial, sfd.importe_retencion, sfd.importe_total, sfd.id_moneda, tm2.denominacion moneda,
	case 
	when t.denominacion is not null and t.denominacion <> '''' 
	then tm.denominacion || '' - '' || t.denominacion
	else tm.denominacion
	end tipo_documento_cobro,
	sfd.estado ';

	v_tabla=' from sodimac_factura_detalles sfd 
	inner join tabla_maestras tm on sfd.id_tipo_documento_cobro = tm.codigo::int and tm.tipo = ''78''
	left join tiendas t on sfd.id_tienda = t.id 
	left join tabla_maestras tm2 on sfd.id_moneda = tm2.codigo::int and tm2.tipo = ''1'' ';
	
	v_where = ' Where 1=1 and sfd.id_tipo_documento = ''2'' and sfd.estado = ''1'' ';

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And sfd.numero_documento ilike  ''%'||p_numero_documento||'%'' ';
	End If;

	If p_tipo_documento_cobro<>'' Then
	 v_where:=v_where||'And sfd.id_tipo_documento_cobro  = '''||p_tipo_documento_cobro||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sfd.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sfd.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
