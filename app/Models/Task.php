<?php

/**
 * Sistema de Gestión de Tareas Pendientes
 * 
 * @author Martin Gonzalez
 * @version 1.0.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'completada',
        'fecha_vencimiento'
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_vencimiento' => 'date'
    ];

    public function scopeCompletadas($query)
    {
        return $query->where('completada', true);
    }

    public function scopePendientes($query)
    {
        return $query->where('completada', false);
    }

    public function scopeVencidas($query)
    {
        return $query->where('completada', false)
            ->whereNotNull('fecha_vencimiento')
            ->whereDate('fecha_vencimiento', '<', now());
    }
}
