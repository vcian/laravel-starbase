<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\MakeFeatureScaffoldCommand;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('make:feature-scaffold', function () {
    $this->call(MakeFeatureScaffoldCommand::class);
})->purpose('Create a feature scaffold for a model');
