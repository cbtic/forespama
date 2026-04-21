CREATE OR REPLACE FUNCTION public.sp_listar_reporte_productos_paginado(p_denominacion character varying, p_codigo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' p.id, p.denominacion, p.codigo, tm.denominacion unidad, tm2.denominacion categoria, tm3.denominacion sub_categoria, tm4.denominacion modelo, tm5.denominacion packet, tm6.denominacion medida, p.peso, p.estado ';

	v_tabla=' from productos p 
	left join tabla_maestras tm on p.id_unidad_producto = tm.codigo::int and tm.tipo = ''43''
	left join tabla_maestras tm2 ON p.id_categoria::int = tm2.codigo::int and tm2.tipo = ''102''
	left join tabla_maestras tm3 ON p.id_sub_categoria::int = tm3.codigo::int and tm3.tipo = ''105''
	left join tabla_maestras tm4 ON p.id_modelo::int = tm4.codigo::int and tm4.tipo = ''106''
	left join tabla_maestras tm5 ON p.id_packet::int = tm5.codigo::int and tm5.tipo = ''107''
	left join tabla_maestras tm6 ON p.id_medida::int = tm6.codigo::int and tm6.tipo = ''111'' ';
	
	v_where = ' Where 1=1 and p.bien_servicio = ''1'' and p.aprobado = ''2'' and p.id_tipo_origen_producto = ''2'' ';

	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And p.codigo =  '''||p_codigo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And p.estado = '''||p_estado||''' ';
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