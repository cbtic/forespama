<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    protected $fillable = ['nro_brevete', 'codigo', 'tipo_documento', 'numero_documento', 'nombres', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'sexo', 'telefono', 'email', 'foto', 'ocupacion', 'titular_id', 'tipo_relacion','nombre_completo'];

    protected $appends = ['nombre_completo'];

    // contantes SEXO
    const SEXO_FEMENINO = 'F';
    const SEXO_MASCULINO = 'M';
    // contantes TIPO DOCUMENTO
    const TIPO_DOCUMENTO_DNI = 'DNI';
    const TIPO_DOCUMENTO_CARNET_EXTRANJERIA = 'CARNET_EXTRANJERIA';
    const TIPO_DOCUMENTO_PASAPORTE = 'PASAPORTE';
    const TIPO_DOCUMENTO_RUC = 'RUC';
    const TIPO_DOCUMENTO_CEDULA = 'CEDULA';
    const TIPO_DOCUMENTO_PTP = 'PTP/PTEP';
    const TIPO_DOCUMENTO_CPP = 'CPP/CSR';

    public function afiliaciones()
    {
        return $this->hasMany(Afiliacion::class);
    }

    public function conductores()
    {
        return $this->hasOne(Conductores::class,'id_conductores');
    }

    //function getPersonas($empresa_id){
      //  $ubicacion = UbicacionTrabajo::where("ubicacion_empresa_id", $empresa_id)->first();
       // $afiliaciones = Afiliacion::where("ubicacion_id", $ubicacion->id)->get("persona_id");
        //$data = Persona::find($afiliaciones);

       // return $data;
    //}

    function getPersona_($tipo_documento,$numero_documento){

        $cad = "select t1.*
		from personas t1
		Where t1.id_tipo_documento='".$tipo_documento."' And t1.numero_documento='".$numero_documento."'";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];

    }


    function getPersona($tipo_documento,$numero_documento){
        //echo $tipo_documento; exit();
        if($tipo_documento=="5"){  //RUC
            $cad = "select t1.id,razon_social,t1.direccion,t1.representante, t1.ruc, t1.email, 5 id_tipo_documento,  trim(t1.ruc) numero_documento_
                    from empresas t1                    
                    Where trim(t1.ruc)='".$numero_documento."' and t1.estado ='1' ";

        }elseif($tipo_documento=="85"){ //NRO_CAP
            
            $cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
            t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, t1.apellido_paterno|| ' ' ||t1.apellido_materno || ', ' || t1.nombres as nombre_completo,85 id_tipo_documento,email1 email, 
            t4.denominacion actividad, t2.numero_regional, r.denominacion regional, t5.denominacion autoriza_tramite, t6.denominacion ubicacion, t7.denominacion categoria, t2.celular1, trim(t2.numero_cap) numero_documento_
            from personas t1 
            inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
            left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
            left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
            inner join regiones r on t2.id_regional = r.id
            left join tabla_maestras t5 on t2.id_autoriza_tramite = t5.codigo::int And t5.tipo ='45'	
            left join tabla_maestras t6 on t2.id_ubicacion = t6.codigo::int And t6.tipo ='63'
            left join tabla_maestras t7 on t2.id_categoria = t7.codigo::int And t7.tipo ='18'
            Where  trim(t2.numero_cap) = trim('".$numero_documento."')
            and t1.estado='1' 
            limit 1";
                                
        }else{

            $cad =  "select t1.id,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t1.foto,
                    t1.numero_ruc,t1.id_tipo_documento,t1.email, trim(t1.numero_documento)  numero_documento_ 			
                    from personas t1                   
                    Where  t1.id_tipo_documento=1 and trim(t1.numero_documento) = trim('".$numero_documento."') 
                    and t1.estado='1' 
                    limit 1";

        }
        //echo $cad; exit();
        $data = DB::select($cad);
        
        if (!empty($data)) {
            return $data[0];
        } else {
            
            return null;
        }

    }

    public function getNombreCompletoAttribute() : string {
      return $this->numero_documento . " - " . $this->apellido_paterno ." " . $this->apellido_materno . ", " . $this->nombres;
    }

    public function getNombreCompletoSinDniAttribute() : string {
      return $this->apellido_paterno ." " . $this->apellido_materno . ", " . $this->nombres;
    }

	public function listar_persona_ajax($p){
		return $this->readFunctionPostgres('sp_listar_persona_paginado',$p);
    }

	function getPersonaBuscar($term){

        $cad = "select id,nombres||' '||apellido_paterno||' '||apellido_materno persona
		from personas
		where estado='1'
		and nombres||' '||apellido_paterno||' '||apellido_materno ilike '%".$term."%' ";

		$data = DB::select($cad);
        return $data;
    }


	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
	  DB::select("END;");
      return $data;
   }

}
