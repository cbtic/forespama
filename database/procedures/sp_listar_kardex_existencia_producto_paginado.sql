CREATE OR REPLACE FUNCTION public.sp_listar_kardex_existencia_producto_paginado(p_producto character varying, p_almacen character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' DISTINCT ON  (k.id_producto, k.id_almacen_destino ) k.*, p.*, a.denominacion almacen_kardex, tm.denominacion unidad_medida ';

	v_tabla=' FROM kardex k
	LEFT JOIN productos p ON k.id_producto = p.id 
	inner join almacenes a on k.id_almacen_destino = a.id 
	inner join tabla_maestras tm on p.id_unidad_producto ::int = tm.codigo::int and tm.tipo = ''43''';
	
	v_where = ' Where 1=1 ';

	If p_producto<>'' Then
	 v_where:=v_where||'And k.id_producto =  '''||p_producto||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where := v_where || 'And (k.id_almacen_destino = ''' || p_almacen || ''' or k.id_almacen_salida = ''' || p_almacen || ''') ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By k.id_producto ASC, k.id_almacen_destino desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By k.id_producto ASC, k.id_almacen_destino desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
