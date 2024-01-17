<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Domains\Auth\Models{
/**
 * Class PasswordHistory.
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordHistory whereUpdatedAt($value)
 */
	class PasswordHistory extends \Eloquent {}
}

namespace App\Domains\Auth\Models{
/**
 * Class Permission.
 *
 * @property int $id
 * @property string $type
 * @property string $guard_name
 * @property string $name
 * @property string|null $description
 * @property int|null $parent_id
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $children
 * @property-read int|null $children_count
 * @property-read Permission|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission isChild()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission isMaster()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission isParent()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission singular()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Conductores
 *
 * @property int $id
 * @property int $personas_id
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $licencia
 * @property string|null $fecha_licencia
 * @property-read \App\Models\Persona $personas
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereFechaLicencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereLicencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores wherePersonasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductores whereUpdatedAt($value)
 */
	class Conductores extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Empresa
 *
 * @property int $id
 * @property string $ruc
 * @property string $nombre_comercial
 * @property string $razon_social
 * @property string $direccion
 * @property string $representante
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereDireccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereNombreComercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereRazonSocial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereRepresentante($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereRuc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Empresa whereUpdatedAt($value)
 */
	class Empresa extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\IngresoVehiculoTronco
 *
 * @property int $id
 * @property string $fecha_ingreso
 * @property string $fecha_salida
 * @property int $empresa_transportista_id
 * @property int $empresa_proveedor_id
 * @property int $vehiculos_id
 * @property int $conductores_id
 * @property int $encargados_id
 * @property int $procedencias_id
 * @property string|null $guia_numero
 * @property string|null $estado_ingreso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco query()
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereConductoresId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereEmpresaProveedorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereEmpresaTransportistaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereEncargadosId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereEstadoIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereFechaIngreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereFechaSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereGuiaNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereProcedenciasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IngresoVehiculoTronco whereVehiculosId($value)
 */
	class IngresoVehiculoTronco extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Persona
 *
 * @property int $id
 * @property int $empresa_id
 * @property string $tipo_documento
 * @property string $numero_documento
 * @property string $nombres
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $fecha_nacimiento
 * @property string $sexo
 * @property string $telefono
 * @property string $email
 * @property string $carnet_saneamiento
 * @property string $foto
 * @property string $nro_brevete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $nombre_completo
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona query()
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereApellidoMaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereApellidoPaterno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCarnetSaneamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereEmpresaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereFechaNacimiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereNombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereNroBrevete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereNumeroDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereTipoDocumento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Persona whereUpdatedAt($value)
 */
	class Persona extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $nombres
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereNombres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TablaMaestra
 *
 * @property int $id
 * @property string|null $tipo
 * @property string|null $denominacion
 * @property int $orden
 * @property string|null $estado
 * @property string|null $codigo
 * @property string|null $tipo_nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra query()
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereDenominacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereTipoNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablaMaestra whereUpdatedAt($value)
 */
	class TablaMaestra extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TablasMaestras
 *
 * @property int $id
 * @property string|null $tipo
 * @property string|null $denominacion
 * @property int $orden
 * @property string|null $estado
 * @property string|null $codigo
 * @property string|null $tipo_nombre
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras query()
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereCodigo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereDenominacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereTipoNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TablasMaestras whereUpdatedAt($value)
 */
	class TablasMaestras extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ubigeo
 *
 * @property int $id
 * @property string|null $id_reniec
 * @property string|null $departamento
 * @property string|null $provincia
 * @property string|null $distrito
 * @property string|null $id_inei
 * @property string|null $id_pais
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereDistrito($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereIdInei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereIdPais($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereIdReniec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereProvincia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ubigeo whereUpdatedAt($value)
 */
	class Ubigeo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vehiculo
 *
 * @property int $id
 * @property string|null $placa
 * @property int|null $ejes
 * @property int|null $peso_tracto
 * @property int|null $peso_carreta
 * @property int|null $peso_seco
 * @property string|null $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereEjes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePesoCarreta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePesoSeco($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePesoTracto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo wherePlaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehiculo whereUpdatedAt($value)
 */
	class Vehiculo extends \Eloquent {}
}

