-- DROP FUNCTION public.sp_listar_chopeo_productos_paginado(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_chopeo_productos_paginado(p_tienda character varying, p_producto character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' id_producto, producto, codigo, precio, fecha_chopeo, precio_dimfer, precio_ares, origen ';

	v_tabla=' (SELECT p.id id_producto, p.denominacion producto, p.codigo, p.costo_unitario precio, ' ||
	'(SELECT c2.fecha_chopeo ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = ep.id_producto_dimfer ' || 
	'AND c2.id_competencia = 2 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) fecha_chopeo, ' ||
	'(SELECT cd2.precio_competencia ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = ep.id_producto_dimfer ' ||
	'AND c2.id_competencia = 2 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) precio_dimfer, ' ||
	'(SELECT cd2.precio_competencia ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = ep.id_producto_ares ' ||
	'AND c2.id_competencia = 3 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) precio_ares, ''PROPIO'' origen ' ||
	'FROM productos p ' ||
	'LEFT JOIN equivalencia_productos ep ON ep.id_producto = p.id AND ep.estado = ''1'' ' ||
	'WHERE p.denominacion ILIKE ''%(RT)%'' ' ||
	'AND p.estado = ''1'' ' ||
	'UNION all ' ||
	'SELECT pc.id id_producto, pc.denominacion producto, pc.codigo, pc.precio, ' ||
	'(SELECT c2.fecha_chopeo ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = pc.id ' ||
	'AND c2.id_competencia = 2 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) fecha_chopeo, ' ||
	'(SELECT cd2.precio_competencia ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = pc.id ' ||
	'AND c2.id_competencia = 2 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) precio_dimfer, ' ||
	'(SELECT cd2.precio_competencia ' ||
	'FROM chopeo_detalles cd2 ' ||
	'INNER JOIN chopeos c2 ON cd2.id_chopeo = c2.id ' ||
	'WHERE cd2.id_producto = pc.id ' ||
	'AND c2.id_competencia = 3 ' ||
	'ORDER BY c2.fecha_chopeo DESC ' ||
	'LIMIT 1) precio_ares, ''COMPETENCIA'' AS origen ' ||
	'FROM productos_competencias pc ' ||
	'WHERE pc.estado = ''1'') union_table ';
	
	v_where = ' Where 1=1 ';

	/*If p_tienda<>'' Then
	 v_where:=v_where||'And m.denominiacion ilike  ''%'||p_tienda||'%'' ';
	End If;*/

	If p_producto<>'' Then
	 v_where:=v_where||'And p.id= '''||p_producto||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) from '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By origen desc, codigo asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count|| 'from' ||v_tabla||v_where||' Order By origen desc, codigo asc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
