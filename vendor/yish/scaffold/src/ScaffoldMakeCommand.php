<?php

namespace Yish\Scaffold;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Schema;
use Symfony\Component\Console\Input\InputInterface;

class ScaffoldMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:scaffold {class} {fields*}
    {--route= : Append to specific route file, default is web.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make scaffolding resource.';

    private $config;

    public function __construct($config)
    {
        $this->config = $config;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->createRequest();
        $this->createModel();

        $dir = "database/migrations";

        $newest_migration = $this->last_file($dir);

        $ruta_migracion = $dir . '/' . $newest_migration;

        $f=fopen($ruta_migracion, 'r+');

        $contenido = file_get_contents($ruta_migracion);
        $array_fields = $this->argument('fields');

        foreach(array_reverse($array_fields) as $field) {
            $split_content = explode('$table->id();', $contenido);
            $column = explode(":", $field);
            $modificadores_array = array("u" => "unsigned", "i" => "index", "U" => "unique", "n" => "nullable", "c" => "comment");

            switch (count($column)) {
                case 5:
                    $modificadores = str_split($column[4]);
                    $insertar_modificadores="";
                    foreach ($modificadores as $modificador) {
                        $insertar_modificadores.="->".$modificadores_array[$modificador]."()";
                    }
                    if ($column[2]=="" && $column[3]!="") {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\')->default('.$column[3].')'.$insertar_modificadores.';';
                    } elseif ($column[2]=="" && $column[3]=="") {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\')'.$insertar_modificadores.';';
                    } elseif ($column[2]!="" && $column[3]=="") {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\', '.$column[2].')'.$insertar_modificadores.';';
                    } else {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\', '.$column[2].')->default('.$column[3].')'.$insertar_modificadores.';';
                    }
                    break;
                case 4:
                    if ($column[2]=="") {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\')->default('.$column[3].');';
                    } else {
                        $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\', '.$column[2].')->default('.$column[3].');';
                    }
                    break;
                case 3:
                    $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\', '.$column[2].');';
                    break;
                case 2:
                    $insertar='            $table->'.$column[1].'(\'' . $column[0] . '\');';
                    break;
                default:
                    $insertar='            $table->string(\'' . $column[0] . '\');';
                    break;
            }

            $contenido=$split_content[0].'$table->id();'.PHP_EOL.$insertar.$split_content[1];
        }
        fwrite($f, $contenido);

        $this->ask('Revisar migration (Enter para continuar): '.$ruta_migracion);

        exec('php artisan migrate');

        $this->updateDummyNameController();

        $this->createViews();

        $this->insertFactories();

        $this->appendRouteFile();
    }

    protected function makeViews($view)
    {
        $name = Str::plural(Str::snake(class_basename($this->argument('class'))));

        $creating = file_get_contents(__DIR__ . '/stubs/' . $view . '.blade.stub');
        $array_fields = array_reverse(array_diff(Schema::getColumnListing($name), ["created_at", "updated_at"]));
        $html_fields = '';

        foreach ($array_fields as $field) {
            $html_fields .= '                                <x-form-input name="' . $field . '" label="' . $field . '" />'.PHP_EOL;
        }

        if (! is_dir(base_path('resources/views/' . $name))) {
            mkdir(base_path('resources/views/' . $name));
        }

        touch(base_path('resources/views/' . $name . '/' . $view . '.blade.php'));

        $cstep2 = str_replace("PluralSnakeClass", $name, $creating);
        $cstep3 = str_replace("SnakeClass", Str::snake(class_basename($this->argument('class'))), $cstep2);
        $cstep4 = str_replace("FormFields", $html_fields, $cstep3);
        $created = str_replace("DummyClass", $this->argument('class'), $cstep4);

        file_put_contents(base_path('resources/views/' . $name . '/' . $view . '.blade.php'), $created);
    }

    /**
     * @deprecated
     */
    protected function createFactory()
    {
        $this->call('make:factory', [
            'name' => $this->argument('class').'Factory',
            '--model' => $this->argument('class'),
        ]);
    }

    /**
     * @deprecated
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('class'))));


        // $this->call('make:migration', [
        //     'name' => "create_{$table}_table".$this->argument('fields'),
        //     '--create' => $table,
        // ]);

        $output = shell_exec('php artisan make:migration create_'.$table.'_table --create='.$table);
        // print_r($this->argument('fields'));
    }

    /**
     * @deprecated
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('class')));

        $this->call('make:controller', [
            'name' => "{$controller}Controller",
            '-r' => true,
        ]);
    }

    protected function createModel()
    {
        // $array_fields = $this->argument('fields');

        $this->call('make:model', [
            'name' => $this->argument('class'),
            '--all' => true,
        ]);

        // exit(print_r($array_fields));
    }

    protected function createRequest()
    {
        $request = Str::studly(class_basename($this->argument('class')));

        $this->call('make:request', [
            'name' => "{$request}Request"
        ]);
    }

    protected function updateDummyNameController()
    {
        $name = Str::plural(Str::snake(class_basename($this->argument('class'))));

        // Listado de campos del Modelo/Schema.
        $array_fields = array_reverse(array_diff(Schema::getColumnListing($name), ["created_at", "updated_at"]));
        $validate_data_fields = '';
        $create_data_fields = '';

        foreach ($array_fields as $field) {
            $validate_data_fields .= '                                \'' . $field . '\' => \'required\','.PHP_EOL;
            $create_data_fields .= '                                \'' . $field . '\' => request()->post(\'' . $field . '\'),'.PHP_EOL;
        }

        // taking scaffold stub.
        $source = file_get_contents(__DIR__ . '/stubs/controller.scaffold.stub');

        // replace dummy name.
        $step1 = str_replace("DummyProp", Str::snake(class_basename($this->argument('class'))), $source);
        $step2 = str_replace("DummyLowerClass", $name, $step1);
        $step3 = str_replace("DummyClass", $this->argument('class'), $step2);
        $step4 = str_replace("ValidateDataFields", $validate_data_fields, $step3);
        $step5 = str_replace("CreateDataFields", $create_data_fields, $step4);


        // put in controller
        $controller = Str::studly(class_basename($this->argument('class')));
        file_put_contents(base_path($this->config['path']['controller'] . '/' . "{$controller}Controller.php"), $step5);
    }

    protected function createViews()
    {
        $this->makeViews('create');
        $this->makeViews('show');
        $this->makeViews('edit');
        $this->makeViews('index');
    }

    protected function appendRouteFile()
    {
        $name = Str::plural(Str::snake(class_basename($this->argument('class'))));
        $controller = Str::studly(class_basename($this->argument('class')));

        $rroute_stub = file_get_contents(__DIR__ . '/stubs/routes.stub');
        $rstep2 = str_replace("PluralSnakeClass", $name, $rroute_stub);
        $route_stub = str_replace("ControllerClass", "{$controller}Controller", $rstep2);

        file_put_contents(
            base_path('routes/' . ($this->option('route') ?: 'web') . '.php'),
            $route_stub,
            FILE_APPEND
        );
    }

    protected function insertFactories()
    {
        $dir = "database/factories";

        $newest_factory = $this->last_file($dir);

        $ruta_factory = $dir . '/' . $newest_factory;

        $f=fopen($ruta_factory, 'r+');

        $contenido = file_get_contents($ruta_factory);

        $array_fields = $this->argument('fields');

        foreach(array_reverse($array_fields) as $field) {
            $split_content = explode('//', $contenido);
            $column = explode(":", $field);
            $insertar='            \''.$column[0].'\' => $this->faker->' . $column[1] .',';
            $contenido=$split_content[0].'//'.PHP_EOL.$insertar.$split_content[1];
        }

        fwrite($f, $contenido);
    }

    protected function last_file(String $dir) {
        $latest = array(); $latest["time"] = 0;
        foreach (array_diff(scandir($dir), array(".", "..")) AS $file) {
            if (filemtime($dir."/".$file) > $latest["time"]) {
                $latest["file"] = $file;
                $latest["time"] = filemtime($dir."/".$file);
            }
        }
        return $latest["file"];
    }
}
