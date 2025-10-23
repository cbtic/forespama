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

	v_campos=' p.id id_producto, p.denominacion producto, p.codigo, ep.sku, p.costo_unitario, 
	(select cd2.precio_competencia from chopeo_detalles cd2 
	inner join chopeos c2 on cd2.id_chopeo = c2.id 
	where cd2.id_producto = p.id and c2.id_competencia = ''1'' 
	order by c2.fecha_chopeo desc 
	limit 1) precio_dimfer,
	(select cd2.precio_competencia from chopeo_detalles cd2 
	inner join chopeos c2 on cd2.id_chopeo = c2.id 
	where cd2.id_producto = p.id and c2.id_competencia = ''2'' 
	order by c2.fecha_chopeo desc 
	limit 1) precio_ares ';

	v_tabla=' from productos p
	left join equivalencia_productos ep on ep.id_producto = p.id and ep.estado = ''1'' ';
	
	v_where = ' Where 1=1 and p.denominacion ilike ''%(RT)%'' and p.estado = ''1'' ';

	/*If p_tienda<>'' Then
	 v_where:=v_where||'And m.denominiacion ilike  ''%'||p_tienda||'%'' ';
	End If;*/

	If p_producto<>'' Then
	 v_where:=v_where||'And p.id= '''||p_producto||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.codigo asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.codigo asc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
