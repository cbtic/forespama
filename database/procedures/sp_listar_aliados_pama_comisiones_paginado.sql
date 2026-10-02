CREATE OR REPLACE FUNCTION public.sp_listar_aliados_pama_comisiones_paginado(p_numero_documento character varying, p_id_user character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_tiene_rol_37 boolean := false;
v_id_persona bigint;
v_id_aliado_pama bigint;

begin

	select 
	    exists(
	        select 1
	        from model_has_roles mhr
	        where mhr.model_id::varchar = p_id_user
	        and mhr.role_id = 37)
	into v_tiene_rol_37;
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' p.id id_persona, p.numero_documento, p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno nombre_aliado, sum(c.total) total, avg(c.porcentaje_comision) porcentaje_comision, sum((c.total * c.porcentaje_comision / 100) - COALESCE(c.monto_pagado_comision, 0)) total_comision, tm.denominacion estado_solicitud ';

	v_tabla=' from comprobantes c 
	inner join aliado_pamas ap on c.id_aliado_pama = ap.id
	inner join personas p on ap.id_persona = p.id and p.estado = ''1''
	inner join tabla_maestras tm on c.estado_pago_comision ::int = tm.codigo ::int and tm.tipo = ''125'' ';
	
	v_where = ' Where 1=1 and c.anulado = ''N'' and ap.estado = ''1'' and c.estado_pago_comision = ''1'' ';

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento = '''||p_numero_documento||''' ';
	End If;

	if v_tiene_rol_37 then 
		select u.id_persona into v_id_persona from users u where u.id = p_id_user::bigint and u.active = '1';
		select ap.id into v_id_aliado_pama from aliado_pamas ap where ap.id_persona = v_id_persona and ap.estado= '1';
	End If;

	IF v_tiene_rol_37 THEN
	    v_where := v_where || ' AND (
	        ap.id = ''' || v_id_aliado_pama || ''')';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ap.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Group by p.id, p.numero_documento, p.nombres, p.apellido_paterno, p.apellido_materno, tm.denominacion /*, c.estado_pago_comision desc*/ Order By p.id LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Group by p.id, p.numero_documento, p.nombres, p.apellido_paterno, p.apellido_materno, tm.denominacion /*, c.estado_pago_comision desc*/ Order By p.id ;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
