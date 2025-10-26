@extends('layouts.app')

@section('title', $task->titulo . ' - Detalles')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($task->titulo, 40) }}</li>
            </ol>
        </nav>

        
        <div class="card shadow-sm mb-4">
            
            <div class="card-header border-0 pt-4 pb-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="d-flex justify-content-between align-items-start text-white p-3">
                    <div class="flex-grow-1">
                        <div class="mb-2">
                            @if($task->completada)
                                <span class="badge bg-success bg-opacity-75">
                                    <i class="bi bi-check-circle me-1"></i> Completada
                                </span>
                            @elseif($task->fecha_vencimiento && $task->fecha_vencimiento->isPast())
                                <span class="badge bg-danger bg-opacity-75">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Vencida
                                </span>
                            @else
                                <span class="badge bg-warning text-dark bg-opacity-75">
                                    <i class="bi bi-clock me-1"></i> Pendiente
                                </span>
                            @endif
                        </div>
                        <h2 class="mb-0 {{ $task->completada ? 'task-completed' : '' }}">
                            {{ $task->titulo }}
                        </h2>
                    </div>
                    <div>
                        <i class="bi bi-{{ $task->completada ? 'check-circle-fill' : 'circle' }}" style="font-size: 2.5rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                
                @if($task->descripcion)
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">
                            <i class="bi bi-text-paragraph me-2 text-primary"></i>
                            Descripción
                        </h5>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <p class="mb-0 {{ $task->completada ? 'task-completed' : '' }}" style="white-space: pre-line;">{{ $task->descripcion }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                
                <div class="row g-3 mb-4">
                    
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-primary bg-opacity-10">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-plus text-primary me-2" style="font-size: 1.5rem;"></i>
                                    <h6 class="mb-0 fw-semibold">Fecha de Creación</h6>
                                </div>
                                <p class="mb-1 fw-bold">{{ $task->created_at->format('d/m/Y') }}</p>
                                <small class="text-muted">{{ $task->created_at->format('H:i') }} • {{ $task->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>

                    
                    @if($task->fecha_vencimiento)
                        <div class="col-md-6">
                            <div class="card h-100 border-0 {{ $task->fecha_vencimiento->isPast() && !$task->completada ? 'bg-danger bg-opacity-10' : 'bg-warning bg-opacity-10' }}">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-calendar-event {{ $task->fecha_vencimiento->isPast() && !$task->completada ? 'text-danger' : 'text-warning' }} me-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="mb-0 fw-semibold">Fecha de Vencimiento</h6>
                                    </div>
                                    <p class="mb-1 fw-bold {{ $task->fecha_vencimiento->isPast() && !$task->completada ? 'text-danger' : '' }}">
                                        {{ $task->fecha_vencimiento->format('d/m/Y') }}
                                    </p>
                                    <small class="text-muted">
                                        @if($task->fecha_vencimiento->isPast() && !$task->completada)
                                            <i class="bi bi-exclamation-triangle me-1"></i>
                                            Venció {{ $task->fecha_vencimiento->diffForHumans() }}
                                        @else
                                            {{ $task->fecha_vencimiento->diffForHumans() }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                
                @if($task->updated_at != $task->created_at)
                    <div class="mb-4">
                        <div class="alert alert-info border-0 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-clock-history me-2" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Última actualización:</strong> 
                                    {{ $task->updated_at->format('d/m/Y H:i') }}
                                    <small class="text-muted">({{ $task->updated_at->diffForHumans() }})</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                
                <div class="border-top pt-4">
                    <div class="row g-2">
                        
                        <div class="col-md-3">
                            <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="h-100">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn w-100 h-100 {{ $task->completada ? 'btn-outline-secondary' : 'btn-success' }}">
                                    <i class="bi bi-{{ $task->completada ? 'arrow-counterclockwise' : 'check2' }} me-2"></i>
                                    <span class="d-block small">
                                        {{ $task->completada ? 'Reabrir' : 'Completar' }}
                                    </span>
                                </button>
                            </form>
                        </div>

                        
                        <div class="col-md-3">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning w-100 h-100">
                                <i class="bi bi-pencil me-2"></i>
                                <span class="d-block small">Editar</span>
                            </a>
                        </div>

                        
                        <div class="col-md-3">
                            <button 
                                type="button" 
                                class="btn btn-danger w-100 h-100" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal"
                            >
                                <i class="bi bi-trash me-2"></i>
                                <span class="d-block small">Eliminar</span>
                            </button>
                        </div>

                        
                        <div class="col-md-3">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary w-100 h-100">
                                <i class="bi bi-arrow-left me-2"></i>
                                <span class="d-block small">Volver</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-clock-history text-primary mb-2" style="font-size: 2rem;"></i>
                        <h6 class="text-muted mb-1">Días desde creación</h6>
                        <h3 class="mb-0 fw-bold">{{ $task->created_at->diffInDays(now()) }}</h3>
                    </div>
                </div>
            </div>

            @if($task->fecha_vencimiento)
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm text-center">
                        <div class="card-body">
                            <i class="bi bi-calendar-check {{ $task->fecha_vencimiento->isFuture() ? 'text-success' : 'text-danger' }} mb-2" style="font-size: 2rem;"></i>
                            <h6 class="text-muted mb-1">Días {{ $task->fecha_vencimiento->isFuture() ? 'restantes' : 'vencidos' }}</h6>
                            <h3 class="mb-0 fw-bold {{ $task->fecha_vencimiento->isPast() && !$task->completada ? 'text-danger' : '' }}">
                                {{ abs($task->fecha_vencimiento->diffInDays(now())) }}
                            </h3>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="bi bi-{{ $task->completada ? 'check-circle text-success' : 'circle text-warning' }} mb-2" style="font-size: 2rem;"></i>
                        <h6 class="text-muted mb-1">Estado</h6>
                        <h5 class="mb-0 fw-bold">{{ $task->completada ? 'Completada' : 'Pendiente' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <i class="bi bi-trash" style="font-size: 3rem; color: #dc3545;"></i>
                </div>
                <p class="text-center mb-3">¿Estás seguro de que deseas eliminar esta tarea?</p>
                <div class="alert alert-warning mb-0">
                    <strong class="d-block mb-2">Tarea: "{{ $task->titulo }}"</strong>
                    <small>Esta acción no se puede deshacer. Todos los datos de esta tarea se perderán permanentemente.</small>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancelar
                </button>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
