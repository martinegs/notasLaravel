@extends('layouts.app')

@section('title', 'Editar Tarea')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tasks.show', $task) }}" class="text-decoration-none">{{ Str::limit($task->titulo, 30) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editar</li>
            </ol>
        </nav>

        
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-pencil text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-1 fw-bold">Editar Tarea</h4>
                        <p class="text-muted mb-0">Modifica los detalles de tu tarea</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('tasks.update', $task) }}" method="POST" id="taskForm">
                    @csrf
                    @method('PUT')

                    
                    <div class="mb-4">
                        <label for="titulo" class="form-label fw-semibold">
                            Título de la Tarea <span class="text-danger">*</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-text-left"></i>
                            </span>
                            <input 
                                type="text" 
                                class="form-control border-start-0 @error('titulo') is-invalid @enderror" 
                                id="titulo" 
                                name="titulo" 
                                value="{{ old('titulo', $task->titulo) }}"
                                placeholder="Ej: Revisar correos electrónicos"
                                required
                                autofocus
                                maxlength="255"
                            >
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label for="descripcion" class="form-label fw-semibold">
                            Descripción
                            <span class="badge bg-secondary ms-1">Opcional</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light align-items-start pt-3">
                                <i class="bi bi-text-paragraph"></i>
                            </span>
                            <textarea 
                                class="form-control @error('descripcion') is-invalid @enderror" 
                                id="descripcion" 
                                name="descripcion" 
                                rows="5"
                                placeholder="Agrega detalles adicionales..."
                                maxlength="1000"
                            >{{ old('descripcion', $task->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text d-flex justify-content-between">
                            <span>
                                <i class="bi bi-info-circle me-1"></i>
                                Proporciona contexto adicional si es necesario
                            </span>
                            <span id="charCount" class="text-muted">{{ strlen(old('descripcion', $task->descripcion ?? '')) }}/1000</span>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label for="fecha_vencimiento" class="form-label fw-semibold">
                            Fecha de Vencimiento
                            <span class="badge bg-secondary ms-1">Opcional</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-calendar-event"></i>
                            </span>
                            <input 
                                type="date" 
                                class="form-control border-start-0 @error('fecha_vencimiento') is-invalid @enderror" 
                                id="fecha_vencimiento" 
                                name="fecha_vencimiento" 
                                value="{{ old('fecha_vencimiento', $task->fecha_vencimiento?->format('Y-m-d')) }}"
                            >
                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch"
                                        id="completada" 
                                        name="completada" 
                                        value="1"
                                        {{ old('completada', $task->completada) ? 'checked' : '' }}
                                        style="width: 3em; height: 1.5em;"
                                    >
                                    <label class="form-check-label fw-semibold ms-2" for="completada">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Marcar esta tarea como completada
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2 ms-5">
                                    Las tareas completadas aparecerán con un estilo diferente en el listado
                                </small>
                            </div>
                        </div>
                    </div>

                    
                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-warning btn-lg px-4">
                            <i class="bi bi-check-lg me-2"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-x-lg me-2"></i> Cancelar
                        </a>
                        <button 
                            type="button" 
                            class="btn btn-outline-danger btn-lg px-4 ms-auto" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal"
                        >
                            <i class="bi bi-trash me-2"></i> Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="card shadow-sm mt-4 border-0 bg-info bg-opacity-10">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3 text-info">
                    <i class="bi bi-info-circle me-2"></i> Información de la Tarea
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Creada</small>
                        <strong>{{ $task->created_at->format('d/m/Y H:i') }}</strong>
                        <small class="text-muted">({{ $task->created_at->diffForHumans() }})</small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Última actualización</small>
                        <strong>{{ $task->updated_at->format('d/m/Y H:i') }}</strong>
                        <small class="text-muted">({{ $task->updated_at->diffForHumans() }})</small>
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
                    <small>Esta acción no se puede deshacer y todos los datos asociados se perderán permanentemente.</small>
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

@section('scripts')
<script>
    // Contador de caracteres para descripción
    document.addEventListener('DOMContentLoaded', function() {
        const descripcion = document.getElementById('descripcion');
        const charCount = document.getElementById('charCount');
        
        if (descripcion && charCount) {
            descripcion.addEventListener('input', function() {
                const count = this.value.length;
                charCount.textContent = count + '/1000';
                
                if (count > 900) {
                    charCount.classList.add('text-warning');
                } else {
                    charCount.classList.remove('text-warning');
                }
            });
        }
    });
</script>
@endsection
