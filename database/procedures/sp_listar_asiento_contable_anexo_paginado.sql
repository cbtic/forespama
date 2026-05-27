CREATE OR REPLACE FUNCTION public.sp_listar_asiento_contable_anexo_paginado(p_numero_documento character varying, p_razon_social character varying, p_tipo_anexo character varying, p_migrado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' aca.id, aca.tipo_anexo id_tipo_anexo, sta.descripcion tipo_anexo, aca.codigo_anexo, aca.ruc, aca.razon_social, aca.direccion, tm.denominacion tipo_documento, aca.nro_documento, tm.denominacion tipo_personal,
	aca.apellido_paterno, aca.apellido_materno, aca.primer_nombre, aca.segundo_nombre, aca.nacionalidad, tm2.denominacion sexo, aca.flag_migrado, aca.fecha_migrado ';

	v_tabla=' from asiento_contable_anexos aca 
	inner join starsoft_tipo_anexos sta on aca.tipo_anexo = sta.codigo_tipo_anexo 
	left join tabla_maestras tm on (case when aca.tipo_documento::int = 6 then 5 else aca.tipo_documento::int end) = tm.codigo::int and tm.tipo = ''9''
	left join tabla_maestras tm2 on aca.sexo::int = tm2.codigo::int and tm2.tipo = ''2'' ';
	
	v_where = ' Where 1=1 ';

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And aca.nro_documento = '''||p_numero_documento||''' ';
	End If;

	If p_razon_social<>'' Then
	 v_where:=v_where||'And aca.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;

	If p_tipo_anexo<>'' Then
	 v_where:=v_where||'And aca.tipo_anexo = '''||p_tipo_anexo||''' ';
	End If;

	If p_migrado<>'' Then
	 v_where:=v_where||'And aca.flag_migrado = '''||p_migrado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And aca.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By aca.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By aca.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
