CREATE OR REPLACE FUNCTION public.sp_crud_actualizar_vigencia_revision_tecnica()
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	entradas_mes record;
	entradas record;
	idp integer;
	v_cant numeric;
	v_cant_dia numeric;
	_fecha varchar;
	
	v_fecha varchar;
	v_fecha_desde varchar;
	v_fecha_hasta varchar;
	
	v_last_day_month varchar;
	
begin
	
	idp:=0;
	
	for entradas in
		
		select rta.id id_revision_tecnica_activo
		from revision_tecnica_activos rta 
		where 1=1 
		and rta.estado='1' 
		and rta.fecha_vencimiento::date<CURRENT_DATE
		and rta.estado_revision ='1'
		order by rta.id desc
		
	loop
	
		update revision_tecnica_activos set 
		estado_revision = 2
		where id=entradas.id_revision_tecnica_activo;
	
	end loop;
	
	return idp;

end;
$function$
;
