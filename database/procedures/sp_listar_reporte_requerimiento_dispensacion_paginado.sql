CREATE OR REPLACE FUNCTION public.sp_listar_reporte_requerimiento_dispensacion_paginado(p_tipo_documento character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_requerimiento_dispensacion character varying, p_almacen character varying, p_sede character varying, p_centro_costo character varying, p_persona_recibe character varying, p_situacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' rdd.id, tm.denominacion tipo_documento, a.denominacion almacen, rd.fecha, rd.codigo, a.denominacion sede, cc.denominacion centro_costo, p2.nombres ||'' ''|| p2.apellido_paterno ||'' ''|| p2.apellido_materno nombres, 
	rd.aprobado, u.name usuario_aprueba, tm2.denominacion cerrado, r.codigo codigo_requerimiento, p.denominacion producto, rdd.cantidad, rdd.estado ';

	v_tabla=' from requerimiento_dispensacion_detalles rdd 
	left join requerimiento_dispensaciones rd on rdd.id_requerimiento_dispensacion = rd.id 
	left join productos p on rdd.id_producto = p.id 
	left join tabla_maestras tm on rd.id_tipo_documento = tm.codigo::int and tm.tipo = ''59''
	left join almacenes a on rd.id_almacen = a.id 
	left join sedes s on rd.id_sede = s.id 
	left join centro_costos cc on rd.id_centro_costo = cc.id 
	left join personas p2 on rd.id_persona = p2.id
	left join users u on rd.id_usuario_aprueba = u.id 
	left join tabla_maestras tm2 on rd.cerrado::int  = tm2.codigo::int and tm2.tipo = ''52''
	left join requerimientos r on rd.id_requerimiento = r.id ';
	
	v_where = ' Where 1=1 ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And rd.id_tipo_documento = '''||p_tipo_documento||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And rd.fecha >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And rd.fecha <= '''||p_fecha_fin||''' ';
	End If;

	If p_numero_requerimiento_dispensacion<>'' Then
	 v_where:=v_where||'And rd.codigo = '''||p_numero_requerimiento_dispensacion||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where:=v_where||'And rd.id_almacen = '''||p_almacen||''' ';
	End If;

	If p_sede<>'' Then
	 v_where:=v_where||'And rd.id_sede = '''||p_sede||''' ';
	End If;

	If p_centro_costo<>'' Then
	 v_where:=v_where||'And rd.id_centro_costo = '''||p_centro_costo||''' ';
	End If;

	If p_persona_recibe<>'' Then
	 v_where:=v_where||'And rd.id_persona = '''||p_persona_recibe||''' ';
	End If;

	If p_situacion<>'' Then
	 v_where:=v_where||'And rd.cerrado = '''||p_situacion||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And rd.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By rd.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By rd.id desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
