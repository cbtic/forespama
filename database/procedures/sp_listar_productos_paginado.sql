CREATE OR REPLACE FUNCTION public.sp_listar_productos_paginado(p_serie character varying, p_denominacion character varying, p_codigo character varying, p_estado_bien character varying, p_tipo_origen_producto character varying, p_tiene_imagen character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' p.id, p.numero_serie, p.denominacion, p.codigo, tm3.denominacion unidad, p.contenido, tm4.denominacion unidad_medida, m.denominiacion marca, tm.denominacion unidad_medida_producto, tm2.denominacion estado_bien, p.fecha_vencimiento, p.stock_minimo, p.stock_actual, p.estado, tm5.denominacion tipo_origen_producto,
	(SELECT CASE 
	WHEN EXISTS (
    SELECT 1 
    FROM producto_imagenes pi 
    WHERE pi.id_producto = p.id) THEN 1 ELSE 0 
	END) tiene_imagen ';

	v_tabla=' from productos p 
	left join tabla_maestras tm on p.id_tipo_producto = tm.codigo::int and tm.tipo =''44''
	left join tabla_maestras tm2 on p.id_estado_bien = tm2.codigo::int and tm2.tipo =''56''
	left join tabla_maestras tm3 on p.id_unidad_producto = tm3.codigo::int and tm3.tipo =''43''
	left join tabla_maestras tm4 on p.id_unidad_medida = tm4.codigo::int and tm4.tipo =''57''
	left join tabla_maestras tm5 on p.id_tipo_origen_producto = tm5.codigo::int and tm5.tipo =''58''
	left join marcas m on p.id_marca = m.id';
	
	v_where = ' Where 1=1 ';

	If p_serie<>'' Then
	 v_where:=v_where||'And p.numero_serie =  '''||p_serie||''' ';
	End If;

	If p_estado_bien<>'' Then
	 v_where:=v_where||'And p.id_estado_bien =  '''||p_estado_bien||''' ';
	End If;

	If p_denominacion<>'' Then
	 v_where:=v_where||'And p.denominacion ilike  ''%'||p_denominacion||'%'' ';
	End If;

	If p_codigo<>'' Then
	 v_where:=v_where||'And p.codigo =  '''||p_codigo||''' ';
	End If;

	If p_tipo_origen_producto<>'' Then
	 v_where:=v_where||'And p.id_tipo_origen_producto =  '''||p_tipo_origen_producto||''' ';
	End If;

	If p_tiene_imagen<>'' Then
	 v_where:=v_where||'And tiene_imagen  = '''||p_tiene_imagen||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And p.estado  = '''||p_estado||''' ';
	End If;

	If p_tiene_imagen<>'' Then
	    If p_tiene_imagen = '1' Then
	        v_where:=v_where||' And exists (select 1 from producto_imagenes pi where pi.id_producto = p.id) ';
	    Else
	        v_where:=v_where||' And not exists (select 1 from producto_imagenes pi where pi.id_producto = p.id) ';
	    End If;
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
