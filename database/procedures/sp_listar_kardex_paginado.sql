-- DROP FUNCTION public.sp_listar_kardex_paginado(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_kardex_paginado(p_producto character varying, p_almacen character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' k.id, p.codigo, p.denominacion producto, k.entradas_cantidad entrada, k.costo_entradas_cantidad costo_entrada, k.total_entradas_cantidad total_entrada, k.salidas_cantidad salida, 
	k.costo_salidas_cantidad costo_salida, k.total_salidas_cantidad total_salida, k.saldos_cantidad saldos, k.costo_saldos_cantidad costo_saldos, k.total_saldos_cantidad total_saldos, a.denominacion almacen_destino, 
	a2.denominacion almacen_salida, to_char(k.created_at, ''DD-MM-YYYY'') fecha_kardex,
	case when k.id_entrada_producto is not null then ''Ingreso''
	when k.id_salida_producto is not null then ''Salida''
	when k.id_dispensacion is not null then ''Dispensacion''
	when k.id_ingreso_produccion is not null then ''Ingreso Produccion''
	end tipo_movimiento,
	case when k.id_entrada_producto is not null then (select ep.codigo from entrada_productos ep where k.id_entrada_producto = ep.id)
	when k.id_salida_producto is not null then (select sp.codigo from salida_productos sp where k.id_salida_producto = sp.id)
	when k.id_dispensacion is not null then (select d.codigo from dispensaciones d where k.id_dispensacion = d.id)
	when k.id_ingreso_produccion is not null then (select ip.codigo from ingreso_produccion ip where k.id_ingreso_produccion = ip.id)
	end codigo_movimiento ';

	v_tabla=' from kardex k 
	inner join productos p on k.id_producto = p.id
	left join almacenes a on k.id_almacen_destino = a.id 
	left join almacenes a2 on k.id_almacen_salida = a2.id ';
	
	v_where = ' Where 1=1 ';

	If p_producto<>'' Then
	 v_where:=v_where||'And k.id_producto =  '''||p_producto||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where := v_where || 'And (k.id_almacen_destino = ''' || p_almacen || ''' or k.id_almacen_salida = ''' || p_almacen || ''') ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And k.created_at  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And k.created_at <= '''||p_fecha_fin|| ' 23:59:59'' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By k.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By k.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
