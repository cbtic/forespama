CREATE OR REPLACE FUNCTION public.sp_listar_descanso_paginado(p_fecha_inicio character varying, p_fecha_fin character varying, p_situacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_id_rol integer;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' dd.id, dd.id_descanso, p.denominacion producto, dd.cantidad, d.fecha_ingreso_descanso, dd.fecha_salida_descanso, tm.denominacion situacion, dd.estado ';

	v_tabla=' from descanso_detalles dd 
	inner join descansos d on dd.id_descanso = d.id
	inner join productos p on dd.id_producto = p.id 
	inner join tabla_maestras tm on dd.estado_descanso::int = tm.codigo::int and tm.tipo = ''119'' ';
		
	v_where = ' Where 1=1 ';
	
	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And d.fecha_ingreso_descanso  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And d.fecha_ingreso_descanso  <= '''||p_fecha_fin||''' ';
	End If;
	
	If p_situacion<>'' Then
	 v_where:=v_where||'And dd.estado_descanso = '''||p_situacion||''' ';
	End If;
		
	If p_estado<>'' Then
	 v_where:=v_where||'And dd.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dd.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By dd.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
