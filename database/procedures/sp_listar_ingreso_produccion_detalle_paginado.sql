-- DROP FUNCTION public.sp_listar_ingreso_produccion_detalle_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_ingreso_produccion_detalle_paginado(p_tipo_documento character varying, p_fecha character varying, p_numero_ingreso_produccion character varying, p_almacen_destino character varying, p_area character varying, p_unidad_trabajo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ip.id, tm.denominacion tipo_documento, ip.fecha, ip.codigo numero_ingreso_produccion, ip.estado, a.denominacion almacen_destino, u.name usuario_ingreso, at2.denominacion area_trabajo, ut.denominacion unidad_trabajo, p.codigo, p.denominacion producto, ipd.cantidad ';

	v_tabla=' from ingreso_produccion ip
	inner join tabla_maestras tm on ip.id_tipo_documento ::int = tm.codigo ::int and tm.tipo = ''53''
	left join almacenes a on ip.id_almacen_destino = a.id
	inner join users u on ip.id_usuario_inserta = u.id
	left join area_trabajo at2 on ip.id_area = at2.id 
	left join unidad_trabajo ut on ut.id = ip.id_unidad_trabajo
	inner join ingreso_produccion_detalles ipd on ip.id = ipd.id_ingreso_produccion 
	inner join productos p on ipd.id_producto = p.id ';
	
	v_where = ' Where 1=1 ';

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And ip.id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And ip.fecha  = '''||p_fecha||''' ';
	End If;

	If p_numero_ingreso_produccion<>'' Then
	 v_where:=v_where||'And ip.codigo = '''||p_numero_ingreso_produccion||''' ';
	End If;

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And ip.id_almacen_destino = '''||p_almacen_destino||''' ';
	End If;

	If p_area<>'' Then
	 v_where:=v_where||'And ip.id_area = '''||p_area||''' ';
	End If;
	
	If p_unidad_trabajo<>'' Then
	 v_where:=v_where||'And ip.id_unidad_trabajo = '''||p_unidad_trabajo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ip.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ip.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ip.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
