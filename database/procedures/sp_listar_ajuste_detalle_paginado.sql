CREATE OR REPLACE FUNCTION public.sp_listar_ajuste_detalle_paginado(p_tipo_documento character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_operacion character varying, p_almacen_destino character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' id, tipo, fecha_movimiento, tipo_documento, id_tipo_movimiento, codigo, estado, id_tipo_documento, almacen, id_almacen, usuario, created_at, codigo_producto, producto, cantidad ';

	v_tabla='(SELECT ep.id, ''INGRESO'' tipo, 1 id_tipo_movimiento, ep.fecha_ingreso fecha_movimiento, tm.denominacion tipo_documento, ep.codigo, ep.estado, ep.id_tipo_documento, a.denominacion almacen, ep.id_almacen_destino id_almacen, u.name usuario, ep.created_at, p.codigo codigo_producto, p.denominacion producto, epd.cantidad ' ||
			'FROM entrada_productos ep ' ||
			'inner join entrada_producto_detalles epd on ep.id = epd.id_entrada_productos ' ||
			'inner join productos p on epd.id_producto = p.id ' ||
			'inner JOIN tabla_maestras tm ON ep.id_tipo_documento = tm.codigo::int and tm.tipo = ''48'' ' ||
			'inner join almacenes a on ep.id_almacen_destino = a.id ' ||
			'left join users u on ep.id_usuario_inserta = u.id ' ||
			'where ep.ajuste = ''1'' ' ||
			'union all ' ||
			'select sp.id, ''SALIDA'' tipo, 2 id_tipo_movimiento, sp.fecha_salida fecha_movimiento, tm.denominacion tipo_documento, sp.codigo, sp.estado, sp.id_tipo_documento, a.denominacion almacen, sp.id_almacen_salida id_almacen, u.name usuario, sp.created_at, p.codigo codigo_producto, p.denominacion producto, spd.cantidad ' ||
			'from salida_productos sp ' ||
			'inner join salida_producto_detalles spd on sp.id = spd.id_salida_productos ' ||
			'inner join productos p on spd.id_producto = p.id ' ||
			'inner JOIN tabla_maestras tm ON sp.id_tipo_documento = tm.codigo::int and tm.tipo = ''49'' ' ||
			'inner join almacenes a on sp.id_almacen_salida = a.id ' ||
			'left join users u on sp.id_usuario_inserta = u.id ' ||
			'where sp.ajuste = ''1'') union_table ';
	
	v_where = ' Where 1=1 ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And fecha_movimiento >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And fecha_movimiento <= '''||p_fecha_fin||''' ';
	End If;

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And id_almacen  = '''||p_almacen_destino||''' ';
	End If;

	If p_numero_operacion<>'' Then
	 v_where:=v_where||'And codigo = '''||p_numero_operacion||''' ';
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
