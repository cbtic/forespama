CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_salida_secundario_paginado(p_tipo_documento character varying, p_empresa character varying, p_persona character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_ingreso_salida character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' iss.id, tm.denominacion tipo_documento,
	case
		when iss.id_tipo_cliente = ''1'' then (select p.apellido_paterno ||'' ''|| p.apellido_materno ||'' ''|| p.nombres proveedor from personas p where p.id = iss.id_persona and p.estado = ''1'')
		when iss.id_tipo_cliente = ''5'' then (select e.razon_social proveedor from empresas e where e.id = iss.id_empresa and e.estado = ''1'')
	end proveedor, iss.fecha_ingreso_salida, iss.numero_ingreso_salida, a.denominacion almacen, iss.estado ';

	v_tabla=' from ingreso_salida_secundarios iss 
	inner join tabla_maestras tm on iss.id_tipo_documento = tm.codigo::int and tm.tipo = ''53''
	inner join almacenes a on iss.id_almacen = a.id ';
	
	v_where = ' Where 1=1 ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And iss.id_tipo_documento = '''||p_tipo_documento||''' ';
	End If;

	If p_empresa<>'' Then
	 v_where:=v_where||'And iss.id_empresa = '''||p_empresa||''' ';
	End If;

	If p_persona<>'' Then
	 v_where:=v_where||'And iss.id_persona = '''||p_persona||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And iss.fecha_ingreso_salida > '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And iss.fecha_ingreso_salida < '''||p_fecha_fin||''' ';
	End If;

	If p_numero_ingreso_salida<>'' Then
	 v_where:=v_where||'And iss.numero_ingreso_salida = '''||p_numero_ingreso_salida||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And iss.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By iss.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By iss.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
