<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\ActivoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CambiarVigenciaSoatAutomaticoCron extends Command
{
    
    protected $signature = 'cambiarVigenciaSoatAutomatico:cron';

    protected $description = 'Ejecuta la funcion cambiarVigenciaSoat';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\ActivoController');
        app()->call([$controller, 'cambiarVigenciaSoat']);
		
		$log = ['metodo' => "cambiarVigenciaSoatAutomatico:cron", 'description' => "Ejecuta la funcion cambiarVigenciaSoat"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
