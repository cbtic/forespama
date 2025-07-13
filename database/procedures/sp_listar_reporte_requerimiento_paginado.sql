-- DROP FUNCTION public.sp_listar_reporte_requerimiento_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_reporte_requerimiento_paginado(p_tipo_documento character varying, p_fecha character varying, p_numero_requerimiento character varying, p_almacen character varying, p_situacion character varying, p_responsable_atencion character varying, p_estado_atencion character varying, p_tipo_requerimiento character varying, p_producto character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' rd.id, tm.denominacion tipo_documento, r.fecha, r.codigo numero_requerimiento, a.denominacion almacen_solicitante, u.name responsable_atencion, r.estado, p.denominacion producto, p.codigo, m.denominiacion marca, rd.cantidad,
	(select coalesce(sum(ocd.cantidad_requerida),0) from orden_compras oc
	inner join orden_compra_detalles ocd on ocd.id_orden_compra = oc.id 
	where oc.id_requerimiento = r.id and ocd.id_producto = rd.id_producto and oc.estado =''1'') cantidad_atendida,
	tm2.denominacion cerrado ';

	v_tabla=' from requerimiento_detalles rd 
	inner join requerimientos r on rd.id_requerimiento = r.id 
	inner join productos p on rd.id_producto = p.id 
	inner join tabla_maestras tm on r.id_tipo_documento::int = tm.codigo::int and tm.tipo = ''59''
	inner join tabla_maestras tm2 on rd.cerrado::int = tm2.codigo::int and tm2.tipo = ''52''
	inner join almacenes a on r.id_almacen_destino = a.id 
	inner join users u on r.responsable_atencion = u.id 
	left join marcas m on p.id_marca = m.id ';
		
	v_where = ' Where 1=1 and rd.estado = ''1'' ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And r.id_tipo_documento =  '''||p_tipo_documento||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And r.fecha =  '''||p_fecha||''' ';
	End If;

	If p_numero_requerimiento<>'' Then
	 v_where:=v_where||'And r.codigo =  '''||p_numero_requerimiento||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where:=v_where||'And r.id_almacen_destino =  '''||p_almacen||''' ';
	End If;

	If p_situacion<>'' Then
	 v_where:=v_where||'And r.cerrado =  '''||p_situacion||''' ';
	End If;

	If p_responsable_atencion<>'' Then
	 v_where:=v_where||'And r.responsable_atencion =  '''||p_responsable_atencion||''' ';
	End If;

	If p_estado_atencion<>'' Then
	 v_where:=v_where||'And r.estado_atencion =  '''||p_estado_atencion||''' ';
	End If;

	If p_tipo_requerimiento<>'' Then
	 v_where:=v_where||'And r.id_tipo_requerimiento =  '''||p_tipo_requerimiento||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And r.estado  = '''||p_estado||''' ';
	End If;
	
	If p_producto<>'' Then
	 v_where := v_where || 'AND EXISTS (
		SELECT 1 FROM requerimiento_detalles rd 
		WHERE rd.id_requerimiento = r.id 
		AND rd.id_producto = ''' || p_producto || ''') ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By r.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By r.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
