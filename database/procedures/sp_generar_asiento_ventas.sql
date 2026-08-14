-- DROP FUNCTION public.sp_generar_asiento_ventas(varchar, int4);

CREATE OR REPLACE FUNCTION public.sp_generar_asiento_ventas(p_tipo character varying, p_id_usuario integer)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$

DECLARE

    v_resultado varchar := 'OK';

    cursor_venta RECORD;

	v_debe numeric(18,2);
	v_haber numeric(18,2);
	v_diferencia numeric(18,2);

BEGIN

    If p_tipo = '1' then

        for cursor_venta in

            select c.id, cc_cliente.cuenta cuenta_cliente, cc_igv.cuenta cuenta_igv, to_char(c.fecha,'YYYYMM') annomes, '03' subdiario, c.correlativo_starsoft comprobante, 
			to_char(c.fecha,'yyyy-mm-dd') fecha_registro, '02' tipo_anexo, c.cod_tributario codigo_cliente, c.tipo tipo_documento, c.serie || c.numero numero_documento, 
			to_char(c.fecha,'yyyy-mm-dd') fecha_documento, (select c2.tipo from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) tipo_documento_referencial,
			case when c.anulado = 'N' then c.impuesto else 0 end igv, 
			c.impuesto_factor tasa_igv, 
			case when c.anulado = 'N' then c.total else 0 end importe,
			c.tipo || ' ' || c.serie || '-' || c.numero glosa_documento, 
			'VTA' tasa_conversion,
			tc.valor_venta tasa_cambio,
			c.tipo || ' ' || c.serie || '-' || c.numero glosa_documento, 
			case
				when c.anulado = 'S' then 'ANULADO'
				when c.adelanto = '1' then 'POR ANTICIPO DEL CLIENTE MES DE ' || to_char(c.fecha,'TMMonth')-- 1. ANTICIPO DE CLIENTE
				when exists (
				    select 1
				    from comprobante_detalles cd
				    where cd.id_comprobante = c.id
				    and cd.codigo ilike '%SERV%')
				then
				    case
				        when exists (
				            select 1
				            from comprobante_detalles cd
				            where cd.id_comprobante = c.id
				            and upper(cd.descripcion) like '%TRANSPORTE%')
				        then
				            'SERVICIOS DE TRANSP MES ' || to_char(c.fecha,'TMMonth')
				        else 
							'SERVICIO DE INSTAL ' || (select string_agg(cd.descripcion, ', ') from comprobante_detalles cd where cd.id_comprobante = c.id and cd.unidad = 'SERV') 
							|| ' ORD VENT ' || oc.numero_orden_compra end -- 2. SERVICIO
						when c.id_forma_pago = 1
							then 'VENTAS MES ' || to_char(c.fecha,'TMMonth') || ', OV ' || oc.numero_orden_compra
			    			|| ', CONDICION ' || tm3.denominacion -- 3. VENTA NORMAL CONTADO
							else
						    'VENTAS MES ' || to_char(c.fecha,'TMMonth') || ', OV ' || oc.numero_orden_compra 
							|| ', CONDICION ' || tm3.denominacion -- 4. VENTA CREDITO
			end glosa_movimiento,
			case when c.anulado = 'N' then 0 else 1 end anulado, 'D' debe_haber, c.cod_tributario ruc_cliente, 
			c.destinatario razon_social, to_char(c.fecha_vencimiento,'yyyy-mm-dd') fecha_vencimiento, 
			(select to_char(c2.fecha,'yyyy-mm-dd') from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) fecha_documento_referencial,
			false exportacion, '' otros_impuestos, '' exonerado, '' otros_cargos, '' impuesto_bolsa, c.id_moneda, 
			(select c2.serie ||' '|| c2.numero from comprobantes c2 where c.id_comprobante_ncnd = c2.id ) numero_documento_referencial, '' valor_isc
			from comprobantes c
			inner join orden_compras oc on nullif(c.orden_compra,'')::integer = oc.id
            --left join orden_compra_pagos ocp on oc.id = ocp.id_orden_compra
			left join starsoft_comprobante_pagos scp on c.id = scp.id_comprobante
            left join tabla_maestras tm2 on tm2.codigo::integer = scp.id_conversion and tm2.tipo = '122'
            left join tabla_maestras tm3 on tm3.codigo::integer = c.id_forma_pago and tm3.tipo = '12'
            left join asignacion_cuentas ac on ac.id_origen = 2 and ac.id_tipo_cuenta = 1 and ac.id_moneda = c.id_moneda
			left join cuenta_contables cc_cliente on cc_cliente.id = ac.id_plan_contable
			left join asignacion_cuentas ac_igv on ac_igv.id_origen = 2 and ac_igv.id_tipo_cuenta = 2 and ac_igv.id_moneda = c.id_moneda
			left join cuenta_contables cc_igv on cc_igv.id = ac_igv.id_plan_contable
			left join tipo_cambios tc on tc.fecha::date = c.fecha::date and tc.estado = '1'
            where c.serie <> 'E001'
            and c.asiento_generado = '0'
            and c.tipo in ('FT','BV')
            --and c.anulado = 'N'
            order by c.id

        loop

			RAISE NOTICE '====================================';
		    RAISE NOTICE 'Comprobante: %', cursor_venta.id;
		    RAISE NOTICE 'Tipo: %', cursor_venta.tipo_documento;
		    RAISE NOTICE 'Cuenta Cliente: %', cursor_venta.cuenta_cliente;
		    RAISE NOTICE 'Cuenta IGV: %', cursor_venta.cuenta_igv;

            If cursor_venta.cuenta_cliente is null then

                RAISE EXCEPTION
                'No existe configuración de cuenta para la moneda % del comprobante %',
                cursor_venta.id_moneda,
                cursor_venta.id;

            End If;

			If cursor_venta.cuenta_igv is null then
		        RAISE EXCEPTION
		        'No existe configuración de cuenta IGV para la moneda % del comprobante %',
		        cursor_venta.id_moneda,
		        cursor_venta.id;
		    End If;

            insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento, fecha_documento, 
			debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social, fecha_vencimiento, exportacion, otro_impuesto, exonerado, otros_cargos, impuesto_bolsa, 
			id_usuario_inserta, created_at, tipo_documento_referencial, numero_documento_referencial, igv, valor_isc, tasa_igv, tasa_cambio_conversion, tasa_cambio,fecha_documento_referencial, estado)

            values(cursor_venta.id, cursor_venta.cuenta_cliente, cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro, cursor_venta.tipo_anexo,
            cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, cursor_venta.debe_haber, cursor_venta.importe,
            cursor_venta.glosa_documento, cursor_venta.glosa_movimiento, cursor_venta.anulado, cursor_venta.ruc_cliente, cursor_venta.razon_social, cursor_venta.fecha_vencimiento,
            cursor_venta.exportacion, cursor_venta.otros_impuestos, cursor_venta.exonerado, cursor_venta.otros_cargos, cursor_venta.impuesto_bolsa, p_id_usuario, CURRENT_TIMESTAMP, 
			cursor_venta.tipo_documento_referencial, cursor_venta.numero_documento_referencial, cursor_venta.igv, cursor_venta.valor_isc, cursor_venta.tasa_igv, cursor_venta.tasa_conversion,
			cursor_venta.tasa_cambio, cursor_venta.fecha_documento_referencial, '1');

            If exists(select 1
	    		from comprobante_detalles
	    		where id_comprobante = cursor_venta.id
	      		and estado = '1'
	      		and afect_igv = '10') then

                insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento,
                fecha_documento, debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social, fecha_vencimiento, exportacion, otro_impuesto,
                exonerado, otros_cargos, impuesto_bolsa, id_usuario_inserta, created_at)

                values(cursor_venta.id, cursor_venta.cuenta_igv, cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro, cursor_venta.tipo_anexo,
                cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, 'H', cursor_venta.igv,
                cursor_venta.glosa_documento, cursor_venta.glosa_movimiento, cursor_venta.anulado, cursor_venta.ruc_cliente, cursor_venta.razon_social, cursor_venta.fecha_vencimiento,
                cursor_venta.exportacion, cursor_venta.otros_impuestos, cursor_venta.exonerado, cursor_venta.otros_cargos, cursor_venta.impuesto_bolsa, p_id_usuario, CURRENT_TIMESTAMP);

            End If;

			If exists (select 1
			    		from comprobante_detalles cd
			    		join productos p on cd.codigo = p.codigo and p.estado = '1'
			    		join familia_contables fc on p.id_familia_contable = fc.id 
						left join cuenta_contables cc on fc.id_plan_contable = cc.id
			    		where cd.id_comprobante = cursor_venta.id
			      		and coalesce(cc.cuenta_venta, cc.cuenta) is null) then
			    RAISE EXCEPTION
			    'El comprobante % tiene productos sin cuenta contable.',
			    cursor_venta.id;
			End If;

            insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento,
            fecha_documento, debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social, fecha_vencimiento, exportacion, otro_impuesto,
            exonerado, otros_cargos, impuesto_bolsa, id_usuario_inserta, created_at)
            
			select cursor_venta.id, coalesce(cc.cuenta_venta, cc.cuenta), cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro,
            cursor_venta.tipo_anexo, cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, 'H',
            sum(case when cursor_venta.anulado = 'N' then cd.valor_venta_bruto else 0 end) valor_venta_bruto, cursor_venta.glosa_documento, cursor_venta.glosa_movimiento, cursor_venta.anulado, cursor_venta.ruc_cliente, cursor_venta.razon_social,
            cursor_venta.fecha_vencimiento, cursor_venta.exportacion, cursor_venta.otros_impuestos, cursor_venta.exonerado, cursor_venta.otros_cargos, cursor_venta.impuesto_bolsa, 
			p_id_usuario, CURRENT_TIMESTAMP
            from comprobante_detalles cd
            inner join productos p on cd.codigo = p.codigo and p.estado = '1'
            inner join familia_contables fc on p.id_familia_contable = fc.id
            inner join cuenta_contables cc on fc.id_plan_contable = cc.id
			left join comprobantes c on cd.id_comprobante = c.id
            where cd.id_comprobante = cursor_venta.id
            and cd.estado = '1'
            group by coalesce(cc.cuenta_venta, cc.cuenta);

            update comprobantes
			set asiento_generado = '1'
			where id = cursor_venta.id;

        End loop;

    End If;

    If p_tipo='2' then

	    for cursor_venta in
	
	        select c.id, cc_cliente.cuenta cuenta_cliente, cc_igv.cuenta cuenta_igv, to_char(c.fecha,'YYYYMM') annomes, '03' subdiario, c.correlativo_starsoft comprobante, 
			to_char(c.fecha,'yyyy-mm-dd') fecha_registro, '02' tipo_anexo, c.cod_tributario codigo_cliente, 'CC' tipo_documento, c.serie || c.numero numero_documento,
			to_char(c.fecha,'yyyy-mm-dd') fecha_documento, c2.tipo tipo_documento_referencial, c2.serie||c2.numero numero_documento_referencial, c.impuesto igv, '' valor_isc,
			c.impuesto_factor tasa_igv, to_char(c2.fecha,'yyyy-mm-dd') fecha_documento_referencial, c.impuesto igv, c.total importe, 'VTA' tasa_conversion,
			(select tc.valor_venta from tipo_cambios tc where tc.fecha::date = c.fecha::date and tc.estado = '1') tasa_cambio, 'CC ' || c.serie || '-' || c.numero glosa_documento, 
			'ANULACIÓN DE FACTURA ' || c2.serie || '-' || c2.numero glosa_movimiento,
			case when c.anulado = 'N' then 0 else 1 end anulado, c.cod_tributario ruc_cliente, c.destinatario razon_social, to_char(c.fecha_vencimiento,'yyyy-mm-dd') fecha_vencimiento,
			false exportacion, '' otros_impuestos, '' exonerado, '' otros_cargos, '' impuesto_bolsa, c.id_moneda, c2.serie serie_matriz, c2.numero numero_matriz, c2.tipo tipo_matriz
			from comprobantes c
	        left join comprobantes c2 on c.id_comprobante_ncnd = c2.id
	        --left join orden_compras oc on nullif(c.orden_compra,'')::integer = oc.id
	        --left join orden_compra_pagos ocp on oc.id = ocp.id_orden_compra
	        --left join tabla_maestras tm2 on tm2.codigo::integer=ocp.id_conversion and tm2.tipo = '122'
	        left join asignacion_cuentas ac_cliente on ac_cliente.id_origen = 2 and ac_cliente.id_tipo_cuenta = 1 and ac_cliente.id_moneda=c.id_moneda
			left join cuenta_contables cc_cliente on cc_cliente.id = ac_cliente.id_plan_contable
	        left join asignacion_cuentas ac_igv on ac_igv.id_origen = 2 and ac_igv.id_tipo_cuenta = 2 and ac_igv.id_moneda=c.id_moneda
			left join cuenta_contables cc_igv on cc_igv.id = ac_igv.id_plan_contable
	        where c.asiento_generado = '0'
	        and c.serie <> 'E001'
	        and c.tipo = 'NC'
            --and c.anulado = 'N'
	        order by c.id

	    loop

			If cursor_venta.cuenta_cliente is null then

                RAISE EXCEPTION
                'No existe configuración de cuenta para la moneda % del comprobante %',
                cursor_venta.id_moneda,
                cursor_venta.id;

            End If;

			If cursor_venta.cuenta_igv is null then
		        RAISE EXCEPTION
		        'No existe configuración de cuenta IGV para la moneda % del comprobante %',
		        cursor_venta.id_moneda,
		        cursor_venta.id;
		    End If;
	
	        insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento, fecha_documento,
			tipo_documento_referencial, numero_documento_referencial, fecha_documento_referencial, debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social,
    		fecha_vencimiento, exportacion, otro_impuesto, exonerado, otros_cargos, impuesto_bolsa, id_usuario_inserta, created_at, igv, 
			valor_isc, tasa_igv, tasa_cambio_conversion, tasa_cambio, estado)

			values(cursor_venta.id, cursor_venta.cuenta_cliente, cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro, cursor_venta.tipo_anexo,
    		cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, cursor_venta.tipo_documento_referencial, 
			cursor_venta.numero_documento_referencial, cursor_venta.fecha_documento_referencial, 'H', cursor_venta.importe, cursor_venta.glosa_documento, cursor_venta.glosa_movimiento, cursor_venta.anulado,
    		cursor_venta.ruc_cliente, cursor_venta.razon_social, cursor_venta.fecha_vencimiento, cursor_venta.exportacion, cursor_venta.otros_impuestos, cursor_venta.exonerado, cursor_venta.otros_cargos,
    		cursor_venta.impuesto_bolsa, p_id_usuario, CURRENT_TIMESTAMP, cursor_venta.igv, cursor_venta.valor_isc, cursor_venta.tasa_igv, cursor_venta.tasa_conversion, cursor_venta.tasa_cambio, '1');

			If exists ( 
				select 1
			    from comprobante_detalles cd
			    where cd.id_comprobante = cursor_venta.id
			    and cd.estado = '1'
			    and cd.afect_igv = '10') then

	    		insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento, fecha_documento,
	        	tipo_documento_referencial, numero_documento_referencial, fecha_documento_referencial, debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social,
	        	fecha_vencimiento, exportacion, otro_impuesto, exonerado, otros_cargos, impuesto_bolsa, id_usuario_inserta, created_at)
	    		
				values(cursor_venta.id, cursor_venta.cuenta_igv, cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro, cursor_venta.tipo_anexo, 
				cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, cursor_venta.tipo_documento_referencial,
	        	cursor_venta.numero_documento_referencial, cursor_venta.fecha_documento_referencial, 'D', cursor_venta.igv, cursor_venta.glosa_documento, cursor_venta.glosa_movimiento,
	        	cursor_venta.anulado, cursor_venta.ruc_cliente, cursor_venta.razon_social, cursor_venta.fecha_vencimiento, cursor_venta.exportacion, cursor_venta.otros_impuestos,
	        	cursor_venta.exonerado, cursor_venta.otros_cargos, cursor_venta.impuesto_bolsa, p_id_usuario, CURRENT_TIMESTAMP);

			End If;
		
			If exists (
			    select 1
			    from comprobante_detalles cd
			    inner join productos p on cd.codigo = p.codigo and p.estado = '1'
			    inner join familia_contables fc on p.id_familia_contable = fc.id
			    left join cuenta_contables cc on fc.id_plan_contable = cc.id
			    where cd.id_comprobante = cursor_venta.id 
				and cd.estado = '1'
			    and coalesce(cc.cuenta_venta, cc.cuenta) is null) then
			
			    RAISE EXCEPTION
			    'El comprobante % tiene productos sin cuenta contable.',
			    cursor_venta.id;
			
			End If;

        	insert into asiento_contable_ventas(id_comprobante, cuenta, annomes, subdiario, comprobante, fecha_registro, tipo_anexo, codigo_cliente, tipo_documento, numero_documento, fecha_documento,
            tipo_documento_referencial, numero_documento_referencial, fecha_documento_referencial, debe_haber, importe, glosa, glosa_movimiento, anulado, ruc_cliente, razon_social,
            fecha_vencimiento, exportacion, otro_impuesto, exonerado, otros_cargos, impuesto_bolsa, id_usuario_inserta, created_at)
        
			select cursor_venta.id, coalesce(cc.cuenta_venta, cc.cuenta), cursor_venta.annomes, cursor_venta.subdiario, cursor_venta.comprobante, cursor_venta.fecha_registro, cursor_venta.tipo_anexo,
			cursor_venta.codigo_cliente, cursor_venta.tipo_documento, cursor_venta.numero_documento, cursor_venta.fecha_documento, cursor_venta.tipo_documento_referencial,
			cursor_venta.numero_documento_referencial, cursor_venta.fecha_documento_referencial, 'D', 
			SUM(COALESCE(cd.valor_venta_bruto, cd.valor_venta, cd.cantidad * cd.importe)), cursor_venta.glosa_documento, cursor_venta.glosa_movimiento, 
			cursor_venta.anulado, cursor_venta.ruc_cliente, cursor_venta.razon_social, cursor_venta.fecha_vencimiento, cursor_venta.exportacion, cursor_venta.otros_impuestos, cursor_venta.exonerado,
			cursor_venta.otros_cargos, cursor_venta.impuesto_bolsa, p_id_usuario, CURRENT_TIMESTAMP
			from comprobante_detalles cd
			inner join productos p on cd.codigo = p.codigo and p.estado = '1'
			inner join familia_contables fc on p.id_familia_contable = fc.id
            inner join cuenta_contables cc on fc.id_plan_contable = cc.id
        	where cd.id_comprobante = cursor_venta.id
          	and cd.estado = '1'
        	group by coalesce(cc.cuenta_venta, cc.cuenta);

			select coalesce(sum(
			case when debe_haber = 'D' then importe::numeric else 0 end),0), coalesce(sum(case when debe_haber = 'H' THEN importe::numeric else 0 end),0)
			into v_debe, v_haber
			from asiento_contable_ventas
			where id_comprobante = cursor_venta.id;
			
			v_diferencia := round(v_debe - v_haber,2);
			
			If v_diferencia <> 0 then
			
			    update asiento_contable_ventas
			    set importe = ROUND(importe + v_diferencia, 2)
			    where id = (SELECT id
		        from asiento_contable_ventas
		        where id_comprobante = cursor_venta.id
		        and debe_haber = 'H'
		        order by id desc
		        limit 1);
			
			End If;

	        update comprobantes
	        set asiento_generado = '1'
	        where id = cursor_venta.id;
	
	    End loop;
	
	End If;
	
    RETURN v_resultado;

	--EXCEPTION WHEN OTHERS THEN RAISE EXCEPTION '%', SQLERRM;

END;
$function$
;
