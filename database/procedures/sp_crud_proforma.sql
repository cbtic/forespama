-- DROP FUNCTION public.sp_crud_proforma(_varchar, _varchar);

CREATE OR REPLACE FUNCTION public.sp_crud_proforma(p_proforma character varying[], p_proforma_detalle character varying[])
 RETURNS character varying
 LANGUAGE plpgsql
AS $function$
declare
	_id integer;
	_serie character varying;
	_numero integer;
	_id_empresa integer;
	_id_persona integer;
	_fecha character varying; 
	_id_moneda integer; 
	_moneda character varying; 
	_sub_total numeric; 
	_igv numeric; 
	_total numeric; 	
	_id_proforma integer; 
	_id_producto integer; 
	_cantidad integer; 
	_id_descuento integer;
	_descuento numeric;
	_precio_unitario numeric;  
	_id_unidad_medida numeric;
	_valor_venta_bruto numeric;
	_accion character varying;
	_id_usuario integer;
	_estado character varying; 

begin

	if array_length(p_proforma, 1)>0 then 
		for i in array_lower(p_proforma, 1) .. array_upper( p_proforma, 1) loop 
			_accion := p_proforma[i][1];
			_id_usuario := p_proforma[i][2];
			_id := p_proforma[i][3];
			_serie := p_proforma[i][4];
			_numero := p_proforma[i][5];	
			_id_empresa := p_proforma[i][6];	
			_id_persona := p_proforma[i][7];
			_fecha := p_proforma[i][8]; 
			_id_moneda := p_proforma[i][9]; 
			_moneda := p_proforma[i][10]; 
			_sub_total := p_proforma[i][11]; 
			_igv := p_proforma[i][12]; 
			_total := p_proforma[i][13];
			_estado := p_proforma[i][14]; 
		end loop;

		case _accion
			when 'i' then

				insert
					into proformas(serie, numero, id_empresa, id_persona, fecha, id_moneda, moneda, sub_total, igv, total, id_usuario_inserta, created_at)
					values (_serie, (select coalesce(max(fi.numero),'0')+1 from proformas pi where pi.serie = _serie), _id_empresa, _id_persona, _fecha::date, _id_moneda, _moneda, _sub_total, _igv, t_otal, _id_usuario, now());
	
	
				if array_length(p_proforma_detalle, 1)>0 then 
	
					for i in array_lower(p_proforma_detalle, 1) .. array_upper(p_proforma_detalle, 1) loop
						 _id := p_proforma_detalle[i][1];
						_id_proforma := p_proforma_detalle[i][2];
						_id_producto := p_proforma_detalle[i][3];
						_cantidad := p_proforma_detalle[i][4];
						_precio_unitario := p_proforma_detalle[i][5];
						_id_descuento := p_proforma_detalle[i][6];
						_descuento := p_proforma_detalle[i][7];
						_precio_unitario := p_proforma_detalle[i][8];
						_valor_venta_bruto := p_proforma_detalle[i][9];
						_sub_total := p_proforma_detalle[i][10];
						_igv := p_proforma_detalle[i][11];
						_total := p_proforma_detalle[i][12];
						_estado := p_proforma_detalle[i][13];
						
						if _id=0 Then
							insert 
								into proforma_detalles(id_proforma, id_producto, id_unidad_medida, cantidad, id_descuento, descuento, precio_unitario, valor_venta_bruto, sub_total, igv, total, id_usuario_inserta, created_at)
								values (_id_proforma, _id_producto, _id_unidad_medida, _cantidad, _id_descuento, _descuento, _precio_unitario, _valor_venta_bruto, _sub_total, _igv, _total, _id_usuario, now());
						end if;
					end loop;
				end if;

			When 'u' then

				update proformas set
					sub_total = _sub_total, 
					igv = _igv, 
					total = _total,
					id_usuario_actualiza = _id_usuario,
					updated_at =now()
				where id=_id;
	
				if array_length(p_proforma_detalle, 1)>0 then 
	
					for i in array_lower(p_proforma_detalle, 1) .. array_upper(p_proforma_detalle, 1) loop
						 _id := p_proforma_detalle[i][1];
						_id_proforma := p_proforma_detalle[i][2];
						_id_producto := p_proforma_detalle[i][3];
						_cantidad := p_proforma_detalle[i][4];
						_precio_unitario := p_proforma_detalle[i][5];
						_id_descuento := p_proforma_detalle[i][6];
						_descuento := p_proforma_detalle[i][7];
						_precio_unitario := p_proforma_detalle[i][8];
						_valor_venta_bruto := p_proforma_detalle[i][9];
						_sub_total := p_proforma_detalle[i][10];
						_igv := p_proforma_detalle[i][11];
						_total := p_proforma_detalle[i][12];
						_estado := p_proforma_detalle[i][13];
						
						update proforma_detalles set
							precio_unitario =_precio_unitario,
							cantidad = _cantidad,
							id_descuento = _id_descuento, 
							descuento = _descuento, 
							precio_unitario = _precio_unitario,
							valor_venta_bruto = _valor_venta_bruto, 
							sub_total = _sub_total, 
							igv = _igv, 
							total = _total,
							id_usuario_actualiza = _id_usuario,
							updated_at=now()
						where id=_id;
						
					end loop;
				end if;
		End Case;
	end if;

	return _id;

end;
$function$
;


SELECT id, '61' tipo, denominacion, codigo, tipo_nombre, orden, estado
FROM public.tabla_maestras
WHERE tipo= '9';

INSERT INTO public.tabla_maestras (tipo,denominacion,codigo,tipo_nombre,orden,estado) VALUES
	 ('61','DNI','1','TIPO DOCUMENTO CLIENTE',1,'1'),
	 ('61','CARNÉ DE EXTRANJERÍA','2','TIPO DOCUMENTO CLIENTE',2,'1'),
	 ('61','PASAPORTE','3','TIPO DOCUMENTO CLIENTE',3,'1'),
	 ('61','CEDULA DIPLOMATICA DE IDENTIDAD','4','TIPO DOCUMENTO CLIENTE',4,'1'),
	 ('61','RUC','5','TIPO DOCUMENTO CLIENTE',5,'1'),
	 ('61','NRO PROFORMA','6','TIPO DOCUMENTO CLIENTE',6,'1');
	 

ALTER SEQUENCE tabla_maestras_id_seq RESTART WITH 310;

INSERT INTO public.tabla_maestras (tipo,denominacion,codigo,tipo_nombre,sub_codigo,abreviatura,orden,estado,created_at,updated_at) VALUES
	 ('62','CAJA VIRTUAL','11','CAJA DOLAR VIRTUAL',NULL,NULL,11,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 10','10','CAJA DOLAR',NULL,NULL,10,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 09','9','CAJA DOLAR',NULL,NULL,9,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 08','8','CAJA DOLAR',NULL,NULL,8,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 07','7','CAJA DOLAR',NULL,NULL,7,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 06','6','CAJA DOLAR',NULL,NULL,6,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 05','5','CAJA DOLAR',NULL,NULL,5,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 04','4','CAJA DOLAR',NULL,NULL,4,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 03','3','CAJA DOLAR',NULL,NULL,3,'1','2024-02-14 02:53:20','2024-02-14 02:53:20'),
	 ('62','CAJA 02','2','CAJA DOLAR',NULL,NULL,2,'1','2024-02-14 02:53:20','2024-02-14 02:53:20');
INSERT INTO public.tabla_maestras (tipo,denominacion,codigo,tipo_nombre,sub_codigo,abreviatura,orden,estado,created_at,updated_at) VALUES
	 ('62','CAJA 01','1','CAJA DOLAR',NULL,NULL,1,'1','2024-02-14 02:53:20','2024-02-14 02:53:20');