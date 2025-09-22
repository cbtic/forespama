CREATE OR REPLACE FUNCTION public.sp_listar_sub_familia_paginado(p_familia character varying, p_denominacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' sf.id, f.denominacion familia, sf.denominacion, sf.inicial_codigo, sf.estado ';

	v_tabla=' from sub_familias sf
	inner join familias f on sf.id_familia = f.id ';
	
	v_where = ' Where 1=1 ';
	
	If p_familia<>'' Then
	 v_where:=v_where||'And sf.id_familia = '''||p_familia||''' ';
	End If;

	If p_denominacion<>'' Then
	 v_where:=v_where||'And sf.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And sf.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sf.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sf.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
