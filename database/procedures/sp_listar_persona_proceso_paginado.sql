CREATE OR REPLACE FUNCTION public.sp_listar_persona_proceso_paginado(p_persona character varying, p_proceso character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' pp.id, u."name" usuario, tm.denominacion proceso, pp.estado ';

	v_tabla=' from persona_procesos pp 
	inner join users u on pp.id_persona = u.id
	inner join tabla_maestras tm on pp.id_proceso = tm.codigo::int and tm.tipo = ''109'' ';
	
	v_where = ' Where 1=1 ';

	If p_persona<>'' Then
	 v_where:=v_where||'And pp.id_persona = '''||p_persona||''' ';
	End If;

	If p_proceso<>'' Then
	 v_where:=v_where||'And pp.id_proceso = '''||p_proceso||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And pp.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pp.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pp.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
