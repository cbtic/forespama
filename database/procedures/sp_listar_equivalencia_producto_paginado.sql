CREATE OR REPLACE FUNCTION public.sp_listar_equivalencia_producto_paginado(p_producto character varying, p_codigo_producto character varying, p_denominacion_producto character varying, p_empresa character varying, p_codigo_empresa character varying, p_denominacion_empresa character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ep.id, p.id id_producto, p.denominacion producto, ep.codigo_producto, ep.descripcion_producto, e.id id_empresa, e.razon_social empresa, ep.codigo_empresa, ep.descripcion_empresa,ep.estado ';

	v_tabla=' from equivalencia_productos ep 
	inner join productos p on ep.id_producto = p.id 
	inner join empresas e on ep.id_empresa = e.id ';
	
	v_where = ' Where 1=1 ';

	If p_producto<>'' Then
	 v_where:=v_where||'And ep.id_producto = '''||p_producto||''' ';
	End If;

	If p_codigo_producto<>'' Then
	 v_where:=v_where||'And ep.codigo_producto  = '''||p_codigo_producto||''' ';
	End If;

	If p_denominacion_producto<>'' Then
	 v_where:=v_where||'And ep.descripcion_producto ilike ''%'||p_denominacion_producto||'%'' ';
	End If;

	If p_empresa<>'' Then
	 v_where:=v_where||'And ep.id_empresa  = '''||p_empresa||''' ';
	End If;

	If p_codigo_empresa<>'' Then
	 v_where:=v_where||'And ep.codigo_empresa = '''||p_codigo_empresa||''' ';
	End If;

	If p_denominacion_empresa<>'' Then
	 v_where:=v_where||'And ep.descripcion_empresa ilike ''%'||p_denominacion_empresa||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ep.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ep.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ep.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
