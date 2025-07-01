@extends('layouts.empleador')

@section('page-title', 'Crear Nueva Oferta')
@section('page-description', 'Publica una nueva oferta de trabajo')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-success">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert-error">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div id="form-errors" class="alert alert-danger" style="display: none;">
    <ul class="mb-0"></ul>
</div>

<form action="{{ route('empleador.ofertas.store') }}" method="POST" id="createOfertaForm" novalidate>
    @csrf

    <!-- Tarjeta de Información Básica -->
    <div class="card form-section-card">
        <div class="card-header">
            Información Básica de la Oferta
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="titulo" class="form-label">Título de la oferta *</label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                           id="titulo" name="titulo" value="{{ old('titulo') }}" required
                           placeholder="Ej: Desarrollador Full Stack Senior" maxlength="100">
                    @error('titulo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría...</option>
                        @foreach($categorias as $key => $value)
                            <option value="{{ $key }}" {{ old('categoria') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('categoria')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ubicacion" class="form-label">Ubicación *</label>
                    <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                           id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required
                           placeholder="Ej: Madrid, España" maxlength="100">
                    @error('ubicacion')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Detalles del Puesto -->
    <div class="card form-section-card">
        <div class="card-header">
            Detalles del Puesto
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nivel_experiencia" class="form-label">Nivel de experiencia *</label>
                    <select class="form-select @error('nivel_experiencia') is-invalid @enderror" id="nivel_experiencia" name="nivel_experiencia" required>
                        <option value="">Seleccionar nivel...</option>
                        @foreach($nivelesExperiencia as $key => $value)
                            <option value="{{ $key }}" {{ old('nivel_experiencia') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('nivel_experiencia')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="modalidad_trabajo" class="form-label">Modalidad de trabajo *</label>
                    <select class="form-select @error('modalidad_trabajo') is-invalid @enderror" id="modalidad_trabajo" name="modalidad_trabajo" required>
                        <option value="">Seleccionar modalidad...</option>
                        @foreach($modalidadesTrabajo as $key => $value)
                            <option value="{{ $key }}" {{ old('modalidad_trabajo') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('modalidad_trabajo')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo_contrato" class="form-label">Tipo de contrato *</label>
                    <select class="form-select @error('tipo_contrato') is-invalid @enderror" id="tipo_contrato" name="tipo_contrato" required>
                        <option value="">Seleccionar...</option>
                        <option value="Indefinido" {{ old('tipo_contrato') == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                        <option value="Temporal" {{ old('tipo_contrato') == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                        <option value="Prácticas" {{ old('tipo_contrato') == 'Prácticas' ? 'selected' : '' }}>Prácticas</option>
                        <option value="Formación" {{ old('tipo_contrato') == 'Formación' ? 'selected' : '' }}>Formación</option>
                    </select>
                    @error('tipo_contrato')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jornada" class="form-label">Jornada laboral *</label>
                    <select class="form-select @error('jornada') is-invalid @enderror" id="jornada" name="jornada" required>
                        <option value="">Seleccionar...</option>
                        <option value="Completa" {{ old('jornada') == 'Completa' ? 'selected' : '' }}>Completa</option>
                        <option value="Parcial" {{ old('jornada') == 'Parcial' ? 'selected' : '' }}>Parcial</option>
                        <option value="Por horas" {{ old('jornada') == 'Por horas' ? 'selected' : '' }}>Por horas</option>
                    </select>
                    @error('jornada')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Salario y Beneficios -->
    <div class="card form-section-card">
        <div class="card-header">
            Salario y Beneficios
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="salario" class="form-label">Salario *</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text">COP $</span>
                        <input type="number" class="form-control @error('salario') is-invalid @enderror" id="salario" name="salario" value="{{ old('salario') }}" placeholder="Ingrese el salario mensual" step="1000" min="0" max="999999999" required>
                        @error('salario')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="form-text text-muted">Ingrese el salario mensual en pesos colombianos (COP)</small>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Beneficios laborales</label>
                    <div class="row g-3">
                        @foreach($beneficiosDisponibles as $key => $value)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="beneficios[]" value="{{ $key }}" id="beneficio_{{ $key }}" {{ (is_array(old('beneficios')) && in_array($key, old('beneficios'))) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="beneficio_{{ $key }}">{{ $value }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tarjeta de Descripción -->
    <div class="card form-section-card">
        <div class="card-header">
            Descripción del Puesto
        </div>
        <div class="card-body">
            <div class="col-12 mb-3">
                <label for="descripcion" class="form-label">Descripción *</label>
                <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="5" required placeholder="Describe las responsabilidades y funciones del puesto..." maxlength="2000">{{ old('descripcion') }}</textarea>
                <small class="form-text text-muted">Mínimo 100 caracteres. Describe detalladamente las funciones y responsabilidades del puesto.</small>
                @error('descripcion')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12 mb-3">
                <label for="requisitos" class="form-label">Requisitos *</label>
                <textarea class="form-control @error('requisitos') is-invalid @enderror" id="requisitos" name="requisitos" rows="5" required placeholder="Lista los requisitos y habilidades necesarias..." maxlength="2000">{{ old('requisitos') }}</textarea>
                <small class="form-text text-muted">Mínimo 50 caracteres. Lista los requisitos, habilidades y experiencia necesaria para el puesto.</small>
                @error('requisitos')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
             <div class="col-12 mb-3">
                <label for="responsabilidades" class="form-label">Responsabilidades</label>
                <textarea class="form-control @error('responsabilidades') is-invalid @enderror" id="responsabilidades" name="responsabilidades" rows="5" placeholder="Describe las responsabilidades específicas del puesto..." maxlength="2000">{{ old('responsabilidades') }}</textarea>
                @error('responsabilidades')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Tarjeta de Configuración Final -->
    <div class="card form-section-card">
        <div class="card-header">
            Configuración Final
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fecha_limite" class="form-label">Fecha límite de aplicación</label>
                    <input type="date" class="form-control @error('fecha_limite') is-invalid @enderror" id="fecha_limite" name="fecha_limite" value="{{ old('fecha_limite') }}" min="{{ date('Y-m-d') }}">
                    @error('fecha_limite')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado de la oferta *</label>
                    <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="activa" {{ old('estado', 'activa') == 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="inactiva" {{ old('estado') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                    </select>
                    @error('estado')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Cancelar
        </a>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>Crear Oferta
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('createOfertaForm');
    
    // Debug: log cuando se envía el formulario
    form.addEventListener('submit', function(event) {
        console.log('Formulario enviado');
        console.log('Datos del formulario:', new FormData(form));
        
        // Permitir que el formulario se envíe normalmente
        // Comentamos la validación por ahora para debug
        /*
        let formIsValid = true;
        const inputs = form.querySelectorAll('input[required]:not(#salario):not(#salario_max), select[required], textarea[required]');
        const salaryMinInput = document.getElementById('salario');
        const salaryMaxInput = document.getElementById('salario_max');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                formIsValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!formIsValid) {
            event.preventDefault();
            console.log('Formulario inválido, previniendo envío');
            return;
        }
        */
        
        console.log('Formulario válido, permitiendo envío');
    });
});

setTimeout(function() {
    var success = document.getElementById('alert-success');
    if (success) { success.classList.remove('show'); success.classList.add('fade'); setTimeout(() => success.remove(), 500); }
    var error = document.getElementById('alert-error');
    if (error) { error.classList.remove('show'); error.classList.add('fade'); setTimeout(() => error.remove(), 500); }
}, 5000);
</script>
@endpush
