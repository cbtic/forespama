CREATE OR REPLACE FUNCTION public.sp_crud_actualizar_vigencia_soat()
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
		
		select sa.id id_soat_activo
		from soat_activos sa
		where 1=1 
		and sa.estado='1' 
		and sa.fecha_vencimiento::date<CURRENT_DATE
		and sa.estado_soat ='1'
		order by sa.id desc
		
	loop
	
		update soat_activos set 
		estado_soat=2
		where id=entradas.id_soat_activo;
	
	end loop;
	
	return idp;

end;
$function$
;
