<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class IngresoVehiculoTronco extends Model
{

	function getEmpresaConductorVehiculos($placa){

        $cad = "select ecv.id,ecv.id_empresas,ecv.id_persona,ecv.id_vehiculos,ecv.id_conductores,
        case when ecv.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = ecv.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = ecv.id_empresas ) 
        end razon_social,
        case when ecv.id_tipo_cliente = 1 then 
        (select p.numero_documento from personas p
        where p.id = ecv.id_persona)
        else (select e2.ruc from empresas e2 
        where e2.id = ecv.id_empresas) 
        end ruc,
        v.placa,v.ejes,v.peso_tracto,v.peso_carreta,v.peso_seco,c.licencia,to_char(c.fecha_licencia,'dd-mm-yyyy')fecha_licencia,p.id_tipo_documento,p.numero_documento,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres conductor, v.id_marca, m.denominiacion marca, c.licencia, v.constancia_inscripcion, ecv.id_tipo_cliente 
        from empresas_conductores_vehiculos ecv
        inner join vehiculos v on ecv.id_vehiculos=v.id and v.estado='1' 
        inner join conductores c on ecv.id_conductores=c.id and c.estado='ACTIVO'
        inner join personas p on c.id_personas=p.id and p.estado='1'
        left join marcas m on v.id_marca = m.id
        where ecv.estado='1'
        and v.placa='".$placa."'
        order by ecv.id desc";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getEmpresaConductoresVehiculos($id_empresa){

        $cad = "select ecv.id,ecv.id_empresas,ecv.id_vehiculos,ecv.id_conductores,p.id_tipo_documento,p.numero_documento,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres conductor, c.licencia 
        from empresas_conductores_vehiculos ecv
        inner join empresas e on ecv.id_empresas=e.id
        inner join vehiculos v on ecv.id_vehiculos=v.id and v.estado='1' 
        inner join conductores c on ecv.id_conductores=c.id and c.estado='ACTIVO'
        inner join personas p on c.id_personas=p.id
        where ecv.estado='1'
        and ecv.id_empresas ='".$id_empresa."'
        and ecv.id = (select MAX(sub.id) from empresas_conductores_vehiculos sub
        where sub.id_conductores = ecv.id_conductores and sub.estado = '1')
        order by ecv.id desc";

		$data = DB::select($cad);
        return $data;
    }

	function getIngresoVehiculoTroncoCubicajeById($id){

        $cad = "select ivtc.*, COALESCE(p.id, e2.id) id_empresa_proveedor, ec.diametro_dm diametro_dm_proveedor, ec.precio_mayor, ec.precio_menor
        from ingreso_vehiculo_tronco_cubicajes ivtc
        left join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = ivttm.id
        left join ingreso_vehiculo_troncos ivt on ivttm.id_ingreso_vehiculo_troncos = ivt.id
        left join personas p on ivt.id_tipo_cliente = 1 and p.id = ivt.id_persona
        left join empresas e2 on ivt.id_tipo_cliente <> 1 and e2.id = ivt.id_empresa_proveedor
        left join lateral (
        select ec.diametro_dm, ec.precio_mayor, ec.precio_menor
        from empresa_cubicajes ec
        where ec.estado = '1'
        and ((ivt.id_tipo_cliente = 1 and ec.id_persona = ivt.id_persona)
        or (ivt.id_tipo_cliente <> 1 and ec.id_empresa = ivt.id_empresa_proveedor))
        and ((ec.id_tipo_empresa = 2 and ec.id_conductor = ivt.id_conductores)
        or ec.id_tipo_empresa = 1)
        order by ec.id desc
        limit 1) ec on true
        where ivtc.id_ingreso_vehiculo_tronco_tipo_maderas = '".$id."'
        and ivtc.estado = '1'
        order by ivtc.id asc";

		$data = DB::select($cad);
        return $data;
    }
	
	function getIngresoVehiculoTroncoCubicajeReporteById($id){

        $cad = "select count(*) cantidad, diametro_dm, longitud, volumen_m3, volumen_pies, sum(volumen_total_m3)volumen_total_m3,
        sum(volumen_total_pies)volumen_total_pies, precio_unitario, sum(precio_total)precio_total  
        from ingreso_vehiculo_tronco_cubicajes ivtc 
        where id_ingreso_vehiculo_tronco_tipo_maderas='".$id."'
        group by diametro_dm, longitud, volumen_m3, volumen_pies, precio_unitario
        order by diametro_dm asc";

		$data = DB::select($cad);
        return $data;
    }

    function getIngresoVehiculoTroncoCubicajeCabeceraById($id){

        $cad = "select ivt.id,ivttm.id id_ingreso_vehiculo_tronco_tipo_maderas,ivt.fecha_ingreso,
        case when ivt.id_tipo_cliente = 1 then 
        (select p.nombres ||' '|| p.apellido_paterno ||' '|| p.apellido_materno from personas p
        where p.id = ivt.id_persona)
        else (select e2.razon_social from empresas e2 
        where e2.id = ivt.id_empresa_transportista ) 
        end razon_social,
        case when ivt.id_tipo_cliente = 1 then 
        (select p.numero_documento from personas p
        where p.id = ivt.id_persona)
        else (select e2.ruc from empresas e2 
        where e2.id = ivt.id_empresa_transportista ) 
        end ruc,
        v.placa,v.ejes,p.numero_documento,
        p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres conductor,
        tm.denominacion tipo_madera,ivttm.cantidad,
        (select ec.id_tipo_empresa
        from empresa_cubicajes ec
        where ec.estado = '1'
        and ((ec.id_tipo_cliente = 1 and ec.id_persona = ivt.id_persona)
        or (ec.id_tipo_cliente <> 1 and ec.id_empresa = ivt.id_empresa_proveedor))
        and (ec.id_tipo_empresa = 1 
        or (ec.id_tipo_empresa = 2 and ec.id_conductor = ivt.id_conductores))
        limit 1)  tipo_empresa
        from ingreso_vehiculo_troncos ivt
        inner join vehiculos v on ivt.id_vehiculos=v.id
        inner join conductores c on ivt.id_conductores=c.id
        inner join personas p on c.id_personas=p.id
        inner join ingreso_vehiculo_tronco_tipo_maderas ivttm on ivt.id=ivttm.id_ingreso_vehiculo_troncos
        inner join tabla_maestras tm on ivttm.id_tipo_maderas=tm.codigo::int and tm.tipo='42'
        where ivttm.id = '".$id."'";

		$data = DB::select($cad);
        return $data;
    }

    function getIngresoVehiculoTroncoPagoById($id){

        $cad = "select ivtp.id,ivtp.fecha,tm.denominacion tipodesembolso,ivtp.importe,observacion,nro_guia,nro_factura,nro_cheque,foto_desembolso   
        from ingreso_vehiculo_tronco_pagos ivtp
        inner join tabla_maestras tm on ivtp.id_tipodesembolso=tm.codigo::int and tm.tipo='65' 
        where ivtp.id_ingreso_vehiculo_tronco_tipo_maderas=".$id."
        and ivtp.estado = '1'
        order by 1 desc";

		$data = DB::select($cad);
        return $data;
    }

    function obtenerAniosIngreso(){

        $cad = "select distinct DATE_PART('YEAR', ivt.fecha_ingreso)::varchar anio from ingreso_vehiculo_troncos ivt 
        order by  DATE_PART('YEAR', ivt.fecha_ingreso)::varchar ";

		$data = DB::select($cad);
        return $data;
    }
	
    function fecha_actual(){
		
		$cad = "select to_char(current_date,'dd-mm-yyyy') as fecha_actual";

		$data = DB::select($cad);
        return $data[0]->fecha_actual;
		
	}
    
	public function listar_ingreso_vehiculo_tronco_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_vehiculo_tronco_paginado',$p);

    }

    public function listar_ingreso_vehiculo_tronco_pagos_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_vehiculo_tronco_pagos_paginado',$p);

    }

    public function listar_ingreso_vehiculo_tronco_reporte_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_vehiculo_tronco_reporte_paginado',$p);

    }

    public function listar_ingreso_vehiculo_tronco_reporte_pago_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_vehiculo_tronco_reporte_pago_paginado',$p);

    }

    public function listar_ingreso_vehiculo_reporte_anual_ajax($p){

        return $this->readFuntionPostgres('sp_listar_ingreso_vehiculo_tronco_reporte_anual_paginado',$p);

    }

	public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;

    }


}
