CREATE OR REPLACE FUNCTION public.sp_listar_dispensacion_paginado(p_tipo_documento character varying, p_fecha character varying, p_numero_dispensacion character varying, p_situacion character varying, p_almacen character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' d.id, tm.denominacion tipo_documento, d.fecha, d.codigo numero_dispensacion, d.estado, a.denominacion almacen, at.denominacion area_trabajo, ut.denominacion unidad_trabajo  ';

	v_tabla=' from dispensaciones d
	inner join tabla_maestras tm on d.id_tipo_documento ::int = tm.codigo ::int and tm.tipo=''53''
	--inner join tabla_maestras tm2 on oc.cerrado ::int = tm2.codigo ::int and tm2.tipo=''52''
	left join almacenes a on d.id_almacen = a.id
	inner join area_trabajo at on d.id_area_trabajo = at.id
	inner join unidad_trabajo ut on d.id_unidad_trabajo = ut.id';
	
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And d.id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And d.fecha  = '''||p_fecha||''' ';
	End If;

	If p_numero_dispensacion<>'' Then
	 v_where:=v_where||'And d.codigo = '''||p_numero_dispensacion||''' ';
	End If;

	/*If p_situacion<>'' Then
	 v_where:=v_where||'And oc.cerrado = '''||p_situacion||''' ';
	End If;*/

	If p_almacen<>'' Then
	 v_where:=v_where||'And d.id_almacen = '''||p_almacen||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And d.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By d.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By d.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
