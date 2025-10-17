-- DROP FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_paginado(varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_vehiculo_tronco_reporte_paginado(p_fecha_desde character varying, p_fecha_hasta character varying, p_tipo_empresa character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' fecha_ingreso,dia_semana,case when id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = R.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = R.id_empresa_transportista) 
	end razon_social,
	case when id_tipo_cliente = 1 then 
	(select p.numero_documento from personas p
	where p.id = R.id_persona)
	else (select e2.ruc from empresas e2 
	where e2.id = R.id_empresa_transportista) 
	end ruc,sum(cantidad)cantidad,sum(volumen_total_m3)volumen_total_m3,sum(volumen_total_pies)volumen_total_pies,sum(precio_total)precio_total,
	case when sum(promedio) > 0 then (sum(promedio)/sum((case when promedio > 0 then 1 else 0 end))) else 0 end promedio, tipo_pago, tipo_empresa ';

	v_tabla=' from (
	select ivt.id_empresa_proveedor id_empresa,ivt.id,ivttm.id id_ingreso_vehiculo_tronco_tipo_maderas,to_char(ivt.fecha_ingreso,''dd-mm-yyyy'') fecha_ingreso,TO_CHAR(ivt.fecha_ingreso, ''Day'') dia_semana, 
	ivttm.cantidad,tmep.denominacion estado_pago, 
	coalesce((select sum(volumen_total_m3) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_m3,
	coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)volumen_total_pies,
	coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where id_ingreso_vehiculo_tronco_tipo_maderas=ivttm.id),0)precio_total,
	coalesce(coalesce((select sum(precio_total) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0) /
	nullif(coalesce((select sum(volumen_total_pies) from ingreso_vehiculo_tronco_cubicajes ivtc where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id), 0), 0),0) promedio,
	(select tm2.denominacion
  	from empresa_cubicajes ec
  	inner join tabla_maestras tm2 on ec.id_tipo_pago::int = tm2.codigo::int and tm2.tipo = ''80''
  	where ec.id_empresa = ivt.id_empresa_proveedor 
    and ec.estado = ''1''
    and (ec.id_tipo_empresa = 1 OR (ec.id_tipo_empresa = 2 AND ec.id_conductor = ivt.id_conductores))) tipo_pago,
	(select ec.id_tipo_empresa 
	from empresa_cubicajes ec
	where ec.id_empresa = ivt.id_empresa_proveedor 
	and ec.estado = ''1''
	and (ec.id_tipo_empresa = 1 OR (ec.id_tipo_empresa = 2 AND ec.id_conductor = ivt.id_conductores))) tipo_empresa, ivt.id_tipo_cliente, ivt.id_persona, ivt.id_empresa_transportista
	from ingreso_vehiculo_troncos ivt
	inner join vehiculos v on ivt.id_vehiculos=v.id
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id=ivttm.id_ingreso_vehiculo_troncos and ivttm.estado =''1''
	inner join tabla_maestras tm on ivttm.id_tipo_maderas=tm.codigo::int and tm.tipo=''42''
	inner join tabla_maestras tmep on ivttm.id_estado_pago=tmep.codigo::int and tmep.tipo=''66''
	where 1=1 '; 
	
	If p_fecha_desde<>'' Then
	 v_tabla:=v_tabla||'And ivt.fecha_ingreso >= '''||p_fecha_desde||''' ';
	End If;

	If p_fecha_hasta<>'' Then
	 v_tabla:=v_tabla||'And ivt.fecha_ingreso <= '''||p_fecha_hasta||''' ';
	End If;	

	If p_tipo_empresa<>'' Then
	 v_tabla:=v_tabla||'And (select ec.id_tipo_empresa 
			from empresa_cubicajes ec
			where ec.id_empresa = ivt.id_empresa_proveedor 
			and ec.estado = ''1''
			and (ec.id_tipo_empresa = 1 OR (ec.id_tipo_empresa = 2 AND ec.id_conductor = ivt.id_conductores))) = '''||p_tipo_empresa||''' ';
	End If;

	v_tabla:=v_tabla||' )R
	group by R.id_tipo_cliente, R.id_persona, R.id_empresa_transportista, fecha_ingreso,dia_semana, tipo_pago, tipo_empresa  ';

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
