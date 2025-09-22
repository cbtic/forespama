<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\OrdenCompraController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ComprometerStockTotalAutomaticoCron extends Command
{
    
    protected $signature = 'comprometerStockTotalAutomatico:cron';

    protected $description = 'Ejecuta la funcion comprometerStockTotalAutomatico';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\OrdenCompraController');
        app()->call([$controller, 'comprometerStockTotalAutomatico']);
		
		$log = ['metodo' => "comprometerStockTotalAutomatico:cron", 'description' => "Ejecuta la funcion comprometerStockTotalAutomatico"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
