CREATE OR REPLACE FUNCTION public.sp_listar_equivalencia_sub_familia_familia_contable_paginado(p_sub_familia character varying, p_familia_contable character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' esffc.id, sf.id id_sub_familia, sf.denominacion sub_familia, fc.id id_familia_contable, fc.denominacion familia_contable, esffc.estado ';

	v_tabla=' from equivalencia_sub_familia_familia_contables esffc 
	inner join sub_familias sf on esffc.id_sub_familia = sf.id 
	inner join familia_contables fc on esffc.id_familia_contable = fc.id ';
	
	v_where = ' Where 1=1 ';
	
	If p_sub_familia<>'' Then
	 v_where:=v_where||'And esffc.id_sub_familia = '''||p_sub_familia||''' ';
	End If;

	If p_familia_contable<>'' Then
	 v_where:=v_where||'And esffc.id_familia_contable = '''||p_familia_contable||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And esffc.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By esffc.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By esffc.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
