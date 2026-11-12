CREATE OR REPLACE FUNCTION public.sp_listar_oxapampa_movimiento_paginado(p_almacen character varying, p_producto character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' com.id, com.id_producto, p.codigo, p.denominacion producto, com.entradas, com.costo_entradas, com.total_entradas, com.salidas, com.costo_salidas, com.total_salidas, com.saldos, 
	com.costo_saldos, com.total_saldos, a.denominacion almacen_destino,  com.fecha fecha_kardex, tm.descripcion tipo_movimiento, /*com.codigo_movimiento,*/ u."name" usuario, 
	to_char(com.created_at,''yyyy-mm-dd'') fecha_creacion, cc.codigo centro_costo, com.estado';

	v_tabla=' from consulta_oxapampa_movimientos com 
	inner join productos p on com.id_producto = p.id 
	left join almacenes a on com.id_almacen = a.id 
	left join users u on com.id_usuario_inserta = u.id
	left join tipo_movimientos tm on com.id_tipo_movimiento = tm.id
	left join dispensaciones d on com.id_movimiento = d.id and tm.id = ''30'' and d.estado = ''1''
	left join centro_costos cc on d.id_centro_costo = cc.id and cc.estado = ''1'' ';
	
	v_where = ' Where 1=1 ';

	If p_producto<>'' Then
	 v_where:=v_where||'And com.id_producto =  '''||p_producto||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where := v_where || 'And com.id_almacen = ''' || p_almacen || ''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And com.fecha  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And com.fecha <= '''||p_fecha_fin|| ' 23:59:59'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And com.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By com.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By com.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
