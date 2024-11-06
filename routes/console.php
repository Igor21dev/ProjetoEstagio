<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('importar-dados-xml', function () {
    $this->call('app:importar-dados-xml'); 
})->purpose('Importar dados XML')->everyMinute();
