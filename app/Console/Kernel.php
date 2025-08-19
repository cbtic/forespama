<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\inhabilitarModificacionRequerimientoAutomaticoCron::class,
        Commands\obtenerTipoCambioDiarioAutomaticoCron::class,
        Commands\CambiarVigenciaRevisionTecnicaAutomaticoCron::class,
        Commands\CambiarVigenciaSoatAutomaticoCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inhabilitarModificacionRequerimientoAutomatico:cron')->dailyAt('22:00');
        $schedule->command('obtenerTipoCambioDiarioAutomatico:cron')->dailyAt('06:00');
        $schedule->command('CambiarVigenciaRevisionTecnicaAutomatico:cron')->dailyAt('05:00');
        $schedule->command('cambiarVigenciaSoatAutomatico:cron')->dailyAt('05:00');
        $schedule->command('comprometerStockTotalAutomatico:cron')->dailyAt('18:07');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
