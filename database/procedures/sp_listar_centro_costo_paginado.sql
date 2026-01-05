-- DROP FUNCTION public.sp_listar_centro_costo_paginado(varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_centro_costo_paginado(p_periodo character varying, p_operacion character varying, p_denominacion character varying, p_codigo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' cc.id, cc.periodo, tm.denominacion operacion, cc.codigo, cc.denominacion, cc.estado ';

	v_tabla=' from centro_costos cc 
	left join tabla_maestras tm on cc.operacion::int = tm.codigo::int and tm.tipo = ''115'' ';
	
	v_where = ' Where 1=1 ';

	If p_periodo<>'' Then
	 v_where:=v_where||'And cc.periodo = '''||p_periodo||''' ';
	End If;

	If p_operacion<>'' Then
	 v_where:=v_where||'And cc.operacion = '''||p_operacion||''' ';
	End If;

	If p_denominacion<>'' Then
	 v_where:=v_where||'And cc.denominacion ilike ''%'||p_denominacion||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And cc.codigo = '''||p_codigo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And cc.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cc.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cc.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
