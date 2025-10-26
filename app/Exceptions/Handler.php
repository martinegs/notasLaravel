<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * Manejador de excepciones del sistema de gestión de tareas pendientes.
 * @author Martin Gonzalez
 * @version 1.0.0
 */
class Handler extends ExceptionHandler
{
    /**
     * Lista de tipos de excepciones con sus niveles de log personalizados.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * Lista de tipos de excepciones que no se reportan.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * Lista de los campos que nunca se mostrarán en la sesión en excepciones de validación.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registra los callbacks para el manejo de excepciones de la aplicación.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
