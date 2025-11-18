-- DROP FUNCTION public.sp_listar_empresa_cubicaje_paginado(varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_empresa_cubicaje_paginado(p_tipo_empresa character varying, p_empresa character varying, p_tipo_pago character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' ec.id, tm.denominacion tipo_empresa, 
	case when ec.id_tipo_cliente = 1 then 
	(select p2.nombres ||'' ''|| p2.apellido_paterno ||'' ''|| p2.apellido_materno from personas p2
	where p2.id = ec.id_persona)
	else (select e2.razon_social from empresas e2 
	where e2.id = ec.id_empresa) 
	end razon_social,
	p.nombres ||'' ''|| p.apellido_paterno ||'' ''|| p.apellido_materno conductor, tm2.denominacion tipo_pago, ec.diametro_dm, ec.precio_mayor,ec.precio_menor, ec.estado, ec.letra ';

	v_tabla=' from empresa_cubicajes ec
	left join conductores c on ec.id_conductor = c.id and c.estado =''ACTIVO''
	left join personas p on c.id_personas = p.id
	left join tabla_maestras tm on ec.id_tipo_empresa::int = tm.codigo::int and tm.tipo = ''79''
	left join tabla_maestras tm2 on ec.id_tipo_pago ::int = tm2.codigo::int and tm2.tipo = ''80'' ';
	
	v_where = ' Where 1=1 ';

	If p_tipo_empresa<>'' Then
	 v_where:=v_where||'And ec.id_tipo_empresa = '''||p_tipo_empresa||''' ';
	End If;

	If p_empresa<>'' Then
	 v_where:=v_where||'And ec.id_empresa = '''||p_empresa||''' ';
	End If;

	If p_tipo_pago<>'' Then
	 v_where:=v_where||'And ec.id_tipo_pago = '''||p_tipo_pago||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And ec.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ec.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By ec.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
