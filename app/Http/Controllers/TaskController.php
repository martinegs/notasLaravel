<?php

/**
 * Sistema de Gestión de Tareas Pendientes
 * 
 * @author Martin Gonzalez
 * @version 1.0.0
 */

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'completada') {
                $query->where('completada', true);
            } elseif ($request->estado === 'pendiente') {
                $query->where('completada', false);
            }
        }

        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        $query->orderBy($sortBy, $sortOrder);

        $tareas = $query->paginate(10)->withQueryString();
        
        return view('tasks.index', compact('tareas'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(TaskRequest $request)
    {
        Task::create($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada exitosamente');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada exitosamente');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente');
    }

    public function toggleComplete(Task $task)
    {
        $task->update(['completada' => !$task->completada]);

        return redirect()->route('tasks.index')
            ->with('success', 'Estado de tarea actualizado');
    }
}
