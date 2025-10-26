<?php

/**
 * Sistema de Gestión de Tareas Pendientes
 * 
 * @author Martin Gonzalez
 * @version 1.0.0
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'completada' => ['nullable', 'boolean'],
            'fecha_vencimiento' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'El título de la tarea es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'fecha_vencimiento.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'fecha_vencimiento.after_or_equal' => 'La fecha de vencimiento no puede ser anterior a hoy.',
        ];
    }

    public function attributes()
    {
        return [
            'titulo' => 'título',
            'descripcion' => 'descripción',
            'completada' => 'estado completada',
            'fecha_vencimiento' => 'fecha de vencimiento',
        ];
    }
}
