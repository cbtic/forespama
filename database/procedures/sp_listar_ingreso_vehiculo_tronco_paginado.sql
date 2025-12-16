-- DROP FUNCTION public.sp_listar_ingreso_vehiculo_tronco_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_vehiculo_tronco_paginado(p_placa character varying, p_ruc character varying, p_anio character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ivt.id, ivttm.id id_ingreso_vehiculo_tronco_tipo_maderas, ivt.fecha_ingreso, 
	case when ivt.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = ivt.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = ivt.id_empresa_transportista) 
	end razon_social,
	case when ivt.id_tipo_cliente = 1 then 
	(select p.numero_documento from personas p
	where p.id = ivt.id_persona)
	else (select e2.ruc from empresas e2 
	where e2.id = ivt.id_empresa_transportista) 
	end ruc,
	v.placa, v.ejes, p.numero_documento,
	p.apellido_paterno||'' ''||p.apellido_materno||'' ''||p.nombres conductor,
	tm.denominacion tipo_madera, ivttm.cantidad,
	(select 1 from ingreso_vehiculo_tronco_imagenes ivti where ivti.id_ingreso_vehiculo_troncos = ivt.id limit 1) tiene_imagen ';

	v_tabla=' from ingreso_vehiculo_troncos ivt
	inner join vehiculos v on ivt.id_vehiculos=v.id
	inner join conductores c on ivt.id_conductores=c.id
	inner join personas p on c.id_personas=p.id
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id=ivttm.id_ingreso_vehiculo_troncos and ivttm.estado=''1''
	inner join tabla_maestras tm on ivttm.id_tipo_maderas=tm.codigo::int and tm.tipo=''42'' ';

	v_where = ' where 1=1 and ivt.estado_ingreso =''1'' ';
	
	If p_placa<>'' Then
	 v_where:=v_where||'And v.placa = '''||p_placa||''' ';
	End If;

	If p_ruc <> '' Then
	  v_where := v_where || '
	  And (
	        (ivt.id_tipo_cliente = 1 AND
	         (select p2.numero_documento
	          from personas p2
	          where p2.id = ivt.id_persona) = ''' || p_ruc || ''')
	     OR
	        (ivt.id_tipo_cliente <> 1 AND
	         (select e2.ruc
	          from empresas e2
	          where e2.id = ivt.id_empresa_transportista) = ''' || p_ruc || ''')
	      ) ';
	End If;

	If p_anio<>'' Then
	 v_where:=v_where||'And to_char(ivt.fecha_ingreso, ''YYYY'') = '''||p_anio||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And ivt.fecha_ingreso  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And ivt.fecha_ingreso  <= '''||p_fecha_fin||''' ';
	End If;

	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ivt.fecha_ingreso Desc,id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';';
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ivt.fecha_ingreso Desc,id Desc;';
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
$function$
;
