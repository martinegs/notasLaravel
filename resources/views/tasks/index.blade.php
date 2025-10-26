@extends('layouts.app')

@section('title', 'Dashboard - Mis Tareas')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="display-5 fw-bold text-white mb-2">
                    <i class="bi bi-kanban"></i> Dashboard de Tareas
                </h1>
                <p class="text-white-50 mb-0">Gestiona y organiza tus tareas pendientes de manera eficiente</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="btn btn-light btn-lg shadow-sm">
                <i class="bi bi-plus-circle me-2"></i> Nueva Tarea
            </a>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <small class="text-uppercase">Total de Tareas</small>
                    <h3 class="mt-2">{{ \App\Models\Task::count() }}</h3>
                </div>
                <div class="opacity-50">
                    <i class="bi bi-list-task" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <small class="text-uppercase">Pendientes</small>
                    <h3 class="mt-2">{{ \App\Models\Task::where('completada', false)->count() }}</h3>
                </div>
                <div class="opacity-50">
                    <i class="bi bi-hourglass-split" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <small class="text-uppercase">Completadas</small>
                    <h3 class="mt-2">{{ \App\Models\Task::where('completada', true)->count() }}</h3>
                </div>
                <div class="opacity-50">
                    <i class="bi bi-check-circle" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="stats-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <small class="text-uppercase">Vencidas</small>
                    <h3 class="mt-2">
                        {{ \App\Models\Task::where('completada', false)
                            ->whereNotNull('fecha_vencimiento')
                            ->whereDate('fecha_vencimiento', '<', now())
                            ->count() 
                        }}
                    </h3>
                </div>
                <div class="opacity-50">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-funnel me-2"></i>Filtros y Búsqueda
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tasks.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label fw-semibold">
                                <i class="bi bi-search me-1"></i> Buscar Tarea
                            </label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg" 
                                id="search" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Escribe el título..."
                            >
                        </div>
                        
                        <div class="col-md-3">
                            <label for="estado" class="form-label fw-semibold">
                                <i class="bi bi-filter me-1"></i> Estado
                            </label>
                            <select class="form-select form-select-lg" id="estado" name="estado">
                                <option value="">Todas las tareas</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>
                                    <i class="bi bi-circle"></i> Pendientes
                                </option>
                                <option value="completada" {{ request('estado') == 'completada' ? 'selected' : '' }}>
                                    Completadas
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="sort" class="form-label fw-semibold">
                                <i class="bi bi-sort-down me-1"></i> Ordenar por
                            </label>
                            <select class="form-select form-select-lg" id="sort" name="sort">
                                <option value="created_at" {{ request('sort', 'created_at') == 'created_at' ? 'selected' : '' }}>
                                    Más recientes
                                </option>
                                <option value="titulo" {{ request('sort') == 'titulo' ? 'selected' : '' }}>
                                    Alfabético (A-Z)
                                </option>
                                <option value="fecha_vencimiento" {{ request('sort') == 'fecha_vencimiento' ? 'selected' : '' }}>
                                    Fecha de vencimiento
                                </option>
                            </select>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label d-block">&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-search me-2"></i> Aplicar
                            </button>
                        </div>
                    </div>
                    
                    @if(request()->hasAny(['search', 'estado', 'sort']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Limpiar Filtros
                                </a>
                                <span class="badge bg-primary ms-2">
                                    {{ $tareas->total() }} resultado(s) encontrado(s)
                                </span>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>


@if($tareas->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-white mb-3 fw-semibold">
                <i class="bi bi-list-check me-2"></i>Mis Tareas ({{ $tareas->total() }})
            </h5>
        </div>
    </div>

    <div class="row">
        @foreach($tareas as $tarea)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="task-card {{ $tarea->completada ? 'completed' : ($tarea->fecha_vencimiento && $tarea->fecha_vencimiento->isPast() && !$tarea->completada ? 'overdue' : 'pending') }} h-100">
                    <div class="card-body p-4">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0 {{ $tarea->completada ? 'task-completed' : '' }}" style="flex: 1;">
                                {{ $tarea->titulo }}
                            </h5>
                            @if($tarea->completada)
                                <span class="badge bg-success ms-2">
                                    <i class="bi bi-check-circle"></i> Completada
                                </span>
                            @elseif($tarea->fecha_vencimiento && $tarea->fecha_vencimiento->isPast())
                                <span class="badge bg-danger ms-2">
                                    <i class="bi bi-exclamation-triangle"></i> Vencida
                                </span>
                            @else
                                <span class="badge bg-warning text-dark ms-2">
                                    <i class="bi bi-clock"></i> Pendiente
                                </span>
                            @endif
                        </div>

                        
                        @if($tarea->descripcion)
                            <p class="card-text text-muted {{ $tarea->completada ? 'task-completed' : '' }} mb-3">
                                {{ Str::limit($tarea->descripcion, 120) }}
                            </p>
                        @endif

                        
                        <div class="mb-3">
                            @if($tarea->fecha_vencimiento)
                                <div class="d-flex align-items-center text-muted mb-2">
                                    <i class="bi bi-calendar-event me-2"></i>
                                    <small>
                                        Vence: 
                                        <span class="{{ $tarea->fecha_vencimiento->isPast() && !$tarea->completada ? 'text-danger fw-bold' : '' }}">
                                            {{ $tarea->fecha_vencimiento->format('d/m/Y') }}
                                        </span>
                                    </small>
                                </div>
                            @endif
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-clock-history me-2"></i>
                                <small>Creada {{ $tarea->created_at->diffForHumans() }}</small>
                            </div>
                        </div>

                        
                        <div class="d-flex flex-wrap gap-2">
                            <form action="{{ route('tasks.toggle', $tarea) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm w-100 {{ $tarea->completada ? 'btn-outline-secondary' : 'btn-success' }}" data-bs-toggle="tooltip" title="{{ $tarea->completada ? 'Marcar como pendiente' : 'Marcar como completada' }}">
                                    <i class="bi bi-{{ $tarea->completada ? 'arrow-counterclockwise' : 'check2' }}"></i>
                                </button>
                            </form>

                            <a href="{{ route('tasks.show', $tarea) }}" class="btn btn-sm btn-info text-white flex-fill" data-bs-toggle="tooltip" title="Ver detalles">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('tasks.edit', $tarea) }}" class="btn btn-sm btn-warning flex-fill" data-bs-toggle="tooltip" title="Editar tarea">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger flex-fill" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tarea->id }}" title="Eliminar tarea">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                
                <div class="modal fade" id="deleteModal{{ $tarea->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tarea->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="deleteModalLabel{{ $tarea->id }}">
                                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                                    Confirmar Eliminación
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Estás seguro de que deseas eliminar la tarea <strong>"{{ $tarea->titulo }}"</strong>?</p>
                                <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </button>
                                <form action="{{ route('tasks.destroy', $tarea) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $tareas->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@else
    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm text-center py-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="bi bi-inbox" style="font-size: 5rem; color: #e5e7eb;"></i>
                    </div>
                    <h3 class="mb-3">No se encontraron tareas</h3>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'estado', 'sort']))
                            No hay tareas que coincidan con los filtros aplicados.
                        @else
                            Comienza agregando tu primera tarea para organizar tu día.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'estado', 'sort']))
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-x-circle me-1"></i> Limpiar Filtros
                        </a>
                    @endif
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-1"></i> Crear Primera Tarea
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
