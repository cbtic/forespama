-- DROP FUNCTION public.sp_listar_asistencia_promotor_paginado(varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_asistencia_promotor_paginado(p_fecha character varying, p_id_user character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_id_rol integer;
v_id_rol_admin integer;

begin
	
	select role_id into v_id_rol from model_has_roles mhr where mhr.model_id::varchar=p_id_user;

	select role_id into v_id_rol_admin from model_has_roles mhr where mhr.model_id::varchar=p_id_user and mhr.role_id in ('1','22');
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' ap.id, t.denominacion tienda, u."name" promotor, ap.fecha, ap.hora_entrada, ap.hora_salida, ap.ip, ap.latitud, ap.longitud, ap.latitud_salida, ap.longitud_salida, ap.estado, ap.ruta_imagen_ingreso, ap.ruta_imagen_salida ';

	v_tabla=' from asistencia_promotores ap 
	inner join users u on ap.id_promotor = u.id
	inner join tiendas t on ap.id_tienda = t.id ';
	
	v_where = ' Where 1=1 ';

	If p_fecha<>'' Then
	 v_where:=v_where||'And ap.fecha = '''||p_fecha||''' ';
	End If;

	If p_id_user<>'' and (v_id_rol_admin is null or v_id_rol_admin not in (1,22)) Then
	 v_where:=v_where||'And ap.id_promotor = '''||p_id_user||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ap.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ap.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ap.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
