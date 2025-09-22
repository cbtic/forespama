-- DROP FUNCTION public.sp_listar_orden_produccion_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_orden_produccion_paginado(p_codigo character varying, p_fecha character varying, p_area character varying, p_unidad_trabajo character varying, p_situacion character varying, p_producto character varying, p_cerrado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' op.id, at.denominacion area_trabajo, ut.denominacion unidad_trabajo, tm.denominacion situacion, op.fecha_orden_produccion, op.fecha_produccion, op.codigo, op.estado ';

	v_tabla=' from orden_produccion op 
	left join area_trabajo at on op.id_area = at.id 
	left join unidad_trabajo ut on ut.id = op.id_unidad_trabajo
	inner join tabla_maestras tm on op.id_situacion = tm.codigo::int and tm.tipo = ''92'' ';
	
	v_where = ' Where 1=1 ';

	If p_codigo<>'' Then
	 v_where:=v_where||'And op.codigo =  '''||p_codigo||''' ';
	End If;

	If p_fecha<>'' Then
	 v_where:=v_where||'And op.fecha_orden_produccion  = '''||p_fecha||''' ';
	End If;

	If p_area<>'' Then
	 v_where:=v_where||'And op.id_area = '''||p_area||''' ';
	End If;

	If p_unidad_trabajo<>'' Then
	 v_where:=v_where||'And op.id_unidad_trabajo = '''||p_unidad_trabajo||''' ';
	End If;
	
	If p_situacion<>'' Then
	 v_where:=v_where||'And op.id_situacion = '''||p_situacion||''' ';
	End If;

	If p_producto<>'' Then
	 v_where := v_where || 'AND EXISTS (
		SELECT 1 FROM orden_produccion_detalles opd
		WHERE opd.id_orden_produccion = op.id 
		AND opd.id_producto = ''' || p_producto || ''') ';
	End If;

	If p_cerrado<>'' Then
	 v_where:=v_where||'And op.cerrado  = '''||p_cerrado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And op.estado  = '''||p_estado||''' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By op.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By op.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
