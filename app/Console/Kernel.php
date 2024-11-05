<?php

namespace App\Console;

use App;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands;
use App\Console\Commands\ImportarDadosXml;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        ImportarDadosXml::class,
    ];

    protected function schedule(Schedule $schedule){

        $schedule->command('app:importar-dados-xml')->everyMinute();
        
    }

    //protected function schedule(Schedule $schedule)
    //{
    //    $schedule->command('app:importar-dados-xml')->everyMinute();
    //}

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
    
}   
