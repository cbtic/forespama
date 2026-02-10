CREATE OR REPLACE FUNCTION public.sp_listar_familia_contable_paginado(p_familia_contable character varying, p_codigo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' fc.id, fc.denominacion familia_contable, cc.denominacion cuenta_contable, cc.cuenta, fc.estado ';

	v_tabla=' from familia_contables fc 
	inner join cuenta_contables cc on fc.id_plan_contable = cc.id ';
	
	v_where = ' Where 1=1 ';
	
	If p_familia_contable<>'' Then
	 v_where:=v_where||'And fc.denominacion ilike ''%'||p_familia_contable||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And cc.cuenta = '''||p_codigo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And fc.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By fc.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By fc.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
