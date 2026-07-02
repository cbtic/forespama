CREATE OR REPLACE FUNCTION public.sp_listar_mantenimiento_precio_productos_paginado(p_denominacion character varying, p_codigo character varying, p_familia character varying, p_sub_familia character varying, p_familia_contable character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' p.id, p.denominacion, p.codigo, tm3.denominacion unidad, m.denominiacion marca, p.estado, p.id_familia, p.id_sub_familia,
	f.denominacion familia, sf.denominacion sub_familia,fc.denominacion familia_contable, p.costo_unitario, p.margen, p.valor_venta, p.precio_venta ';

	v_tabla=' from productos p 
	left join tabla_maestras tm3 on p.id_unidad_producto = tm3.codigo::int and tm3.tipo = ''43''
	left join marcas m on p.id_marca = m.id
	left join familias f on p.id_familia = f.id 
	left join sub_familias sf on p.id_sub_familia = sf.id
	left join familia_contables fc on p.id_familia_contable = fc.id ';
	
	v_where = ' Where 1=1 ';

	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And p.codigo =  '''||p_codigo||''' ';
	End If;

	If p_familia<>'' Then
	 v_where:=v_where||'And p.id_familia =  '''||p_familia||''' ';
	End If;

	If p_sub_familia<>'' Then
	 v_where:=v_where||'And p.id_sub_familia =  '''||p_sub_familia||''' ';
	End If;

	If p_familia_contable<>'' Then
		 If p_familia_contable = '99' Then
	        v_where := v_where || ' and p.id_familia_contable is null ';
	    Else
	        v_where := v_where || ' and p.id_familia_contable = ' || p_familia_contable || ' ';
	    End If;
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And p.estado = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By p.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
