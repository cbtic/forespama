CREATE OR REPLACE FUNCTION public.sp_listar_promart_factura_paginado(p_fecha_inicio character varying, p_fecha_fin character varying, p_tiene_tipo_cobro character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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
	
	v_campos=' pf.id, tm.denominacion medio_pago, pf.cuenta_bancaria, tm2.denominacion banco, pf.fecha_pago, e.razon_social empresa, pf.total_pagado, tm3.denominacion moneda, pf.estado,
	(select case when not exists ( select 1 from promart_factura_detalles pfd
	left join tabla_maestras tm on pfd.id_tipo_documento_cobro = tm.codigo::int and tm.tipo = ''78''
	where pfd.id_tipo_documento = ''2''
	and pfd.id_promart_factura = pf.id
	and (tm.codigo is null)) then 1 else 0 
	end) tiene_tipo_cobro ';

	v_tabla=' from promart_facturas pf 
	inner join tabla_maestras tm on tm.codigo::int = pf.id_medio_pago and tm.tipo = ''65''
	inner join tabla_maestras tm2 on tm2.codigo::int = pf.id_banco and tm2.tipo = ''16''
	inner join tabla_maestras tm3 on tm3.codigo::int = pf.id_moneda and tm3.tipo = ''1''
	inner join empresas e on e.id = pf.id_empresa ';
		
	v_where = ' Where 1=1  ';
	
	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And pf.fecha_pago > '''||p_fecha_inicio||''' ';
	End If;
	
	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And pf.fecha_pago < '''||p_fecha_fin||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And pf.estado = '''||p_estado||''' ';
	End If;

	If p_tiene_tipo_cobro<>'' Then
	v_where := v_where || ' And (
   	select case when not exists (select 1 
   	from promart_factura_detalles pfd
   	left join tabla_maestras tm on pfd.id_tipo_documento_cobro = tm.codigo::int and tm.tipo = ''78''
   	where pfd.id_tipo_documento = ''2''
   	and pfd.id_promart_factura = pf.id
   	and tm.codigo is null) then 1 else 0 
   	end) = ' || p_tiene_tipo_cobro || ' ';
	End If;
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pf.id Desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By pf.id Desc;'; 
	End If;
	
	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End

$function$
;
