CREATE OR REPLACE FUNCTION public.sp_listar_comprobante_pagos_paginado(p_empresa character varying, p_persona character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_estado_pago character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' oc.id, c.id id_comprobante, oc.fecha_orden_compra, 
	CASE
	    WHEN oc.id_tipo_cliente = 1
	    THEN CONCAT_WS('' '',per.nombres,per.apellido_paterno,per.apellido_materno)
	    ELSE emp.razon_social
	END cliente,
	u."name" vendedor,
	bs.denominacion bien_servicio,
	oc.numero_orden_compra, sp.codigo codigo_salida_producto, sp.id id_salida_productos, to_char(c.fecha,''yyyy-mm-dd'') fecha_factura, c.serie ||''-''|| c.numero numero_factura, oc.sub_total, oc.igv, oc.total, 
	g.guia, COALESCE((SELECT tm.denominacion
    from starsoft_comprobante_pagos scp
    left join tabla_maestras tm on scp.id_estado_pago = tm.codigo::int and tm.tipo = ''66''
    WHERE scp.id_comprobante = c.id LIMIT 1), ''PENDIENTE'') AS estado_pago,
	(select sum(scp2.importe)
	from starsoft_comprobante_pagos scp2
	where scp2.id_comprobante = c.id
	and scp2.estado = ''1'') abono_pago, tm2.denominacion forma_pago, 
	(select cc.fecha_vencimiento  from comprobante_cuotas cc 
	where cc.id_comprobante = c.id)fecha_vencimiento ';

	v_tabla=' from comprobantes c 
	left join orden_compras oc on NULLIF(c.orden_compra, '''')::int = oc.id
	left join tabla_maestras tm2 on c.id_forma_pago = tm2.codigo::int and tm2.tipo = ''104''
	left join salida_productos sp on c.id_salida_productos = sp.id
	left join users u on oc.id_vendedor = u.id
	left join personas per on per.id = oc.id_persona
	left join empresas emp on emp.id = oc.id_empresa_compra
	left join lateral (select tm3.denominacion 
	from orden_compra_detalles ocd
	join productos p on p.id=ocd.id_producto
	join tabla_maestras tm3 on tm3.codigo::int=p.bien_servicio and tm3.tipo = ''73''
	where ocd.id_orden_compra=oc.id
	limit 1) bs on true
	left join lateral (select STRING_AGG(gi.guia_serie||''-''||gi.guia_numero,'', '') guia
	from salida_productos sp2
	left join guia_internas gi on gi.numero_documento::int=sp2.id ';
	
	v_where = ' Where 1=1 
	and sp2.tipo_devolucion = ''3''
	and gi.id_tipo_documento <> ''4''
	and gi.guia_anulado = ''N''
	and ((sp.id is not null and sp2.id=sp.id) or (sp.id is null and sp2.id_orden_compra=oc.id))) g on true
	where c.serie <> ''E001''
	and c.tipo <> ''NC'' ';

	/*If p_empresa<>'' Then
	 v_where:=v_where||'And c.id_plan_contable =  '''||p_empresa||''' ';
	End If;

	If p_persona<>'' Then
	 v_where:=v_where||'And c.id_tipo_cuenta =  '''||p_persona||''' ';
	End If;*/

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And c.fecha >=  '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And c.fecha <=  '''||p_fecha_fin||''' ';
	End If;

	If p_estado_pago <> '' Then
	    If p_estado_pago = '1' Then
	        v_where := v_where || ' And not exists (
	            select 1
	            from starsoft_comprobante_pagos scp
	            where scp.id_comprobante = c.id) ';
	    Else
	        v_where := v_where || ' And exists (
	            select 1
	            from starsoft_comprobante_pagos scp
	            where scp.id_comprobante = c.id
	              and scp.id_estado_pago = ' || p_estado_pago || ') ';
	    End If;
	
	END IF;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By c.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
