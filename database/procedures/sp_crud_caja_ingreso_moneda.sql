-- DROP FUNCTION public.sp_crud_caja_ingreso_moneda(varchar, int4, int4, int4, varchar, varchar, varchar, int4, int4, varchar, varchar, varchar, varchar);

CREATE OR REPLACE FUNCTION public.sp_crud_caja_ingreso_moneda(accion character varying, p_id_usuario integer, p_id_caja_ingreso_soles integer, p_id_caja_soles integer, p_saldo_inicial_soles character varying, p_total_recaudado_soles character varying, p_saldo_total_soles character varying, p_id_caja_ingreso_dolares integer, p_id_caja_dolares integer, p_saldo_inicial_dolares character varying, p_total_recaudado_dolares character varying, p_saldo_total_dolares character varying, p_estado character varying)
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	--id_caja_ingreso integer;
	cantidad_caja integer;
begin

	Case accion
		When 'i' then
			
			select count(id) into cantidad_caja from caja_ingresos where id_caja=p_id_caja_soles And estado = '1';
			if cantidad_caja=0 Then
				Insert Into caja_ingresos (id_usuario, id_caja, saldo_inicial, total_recaudado,saldo_total,fecha_inicio,estado,created_at,id_moneda,id_usuario_inserta)
				Values (p_id_usuario,p_id_caja_soles,to_number(p_saldo_inicial_soles,'9999999999.99'),to_number( p_total_recaudado_soles,'9999999999.99'),to_number( p_saldo_total_soles,'9999999999.99'),now(),p_estado,now(),1, p_id_usuario);

				p_id_caja_ingreso_soles := (SELECT currval('caja_ingresos_id_seq'));
				
			End if;
			
			select count(id) into cantidad_caja from caja_ingresos where id_caja=p_id_caja_dolares And estado = '1';
			if cantidad_caja=0 Then
				Insert Into caja_ingresos (id_usuario, id_caja, saldo_inicial, total_recaudado,saldo_total,fecha_inicio,estado,created_at,id_moneda, id_usuario_inserta)
				Values (p_id_usuario,p_id_caja_dolares,to_number(p_saldo_inicial_dolares,'9999999999.99'),to_number( p_total_recaudado_dolares,'9999999999.99'),to_number( p_saldo_total_dolares,'9999999999.99'),now(),p_estado,now(),2,p_id_usuario);
				p_id_caja_ingreso_dolares := (SELECT currval('caja_ingresos_id_seq'));
			End if;
			
		
		When 'u' then
		
			/******************SOLES***************************/
			
			update caja_ingresos t1 set 
			estado=0,
			total_recaudado=(select coalesce(Sum(total),0) from comprobantes fac where fac.anulado='N' And fac.id_caja=t1.id_caja And fac.fecha >= t1.fecha_inicio And fac.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end)),
			saldo_total=((select coalesce(Sum(total),0) from comprobantes fac where fac.anulado='N' And fac.id_caja=t1.id_caja And fac.fecha >= t1.fecha_inicio And fac.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end))+t1.saldo_inicial),
			fecha_fin=now(),
			updated_at=now(),
			id_usuario_actualiza = p_id_usuario  
			where id=p_id_caja_ingreso_soles;
		
			/******************DOLARES***************************/
			
			update caja_ingresos t1 set 
			estado=0,
			total_recaudado=(select coalesce(Sum(total),0) from comprobantes fac where fac.anulado='N' And fac.id_caja=t1.id_caja And fac.fecha >= t1.fecha_inicio And fac.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end)),
			saldo_total=((select coalesce(Sum(total),0) from comprobantes fac where fac.anulado='N' And fac.id_caja=t1.id_caja And fac.fecha >= t1.fecha_inicio And fac.fecha <= (case when t1.fecha_fin is null then now() else t1.fecha_fin end))+t1.saldo_inicial),
			fecha_fin=now(),
			updated_at=now(),
			id_usuario_actualiza = p_id_usuario 
			where id=p_id_caja_ingreso_dolares;
		
		When 'ul' then
			
			update caja_ingresos set 
			id_usuario_supervisor=p_id_usuario,
			saldo_liquidado=to_number( p_saldo_total_soles,'9999999999.99'),
			observacion=p_estado
			where id=p_id_caja_ingreso_soles;

			update caja_ingresos set 
			id_usuario_supervisor=p_id_usuario,
			saldo_liquidado=to_number( p_saldo_total_dolares,'9999999999.99'),
			observacion=p_estado
			where id=p_id_caja_ingreso_dolares;
		
		End Case;
				
	return p_id_caja_ingreso_soles;
	/*EXCEPTION
	WHEN OTHERS THEN
        id_caja_ingreso:=-1;
	return id_caja_ingreso;
	*/
end;
$function$
;
