CREATE OR REPLACE FUNCTION public.sp_listar_empresa_paginado(p_tipo_empresa character varying, p_razon_social character varying, p_ruc character varying, p_agente_retenedor character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;23

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' e.id, e.ruc, e.nombre_comercial, e.razon_social, e.direccion, e.email, e.telefono, e.representante, e.cliente, e.proveedor, e.transporte, e.estado,
	concat_ws('' | '',
        case when e.cliente = ''1'' then ''CLIENTE'' end,
        case when e.proveedor = ''1'' then ''PROVEEDOR'' end,
        case when e.transporte = ''1'' then ''TRANSPORTE'' end) tipo_empresa,
	case 
		when e.agente_retenedor = ''1'' then ''SI''
		when e.agente_retenedor = ''0'' then ''NO''
		when e.agente_retenedor is null then ''SIN ASIGNAR''
	end agente_retenedor ';

	v_tabla='from empresas e ';
	
	v_where = ' Where 1=1  ';
	
	If p_ruc<>'' Then
	 v_where:=v_where||'And e.ruc ilike ''%'||p_ruc||'%'' ';
	End If;

	If p_tipo_empresa<>'' Then
		If p_tipo_empresa = '1' then
			v_where:=v_where||'And e.cliente = ''1'' ';
		End If;
		if p_tipo_empresa = '2' then
			v_where:=v_where||'And e.proveedor = ''1'' ';
		End If;
		if p_tipo_empresa = '3' then
			v_where:=v_where||'And e.transporte = ''1'' ';
		End If;
	End If;
	
	If p_agente_retenedor<>'' Then
		if p_agente_retenedor<>'2' Then
	 		v_where:=v_where||'And e.agente_retenedor = '''||p_agente_retenedor||''' ';
		End If;
		If p_agente_retenedor='2' Then
	 		v_where:=v_where||'And e.agente_retenedor is null ';
		End If;
	End If;

	If p_razon_social<>'' Then
	 v_where:=v_where||'And e.razon_social ilike ''%'||p_razon_social||'%'' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And e.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By e.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
