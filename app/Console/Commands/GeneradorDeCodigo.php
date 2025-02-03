<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class GeneradorDeCodigo extends Command
{
    protected $signature = 'generar:crud {nombre} {--campos=}';
    protected $description = 'Genera un CRUD con modelo, migración, controlador, vista, JS y rutas';

    public function handle()
    {
        $nombre = ucfirst($this->argument('nombre')); // Capitaliza la primera letra
        $nombreLower = strtolower($nombre); // Minúsculas para rutas y archivos
        $campos = $this->option('campos') ?? 'nombre:string';

        $this->info("Generando código para: $nombre con campos: $campos...");

        // 1. Crear el modelo con una migración
        Artisan::call("make:model $nombre");

        // 2. Crear la migración con los campos definidos
        $this->crearMigracion($nombre, $nombreLower, $campos);

        // 3. Ejecutar las migraciones
        $this->ejecutarMigraciones($nombreLower);

        // 4. Crear el controlador con recursos
        Artisan::call("make:controller {$nombre}Controller");

        // 5. Crear la fábrica de datos
        Artisan::call("make:factory {$nombre}Factory --model=$nombre");

        // 6. Crear el seeder (opcional)
        Artisan::call("make:seeder {$nombre}Seeder");

        // 7. Crear la vista Blade
        $this->generarVistaBlade($nombre);

        // 8. Crear el archivo JS
        $this->generarArchivoJS($nombre, $nombreLower);

        // 9. Agregar métodos al controlador
        $this->agregarMetodosAlControlador($nombre, $nombreLower);

        // 10. Agregar rutas automáticamente
        $this->agregarRutas($nombre, $nombreLower);

        // 11. Limpiar y cachear las rutas
        $this->regenerarCacheRutas();
        
        // 12. Agregar métodos al modelo
        $this->agregarMetodosAlModelo($nombre, $nombreLower);

        // 13. Agregar métodos al modelo
        $this->crearProcedimiento($nombre, $nombreLower);

        $this->info("Vista y archivo JS creados correctamente.");
        $this->info("CRUD generado correctamente con migración y caché de rutas.");
    }

    private function crearProcedimiento($nombre, $nombreLower)
    {
        $tabla = \Str::snake(\Str::plural($nombre)); // Convierte el nombre a snake_case y pluraliza
        $camposArray = Schema::getColumnListing($tabla); // Obtiene las columnas de la tabla
        $camposFiltrados = [];

        // Generar lista de parámetros y excluir timestamps y soft deletes
        $parametros = [];
        $filtros = [];
        foreach ($camposArray as $campo) {
            if (!in_array($campo, ['created_at', 'updated_at', 'deleted_at'])) {
                $parametros[] = "p_$campo character varying";
                $camposFiltrados[] = "p.$campo";
                
                // Generar filtro dinámico
                $filtros[] = "IF p_$campo IS NOT NULL AND p_$campo <> '' THEN
                    v_where := v_where || ' AND p.$campo ILIKE ''%' || p_$campo || '%''';
                END IF;";
            }
        }

        // Agregar parámetros de paginación y cursor
        $parametros[] = "p_pagina character varying";
        $parametros[] = "p_limit character varying";
        $parametros[] = "p_ref refcursor";

        // Convertir las listas a cadenas separadas por comas
        $parametrosList = implode(",\n    ", $parametros);
        $camposList = implode(", ", $camposFiltrados);
        $filtrosList = implode("\n    ", $filtros);

        // Construcción del procedimiento almacenado
        $procedimiento = <<<SQL
    CREATE OR REPLACE FUNCTION sp_listar_{$nombreLower}_paginado(
        $parametrosList
    )
    RETURNS refcursor
    LANGUAGE plpgsql
    AS \$function\$

    DECLARE
        v_scad varchar;
        v_campos varchar;
        v_tabla varchar;
        v_where varchar;
        v_count varchar;
        v_col_count varchar;

    BEGIN
        -- Calcular el offset
        p_pagina = (p_pagina::Integer - 1) * p_limit::Integer;
        
        -- Definir los campos y la tabla
        v_campos = ' $camposList';
        v_tabla = ' FROM {$tabla} p';
        v_where = ' WHERE 1=1';

        -- Aplicar filtros dinámicamente
        $filtrosList

        -- Obtener la cantidad total de registros
        EXECUTE ('SELECT count(1) ' || v_tabla || v_where) INTO v_count;
        v_col_count := ' ,' || v_count || ' as TotalRows';

        -- Construcción de la consulta final
        IF v_count::Integer > p_limit::Integer THEN
            v_scad := 'SELECT ' || v_campos || v_col_count || v_tabla || v_where || ' ORDER BY p.id LIMIT ' || p_limit || ' OFFSET ' || p_pagina || ';';
        ELSE
            v_scad := 'SELECT ' || v_campos || v_col_count || v_tabla || v_where || ' ORDER BY p.id;';
        END IF;

        -- Ejecutar la consulta dinámica
        OPEN p_ref FOR EXECUTE(v_scad);
        RETURN p_ref;
    END

    \$function\$;
    SQL;

        // Ejecutar el procedimiento en la base de datos
        DB::unprepared($procedimiento);

        $this->info("Procedimiento almacenado `sp_listar_{$nombreLower}_paginado` creado con éxito.");
    }

    private function agregarMetodosAlModelo($nombre, $nombreLower)
    {
        $modeloPath = app_path("Models/{$nombre}.php");

        if (!File::exists($modeloPath)) {
            $this->error("Error: No se encontró el modelo {$nombre}.");
            return;
        }

        // Obtener el contenido actual del archivo del modelo
        $contenido = File::get($modeloPath);

        // Agregar `use DB;` si no está presente
        if (!preg_match('/\buse\s+DB;/', $contenido)) {
            // Insertamos `use DB;` después de la última declaración de `use`
            if (preg_match('/(use\s+[\w\\\]+;\s*)+(?!class)/', $contenido, $matches)) {
                $ultimoUse = $matches[0];
                $contenido = str_replace($ultimoUse, $ultimoUse . "use DB;\n", $contenido);
            } else {
                // Si no hay otras declaraciones de `use`, lo agregamos después del `namespace`
                $contenido = preg_replace('/(namespace\s+App\\\Models;)/', "$1\n\nuse DB;", $contenido, 1);
            }
        }

        // Métodos que queremos agregar al modelo
        $contenidoMetodos = <<<PHP

    // Método para obtener todos los {$nombreLower}s
    public function all_ajax(\$p)
    {
        return readFunctionPostgres('sp_listar_{$nombreLower}_paginado',\$p);
    }

PHP;

        // Verificamos si ya se han agregado estos métodos
        if (strpos($contenido, "public function all_ajax(\$p)") === false) {
            // Agregar los métodos antes del cierre de la clase
            $contenido = str_replace("}", $contenidoMetodos . "\n}", $contenido);
            File::put($modeloPath, $contenido);
            $this->info("Métodos agregados al modelo {$nombre}.");
        } else {
            $this->info("Los métodos ya fueron agregados al modelo {$nombre}.");
        }

    }

    private function crearMigracion($nombre, $nombreLower, $campos)
    {

        $nombreMigracion = "create_{$nombreLower}s_table";
        $migrationPath = database_path("migrations");

        // Verificar si ya existe una migración con el mismo nombre
        $migracionExistente = glob("{$migrationPath}/*_{$nombreMigracion}.php");

        if (count($migracionExistente) > 0) {
            $this->info("La migración '{$nombreMigracion}' ya existe.");
            return;
        }

        // Crear la migración
        Artisan::call("make:migration {$nombreMigracion}");
        
        // Obtener el archivo de la migración recién creada
        $migrationPath = glob(database_path('migrations/*_create_' . $nombreLower . 's_table.php'))[0] ?? null;

        if ($migrationPath) {
            $contenido = File::get($migrationPath);

            $schemaFields = '';
            $camposArray = explode(',', $campos);

            foreach ($camposArray as $campo) {
                [$nombreCampo, $tipo] = explode(':', $campo);
                
                // Manejo especial para decimal
                if ($tipo === 'decimal') {
                    $schemaFields .= "            \$table->$tipo('$nombreCampo', 8, 2);\n";
                } else {
                    $schemaFields .= "            \$table->$tipo('$nombreCampo');\n";
                }
            }

            // Estructura correcta del método up()
            $schema = <<<PHP
        public function up()
        {
            Schema::create('{$nombreLower}s', function (Blueprint \$table) {
                \$table->id();
    $schemaFields
                \$table->timestamps();
            });
        }
    PHP;

            // Buscamos la posición de la función `up()` y reemplazamos su contenido
            $posicionInicio = strpos($contenido, 'public function up()');
            if ($posicionInicio !== false) {
                $posicionFin = strpos($contenido, 'public function down()', $posicionInicio);
                if ($posicionFin !== false) {
                    $contenido = substr_replace($contenido, $schema, $posicionInicio, $posicionFin - $posicionInicio);
                }
            }

            File::put($migrationPath, $contenido);
        }
    }

    private function ejecutarMigraciones_($nombreLower)
    {
        $this->info("Ejecutando migraciones...");
        Artisan::call('migrate', [], $this->getOutput());
    }

    private function ejecutarMigraciones($nombreLower)
    {
        $migrationPath = database_path('migrations');
        $migrationFile = glob("{$migrationPath}/*_create_{$nombreLower}s_table.php");

        if (!empty($migrationFile)) {
            $relativePath = str_replace(base_path(), '', $migrationFile[0]);
            $this->info("Ejecutando migración: $relativePath...");
            Artisan::call('migrate', ['--path' => $relativePath]);
        } else {
            $this->info("No se encontró la migración para ejecutar.");
        }
    }

    private function generarVistaBlade($nombre)
    {
        $nombreLower = strtolower($nombre);
        $tabla = \Str::snake(\Str::plural($nombre)); // Convierte el nombre del modelo a un nombre de tabla
        $modeloPath = app_path("Models/{$nombre}.php");

        if (!File::exists($modeloPath)) {
            $this->error("Error: No se encontró el modelo {$nombre}.");
            return;
        }

        // Obtener los campos de la migración (es decir, de la tabla en la base de datos)
        if (!Schema::hasTable($tabla)) {
            $this->error("Error: No se encontró la tabla {$tabla} en la base de datos.");
            return;
        }

        $campos_tbl = Schema::getColumnListing($tabla); // Obtiene las columnas de la tabla

        // Excluir campos como 'id', 'created_at', 'updated_at', 'deleted_at'
        $campos = array_diff($campos_tbl, ['id', 'created_at', 'updated_at', 'deleted_at']);
        $campos_con_id = array_diff($campos_tbl, [/*'id', */'created_at', 'updated_at', 'deleted_at']);

        if (empty($campos)) {
            $this->error("No se encontraron columnas relevantes en la tabla {$tabla}.");
            return;
        }

        // Construcción dinámica de inputs
        $inputs = '';
        foreach ($campos as $campo) {
            $inputs .= <<<HTML
                <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12">
                    <input class="form-control form-control-sm" id="{$campo}_bus" name="{$campo}_bus" placeholder="{$campo}">
                </div>\n
    HTML;
        }

        // Construcción dinámica de las columnas de la tabla
        $columnasTabla = '';
        foreach ($campos as $campo) {
            $columnasTabla .= "<th>" . ucfirst($campo) . "</th>\n";
        }

        $contenido = <<<BLADE
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    @extends('backend.layouts.app')

    @section('breadcrumb')
    <ol class="breadcrumb" style="padding-left:130px;margin-top:0px;background-color:#283659">
        <li class="breadcrumb-item text-primary">Inicio</li>
        <li class="breadcrumb-item active">Consulta de {$nombre}</li>
    </ol>
    @endsection

    @section('content')

    <div class="loader"></div>

    <div class="justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0 text-primary">
                            Consulta de {$nombre}
                        </h4>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col col-sm-12 align-self-center">
                        <div class="card">
                            <div class="card-header">
                                <strong>
                                    Lista de {$nombre}
                                </strong>
                            </div>

                            <form class="form-horizontal" method="post" action="" id="frm{$nombre}" autocomplete="off">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

                                <div style="padding:20px 20px 0px 20px;">
                                    <div class="row">
                                        {$inputs}
                                        <div class="col-lg-2 col-md-1 col-sm-12 col-xs-12" style="padding-right:0px">
                                            <input class="btn btn-warning" value="Buscar" type="button" id="btnBuscar" />
                                            <input class="btn btn-success" value="Nuevo" type="button" id="btnNuevo" style="margin-left:15px"/>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="card-body">    
                                <div class="table-responsive">
                                    <table id="tbl{$nombre}" class="table table-hover table-sm">
                                        <thead>
                                            <tr style="font-size:13px">
                                                <th>Id</th>
                                                {$columnasTabla}
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    @endsection

    <div id="openOverlayOpc" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div id="id_content_OverlayoneOpc" class="modal-content" style="padding: 0px;margin: 0px">
        <div class="modal-body" style="padding: 0px;margin: 0px">
            <div id="diveditpregOpc"></div>
        </div>
        </div>
    </div>
    </div>

    @push('after-scripts')
    <script src="{{ asset('js/{$nombreLower}/{$nombreLower}.js') }}"></script>
    @endpush
    BLADE;

        // Guardar la vista en la carpeta resources/views/{nombreLower}/index.blade.php
        $rutaVista = resource_path("views/{$nombreLower}/all.blade.php");
        File::ensureDirectoryExists(dirname($rutaVista));
        File::put($rutaVista, $contenido);


        // Inputs dinámicos
        $inputs = '';
        foreach ($campos as $campo) {
            $inputs .= <<<HTML
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="control-label">{$campo}</label>
                        <input class="form-control form-control-sm" id="{$campo}" name="{$campo}" value="{{ \${$nombreLower}->{$campo} }}" placeholder="{$campo}">
                    </div>
                </div>
            HTML;
        }

        // Generar dinámicamente los inputs en `extraData`
        //$extraDataJS = implode(",\n\t\t\t", array_map(fn($campo) => "{$campo}: $('#{$campo}').val()", $campos));
        $extraDataJS = "{\n\t\t\t" . implode(",\n\t\t\t", array_map(fn($campo) => "'{$campo}': $('#{$campo}').val()", $campos_con_id)) . "\n\t\t}";
        // Vista del modal
        $contenidoBlade = <<<BLADE
<title>Sistema</title>
<style>
</style>
<script type="text/javascript">
$(document).ready(function () {
});
function fn_save(){
    save_modal({
        sAjaxSource: "/{$nombreLower}/send",
        extraData: {$extraDataJS}
    });
}
</script>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="panel-heading close-heading">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>

    <div>
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header" style="padding:5px!important;padding-left:20px!important; font-weight: bold">
                    Registro {$nombre}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-top:5px;padding-bottom:20px">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id" value="{{ \$id }}">
                            
                            <div class="row" style="padding:0px,10px,0px,10px">
                                {$inputs} <!-- Campos dinámicos -->
                            </div>
                            
                            <div style="margin-top:15px" class="form-group">
                                <div class="col-sm-12 controls">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Log Viewer Actions">
                                        <a href="javascript:void(0)" onClick="fn_save()" class="btn btn-sm btn-success">Guardar</a>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
BLADE;

        $rutaVista = resource_path("views/{$nombreLower}/modal.blade.php");
        File::ensureDirectoryExists(dirname($rutaVista));
        File::put($rutaVista, $contenidoBlade);
        
        $this->info("Vista Blade generada correctamente en: resources/views/{$nombreLower}/all.blade.php");
    }

    private function generarArchivoJS($nombre, $nombreLower)
    {
        $jsPath = public_path("js/{$nombreLower}");
        if (!File::exists($jsPath)) {
            File::makeDirectory($jsPath, 0777, true, true);
        }

        $jsFile = "{$jsPath}/{$nombreLower}.js";

        // Obtener el nombre de la tabla desde el modelo
        $tabla = \Str::snake(\Str::plural($nombre)); // Convierte `Producto` en `productos`

        // Obtener los campos de la tabla
        if (!Schema::hasTable($tabla)) {
            $this->error("Error: No se encontró la tabla '{$tabla}' en la base de datos.");
            return;
        }

        $camposArray = Schema::getColumnListing($tabla);
        $camposArray = array_diff($camposArray, [/*'id', */'created_at', 'updated_at', 'deleted_at']); // Excluir estos campos innecesarios

        if (empty($camposArray)) {
            $this->error("No se encontraron columnas relevantes en la tabla '{$tabla}'.");
            return;
        }

        // Generar dinámicamente los inputs en `extraData`
        $extraDataJS = implode(",\n\t\t\t", array_map(fn($campo) => "{$campo}: $('#{$campo}_bus').val()", $camposArray));

        // Generar dinámicamente las columnas en `columns`
        $columnsJS = "'" . implode("',\n\t\t\t'", $camposArray) . "'";

        // Contenido dinámico del archivo JS
        $contenidoJS = <<<JS
    $(document).ready(function () {
        $('#btnBuscar').click(function () {
            fn_ListarBusqueda();
        });
        $('#btnNuevo').click(function () {
            fn_modal(0);
        });
        fn_ListarBusqueda();
    });

    function fn_modal(id){
        modal({
            sAjaxSource: "/{$nombreLower}/modal/"+id,
        });
    }

    function fn_eliminar(id,estado){
        if(estado==1)estado_=0;
        if(estado==0)estado_=1;
        eliminar({
            estado : estado,
            sAjaxSource: "/{$nombreLower}/eliminar/"+id+"/"+estado_,
        });
    }

    function fn_ListarBusqueda() {
        datatablenew({
            tabla: "tbl{$nombre}",
            sAjaxSource: "/{$nombreLower}/all_ajax",
            extraData: {
                $extraDataJS
            },
            columns: [
                $columnsJS
            ]
        });
    };
    JS;

        // Guardar el archivo JS si no existe
        if (!File::exists($jsFile)) {
            File::put($jsFile, $contenidoJS);
            $this->info("Archivo JS generado: {$jsFile}");
        } else {
            $this->info("El archivo JS ya existe: {$jsFile}");
        }
    }

    private function agregarMetodosAlControlador($nombre, $nombreLower)
    {
        $controllerPath = app_path("Http/Controllers/{$nombre}Controller.php");

        if (!File::exists($controllerPath)) {
            $this->error("Error: No se encontró el controlador {$nombre}Controller.");
            return;
        }

        // Obtener el nombre de la tabla desde el modelo
        $tabla = \Str::snake(\Str::plural($nombre)); // Convierte `Producto` en `productos`

        // Obtener los campos de la tabla
        if (!Schema::hasTable($tabla)) {
            $this->error("Error: No se encontró la tabla '{$tabla}' en la base de datos.");
            return;
        }

        $camposArray = Schema::getColumnListing($tabla); // Lista de columnas en la tabla
        $camposArray = array_diff($camposArray, [/*'id',*/'created_at', 'updated_at', 'deleted_at']); // Excluir estos campos

        if (empty($camposArray)) {
            $this->error("No se encontraron columnas relevantes en la tabla '{$tabla}'.");
            return;
        }

        // Construcción dinámica de asignaciones para $p
        $parametros = implode("\n\t\t", array_map(fn($campo) => "\$p[] = \$request->$campo;", $camposArray));

        // Código de la función `all_ajax` con campos dinámicos
        $contenidoAllAjax = <<<PHP
        public function all_ajax(Request \$request)
        {
            \$modelo = new {$nombre};
            $parametros
            \$p[] = \$request->NumeroPagina;
            \$p[] = \$request->NumeroRegistros;
            \$data = \$modelo->all_ajax(\$p);
            \$iTotalDisplayRecords = isset(\$data[0]->totalrows) ? \$data[0]->totalrows : 0;

            \$result = [
                "PageStart" => \$request->NumeroPagina,
                "pageSize" => \$request->NumeroRegistros,
                "SearchText" => "",
                "ShowChildren" => true,
                "iTotalRecords" => \$iTotalDisplayRecords,
                "iTotalDisplayRecords" => \$iTotalDisplayRecords,
                "aaData" => \$data
            ];

            return response()->json(\$result);
        }
    PHP;

    
        $camposArray = array_diff($camposArray, ['id',]); // Excluir estos campos
        // Construcción dinámica de send
        $parametros_send = implode("\n\t\t", array_map(fn($campo) => "\$modelo->$campo = \$request->$campo;", $camposArray));

        // Código de los demás métodos
        $contenidoMetodos = <<<PHP

        public function index()
        {
            return view('{$nombreLower}.index');
        }

        public function all()
        {
            return view('{$nombreLower}.all');
        }

        public function modal(\$id)
        {
            if (\$id > 0) {
                \${$nombreLower} = {$nombre}::find(\$id);
            } else {
                \${$nombreLower} = new {$nombre};
            }
            return view('{$nombreLower}.modal',compact('id','{$nombreLower}'));
        }

        public function send(Request \$request)
        {
            if (\$request->id == 0) {
                \$modelo = new {$nombre};
            } else {
                \$modelo = {$nombre}::find(\$request->id);
                
                if (!\$modelo) {
                    return response()->json(['error' => 'Registro no encontrado'], 404);
                }

            }
            $parametros_send
            \$modelo->save();
            return response()->json(['success' => true, 'message' => 'Registro guardado correctamente.']);
        }

        public function eliminar(\$id, \$estado)
        {
            \$modelo = {$nombre}::find(\$id);
            \$modelo->estado = \$estado;
            \$modelo->save();
            return response()->json(['success' => true, 'message' => 'Registro elimino correctamente.']);
        }

    PHP;

        $contenido = File::get($controllerPath);

        // Agregar `use App\Models\Categoria;` si no está presente
        if (!preg_match('/\buse\s+App\\\Models\\\'.$nombre.\';/', $contenido)) {
            // Insertamos `use App\Models\Categoria;` después de la última declaración de `use`
            if (preg_match('/(use\s+[\w\\\]+;\s*)+(?!class)/', $contenido, $matches)) {
                $ultimoUse = $matches[0];
                $contenido = str_replace($ultimoUse, $ultimoUse . "use App\Models\\{$nombre};\n", $contenido);
            } else {
                // Si no hay otras declaraciones de `use`, lo agregamos después del `namespace`
                $contenido = preg_replace('/(namespace\s+App\\\Models;)/', "$1\n\nuse App\Models\\{$nombre};", $contenido, 1);
            }
        }
        
        // Agregar `all_ajax` si no existe en el controlador
        if (strpos($contenido, "public function all_ajax(") === false) {
            $contenidoMetodos = $contenidoAllAjax . "\n" . $contenidoMetodos;
        }
        
        if (strpos($contenido, "public function index()") === false) {
            // Agregar los métodos antes del cierre de la clase
            $contenido = str_replace("}", $contenidoMetodos . "\n}", $contenido);
            File::put($controllerPath, $contenido);
            $this->info("Métodos agregados al controlador {$nombre}Controller.");
        } else {
            $this->info("Los métodos ya existen en {$nombre}Controller.");
        }
    }

    private function agregarRutas($nombre, $nombreLower)
    {
        $rutaArchivo = base_path("routes/web.php");

        $contenidoRuta = "\n// Rutas para {$nombre}\n";
        $contenidoRuta .= "Route::get('/{$nombreLower}', [\App\Http\Controllers\\{$nombre}Controller::class, 'index'])->name('{$nombreLower}.index');\n";
        $contenidoRuta .= "Route::get('/{$nombreLower}/all', [\App\Http\Controllers\\{$nombre}Controller::class, 'all'])->name('{$nombreLower}.all');\n";
        $contenidoRuta .= "Route::post('/{$nombreLower}/all_ajax', [\App\Http\Controllers\\{$nombre}Controller::class, 'all_ajax'])->name('{$nombreLower}.all_ajax');\n";
        $contenidoRuta .= "Route::get('/{$nombreLower}/modal/{id}', [\App\Http\Controllers\\{$nombre}Controller::class, 'modal'])->name('{$nombreLower}.modal');\n";
        $contenidoRuta .= "Route::post('/{$nombreLower}/send', [\App\Http\Controllers\\{$nombre}Controller::class, 'send'])->name('{$nombreLower}.send');\n";
        $contenidoRuta .= "Route::get('/{$nombreLower}/eliminar/{id}/{estado}', [\App\Http\Controllers\\{$nombre}Controller::class, 'eliminar'])->name('{$nombreLower}.eliminar');\n";

        $contenido = File::get($rutaArchivo);

        if (strpos($contenido, "Route::get('/{$nombreLower}',") === false) {
            File::append($rutaArchivo, $contenidoRuta);
        }
    }

    private function regenerarCacheRutas()
    {
        $this->info("Limpiando caché de rutas...");
        Artisan::call('route:clear');

        $this->info("Generando caché de rutas...");
        Artisan::call('route:cache');

        $this->info("Caché de rutas actualizada con éxito.");
    }

}
