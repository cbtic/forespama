DROP FUNCTION public.sp_listar_dispensacion_reporte_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_dispensacion_reporte_paginado(p_tipo_documento character varying, p_fecha_desde character varying, p_fecha_hasta character varying, p_numero_dispensacion character varying, p_almacen character varying, p_sede character varying, p_centro_costo character varying, p_persona_recibe character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' dd.id, tm.denominacion tipo_movimiento, s.denominacion sede, cc.denominacion centro_costo, to_char(d.fecha, ''dd-mm-yyyy'') fecha, d.codigo codigo_dispensacion, a.denominacion almacen_salida, pe.nombres ||'' ''|| pe.apellido_paterno ||'' ''|| pe.apellido_materno usuario_recibe,
	p.codigo codigo_producto, p.denominacion producto, dd.cantidad ';

	v_tabla=' from dispensaciones d
	inner join dispensacion_detalles dd on dd.id_dispensacion = d.id 
	inner join productos p on dd.id_producto = p.id 
	left join sedes s on d.id_sede = s.id
	left join centro_costos cc on d.id_centro_costo = cc.id
	left join almacenes a on d.id_almacen = a.id 
	left join personas pe on d.id_usuario_recibe = pe.id
	inner join tabla_maestras tm on d.id_tipo_documento = tm.codigo::int and tm.tipo = ''53'' ';
		
	v_where = ' Where 1=1 and dd.estado = ''1'' ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And d.id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_fecha_desde<>'' Then
	 v_where:=v_where||'And d.fecha >= '''||p_fecha_desde||''' ';
	End If;

	If p_fecha_hasta<>'' Then
	 v_where:=v_where||'And d.fecha <= '''||p_fecha_hasta||''' ';
	End If;	

	If p_numero_dispensacion<>'' Then
	 v_where:=v_where||'And d.codigo = '''||p_numero_dispensacion||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where:=v_where||'And d.id_almacen = '''||p_almacen||''' ';
	End If;

	If p_sede<>'' Then
	 v_where:=v_where||'And d.id_sede = '''||p_sede||''' ';
	End If;

	If p_centro_costo<>'' Then
	 v_where:=v_where||'And d.id_centro_costo = '''||p_centro_costo||''' ';
	End If;

	If p_persona_recibe<>'' Then
	 v_where:=v_where||'And d.id_usuario_recibe = '''||p_persona_recibe||''' ';
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
