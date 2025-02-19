CREATE OR REPLACE FUNCTION public.sp_listar_total_orden_compra_tienda_paginado(p_orden_compra character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' oc.id, oc.numero_orden_compra, e.razon_social AS empresa, oc.estado, 
                 (SELECT 
                     CASE 
                         WHEN SUM(CASE WHEN poc.estado_validacion::int = 1 THEN 1 ELSE 0 END) = COUNT(*) THEN 1
                         WHEN SUM(CASE WHEN poc.estado_validacion::int = 0 THEN 1 ELSE 0 END) = COUNT(*) THEN 0
                         ELSE NULL
                     END
                  FROM parametro_orden_compras poc
                  WHERE poc.id_orden_compra = oc.id) AS estado_validacion ';

	v_tabla=' from orden_compras oc 
	inner join empresas e on oc.id_empresa_compra = e.id ';
	
	v_where = ' Where 1=1 and oc.id_tipo_documento = ''2'' and tienda_asignada = ''1'' and oc.estado=''1'' ';

	If p_orden_compra<>'' Then
	 v_where:=v_where||'And oc.numero_orden_compra =  '''||p_orden_compra||''' ';
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
