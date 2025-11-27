--DROP FUNCTION public.sp_listar_autorizacion_orden_compra_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_autorizacion_orden_compra_paginado(p_empresa_compra character varying, p_numero_orden_compra character varying, p_numero_orden_compra_cliente character varying, p_user character varying, p_estado_autorizacion character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_id_proceso integer;

begin

	select role_id into v_id_rol from model_has_roles mhr where mhr.model_id::varchar=p_user;

	select id_proceso into v_id_proceso from persona_procesos pp where pp.id_persona::varchar = p_user;
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' oc.id, tm.denominacion tipo_documento,
	case when oc.id_tipo_cliente = 1 then 
	(select p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno from personas p
	where p.id = oc.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = oc.id_empresa_compra) 
	end cliente,
	oc.fecha_orden_compra, oc.numero_orden_compra, oc.estado, oc.id_empresa_compra,
	u.id id_usuario, oc.numero_orden_compra_cliente, u2.name vendedor,
	oc.total, oc.estado_pedido, a2.denominacion almacen_origen,
	oc.cerrado id_cerrado, tm2.denominacion cerrado, oc.id_autorizacion ';

	v_tabla=' from orden_compras oc 
	inner join tabla_maestras tm on oc.id_tipo_documento ::int = tm.codigo ::int and tm.tipo = ''54''
	inner join tabla_maestras tm2 on oc.cerrado ::int = tm2.codigo ::int and tm2.tipo= ''52''
	inner join users u on oc.id_usuario_inserta = u.id
	left join users u2 on oc.id_vendedor = u2.id 
	left join almacenes a2 on oc.id_almacen_salida = a2.id ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and oc.estado_pedido = ''1'' ';
	
	If p_empresa_compra<>'' Then
	 v_where:=v_where||'And oc.id_empresa_compra  = '''||p_empresa_compra||''' ';
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
	
	If p_estado_autorizacion <> '' Then

	    If p_estado_autorizacion = '1' Then
	        v_where := v_where || ' And (
	            coalesce((
	                select aoc.id_proceso_pedido
	                from autorizacion_orden_compras aoc
	                where aoc.id_orden_compra = oc.id
	                order by aoc.id desc
	                limit 1
	            ), 0) = 2
	            and
	            (coalesce((
	                select aoc.id_autorizacion
	                from autorizacion_orden_compras aoc
	                where aoc.id_orden_compra = oc.id
	                order by aoc.id desc
	                limit 1
	            ), 0) = 1
				or
	            coalesce((
	                select aoc.id_autorizacion
	                from autorizacion_orden_compras aoc
	                where aoc.id_orden_compra = oc.id
	                order by aoc.id desc
	                limit 1
	            ), 0) = 0)
	        ) ';
	
	    ELSIF p_estado_autorizacion = '2' Then
	        v_where := v_where || ' And (
	            coalesce((
	                select aoc.id_proceso_pedido
	                from autorizacion_orden_compras aoc
	                where aoc.id_orden_compra = oc.id
	                order by aoc.id desc
	                limit 1
	            ), 0) > 2
	            or
	            coalesce((
	                select aoc.id_autorizacion
	                from autorizacion_orden_compras aoc
	                where aoc.id_orden_compra = oc.id
	                order by aoc.id desc
	                limit 1
	            ), 0) = 2
	        ) ';
	    END IF;
	
	END IF;


	
	If v_id_rol = 11 Then
	   v_where := v_where || ' And (oc.id_vendedor = ''' || p_user || ''' or oc.id_vendedor in (
	       select id_vendedor from jefe_vendedor_detalles where id_jefe_vendedor = ' || p_user || '
	   ))';
	End If;
	
	If p_estado<>'' Then
	 v_where:=v_where||'And oc.estado = '''||p_estado||''' ';
	End If;

	If /*p_user <> '1' and*/ v_id_proceso IS NOT NULL Then 
		v_where:=v_where||' and(
		select aoc.id_proceso_pedido from autorizacion_orden_compras aoc 
		where aoc.id_orden_compra = oc.id
		order by id desc
		limit 1) >= '''||v_id_proceso||''' ' ; 
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
