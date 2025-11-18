-- DROP FUNCTION public.sp_listar_activos_paginado(varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_activos_paginado(p_tipo_activo character varying, p_descripcion character varying, p_placa character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' a.id, u.desc_ubigeo ubigeo, a.direccion, tm.denominacion tipo_activo, a.descripcion, a.placa, a.modelo, a.serie, m.denominiacion marca, a.color, a.titulo, a.partida_registral, a.partida_circulacion, a.vigencia_circulacion,
	(select sa.fecha_vencimiento 
	from soat_activos sa 
	where sa.id_activos = a.id 
	and sa.estado = ''1'' 
	order by fecha_vencimiento desc 
	limit 1) fecha_vencimiento_soat, 
	(select rta.fecha_vencimiento 
	from revision_tecnica_activos rta 
	where rta.id_activos = a.id 
	and rta.estado = ''1'' 
	order by fecha_vencimiento desc 
	limit 1) fecha_vencimiento_revision, 
	a.valor_libros, a.valor_comercial, tm3.denominacion tipo_combustible, a.dimensiones, tm2.denominacion estado_activo, a.estado ';

	v_tabla=' from activos a
	inner join tabla_maestras tm on a.id_sub_tipo_activo = tm.codigo::int and tm.tipo = ''84'' and tm.sub_codigo::int = a.id_tipo_activo
	left join tabla_maestras tm2 on a.id_estado_activo::int = tm2.codigo::int and tm2.tipo = ''85''
	left join tabla_maestras tm3 on a.id_tipo_combustible = tm3.codigo::int and tm3.tipo = ''86''
	left join marcas m on a.id_marca = m.id 
	inner join ubigeos u on a.id_ubigeo::int = u.id_ubigeo::int ';
	
	v_where = ' Where 1=1 ';

	/*If p_ubigeo<>'' Then
	 v_where:=v_where||'And a.id_ubigeo  = '''||p_ubigeo||''' ';
	End If;*/

	If p_tipo_activo<>'' Then
	 v_where:=v_where||'And a.id_tipo_activo  = '''||p_tipo_activo||''' ';
	End If;

	If p_descripcion<>'' Then
	 v_where:=v_where||'And a.descripcion  ilike ''%'||p_descripcion||'%'' ';
	End If;

	If p_placa<>'' Then
	 v_where:=v_where||'And a.placa  = '''||p_placa||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And a.estado  = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By a.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
