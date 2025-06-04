CREATE OR REPLACE FUNCTION public.sp_listar_reporte_comercializacion_tienda_pedido_paginado(p_empresa_compra character varying, p_fecha_desde character varying, p_fecha_hasta character varying, p_numero_orden_compra_cliente character varying, p_producto character varying, p_tienda character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' distinct oc.id, e.razon_social, oc.numero_orden_compra_cliente, oc.numero_orden_compra pedido, to_char(oc.fecha_orden_compra,''dd-mm-yyyy'') fecha_orden_compra, to_char(oc.fecha_vencimiento,''dd-mm-yyyy'') fecha_vencimiento, p.codigo, ep.codigo_empresa, 
	p.denominacion producto, ocd.precio, tdoc.cantidad , coalesce(ocd.cantidad_despacho, 0) cantidad_despacho, coalesce((ocd.cantidad_requerida - ocd.cantidad_despacho), 0) cantidad_cancelada, ocd.cerrado, u."name" vendedor, t.denominacion tienda ';

	v_tabla=' from orden_compras oc 
	left join empresas e on oc.id_empresa_compra = e.id 
	left join orden_compra_detalles ocd on oc.id = ocd.id_orden_compra 
	left join tienda_detalle_orden_compras tdoc on tdoc.id_orden_compra = oc.id and tdoc.id_producto = ocd.id_producto 
	left join tiendas t on tdoc.id_tienda = t.id 
	left join users u on oc.id_vendedor = u.id
	left join productos p on ocd.id_producto = p.id 
	left join equivalencia_productos ep on ep.codigo_producto = p.codigo ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and oc.id_empresa_compra in(''23'',''187'') and oc.estado_pedido =''1'' ';

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

	If p_producto<>'' Then
	 v_where:=v_where||'And ocd.id_producto = '''||p_producto||''' ';
	End If;

	If p_tienda<>'' Then
	 v_where:=v_where||'And tdoc.id_tienda = '''||p_tienda||''' ';
	End If;
	
	/*If p_tienda<>'' Then
	  v_where := v_where || ' AND EXISTS (
	    SELECT 1 FROM tienda_detalle_orden_compras tdoc_filtro
	    WHERE tdoc_filtro.id_orden_compra = oc.id
	    AND tdoc_filtro.id_tienda = ''' || p_tienda || '''
	  ) ';
	End If;*/

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