CREATE OR REPLACE FUNCTION public.sp_listar_reporte_autorizacion_pedido_paginado(p_canal character varying, p_empresa_compra character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_orden_compra character varying, p_numero_orden_compra_cliente character varying, p_situacion character varying, p_id_vendedor character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' oc.id, tm2.denominacion canal,
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	oc.fecha_orden_compra, oc.numero_orden_compra, oc.estado, oc.cerrado id_cerrado, tm.denominacion cerrado,
	oc.id_almacen_salida, a.denominacion almacen_origen, oc.numero_orden_compra_cliente, u.name vendedor, tm3.denominacion proceso_pedido ';

	v_tabla=' from orden_compras oc 
	inner join tabla_maestras tm on oc.cerrado ::int = tm.codigo ::int and tm.tipo = ''52''
	left join tabla_maestras tm2 on oc.id_canal ::int = tm2.codigo ::int and tm2.tipo = ''98''
	left join autorizacion_orden_compras aoc on aoc.id_orden_compra = oc.id and aoc.id = (select id from autorizacion_orden_compras where id_orden_compra = oc.id order by id desc limit 1)
	left join tabla_maestras tm3 on aoc.id_proceso_pedido ::int = tm3.codigo ::int and tm3.tipo = ''109''
	left join almacenes a on oc.id_almacen_salida = a.id 
	left join users u on oc.id_vendedor = u.id ';
		
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and oc.estado_pedido = ''1'' ';
	
	If p_canal<>'' Then
	 v_where:=v_where||'And oc.id_canal = '''||p_canal||''' ';
	End If;
	
	If p_empresa_compra<>'' Then
	 v_where:=v_where||'And oc.id_empresa_compra  = '''||p_empresa_compra||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And oc.fecha_orden_compra  >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And oc.fecha_orden_compra  <= '''||p_fecha_fin||''' ';
	End If;

	If p_numero_orden_compra<>'' Then
	 v_where:=v_where||'And oc.id in (
				        select id 
				        from orden_compras 
				        where numero_orden_compra = '''||p_numero_orden_compra||'''
				        union
				        select id_orden_compra_matriz 
				        from orden_compras 
				        where numero_orden_compra = '''||p_numero_orden_compra||'''
				        and id_orden_compra_matriz is not null
				        union
				        select id 
				        from orden_compras 
				        where id_orden_compra_matriz = (
			            select id 
			            from orden_compras 
			            where numero_orden_compra = '''||p_numero_orden_compra||''' and id_tipo_documento = ''2'')) ';
	End If;
	
	If p_numero_orden_compra_cliente<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra_cliente = '''||p_numero_orden_compra_cliente||''' ';
	End If;
	
	If p_situacion<>'' Then
	 v_where:=v_where||'And oc.cerrado = '''||p_situacion||''' ';
	End If;
	
	If p_id_vendedor<>'' Then
	 v_where:=v_where||'And oc.id_vendedor = '''||p_id_vendedor||''' ';
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
