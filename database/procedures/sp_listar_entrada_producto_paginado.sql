CREATE OR REPLACE FUNCTION public.sp_listar_entrada_producto_paginado(p_tipo_movimiento character varying, p_tipo_documento character varying, p_unidad_origen character varying, p_almacen_destino character varying, p_proveedor character varying, p_numero_comprobante character varying, p_cerrado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' id, tipo, fecha_movimiento, tipo_documento, unidad_origen, razon_social, codigo, fecha_comprobante, estado, created_at, cerrado, id_tipo, id_tipo_documento, id_unidad_origen, almacen, id_almacen, id_proveedor, usuario_recibe ';

	v_tabla=' (SELECT ep.id, ''INGRESO'' tipo, ep.fecha_ingreso fecha_movimiento, tm.denominacion tipo_documento, tm2.denominacion unidad_origen, e.razon_social, ep.codigo, ep.fecha_comprobante, ep.estado, ep.created_at, ep.cerrado, ''1'' id_tipo, ep.id_tipo_documento, ep.unidad_origen id_unidad_origen, a.denominacion almacen, ep.id_almacen_destino id_almacen, ep.id_proveedor, u.name usuario_recibe ' ||
              'FROM entrada_productos ep ' ||
              'INNER JOIN tabla_maestras tm ON ep.id_tipo_documento = tm.codigo::int AND tm.tipo = ''48'' ' ||
              'INNER JOIN tabla_maestras tm2 ON ep.unidad_origen::int = tm2.codigo::int AND tm2.tipo = ''50'' ' ||
              'INNER JOIN empresas e ON ep.id_proveedor = e.id ' ||
              'inner join almacenes a on ep.id_almacen_destino = a.id ' ||
              'left join users u on ep.id_usuario_recibe = u.id ' ||
              'UNION ALL ' ||
              'SELECT sp.id, ''SALIDA'' tipo, sp.fecha_salida fecha_movimiento, tm.denominacion tipo_documento, tm2.denominacion unidad_origen, '''' razon_social, sp.codigo, sp.fecha_comprobante, sp.estado, sp.created_at, sp.cerrado, ''2'' id_tipo, sp.id_tipo_documento, sp.unidad_destino id_unidad_origen, a.denominacion almacen, sp.id_almacen_salida id_almacen, null id_proveedor, u.name usuario_recibe ' ||
              'FROM salida_productos sp ' ||
              'INNER JOIN tabla_maestras tm ON sp.id_tipo_documento = tm.codigo::int AND tm.tipo = ''49'' ' ||
              'inner join almacenes a on sp.id_almacen_salida = a.id ' ||
              'left join users u on sp.id_usuario_recibe = u.id ' ||
              'INNER JOIN tabla_maestras tm2 ON sp.unidad_destino::int = tm2.codigo::int AND tm2.tipo = ''50'') union_table ';
	
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
