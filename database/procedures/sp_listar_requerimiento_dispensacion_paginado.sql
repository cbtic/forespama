CREATE OR REPLACE FUNCTION public.sp_listar_requerimiento_dispensacion_paginado(p_tipo_documento character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_requerimiento_dispensacion character varying, p_almacen character varying, p_sede character varying, p_centro_costo character varying, p_persona_recibe character varying, p_situacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' rd.id, tm.denominacion tipo_documento, rd.fecha, rd.codigo, a.denominacion almacen, s.denominacion sede, cc.denominacion centro_costo, p.nombres || '' '' || p.apellido_paterno || '' '' || p.apellido_materno persona, rd.estado, rd.aprobado, rd.cerrado, u.name persona_genera, u2.name persona_aprueba, r.codigo codigo_requerimiento ';

	v_tabla=' from requerimiento_dispensaciones rd 
	left join tabla_maestras tm on rd.id_tipo_documento = tm.codigo::int and tm.tipo = ''59''
	left join almacenes a on rd.id_almacen = a.id 
	left join sedes s on rd.id_sede = s.id 
	left join centro_costos cc on rd.id_centro_costo = cc.id
	left join personas p on p.id= rd.id_persona
	left join users u on u.id= rd.id_usuario_inserta
	left join users u2 on u2.id= rd.id_usuario_aprueba
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
