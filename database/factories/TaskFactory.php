<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tareas = [
            'Revisar correos electrónicos',
            'Preparar presentación del proyecto',
            'Llamar al cliente',
            'Actualizar documentación',
            'Realizar backup de la base de datos',
            'Revisar pull requests',
            'Planificar sprint de la semana',
            'Estudiar nuevo framework',
            'Comprar material de oficina',
            'Organizar reunión de equipo',
            'Escribir artículo del blog',
            'Actualizar dependencias del proyecto',
            'Revisar métricas de rendimiento',
            'Preparar informe mensual',
            'Contactar con proveedores'
        ];

        $descripciones = [
            'Tarea importante que requiere atención inmediata.',
            'Actividad programada para completar esta semana.',
            'Pendiente de seguimiento y actualización.',
            'Requiere coordinación con el equipo de trabajo.',
            'Tarea de alta prioridad para el proyecto actual.',
            null, // Algunas tareas sin descripción
            'Recordatorio para completar antes del viernes.',
            'Actividad que debe completarse en las próximas 48 horas.',
        ];

        return [
            'titulo' => fake()->randomElement($tareas),
            'descripcion' => fake()->randomElement($descripciones),
            'completada' => fake()->boolean(30), // 30% de probabilidad de estar completada
            'fecha_vencimiento' => fake()->optional(0.7)->dateTimeBetween('now', '+30 days'),
            'created_at' => fake()->dateTimeBetween('-60 days', 'now'),
        ];
    }

    /**
     * Indicar que la tarea debe estar completada.
     */
    public function completada()
    {
        return $this->state(function (array $attributes) {
            return [
                'completada' => true,
            ];
        });
    }

    /**
     * Indicar que la tarea debe estar pendiente.
     */
    public function pendiente()
    {
        return $this->state(function (array $attributes) {
            return [
                'completada' => false,
            ];
        });
    }

    /**
     * Indicar que la tarea está vencida.
     */
    public function vencida()
    {
        return $this->state(function (array $attributes) {
            return [
                'completada' => false,
                'fecha_vencimiento' => fake()->dateTimeBetween('-30 days', '-1 days'),
            ];
        });
    }
}
