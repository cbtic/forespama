<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    protected $fillable = ['tipo', 'denominacion', 'orden', 'estado', 'codigo', 'tipo_nombre'];

    // contantes TIPO
    const NC = 'NC';
    const ND = 'ND';
    const GUIA = 'GUIA';
    const DOC_RELA = 'DOC_RELA';
    const TIPO_OPE = 'TIPO_OPE';
    const TIPO_IGV = 'TIPO_IGV';
    const UNIDADES = 'UNIDADES';
    const CODIGOBYS = 'CODIGOBYS';
    const ESTADO_BALANZA = 'ESTADO BALANZA';
    const G_DOC_RELA = 'G_DOC_RELA';
    const MOTIVO_T = 'MOTIVO_T';
    const MODAL_T = 'MODAL_T';
    const SERIES = 'SERIES';
    const CAJA = 'CAJA';
    const BALANZA = 'BALANZA';
    const CARRETA = 'CARRETA';
    const ESPACIO = 'ESPACIO';
    const ESTACIONAMIENTO = 'ESTACIONAMIENTO';

    const ACTIVO = 'A';
    const CANCELADO = 'C';

    use HasFactory;

	public function listar_tabla_maestras_ajax($p){
		return $this->readFunctionPostgres('sp_listar_tabla_maestra_paginado',$p);
    }

	public function readFunctionPostgres($function, $parameters = null){

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
