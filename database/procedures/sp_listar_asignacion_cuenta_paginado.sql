CREATE OR REPLACE FUNCTION public.sp_listar_asignacion_cuenta_paginado(p_cuenta character varying, p_tipo character varying, p_centro_costo character varying, p_medio_pago character varying, p_origen character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ac.id, cc2.cuenta cuenta, cc2.denominacion, tc.denominacion tipo_cuenta, 
	cc.codigo centro_costo, 
	mp.codigo || ''-'' || mp.denominacion medio_pago, ss.codigo||''-''||ss.descripcion origen, ac.estado, tm.denominacion moneda ';

	v_tabla=' from asignacion_cuentas ac 
	left join cuenta_contables cc2 on cc2.id = ac.id_plan_contable 
	left join tabla_maestras tc on tc.tipo = ''124'' and tc.codigo::int = ac.id_tipo_cuenta::int 
	left join centro_costos cc on cc.id = ac.id_centro_costo 
	left join tabla_maestras mp on mp.tipo = ''108'' and mp.codigo::int = ac.id_medio_pago::int
	left join starsoft_subdiarios ss on ss.id = ac.id_origen
	left join tabla_maestras tm on tm.tipo = ''1'' and tm.codigo::int = ac.id_moneda::int ';
	
	v_where = ' Where 1=1 ';

	If p_cuenta<>'' Then
	 v_where:=v_where||'And ac.id_plan_contable =  '''||p_cuenta||''' ';
	End If;

	If p_tipo<>'' Then
	 v_where:=v_where||'And ac.id_tipo_cuenta =  '''||p_tipo||''' ';
	End If;

	If p_centro_costo<>'' Then
	 v_where:=v_where||'And ac.id_centro_costo =  '''||p_centro_costo||''' ';
	End If;

	If p_medio_pago<>'' Then
	 v_where:=v_where||'And ac.id_medio_pago =  '''||p_medio_pago||''' ';
	End If;

	If p_origen<>'' Then
	 v_where:=v_where||'And ac.id_origen =  '''||p_origen||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ac.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ac.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ac.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
