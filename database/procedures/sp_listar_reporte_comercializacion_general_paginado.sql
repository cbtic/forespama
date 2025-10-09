
CREATE OR REPLACE FUNCTION public.sp_listar_reporte_comercializacion_general_paginado(p_canal character varying, p_empresa_compra character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_vendedor character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' distinct oc.id, 
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente, tm.denominacion canal,
	u."name" vendedor, 
	oc.numero_orden_compra pedido, to_char(oc.fecha_orden_compra,''dd-mm-yyyy'') fecha_orden_compra,
	(select coalesce(sum(spd.cantidad), 0) cantidad from salida_productos sp 
	inner join salida_producto_detalles spd on spd.id_salida_productos = sp.id 
	where sp.id_orden_compra = oc.id
	and sp.tipo_devolucion = ''3''
	and sp.estado = ''1'') cantidad_despacho,
	oc.numero_orden_compra pedido, to_char(oc.fecha_orden_compra,''dd-mm-yyyy'') fecha_orden_compra,
	(select coalesce(sum(sp.total_compra), 0) cantidad from salida_productos sp 
	where sp.id_orden_compra = oc.id
	and sp.tipo_devolucion = ''3''
	and sp.estado = ''1'') total_despacho ';

	v_tabla=' from orden_compras oc 
	left join empresas e on oc.id_empresa_compra = e.id 
	left join users u on oc.id_vendedor = u.id
	left join tabla_maestras tm on oc.id_canal = tm.codigo::int and tm.tipo = ''98'' ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and oc.estado_pedido = ''1'' and oc.estado = ''1'' ';

	If p_canal<>'' Then
	 v_where:=v_where||' And oc.id_canal = '''||p_canal||''' ';
	End If;

	If p_empresa_compra<>'' Then
	 v_where:=v_where||' And oc.id_empresa_compra = '''||p_empresa_compra||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||' And oc.fecha_orden_compra >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||' And oc.fecha_orden_compra  <= '''||p_fecha_fin||''' ';
	End If;

	If p_vendedor<>'' Then
	 v_where:=v_where||' And oc.id_vendedor = '''||p_vendedor||''' ';
	End If;	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By oc.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
