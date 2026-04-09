-- DROP FUNCTION public.sp_listar_reporte_comercializacion_general_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_reporte_comercializacion_sin_igv_paginado(p_canal character varying, p_empresa_compra character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_vendedor character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' c.destinatario cliente, tm.denominacion canal, u.name vendedor, c.subtotal total_despacho, c.fecha fecha_orden_compra, oc.numero_orden_compra pedido ';

	v_tabla=' from comprobantes c 
	inner join orden_compras oc on c.orden_compra::int = oc.id 
	left join tabla_maestras tm on oc.id_canal = tm.codigo::int and tm.tipo = ''98''
	left join users u on oc.id_vendedor = u.id ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and oc.estado_pedido = ''1'' and oc.estado = ''1'' and c.anulado = ''N'' ';

	If p_canal<>'' Then
	 v_where:=v_where||' And oc.id_canal = '''||p_canal||''' ';
	End If;

	If p_empresa_compra<>'' Then
	 v_where:=v_where||' And oc.id_empresa_compra = '''||p_empresa_compra||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||' And c.fecha >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||' And c.fecha  <= '''||p_fecha_fin||''' ';
	End If;

	If p_vendedor<>'' Then
	 v_where:=v_where||' And oc.id_vendedor = '''||p_vendedor||''' ';
	End If;	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
