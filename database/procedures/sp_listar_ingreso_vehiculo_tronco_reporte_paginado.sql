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

	v_campos=' fecha_ingreso,dia_semana,ruc,razon_social,sum(cantidad)cantidad,sum(volumen_total_m3)volumen_total_m3,sum(volumen_total_pies)volumen_total_pies,sum(precio_total)precio_total,
	case when sum(promedio) > 0 then (sum(promedio)/sum((case when promedio > 0 then 1 else 0 end))) else 0 end promedio ';

	v_tabla=' from (
	select ivt.id_empresa_proveedor id_empresa,ivt.id,ivttm.id id_ingreso_vehiculo_tronco_tipo_maderas,to_char(ivt.fecha_ingreso,''dd-mm-yyyy'') fecha_ingreso,TO_CHAR(ivt.fecha_ingreso, ''Day'') dia_semana, 
	ivttm.cantidad,tmep.denominacion estado_pago, 
	coalesce((select sum(volumen_total_m3) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_m3,
	coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_pies,
	coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)precio_total,
	coalesce(coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0) /
	nullif(coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0), 0),0) promedio 
	from ingreso_vehiculo_troncos ivt
	inner join vehiculos v on ivt.id_vehiculos=v.id
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id=ivttm.id_ingreso_vehiculo_troncos
	inner join tabla_maestras tm on ivttm.id_tipo_maderas=tm.codigo::int and tm.tipo=''42''
	inner join tabla_maestras tmep on ivttm.id_estado_pago=tmep.codigo::int and tmep.tipo=''66''
	where 1=1 
	'; 
	
	If p_fecha_desde<>'' Then
	 v_tabla:=v_tabla||'And ivt.fecha_ingreso >= '''||p_fecha_desde||''' ';
	End If;

	If p_fecha_hasta<>'' Then
	 v_tabla:=v_tabla||'And ivt.fecha_ingreso <= '''||p_fecha_hasta||''' ';
	End If;	

v_tabla:=v_tabla||' )R
inner join empresas e on R.id_empresa=e.id
group by e.id,fecha_ingreso,dia_semana ';

	v_where = ' ';
	
	EXECUTE ('SELECT count(1) from( select '||v_campos||v_tabla||v_where||')S') INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By fecha_ingreso Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By fecha_ingreso Desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
