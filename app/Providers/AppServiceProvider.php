<?php

/**
 * Sistema de Gestión de Tareas Pendientes
 * 
 * @author Martin Gonzalez
 * @version 1.0.0
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Paginator::useBootstrapFive();
    }
}
