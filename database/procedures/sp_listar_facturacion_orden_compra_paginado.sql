-- DROP FUNCTION public.sp_listar_facturacion_orden_compra_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_facturacion_orden_compra_paginado(p_empresa_compra character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_orden_compra character varying, p_numero_orden_compra_cliente character varying, p_situacion character varying, p_estado character varying, p_id_vendedor character varying, p_estado_pedido character varying, p_facturado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' oc.id,
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	oc.fecha_orden_compra, oc.numero_orden_compra, oc.estado, oc.id_empresa_compra, oc.cerrado id_cerrado, tm2.denominacion cerrado,
	oc.numero_orden_compra_cliente, u2.name vendedor,
	oc.total, oc.estado_pedido,
	(select 1 from comprobantes c where c.orden_compra = oc.id::varchar and c.anulado = ''N'' and c.estado = ''1'') facturado,
	(select to_char(c.fecha,''yyyy-mm-dd'') from comprobantes c where c.orden_compra::int = oc.id and c.anulado = ''N'' and c.estado = ''1'') fecha_facturado,
	(select to_char(sp.created_at,''yyyy-mm-dd'') from salida_productos sp 
	where sp.id_orden_compra = oc.id
	limit 1) fecha_salida ';

	v_tabla=' from orden_compras oc
	inner join tabla_maestras tm2 on oc.cerrado ::int = tm2.codigo ::int and tm2.tipo=''52''
	left join users u2 on oc.id_vendedor = u2.id ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento =''2'' ';

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
	 v_where:=v_where||'And oc.numero_orden_compra  = '''||p_numero_orden_compra||''' ';
	End If;

	If p_numero_orden_compra_cliente<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra_cliente  = '''||p_numero_orden_compra_cliente||''' ';
	End If;

	If p_situacion<>'' Then
	 v_where:=v_where||'And oc.cerrado = '''||p_situacion||''' ';
	End If;
	
	If p_estado<>'' Then
	 v_where:=v_where||'And oc.estado  = '''||p_estado||''' ';
	End If;
	
	If p_id_vendedor<>'' Then
	 v_where:=v_where||'And oc.id_vendedor  = '''||p_id_vendedor||''' ';
	End If;

	If p_estado_pedido<>'' Then
	 v_where:=v_where||'And oc.estado_pedido  = '''||p_estado_pedido||''' ';
	End If;

	If p_facturado<>'' Then
	  If p_facturado = '1' Then
	    v_where := v_where || 'AND EXISTS (
	      select 1 from comprobantes c 
	      where c.orden_compra = oc.id::varchar 
	        and c.anulado = ''N'' and c.estado = ''1''
	    ) ';
	  Else
	    v_where := v_where || 'AND NOT EXISTS (
	      select 1 from comprobantes c 
	      where c.orden_compra = oc.id::varchar 
	        and c.anulado = ''N'' and c.estado = ''1''
	    ) ';
	  End If;
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
