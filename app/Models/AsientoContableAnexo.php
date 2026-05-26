<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AsientoContableAnexo extends Model
{
    use HasFactory;

    public function listar_asiento_contable_anexo_ajax($p){

        return $this->readFuntionPostgres('sp_listar_asiento_contable_anexo_paginado',$p);

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

    function generarAsientosPersonas(){

        $cad = "select p.id, sta.codigo_tipo_anexo tipo_anexo, p.numero_documento codigo_anexo,'' ruc, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres razon_social, coalesce(p.direccion,'') direccion, 
        p.id_tipo_documento tipo_documento, p.numero_documento, '1' tipo_personal, p.apellido_paterno, p.apellido_materno, split_part(p.nombres,' ',1) as primer_nombre,
        split_part(p.nombres,' ',2) as segundo_nombre, '9589' nacionalidad, p.id_sexo sexo --substring(p.nombres from position(' ' in p.nombres)+1) as segundo_nombre
        from personas p
        cross join lateral (
        values
        ('CLIENTES', p.cliente),
        ('PROVEEDORES', p.proveedor),
        ('TRABAJADORES', p.personal)) t(tipo, valor)
        join starsoft_tipo_anexos sta on sta.descripcion ilike '%' || t.tipo || '%'
        where t.valor = '1'
        and p.asiento_generado = '0'
        order by p.id desc";

		$data = DB::select($cad);
        return $data;
    }

    function generarAsientosEmpresas(){

        $cad = "select e.id, sta.codigo_tipo_anexo tipo_anexo, e.ruc codigo_anexo, e.ruc, e.razon_social, e.direccion, '6' tipo_documento, e.ruc numero_documento, '6' tipo_personal, '' apellido_paterno, '' apellido_materno, '' primer_nombre,
        '' segundo_nombre, '9589' nacionalidad, '1' sexo
        from empresas e
        cross join lateral (
        values
        ('CLIENTES', e.cliente),
        ('PROVEEDORES', e.proveedor),
        ('PROVEEDORES', e.transporte)) t(tipo, valor)
        join starsoft_tipo_anexos sta on sta.descripcion ilike '%' || t.tipo || '%'
        where t.valor = '1'
        and e.asiento_generado = '0'
        order by e.id desc";

		$data = DB::select($cad);
        return $data;
    }

    function asientosContableAnexoPendientes(){

        $cad = "select aca.id, aca.tipo_anexo, aca.codigo_anexo, aca.ruc, aca.razon_social, aca.direccion, aca.tipo_documento, aca.nro_documento, aca.tipo_personal, aca.apellido_paterno, aca.apellido_materno,
        aca.primer_nombre, aca.segundo_nombre, aca.nacionalidad, aca.sexo 
        from asiento_contable_anexos aca 
        where aca.flag_migrado = '0'
        and aca.estado ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

}
