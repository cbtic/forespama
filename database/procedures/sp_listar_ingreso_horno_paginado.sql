CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_horno_paginado(p_fecha character varying, p_situacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ih.id, tm.denominacion horno, ih.fecha_encendido, ih.hora_encendido, ih.temperatura_inicio, ih.humedad_inicio, p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno operador_encendido, 
	ih.fecha_apagado, ih.hora_apagado, ih.humedad_apagado, p2.nombres ||'' ''|| p2.apellido_paterno ||'' ''|| p2.apellido_materno operador_apagado, ih.observacion, ih.total_ingreso, ih.estado ';

	v_tabla=' from ingreso_hornos ih 
	inner join  tabla_maestras tm on ih.id_numero_horno = tm.codigo::int and tm.tipo = ''83''
	left join personas p on ih.id_operador_inicio = p.id 
	left join personas p2 on ih.id_operador_apagado = p2.id ';
	
	v_where = ' Where 1=1 ';

	If p_fecha<>'' Then
	 v_where:=v_where||'And ih.fecha_encendido = '''||p_fecha||''' ';
	End If;

	If p_situacion<>'' Then
	 v_where:=v_where||'And ih.estado_ingreso_horno = '''||p_situacion||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ih.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ih.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ih.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
