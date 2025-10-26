<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Genera un conjunto de tareas de ejemplo para demostración y pruebas.
     *
     * @return void
     */
    public function run()
    {
        // Crear 10 tareas pendientes
        Task::factory()->count(10)->pendiente()->create();

        // Crear 5 tareas completadas
        Task::factory()->count(5)->completada()->create();

        // Crear 3 tareas vencidas
        Task::factory()->count(3)->vencida()->create();

        // Mensaje de confirmación
        $this->command->info('✅ Se han creado 18 tareas de ejemplo exitosamente.');
    }
}
