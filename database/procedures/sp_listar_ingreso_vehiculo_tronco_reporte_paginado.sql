CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_paginado(p_fecha_desde character varying, p_fecha_hasta character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

begin

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' ivt.id,ivttm.id id_ingreso_vehiculo_tronco_tipo_maderas,to_char(ivt.fecha_ingreso,''dd-mm-yyyy'') fecha_ingreso,TO_CHAR(ivt.fecha_ingreso, ''Day'') dia_semana, e.ruc,e.razon_social,
	ivttm.cantidad,tmep.denominacion estado_pago, 
	coalesce((select sum(volumen_total_m3) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_m3,
	coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_pies,
	coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)precio_total,
	coalesce(coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0) /
	nullif(coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0), 0),0) promedio ';

	v_tabla=' from ingreso_vehiculo_troncos ivt
	inner join empresas e on ivt.id_empresa_proveedor=e.id
	inner join vehiculos v on ivt.id_vehiculos=v.id
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id=ivttm.id_ingreso_vehiculo_troncos
	inner join tabla_maestras tm on ivttm.id_tipo_maderas=tm.codigo::int and tm.tipo=''42''
	inner join tabla_maestras tmep on ivttm.id_estado_pago=tmep.codigo::int and tmep.tipo=''66'' ';

	v_where = ' where 1=1  ';

	If p_fecha_desde<>'' Then
	 v_where:=v_where||'And ivt.fecha_ingreso >= '''||p_fecha_desde||''' ';
	End If;

	If p_fecha_hasta<>'' Then
	 v_where:=v_where||'And ivt.fecha_ingreso <= '''||p_fecha_hasta||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ivt.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ivt.id Desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;

