CREATE OR REPLACE FUNCTION public.sp_listar_informe_venta_b2b_paginado(p_semana character varying, p_producto character varying, p_tienda character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ibbv.id, ibbv.upc, ibbv.sku, ep.descripcion_empresa, ibbv.subclase_conjunto, ibbv.desc_subclase_conjunto, t.numero_tienda, t.denominacion tienda, /*t.denominacion,*/ibbv.semana, ibbv.lunes, ibbv.martes, ibbv.miercoles, ibbv.jueves, ibbv.viernes, 
	ibbv.sabado, ibbv.domingo, ibbv.venta_unidades, ibbv.venta_soles, ibbv.stock_contable, ibbv.oc_pendiente, ibbv.trf_por_recibir, ibbv.trf_enviadas, ibbv.estado ';

	v_tabla=' from informe_b2b_ventas ibbv 
	inner join productos p on ibbv.id_producto = p.id 
	left join equivalencia_productos ep on p.id = ep.id_producto 
	left join tiendas t on ibbv.id_tienda = t.id ';
	
	v_where = ' Where 1=1 and ibbv.estado = ''1'' ';

	If p_semana<>'' Then
	 v_where:=v_where||'And ibbv.semana = '''||p_semana||''' ';
	End If;

	If p_producto<>'' Then
	 v_where:=v_where||'And ibbv.id_producto = '''||p_producto||''' ';
	End If;

	If p_tienda<>'' Then
	 v_where:=v_where||'And ibbv.id_tienda = '''||p_tienda||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ibbv.semana desc, ibbv.id asc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ibbv.semana desc, ibbv.id asc desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
