CREATE OR REPLACE FUNCTION public.sp_listar_entrega_activos_paginado(p_persona character varying, p_descripcion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' au.id, p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno persona, p.numero_documento, a.descripcion, m.denominiacion marca, a.modelo, au.fecha_entrega, au.fecha_devolucion, au.estado ';

	v_tabla=' from activo_usuarios au 
	inner join personas p on au.id_usuario = p.id 
	inner join activos a on au.id_activo = a.id 
	left join marcas m on a.id_marca = m.id ';
	
	v_where = ' Where 1=1 ';

	If p_persona<>'' Then
	 v_where:=v_where||'And au.id_usuario  = '''||p_persona||''' ';
	End If;

	If p_descripcion<>'' Then
	 v_where:=v_where||'And a.descripcion  ilike ''%'||p_descripcion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And au.estado  = '''||p_estado||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By au.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By au.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
