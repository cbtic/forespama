-- DROP FUNCTION public.sp_listar_sodimac_factura_paginado(varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_sodimac_factura_paginado(p_fecha_inicio character varying, p_fecha_fin character varying, p_tiene_tipo_cobro character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
 RETURNS refcursor
 LANGUAGE plpgsql
AS $function$

Declare
--v_id numeric;
--v_numinf character varying;
v_scad varchar;
v_campos varchar;
v_tabla varchar;
v_where varchar;
v_count varchar;
v_col_count varchar;
--v_perfil varchar;

Begin
	
	p_pagina=(p_pagina::Integer-1)*p_limit::Integer;
	
	v_campos=' sf.id, e.razon_social empresa, tm2.denominacion medio_pago, tm.denominacion banco, sf.fecha_pago, sf.total_pagado, sf.estado,
	(select case when not exists ( select 1 from sodimac_factura_detalles sfd
	left join tabla_maestras tm on sfd.id_tipo_documento_cobro = tm.codigo::int and tm.tipo = ''78''
	where sfd.id_tipo_documento = ''2''
	and sfd.id_sodimac_factura = sf.id
	and (tm.codigo is null)) then 1 else 0 
	end) tiene_tipo_cobro ';

	v_tabla=' from sodimac_facturas sf 
	inner join tabla_maestras tm on sf.id_banco = tm.codigo::int and tm.tipo =''16''
	inner join tabla_maestras tm2 on sf.id_medio_pago  = tm2.codigo::int and tm2.tipo =''65''
	inner join empresas e on sf.id_empresa = e.id ';
		
	v_where = ' Where 1=1  ';
	
	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And sf.fecha_pago > '''||p_fecha_inicio||''' ';
	End If;
	
	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And sf.fecha_pago < '''||p_fecha_fin||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And sf.estado = '''||p_estado||''' ';
	End If;

	If p_tiene_tipo_cobro<>'' Then
	v_where := v_where || ' AND (
   	SELECT CASE WHEN NOT EXISTS (SELECT 1 
   	FROM sodimac_factura_detalles sfd
   	LEFT JOIN tabla_maestras tm ON sfd.id_tipo_documento_cobro = tm.codigo::int AND tm.tipo = ''78''
   	WHERE sfd.id_tipo_documento = ''2''
   	AND sfd.id_sodimac_factura = sf.id
   	AND tm.codigo IS NULL) THEN 1 ELSE 0 
   	END) = ' || p_tiene_tipo_cobro || ' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sf.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By sf.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
