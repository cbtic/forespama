-- DROP FUNCTION public.sp_listar_orden_compra_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_orden_compra_paginado(p_tipo_documento character varying, p_empresa_compra character varying, p_empresa_vende character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_numero_orden_compra character varying, p_numero_orden_compra_cliente character varying, p_situacion character varying, p_almacen_origen character varying, p_almacen_destino character varying, p_estado character varying, p_id_user character varying, p_id_vendedor character varying, p_estado_pedido character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	select role_id into v_id_rol from model_has_roles mhr where mhr.model_id::varchar=p_id_user;

	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' oc.id, tm.denominacion tipo_documento, e2.razon_social empresa_vende,
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	oc.fecha_orden_compra, oc.numero_orden_compra, oc.estado, oc.id_tipo_documento, oc.id_tipo_documento, oc.id_empresa_compra, oc.id_empresa_vende, oc.cerrado id_cerrado, tm2.denominacion cerrado,
	oc.id_almacen_salida, oc.id_almacen_destino, a.denominacion almacen_destino, a2.denominacion almacen_origen, u.id id_usuario, oc.id_unidad_origen, oc.numero_orden_compra_cliente, oc.tienda_asignada, u2.name vendedor,
	(select case
	when exists (
	select 1 
	from orden_compra_contacto_entregas occe 
	where occe.id_orden_compra = oc.id) then 1 else 0 
	end) tiene_direccion, oc.total ';

	v_tabla=' from orden_compras oc 
	inner join empresas e2 on oc.id_empresa_vende = e2.id
	inner join tabla_maestras tm on oc.id_tipo_documento ::int = tm.codigo ::int and tm.tipo=''54''
	inner join tabla_maestras tm2 on oc.cerrado ::int = tm2.codigo ::int and tm2.tipo=''52'' 
	left join almacenes a on oc.id_almacen_destino = a.id
	left join almacenes a2 on oc.id_almacen_salida = a2.id 
	inner join users u on oc.id_usuario_inserta = u.id
	left join users u2 on oc.id_vendedor = u2.id ';
		
	v_where = ' Where 1=1 ';

	/*If p_denominacion<>'' Then
	 v_where:=v_where||'And ep.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;*/

	If p_tipo_documento<>'' Then
	 v_where:=v_where||'And oc.id_tipo_documento  = '''||p_tipo_documento||''' ';
	End If;

	If p_empresa_compra<>'' Then
	 v_where:=v_where||'And oc.id_empresa_compra  = '''||p_empresa_compra||''' ';
	End If;

	If p_empresa_vende<>'' Then
	 v_where:=v_where||'And oc.id_empresa_vende  = '''||p_empresa_vende||''' ';
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

	If p_almacen_origen<>'' Then
	 v_where:=v_where||'And oc.id_almacen_salida = '''||p_almacen_origen||''' ';
	End If;

	If p_almacen_destino<>'' Then
	 v_where:=v_where||'And oc.id_almacen_destino = '''||p_almacen_destino||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And oc.estado  = '''||p_estado||''' ';
	End If;

	If v_id_rol=7 Then 
		v_where:=v_where||'And oc.id_vendedor  = '''||p_id_user||''' ';
	End If;

	If p_id_vendedor<>'' Then
	 v_where:=v_where||'And oc.id_vendedor  = '''||p_id_vendedor||''' ';
	End If;

	If p_estado_pedido<>'' Then
	 v_where:=v_where||'And oc.estado_pedido  = '''||p_estado_pedido||''' ';
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
