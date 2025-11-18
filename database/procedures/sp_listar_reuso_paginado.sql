CREATE OR REPLACE FUNCTION public.sp_listar_reuso_paginado(p_fecha character varying, p_codigo character varying, p_almacen_destino character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' r.id, r.id_tipo_documento, r.codigo, r.fecha, a.denominacion almacen_destino, r.estado ';

	v_tabla=' from reusos r 
	inner join almacenes a on r.id_almacen_destino = a.id  ';
	
	v_where = ' Where 1=1 ';

	If p_fecha<>'' Then
	 v_where:=v_where||'And r.fecha = '''||p_fecha||''' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And r.codigo  = '''||p_codigo||''' ';
	End If;

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And r.id_almacen_destino = '''||p_almacen_destino|| ''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And r.estado = '''||p_estado|| ''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By r.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By r.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
