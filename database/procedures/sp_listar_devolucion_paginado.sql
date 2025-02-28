CREATE OR REPLACE FUNCTION public.sp_listar_devolucion_paginado(p_empresa character varying, p_fecha character varying, p_numero_devolucion character varying, p_numero_orden_compra_cliente character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' sp.id, ''SALIDA'' tipo, sp.fecha_salida fecha_movimiento, tm.denominacion tipo_documento, tm2.denominacion unidad_origen, e.razon_social empresa, sp.codigo, sp.fecha_comprobante, sp.estado, sp.created_at, sp.cerrado, ''2'' id_tipo, sp.id_tipo_documento, sp.unidad_destino id_unidad_origen, a.denominacion almacen, sp.id_almacen_salida id_almacen, null id_proveedor, u.name usuario_recibe, oc.numero_orden_compra_cliente ';

	v_tabla=' FROM salida_productos sp 
	INNER JOIN tabla_maestras tm ON sp.id_tipo_documento = tm.codigo::int AND tm.tipo = ''49'' 
	inner join almacenes a on sp.id_almacen_salida = a.id 
	left join users u on sp.id_usuario_recibe = u.id 
	INNER JOIN tabla_maestras tm2 ON sp.unidad_destino::int = tm2.codigo::int AND tm2.tipo = ''50''
	inner join orden_compras oc on sp.id_orden_compra = oc.id
	inner join empresas e on sp.id_empresa_compra = e.id  ';
			
	v_where = ' Where 1=1 and sp.tipo_devolucion =''2'' ';

	If p_empresa<>'' Then
	 v_where:=v_where||'And sp.id_empresa_compra  = '''||p_empresa||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And sp.fecha_salida  = '''||p_fecha||''' ';
	End If;

	/*If p_numero_devolucion<>'' Then
	 v_where:=v_where||'And d.numero_devolucion = '''||p_numero_devolucion||''' ';
	End If;*/

	If p_numero_orden_compra_cliente<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra_cliente  = '''||p_numero_orden_compra_cliente||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sp.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sp.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
