CREATE OR REPLACE FUNCTION public.sp_listar_comprobante_promart_paginado(p_fecha_ini character varying, p_fecha_fin character varying, p_tipo character varying, p_serie character varying, p_numero character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' c.id, 
	(select e.ruc from empresas e where c.id_empresa = e.id) ruc,
	c.serie, c.numero, c.tipo, TO_CHAR(c.fecha,''dd-mm-yyyy'') fecha, c.destinatario, 
	c.subtotal, c.impuesto, c.total, c.estado_pago, c.anulado, c.estado_sunat sunat,
	(select oc.numero_orden_compra_cliente from orden_compras oc
	inner join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra 
	left join valorizaciones v on ocd.id = v.pk_registro 
	where v.id_comprobante = c.id
	limit 1), c.moneda ';
        
	v_tabla='FROM comprobantes c ';

	v_where = ' Where 1 = 1 and  c.id_empresa = ''459'' and c.anulado != ''S'' ';

	If p_fecha_ini<>'' Then
	 v_where:=v_where||' And c.fecha >= '''||p_fecha_ini||' :00:00'' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||' And c.fecha <= '''||p_fecha_fin||' :23:59'' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||' And c.tipo = '''||p_tipo||''' '; 
	End If;

	If p_serie<>'' Then
	 v_where:=v_where||' And c.serie ilike '''||p_serie||'%'' '; 
	End If;
	
	If p_numero<>'' Then
	 v_where:=v_where||' And c.numero = '''||p_numero||''' '; 
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.fecha Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.fecha Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
