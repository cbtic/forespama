-- DROP FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_anual_paginado(varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_anual_paginado(p_placa character varying, p_ruc character varying, p_anio character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
--v_perfil varchar;

Begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos = ' to_char(ivt.fecha_ingreso, ''TMMonth'') mes, 
	extract(MONTH FROM ivt.fecha_ingreso) mes_numero, 
	sum(ivttm.cantidad) as total_trozas, 
	round(sum(ivtc.volumen_m3)::numeric, 2) as total_m3,
	round(sum(ivtc.volumen_pies)::numeric, 2) as total_pies,
	round(sum(ivtc.precio_total)::numeric, 2) as total_precio_total';

	v_tabla = ' from ingreso_vehiculo_troncos ivt
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm ON ivttm.id_ingreso_vehiculo_troncos = ivt.id and ivttm.estado = ''1''
	left join empresas e on ivt.id_empresa_proveedor = e.id
	left join vehiculos v on ivt.id_vehiculos=v.id
	left join (select id_ingreso_vehiculo_tronco_tipo_maderas, sum(volumen_m3) as volumen_m3, sum(volumen_pies) as volumen_pies, sum(precio_total) as precio_total
	from ingreso_vehiculo_tronco_cubicajes
	group by id_ingreso_vehiculo_tronco_tipo_maderas) ivtc on ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id ';

	v_where = ' where 1=1 ';
	
	If p_placa<>'' Then
	 v_where:=v_where||'And v.placa = '''||p_placa||''' ';
	End If;

	If p_ruc<>'' Then
	 v_where:=v_where||'And e.ruc = '''||p_ruc||''' ';
	End If;

	If p_anio<>'' Then
	 v_where:=v_where||'And to_char(ivt.fecha_ingreso, ''YYYY'') = '''||p_anio||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' group by mes, mes_numero Order By mes_numero asc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' group by mes, mes_numero Order By mes_numero asc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
