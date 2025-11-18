CREATE OR REPLACE FUNCTION public.sp_listar_usuario_descuento_paginado(p_usuario character varying, p_descuento character varying, p_tipo_usuario character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ud.id, u."name" usuario, tm.denominacion descuento, tm2.denominacion tipo_usuario, ud.estado ';

	v_tabla=' from usuario_descuentos ud
	inner join users u on ud.id_usuario = u.id 
	inner join tabla_maestras tm on tm.codigo::int = ud.id_descuento and tm.tipo = ''55'' 
	inner join tabla_maestras tm2 on tm2.codigo::int = ud.id_tipo_usuario and tm2.tipo = ''99'' ';
	
	v_where = ' Where 1=1 ';

	If p_usuario<>'' Then
	 v_where:=v_where||'And ud.id_usuario = '''||p_usuario||''' ';
	End If;

	If p_descuento<>'' Then
	 v_where:=v_where||'And ud.id_descuento = '''||p_descuento||''' ';
	End If;

	If p_tipo_usuario<>'' Then
	 v_where:=v_where||'And ud.id_tipo_usuario = '''||p_tipo_usuario||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ud.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ud.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ud.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
