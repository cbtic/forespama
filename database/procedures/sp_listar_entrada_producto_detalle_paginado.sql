CREATE OR REPLACE FUNCTION public.sp_listar_entrada_producto_detalle_paginado(p_tipo_movimiento character varying, p_tipo_documento character varying, p_unidad_origen character varying, p_almacen_destino character varying, p_proveedor character varying, p_numero_comprobante character varying, p_cerrado character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' id, tipo, id_tipo, fecha_movimiento, unidad_origen, razon_social, codigo, estado, almacen, usuario_recibe, codigo_producto, producto, cantidad, created_at ';

	v_tabla=' (select ep.id, ''INGRESO'' tipo, ''1'' id_tipo, ep.fecha_ingreso fecha_movimiento,tm2.denominacion unidad_origen, ' ||
			'case when ep.id_tipo_cliente = ''1'' ' ||
			'then (select p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres proveedor from personas p ' ||
			'where p.id = ep.id_persona ' ||
			'and p.estado = ''1'') ' ||
			'else (select e.razon_social from empresas e ' ||
			'where e.id = ep.id_empresa_compra ' ||
			'and e.estado = ''1'') ' ||
			'end razon_social, ' ||
			'ep.codigo, ep.estado, a.denominacion almacen, u.name usuario_recibe, p.codigo codigo_producto, p.denominacion producto, epd.cantidad, ep.created_at ' ||
			'from entrada_productos ep ' ||
			'inner join entrada_producto_detalles epd on ep.id = epd.id_entrada_productos ' ||
			'inner join productos p on epd.id_producto = p.id ' ||
			'left join tabla_maestras tm2 ON ep.unidad_origen::int = tm2.codigo::int and tm2.tipo = ''50'' ' ||
			'left join almacenes a on ep.id_almacen_destino = a.id ' ||
			'left join users u on ep.id_usuario_recibe = u.id ' ||
			'where ep.ajuste is null ' ||
			'and ep.estado = ''1'' ' ||
			'union all ' ||
			'select sp.id, ''SALIDA'' tipo, ''2'' id_tipo, sp.fecha_salida fecha_movimiento, tm2.denominacion unidad_origen, ' ||
			'case when sp.id_tipo_cliente = ''1'' ' ||
			'then (select p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres proveedor from personas p ' ||
			'where p.id = sp.id_persona ' ||
			'and p.estado = ''1'') ' ||
			'else (select e.razon_social from empresas e ' ||
			'where e.id = sp.id_empresa_compra ' ||
			'and e.estado = ''1'') ' ||
			'end razon_social, ' ||
			'sp.codigo, sp.estado, a.denominacion almacen, u.name usuario_recibe, p.codigo codigo_producto, p.denominacion producto, spd.cantidad, sp.created_at ' ||
			'from salida_productos sp ' ||
			'inner join salida_producto_detalles spd on sp.id = spd.id_salida_productos ' ||
			'inner join productos p on spd.id_producto = p.id ' ||
			'inner join almacenes a on sp.id_almacen_salida = a.id ' ||
			'left join users u on sp.id_usuario_recibe = u.id ' ||
			'inner join tabla_maestras tm2 ON sp.unidad_destino::int = tm2.codigo::int and tm2.tipo = ''50'' ' ||
			'where sp.tipo_devolucion = ''3'') union_table ';

	v_where = ' Where 1=1 ';
	
	If p_tipo_movimiento<>'' Then
	 v_where:=v_where||'And id_tipo = '''||p_tipo_movimiento||''' ';
	End If;

	/*If p_tipo_documento<>'' Then
	 v_where:=v_where||'And id_tipo_documento = '''||p_tipo_documento||''' ';
	End If;*/

	/*If p_unidad_origen<>'' Then
	 v_where:=v_where||'And id_unidad_origen = '''||p_unidad_origen||''' ';
	End If;*/

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And id_almacen = '''||p_almacen_destino||''' ';
	End If;

	/*If p_proveedor<>'' Then
	 v_where:=v_where||'And id_proveedor = '''||p_proveedor||''' ';
	End If;*/

	If p_numero_comprobante<>'' Then
	 v_where:=v_where||'And codigo = '''||p_numero_comprobante||''' ';
	End If;

	/*If p_cerrado<>'' Then
	 v_where:=v_where||'And cerrado = '''||p_cerrado||''' ';
	End If;*/

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And fecha_movimiento >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And fecha_movimiento <= '''||p_fecha_fin||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And estado = '''||p_estado||''' ';
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
