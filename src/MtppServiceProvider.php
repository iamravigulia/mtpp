<?php

namespace edgewizz\mtpp;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class MtppServiceProvider extends ServiceProvider{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        $this->app->make('Edgewizz\Mtpp\Controllers\MtppController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        // dd($this);
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__ . '/components', 'mtpp');
        Blade::component('mtpp::mtpp.open', 'mtpp.open');
        Blade::component('mtpp::mtpp.index', 'mtpp.index');
        Blade::component('mtpp::mtpp.edit', 'mtpp.edit');
    }
}