CREATE OR REPLACE FUNCTION public.sp_listar_empaquetados_paginado(p_producto character varying, p_numero_empaquetado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' e.id, p.denominacion producto, e.fecha, e.codigo, u.name usuario, e.estado ';

	v_tabla=' from empaquetado e 
	inner join productos p on e.id_producto = p.id 
	inner join users u on e.id_usuario_inserta = u.id ';
	
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_producto<>'' Then
	 v_where:=v_where||'And e.id_producto  = '''||p_producto||''' ';
	End If;

	If p_numero_empaquetado<>'' Then
	 v_where:=v_where||'And e.codigo  = '''||p_numero_empaquetado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And e.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
