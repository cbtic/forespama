CREATE OR REPLACE FUNCTION public.sp_listar_parametros_paginado(p_denominacion character varying, p_empresa character varying, p_anio character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' p.id, e.razon_social empresa, p.anio, p.nombre_acuerdo_comercial, p.porcentaje_valor, p.aplica_detalle, p.general_especifico, p.estado, tm. denominacion tipo ';

	v_tabla=' from parametros p 
	inner join empresas e on p.id_empresa = e.id 
	left join tabla_maestras tm on p.id_tipo ::int = tm.codigo::int and tm.tipo = ''72''';
	
	v_where = ' Where 1=1 ';

	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.nombre_acuerdo_comercial ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_empresa<>'' Then
	 v_where:=v_where||'And p.id_empresa  = '''||p_empresa||''' ';
	End If;

	If p_anio<>'' Then
	 v_where:=v_where||'And p.anio  = '''||p_anio||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And p.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
