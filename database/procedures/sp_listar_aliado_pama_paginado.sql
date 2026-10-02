CREATE OR REPLACE FUNCTION public.sp_listar_aliado_pama_paginado(p_numero_documento character varying, p_aliado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ap.id, p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno nombres, tm.denominacion tipo_documento, p.numero_documento, dp.desc_ubigeo departamento, pr.desc_ubigeo provincia, d.desc_ubigeo distrito, p.direccion, p.telefono, p.email, ap.fecha_inicio, ap.porcentaje_comision, ap.estado ';

	v_tabla=' from aliado_pamas ap 
	inner join personas p on ap.id_persona = p.id 
	left join tabla_maestras tm ON p.id_tipo_documento = tm.codigo::int and tm.tipo = ''9''
	inner join ubigeos u on p.id_ubigeo_nacimiento = u.id_ubigeo
	left join ubigeos pr on pr.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 4) || ''00''
	left join ubigeos dp on dp.id_ubigeo = SUBSTRING(u.id_ubigeo FROM 1 FOR 2) || ''0000''
	left join ubigeos d on d.id_ubigeo = u.id_ubigeo ';
	
	v_where = ' Where 1=1 ';

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento = '''||p_numero_documento||''' ';
	End If;

	If p_aliado<>'' Then
	 v_where:=v_where||'And p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno ilike ''%'||p_aliado||'%'' ';
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
