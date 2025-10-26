<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * Middleware para permitir ciertas URIs durante el modo mantenimiento.
 * @author Martin Gonzalez
 * @version 1.0.0
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Las URIs que deben ser accesibles mientras el modo mantenimiento está habilitado.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
