-- DROP FUNCTION public.sp_crud_comprobante_ncnd(varchar, int4, varchar, varchar, varchar, varchar, varchar, int4, int4, numeric, varchar, int4, int4, varchar, varchar, int4, varchar, int4, varchar, varchar, varchar, varchar, int4, int4, int4);

CREATE OR REPLACE FUNCTION public.sp_crud_comprobante_ncnd(serie character varying, numero integer, tipo character varying, cod_tributario character varying, total character varying, descripcion character varying, cod_contable character varying, id_v integer, id_caja integer, descuento numeric, accion character varying, p_id_usuario integer, p_id_moneda integer, p_razon_social character varying, p_direccion character varying, p_comprobante_origen integer, correo character varying, p_afectacion integer, p_tipo_nota character varying, p_motivo character varying, p_afecta_ingreso character varying, p_id_concepto integer, p_item integer, p_cantidad integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	_numero integer;
	idp integer;
	_ruc character varying;
	_razon_social character varying;
	_direccion character varying;
	_correo character varying;
	_total numeric;
	_total_letras character varying;
	_decimal_letras character varying;
	_total_sm numeric;
	_nombres character varying;
	_id_valoriza integer;
	_id_valoriza_act integer;

	_cuenta_s integer;
	_cuenta_t integer;

	_total_smr numeric;
	_descuento numeric;
	_moneda character varying;
	_serie character varying;
	_tipo character varying;

	_sub_total numeric;
	_igv numeric;
	
	_id_liquidacion numeric;
    _fecha_comp date;
	_id_medio integer;
	_nro_operacion character varying;

begin
	_serie:=serie;
	_tipo:=tipo;

	_total := to_number(total,'9999999999.99');
	select CAST(descuento AS numeric) into _descuento;
	

				if p_afectacion=30 then
					_sub_total=_total;
					_igv=0;
							
				else
					_sub_total:=round(_total/1.18,2);
					_igv:=round(_total-_sub_total,2);
				
				end if;	

	Case accion

		When 'f' then
			
			if p_id_moneda = 1 then
				_moneda:='SOLES';
			else
				_moneda:='DOLARES';
			end if;
			
				if trunc(_total) = 0 Then
					select substr(CAST(_total AS varchar),3) into _decimal_letras;
				else
					select substr(CAST(mod(_total,trunc(_total)) AS varchar),3) into _decimal_letras;
				End if;

				select upper(f_convnl(trunc(_total))) || ' CON '|| Case When _decimal_letras = '' Then '0' Else _decimal_letras End ||'/100 '||_moneda into _total_letras;


				Insert Into comprobantes (serie, numero, fecha, destinatario, direccion, cod_tributario, serie_guia,nro_guia, total_grav, total_inaf, total_exo, impuesto,
						total, letras, moneda, impuesto_factor, tipo_cambio, estado_pago, anulado, fecha_pago, fecha_recepcion, fecha_vencimiento,
						fecha_programado, observacion, id_moneda, tipo, id_forma_pago, afecta, cerrado, id_tipo_documento,serie_ncnd ,id_numero_ncnd ,tipo_ncnd,
						solictante,orden_compra,  total_anticipo, total_descuentos, desc_globales,monto_perce, monto_detrac, porc_detrac, totalconperce, tipo_guia,
						serie_refer, nro_refer, tipo_refer, codtipo_ncnd, motivo_ncnd, correo_des, tipo_operacion, base_perce, tipo_emision, ope_gratuitas,
						subtotal, codigo_bbss_detrac, cuenta_detrac, notas, cond_pago, id_caja, id_usuario_inserta, id_comprobante_ncnd,afecta_caja)
						
					Values (serie,(select coalesce(max(fi.numero),'0')+1 from comprobantes fi where fi.serie = _serie and fi.tipo=_tipo),now(),p_razon_social,p_direccion,cod_tributario,'', '',
						_sub_total,0.00,0.00,_igv,CAST(_total AS numeric),_total_letras,_moneda,18,0.000,'P','N',now(),now(),
						now(),now(),'',p_id_moneda, tipo, 1, p_afectacion, 'S',6,'',0,'','','',0.00, 0.00, 0.00, 0.00, 0.00, 0, CAST(_total AS numeric), '', '', '', '', p_tipo_nota,p_motivo, correo, '01',
						CAST(_total AS numeric), 'SINCRONO', 0, _sub_total, '', '', '', '', id_caja, p_id_usuario, p_comprobante_origen,p_afecta_ingreso);

				idp := (SELECT currval('comprobantes_id_seq'));

					if tipo='NC' then
		
						update valorizaciones set pagado ='0' where id_comprobante = p_comprobante_origen;
					    
						update valorizaciones Set estado='0'  where id_comprobante = p_comprobante_origen;
						
						--_id_liquidacion=(select pk_registro from valorizacion where  id_comprobante = p_comprobante_origen)
						insert into valorizaciones (id_modulo,pk_registro,id_concepto,id_agremido,id_empresa,id_comprobante,monto  ,estado,id_usuario_inserta,id_usuario_actualiza,created_at             ,updated_at             ,fecha                  ,id_moneda,moneda,descuento_porcentaje,fecha_proceso          ,id_persona,descripcion                                                                ,pagado,pk_fraccionamiento,codigo_fraccionamiento,id_pronto_pago,valor_unitario,cantidad,otro_concepto,exonerado,exonerado_motivo,pagado_post,nro_operacion_pos,fecha_pago_pos)
								select v2.id_modulo, v2.pk_registro, v2.id_concepto, v2.id_agremido, v2.id_empresa, idp, v2.monto , '1', 1, 1, v2.created_at, v2.updated_at, v2.fecha, v2.id_moneda, v2.moneda, v2.descuento_porcentaje, v2.fecha_proceso, v2.id_persona, v2.descripcion, v2.pagado, v2.pk_fraccionamiento, v2.codigo_fraccionamiento, v2.id_pronto_pago, v2.valor_unitario, v2.cantidad, v2.otro_concepto, v2.exonerado, v2.exonerado_motivo, v2.pagado_post, v2.nro_operacion_pos, v2.fecha_pago_pos
								from valorizaciones v2
								where id_comprobante = p_comprobante_origen;
						
						if p_afecta_ingreso='C' then

							select c.fecha, cp.id_medio, cp.nro_operacion
							into  _fecha_comp,_id_medio, _nro_operacion
							from comprobantes c inner join comprobante_pagos cp on c.id =cp.id_comprobante where c.id=p_comprobante_origen;

							if _fecha_comp=CURRENT_DATE THEN
								insert into comprobante_pagos (id_comprobante,item,fecha    , id_medio,  nro_operacion,descripcion,monto   ,fecha_vencimiento,estado,id_usuario_inserta)
													values (  idp,            1,    now(),    _id_medio,_nro_operacion,            '',     _total*-1,now(),            '1',    p_id_usuario);
							else
							
								insert into comprobante_pagos (id_comprobante,item,fecha     ,id_medio,nro_operacion,descripcion,monto   ,fecha_vencimiento,estado,id_usuario_inserta)
													values (  idp,            1,    now(),     91,       '',            '',     _total*-1,now(),            '1',    p_id_usuario);
							end if;
						end if;
					end if;			
			
		When 'd' then

			if numero > 0 Then

				Insert Into comprobante_detalles (serie, numero, tipo, item, cantidad, descripcion,
					pu, pu_con_igv, igv_total, descuento, importe,afect_igv, cod_contable, valor_gratu, unidad,id_usuario_inserta,id_comprobante,id_concepto)
					Values (_serie,numero,tipo,p_item,p_cantidad,descripcion,_sub_total,_igv,_igv,descuento,_total,p_afectacion,cod_contable,0,'ZZ',p_id_usuario, id_caja,p_id_concepto);
				
				idp := (SELECT currval('comprobante_detalles_id_seq'));

			Else
				idp:=0;
			End if;

	End Case;

	return idp;

end;
$function$
;
