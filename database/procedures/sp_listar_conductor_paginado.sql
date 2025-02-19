CREATE OR REPLACE FUNCTION public.sp_listar_conductor_paginado(p_nombres character varying, p_licencia character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$
Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

begin 

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' c.id, p.nombres||'' ''||p.apellido_paterno||'' ''||p.apellido_materno nombres, p.numero_documento, c.licencia, c.fecha_licencia, c.estado ';

	v_tabla=' from conductores c 
	inner join personas p on c.id_personas = p.id ';
	
	v_where = ' where 1=1  ';
	
	If p_nombres<>'' Then
	 v_where:=v_where||' And p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres ilike ''%'||p_nombres||'%'' ';
	End If;

	If p_licencia<>'' Then
	 v_where:=v_where||' And c.licencia = '''||p_licencia||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||' And c.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
