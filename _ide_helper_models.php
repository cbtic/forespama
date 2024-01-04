<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Domains\Announcement\Models{
/**
 * Class Announcement.
 *
 * @property int $id
 * @property string|null $area
 * @property string $type
 * @property string $message
 * @property bool $enabled
 * @property \Illuminate\Support\Carbon|null $starts_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement enabled()
 * @method static \Database\Factories\AnnouncementFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement forArea($area)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement inTimeFrame()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUpdatedAt($value)
 */
	class Announcement extends \Eloquent {}
}

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

namespace App\Domains\Auth\Models{
/**
 * Class Role.
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $permissions_label
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\RoleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Domains\Auth\Models{
/**
 * Class User.
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property \Illuminate\Support\Carbon|null $password_changed_at
 * @property bool $active
 * @property string|null $timezone
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property bool $to_be_logged_out
 * @property string|null $provider
 * @property string|null $provider_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $avatar
 * @property-read string $permissions_label
 * @property-read string $roles_label
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\PasswordHistory> $passwordHistories
 * @property-read int|null $password_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Domains\Auth\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \DarkGhostHunter\Laraguard\Eloquent\TwoFactorAuthentication $twoFactorAuth
 * @method static \Illuminate\Database\Eloquent\Builder|User admins()
 * @method static \Illuminate\Database\Eloquent\Builder|User allAccess()
 * @method static \Illuminate\Database\Eloquent\Builder|User byType($type)
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyActive()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyDeactivated()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User search($term)
 * @method static \Illuminate\Database\Eloquent\Builder|User users()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordChangedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereToBeLoggedOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail, \DarkGhostHunter\Laraguard\Contracts\TwoFactorAuthenticatable {}
}

namespace App\Models{
/**
 * App\Models\Conductore
 *
 * @property int $id
 * @property int $personas_id
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore wherePersonasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conductore whereUpdatedAt($value)
 */
	class Conductore extends \Eloquent {}
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

