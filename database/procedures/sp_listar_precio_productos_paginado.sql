CREATE OR REPLACE FUNCTION public.sp_listar_precio_productos_paginado(p_denominacion character varying, p_codigo character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' distinct on (ppd.id_producto) ppd.id_producto, p.codigo, p.denominacion producto, tm2.denominacion unidad_producto, m.denominiacion marca, tm.denominacion moneda, ppd.tipo_cambio, ppd.precio, ppd.precio_dolares, ppd.fecha, ppd.estado ';

	v_tabla=' from producto_precio_detalles ppd
	inner join productos p on ppd.id_producto = p.id
	inner join tabla_maestras tm on ppd.id_moneda = tm.codigo::int and tm.tipo = ''1''
	inner join tabla_maestras tm2 on p.id_unidad_producto = tm2.codigo::int and tm2.tipo = ''43''
	left join marcas m on p.id_marca = m.id ';
	
	v_where = ' Where 1=1 and ppd.id_moneda > 0 ';

	If p_denominacion<>'' Then
	 v_where:=v_where||' And p.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||' And p.codigo =  '''||p_codigo||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||' And ppd.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(DISTINCT ppd.id_producto) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ppd.id_producto, ppd.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ppd.id_producto, ppd.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
