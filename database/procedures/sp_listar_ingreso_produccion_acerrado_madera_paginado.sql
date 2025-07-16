-- DROP FUNCTION public.sp_listar_ingreso_produccion_acerrado_madera_paginado(varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_produccion_acerrado_madera_paginado(p_fecha character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ipd.id, ipam.fecha_ingreso, e.ruc, e.razon_social, v.placa, tm.denominacion tipo_madera, ipd.cantidad_ingreso_tronco, ipd.estado ';

	v_tabla=' from ingreso_produccion_acerrado_madera_detalles ipd 
	inner join ingreso_produccion_acerrado_maderas ipam on ipd.id_ingreso_produccion_acerrado_maderas = ipam.id 
	inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivttm.id = ipd.id_ingreso_vehiculo_tronco_tipo_maderas 
	inner join ingreso_vehiculo_troncos ivt on ivttm.id_ingreso_vehiculo_troncos = ivt.id 
	inner join empresas e on e.id = ivt.id_empresa_proveedor 
	inner join vehiculos v on ivt.id_vehiculos = v.id
	inner join tabla_maestras tm on tm.codigo::int = ipd.id_tipo_madera and tm.tipo =''42'' ';
	
	v_where = ' Where 1=1 ';

	If p_fecha<>'' Then
	 v_where:=v_where||'And ipam.fecha_ingreso = '''||p_fecha||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ipd.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ipd.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ipd.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
