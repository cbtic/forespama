<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\RequerimientoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class obtenerTipoCambioDiarioAutomaticoCron extends Command
{
    
    protected $signature = 'obtenerTipoCambioDiarioAutomatico:cron';

    protected $description = 'Ejecuta la funcion obtenerTipoCambioDiario';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\TipoCambioController');
        app()->call([$controller, 'obtenerTipoCambioDiario']);
		
		$log = ['metodo' => "obtenerTipoCambioDiarioAutomatico:cron", 'description' => "Ejecuta la funcion obtenerTipoCambioDiario"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
