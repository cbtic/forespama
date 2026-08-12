-- DROP FUNCTION public.sp_listar_asiento_contable_venta_paginado(varchar, varchar, varchar, varchar, varchar, varchar, varchar, varchar, refcursor);

CREATE OR REPLACE FUNCTION public.sp_listar_asiento_contable_venta_paginado(p_numero_comprobante character varying, p_numero_documento character varying, p_fecha_inicio character varying, p_fecha_fin character varying, p_migrado character varying, p_estado character varying, p_pagina character varying, p_limit character varying, p_ref refcursor)
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

	v_campos=' acv.id, cc.denominacion cuenta, acv.cuenta numero_cuenta, acv.annomes, ss.descripcion subdiario, acv.comprobante, acv.fecha_registro, sta.descripcion tipo_anexo, acv.codigo_cliente, acv.tipo_documento,
	acv.numero_documento, acv.fecha_documento, acv.tipo_documento_referencial, acv.numero_documento_referencial, acv.igv, acv.valor_isc, acv.tasa_igv, acv.importe, acv.tasa_cambio_conversion,
	acv.tasa_cambio, acv.glosa, acv.glosa_movimiento, acv.anulado, acv.debe_haber, acv.ruc_cliente, acv.razon_social, acv.centro_costo, acv.fecha_vencimiento, acv.fecha_documento_referencial,
	acv.exportacion, acv.otros_cargos, acv.impuesto_bolsa, acv.flag_migrado, acv.fecha_migrado, acv.estado ';

	v_tabla=' from asiento_contable_ventas acv
	left join starsoft_subdiarios ss on acv.subdiario = ss.codigo 
	left join cuenta_contables cc on acv.cuenta = cc.cuenta 
	left join starsoft_tipo_anexos sta on acv.tipo_anexo = sta.codigo_tipo_anexo ';
	
	v_where = ' Where 1=1 ';

	If p_numero_comprobante<>'' Then
	 v_where:=v_where||'And acv.comprobante = '''||p_numero_comprobante||''' ';
	End If;

	If p_numero_documento<>'' Then
	 v_where:=v_where||'And acv.numero_documento = '''||p_numero_documento||''' ';
	End If;

	If p_fecha_inicio<>'' Then
	 v_where:=v_where||'And acv.fecha_registro >= '''||p_fecha_inicio||''' ';
	End If;

	If p_fecha_fin<>'' Then
	 v_where:=v_where||'And acv.fecha_registro <= '''||p_fecha_fin||''' ';
	End If;

	If p_migrado<>'' Then
	 v_where:=v_where||'And acv.flag_migrado = '''||p_migrado||''' ';
	End If;

	If p_estado<>'' Then
	 v_where:=v_where||'And acv.estado  = '''||p_estado||''' ';
	End If;
	
	
	EXECUTE ('SELECT count(1) '||v_tabla||v_where) INTO v_count;
	v_col_count:=' ,'||v_count||' as TotalRows ';

	If v_count::Integer > p_limit::Integer then
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By acv.id desc LIMIT '||p_limit||' OFFSET '||p_pagina||';'; 
	else
		v_scad:='SELECT '||v_campos||v_col_count||v_tabla||v_where||' Order By acv.id desc;'; 
	End If;

	--Raise Notice '%',v_scad;
	Open p_ref For Execute(v_scad);
	Return p_ref;
End
--select sp_listar_periodos_paginado('','','','','','1','10','ref');fetch all in ref
$function$
;
