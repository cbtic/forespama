CREATE OR REPLACE FUNCTION public.sp_listar_kardex_secundario_paginado(p_producto character varying, p_almacen character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ks.id, p.codigo, p.denominacion producto, ks.entradas_cantidad, ks.costo_entradas_cantidad, ks.total_entradas_cantidad, ks.salidas_cantidad, ks.costo_salidas_cantidad, ks.total_salidas_cantidad,
	ks.saldos_cantidad, ks.costo_saldos_cantidad, ks.total_saldos_cantidad, a.denominacion almacen, to_char(ks.fecha,''dd-mm-yyyy'') fecha, tm.denominacion tipo_movimiento, iss.numero_ingreso_salida ';

	v_tabla=' from kardex_secundarios ks 
	inner join ingreso_salida_secundarios iss on ks.id_entrada_salida_secundario = iss.id 
	inner join productos p on ks.id_producto = p.id 
	inner join almacenes a on ks.id_almacen = a.id 
	inner join tabla_maestras tm on iss.id_tipo_documento = tm.codigo:: int and tm.tipo = ''53'' ';
	
	v_where = ' Where 1=1 ';

	If p_producto<>'' Then
	 v_where:=v_where||'And ks.id_producto =  '''||p_producto||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where := v_where || 'And ks.id_almacen = ''' || p_almacen || ''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And ks.fecha  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And ks.fecha <= '''||p_fecha_fin|| ' 23:59:59'' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ks.fecha desc, ks.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ks.fecha desc, ks.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
