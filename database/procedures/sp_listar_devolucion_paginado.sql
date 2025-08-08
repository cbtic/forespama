CREATE OR REPLACE FUNCTION public.sp_listar_devolucion_paginado(p_empresa character varying, p_fecha character varying, p_numero_devolucion character varying, p_numero_orden_compra_cliente character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' id, tipo_documento, id_tipo_documento, codigo, empresa, numero_orden_compra_cliente, fecha_documento ';

	v_tabla=' (select sp.id, ''SALIDA'' tipo_documento, 2 id_tipo_documento, sp.codigo, e.razon_social empresa, oc.numero_orden_compra_cliente, sp.fecha_salida fecha_documento ' ||
              'FROM salida_productos sp ' ||
              'inner join empresas e on sp.id_empresa_compra = e.id '||
              'inner join orden_compras oc on sp.id_orden_compra = oc.id '||
              'Where 1 = 1 and sp.tipo_devolucion = ''2'' ' ||
              'UNION ALL ' ||
              'select ep.id, ''ENTRADA'' tipo_documento, 1 id_tipo_documento, ep.codigo, e.razon_social empresa, oc.numero_orden_compra_cliente, ep.fecha_ingreso fecha_documento ' ||
              'from entrada_productos ep ' ||
              'inner join empresas e on ep.id_empresa_compra  = e.id ' || 
			  'inner join orden_compras oc on ep.id_orden_compra = oc.id '||
			  'Where 1 = 1 and ep.tipo_devolucion = ''2'') union_table ';
	
	v_where = ' Where 1=1 ';

	If p_empresa<>'' Then
	 v_where:=v_where||'And sp.id_empresa_compra  = '''||p_empresa||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And sp.fecha_salida  = '''||p_fecha||''' ';
	End If;

	/*If p_numero_devolucion<>'' Then
	 v_where:=v_where||'And d.numero_devolucion = '''||p_numero_devolucion||''' ';
	End If;*/

	If p_numero_orden_compra_cliente<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra_cliente  = '''||p_numero_orden_compra_cliente||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) from '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By fecha_documento desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By fecha_documento desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
