CREATE OR REPLACE FUNCTION public.sp_listar_guia_interna_paginado(p_tipo_documento character varying, p_fecha_emision character varying, p_numero_guia character varying, p_numero_documento character varying, p_empresa_destino character varying, p_placa character varying, p_empresa_trasporte character varying, p_origen character varying, p_destino character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' gi.id, gi.fecha_emision, gi.punto_partida, gi.punto_llegada, gi.fecha_traslado, gi.costo_minimo, e.razon_social destinatario, gi.ruc_destinatario, m.denominiacion marca, gi.placa, gi.constancia_inscripcion, gi.licencia_conducir, e2.razon_social id_transporte, gi.ruc_empresa_transporte ruc_transporte, tm1.denominacion tipo_documento, gi.numero_documento, tm2.denominacion motivo_traslado, gi.estado ';

	v_tabla=' from guia_internas gi 
	inner join empresas e on gi.id_destinatario = e.id 
	left join marcas m on gi.marca::int = m.id
	left join empresas e2 on gi.id_empresa_transporte = e2.id 
	LEFT JOIN 
	    tabla_maestras tm1 
	    ON (gi.id_tipo_documento = 1 AND gi.id_tipo_documento ::int = tm1.codigo::int AND tm1.tipo = ''48'')
	    OR (gi.id_tipo_documento = 2 AND gi.id_tipo_documento ::int = tm1.codigo::int AND tm1.tipo = ''49'')
	inner join tabla_maestras tm2 on gi.id_motivo_traslado ::int = tm2.codigo::int and tm2.tipo = ''63'' ';
	
	v_where = ' Where 1=1 '; 

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And gi.id_tipo_documento =  '''||p_tipo_documento||''' ';
	End If;

	If p_fecha_emision<>'' Then
	 v_where:=v_where||'And gi.fecha_emision =  '''||p_fecha_emision||''' ';
	End If;

	If p_numero_guia<>'' Then
	 v_where:=v_where||'And gi.id =  '''||p_numero_guia||''' ';
	End If;

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And gi.numero_documento =  '''||p_numero_documento||''' ';
	End If;

	If p_empresa_destino<>'' Then
	 v_where:=v_where||'And gi.numero_documento =  '''||p_empresa_destino||''' ';
	End If;

	If p_placa<>'' Then
	 v_where:=v_where||'And gi.numero_documento =  '''||p_placa||''' ';
	End If;

	If p_empresa_trasporte<>'' Then
	 v_where:=v_where||'And gi.numero_documento =  '''||p_empresa_trasporte||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And gi.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By gi.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By gi.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
