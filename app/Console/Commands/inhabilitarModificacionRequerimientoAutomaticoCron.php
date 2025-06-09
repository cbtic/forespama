<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\RequerimientoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class inhabilitarModificacionRequerimientoAutomaticoCron extends Command
{
    
    protected $signature = 'inhabilitarModificacionRequerimientoAutomatico:cron';

    protected $description = 'Ejecuta la funcion inhabilitarModificacionRequerimiento';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\RequerimientoController');
        app()->call([$controller, 'inhabilitarModificacionRequerimiento']);
		
		$log = ['metodo' => "inhabilitarModificacionRequerimientoAutomatico:cron", 'description' => "Ejecuta la funcion inhabilitarModificacionRequerimiento"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
