CREATE OR REPLACE FUNCTION public.sp_crud_requerimiento_inhabilitar_editar()
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
		
		select r.id id_requerimiento
		from requerimientos r 
		where 1=1 
		and estado='1' 
		and r.fecha::date<CURRENT_DATE
		and r.estado_solicitud = '1'
		order by r.id desc
		
	loop
	
		update requerimientos set 
		estado_solicitud=2
		where id=entradas.id_requerimiento;
	
	end loop;
	
	
	return idp;

end;
$function$
;

