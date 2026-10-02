CREATE OR REPLACE FUNCTION public.sp_listar_aliados_pama_solicitud_comisiones_paginado(p_numero_documento character varying, p_estado_pago character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_tiene_rol_37 boolean := false;
v_id_persona bigint;
v_id_aliado_pama bigint;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' cs.id,p.numero_documento, p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno nombres, cs.monto, cs.estado_solicitud id_estado_solicitud, tm.denominacion estado_solicitud, u."name" usuario_aprueba, cs.estado ';

	v_tabla=' from comision_solicitudes cs 
	inner join aliado_pamas ap on cs.id_aliado_pama = ap.id and ap.estado = ''1''
	inner join personas p on ap.id_persona = p.id and p.estado = ''1''
	inner join tabla_maestras tm on cs.estado_solicitud::int = tm.codigo ::int and tm.tipo = ''125''
	left join users u on cs.id_usuario_aprueba = u.id';
	
	v_where = ' Where 1=1 ';

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And p.numero_documento = '''||p_numero_documento||''' ';
	End If;

	If p_estado_pago<>'' Then
	 v_where:=v_where||'And cs.estado_solicitud = '''||p_estado_pago||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And cs.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cs.id LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By cs.id ;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
