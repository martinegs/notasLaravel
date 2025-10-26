@extends('layouts.app')

@section('title', 'Crear Nueva Tarea')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-white px-3 py-2 rounded shadow-sm">
                <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nueva Tarea</li>
            </ol>
        </nav>

        
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-plus-circle text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h4 class="mb-1 fw-bold">Crear Nueva Tarea</h4>
                        <p class="text-muted mb-0">Completa el formulario para agregar una tarea pendiente</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('tasks.store') }}" method="POST" id="taskForm">
                    @csrf

                    
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
                                value="{{ old('titulo') }}"
                                placeholder="Ej: Revisar correos electrónicos"
                                required
                                autofocus
                                maxlength="255"
                            >
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Escribe un título claro y descriptivo para tu tarea
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
                                placeholder="Agrega detalles adicionales, instrucciones o notas sobre esta tarea..."
                                maxlength="1000"
                            >{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text d-flex justify-content-between">
                            <span>
                                <i class="bi bi-info-circle me-1"></i>
                                Proporciona contexto adicional si es necesario
                            </span>
                            <span id="charCount" class="text-muted">0/1000</span>
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
                                value="{{ old('fecha_vencimiento') }}"
                                min="{{ date('Y-m-d') }}"
                            >
                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Establece una fecha límite para completar esta tarea
                        </div>
                    </div>

                    
                    <div class="d-flex gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-check-lg me-2"></i> Crear Tarea
                        </button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-x-lg me-2"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="card shadow-sm mt-4 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white p-4">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-lightbulb me-2"></i> Consejos para Organizar tus Tareas
                </h6>
                <ul class="mb-0 ps-3">
                    <li class="mb-2">Usa títulos claros y concisos que describan la acción a realizar</li>
                    <li class="mb-2">Divide tareas grandes en subtareas más pequeñas y manejables</li>
                    <li class="mb-2">Establece fechas de vencimiento realistas para mantener el enfoque</li>
                    <li class="mb-0">Revisa y actualiza tus tareas regularmente</li>
                </ul>
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

        // Validación de fecha
        const fechaVencimiento = document.getElementById('fecha_vencimiento');
        if (fechaVencimiento) {
            fechaVencimiento.addEventListener('change', function() {
                const selectedDate = new Date(this.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    alert('⚠️ La fecha de vencimiento no puede ser anterior a hoy');
                    this.value = '';
                }
            });
        }
    });
</script>
@endsection
