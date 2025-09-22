CREATE OR REPLACE FUNCTION public.sp_listar_kardex_consulta_producto_paginado(p_producto character varying, p_almacen character varying, p_cantidad_producto character varying, p_tipo_producto character varying, p_id_user character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
v_total_saldos varchar;
v_id_rol integer;

begin
	
	select role_id into v_id_rol from model_has_roles mhr where mhr.model_id::varchar=p_id_user;
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;

	v_campos=' DISTINCT ON  (k.id_producto, k.id_almacen_destino ) k.*, p.*, a.denominacion almacen_kardex, tm.denominacion unidad_medida, tm2.denominacion tipo_producto,
	(select coalesce(sum(ocd.cantidad_requerida),0) from orden_compra_detalles ocd 
	inner join orden_compras oc on ocd.id_orden_compra = oc.id 
	where id_producto = k.id_producto 
	and oc.id_tipo_documento = ''2''
	and oc.id_tipo_documento =''2''
	and oc.cerrado =''1''
	and ocd.cerrado =''1''
	and oc.estado =''1''
	and oc.id_almacen_salida = k.id_almacen_destino) cantidad_orden_compra,
	k.saldos_cantidad - COALESCE(
	(SELECT SUM(ocd.cantidad_requerida) 
	FROM orden_compra_detalles ocd 
	INNER JOIN orden_compras oc ON ocd.id_orden_compra = oc.id 
	WHERE ocd.id_producto = k.id_producto 
	AND oc.id_tipo_documento = ''2''
	and oc.cerrado =''1''
	and ocd.cerrado =''1''
	and oc.estado =''1''
	AND oc.id_almacen_salida = k.id_almacen_destino), 
	0) AS saldo_final ';

	v_tabla=' FROM kardex k
	LEFT JOIN productos p ON k.id_producto = p.id
	inner join almacenes a on k.id_almacen_destino = a.id 
	left join tabla_maestras tm on p.id_unidad_producto ::int = tm.codigo::int and tm.tipo = ''43''
	left join tabla_maestras tm2 on p.id_tipo_producto ::int = tm2.codigo::int and tm2.tipo = ''44''';
	
	v_where = ' Where 1=1 ';

	If v_id_rol=7 Then 
		v_where:=v_where||' And p.id_tipo_origen_producto =''2'' ';
	End If;

	If p_producto<>'' Then
	 v_where:=v_where||'And k.id_producto =  '''||p_producto||''' ';
	End If;

	If p_almacen<>'' Then
	 v_where := v_where || 'And k.id_almacen_destino = ''' || p_almacen || ''' ';
	End If;

	If p_tipo_producto<>'' Then
	 v_where := v_where || 'And p.id_tipo_producto = ''' || p_tipo_producto || ''' ';
	End If;

	If p_cantidad_producto <> '' Then
	    If p_cantidad_producto = '0' Then
	        v_where := v_where || ' AND k.id in(
									select k1.id 
									from kardex k1 
									where k1.id_producto = k.id_producto 
									and k1.id_almacen_destino = k.id_almacen_destino 
									order by k1.id desc 
									limit 1) and k.saldos_cantidad =0 ';
	    Else
	        v_where := v_where || ' AND k.id in(
									select k1.id 
									from kardex k1 
									where k1.id_producto = k.id_producto 
									and k1.id_almacen_destino = k.id_almacen_destino 
									order by k1.id desc 
									limit 1) and k.saldos_cantidad > 0 ';
	    End If;
	End If;
	--Raise Notice '%',v_where;
	--EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	EXECUTE ('SELECT count(*) FROM (SELECT DISTINCT ON (k.id_producto, k.id_almacen_destino) k.id_producto ' || v_tabla || v_where || ') as count_table') INTO v_count;	
	

	v_scad := 'SELECT coalesce(SUM(saldos.saldos_cantidad),0) AS total_saldos
               FROM (
                   SELECT DISTINCT ON (k.id_producto, k.id_almacen_destino) k.saldos_cantidad
                   ' || v_tabla || v_where || '
                   ORDER BY k.id_producto, k.id_almacen_destino, k.id DESC
               ) AS saldos';

    --Raise Notice 'suma es : %',v_scad;
    -- Ejecutar la suma de saldos para los registros seleccionados por DISTINCT ON
    EXECUTE v_scad INTO v_total_saldos;

--v_total_saldos=10;

	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count || ' ,' || v_total_saldos || ' AS total_saldos2 ' ||v_tabla||v_where||' Order By k.id_producto, k.id_almacen_destino, k.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count|| ' ,' || v_total_saldos || ' AS total_saldos2 ' ||v_tabla||v_where||' Order By k.id_producto, k.id_almacen_destino, k.id desc ;'; 
	End If;           

	--Raise Notice '%',v_scad;
	RAISE NOTICE 'Consulta generada: %', v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
