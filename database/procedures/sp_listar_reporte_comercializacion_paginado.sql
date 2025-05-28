-- DROP FUNCTION public.sp_listar_reporte_comercializacion_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_reporte_comercializacion_paginado(p_empresa_compra character varying, p_fecha_desde character varying, p_fecha_hasta character varying, p_numero_orden_compra_cliente character varying, p_situacion character varying, p_codigo_producto character varying, p_producto character varying, p_vendedor character varying, p_estado_pedido character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_id_rol integer;

begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' distinct oc.id, case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	oc.numero_orden_compra_cliente, oc.numero_orden_compra pedido, to_char(oc.fecha_orden_compra,''dd-mm-yyyy'') fecha_orden_compra, to_char(oc.fecha_vencimiento,''dd-mm-yyyy'') fecha_vencimiento, p.codigo, ep.codigo_empresa, 
	p.denominacion producto, ocd.precio, ocd.cantidad_requerida, coalesce(ocd.cantidad_despacho, 0) cantidad_despacho, coalesce((ocd.cantidad_requerida - ocd.cantidad_despacho), 0) cantidad_cancelada, ocd.cerrado, u."name" vendedor, tm.denominacion estado_pedido ';

	v_tabla=' from orden_compras oc 
	left join empresas e on oc.id_empresa_compra = e.id 
	left join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra and ocd.estado = ''1''
	left join tienda_detalle_orden_compras tdoc on tdoc.id_orden_compra = oc.id and tdoc.id_producto = ocd.id_producto 
	--left join tiendas t on tdoc.id_tienda = t.id 
	left join users u on oc.id_vendedor = u.id
	left join productos p on ocd.id_producto = p.id
	left join equivalencia_productos ep on ep.codigo_producto = p.codigo 
	inner join tabla_maestras tm on oc.estado_pedido::int = tm.codigo::int and tm.tipo = ''77'' ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' ';

	If p_empresa_compra<>'' Then
	 v_where:=v_where||'And oc.id_empresa_compra  = '''||p_empresa_compra||''' ';
	End If;

	If p_fecha_desde<>'' Then
	 v_where:=v_where||'And oc.fecha_orden_compra >= '''||p_fecha_desde||''' ';
	End If;

	If p_fecha_hasta<>'' Then
	 v_where:=v_where||'And oc.fecha_orden_compra <= '''||p_fecha_hasta||''' ';
	End If;	

	If p_numero_orden_compra_cliente<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra_cliente  = '''||p_numero_orden_compra_cliente||''' ';
	End If;

	If p_situacion<>'' Then
	 v_where:=v_where||'And oc.cerrado = '''||p_situacion||''' ';
	End If;

	If p_codigo_producto<>'' Then
	 v_where:=v_where||'And p.codigo = '''||p_codigo_producto||''' ';
	End If;

	If p_producto<>'' Then
	 v_where:=v_where||'And ocd.id_producto = '''||p_producto||''' ';
	End If;
	
	If p_vendedor<>'' Then
	 v_where:=v_where||'And oc.id_vendedor = '''||p_vendedor||''' ';
	End If;

	If p_estado_pedido<>'' Then
	 v_where:=v_where||'And oc.estado_pedido = '''||p_estado_pedido||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And oc.estado = '''||p_estado||''' ';
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
