@extends('layouts.empleador')

@section('page-title', 'Editar Oferta')
@section('page-description', 'Modifica los detalles de tu oferta de trabajo')

@section('content')

<div id="form-errors" class="alert alert-danger" style="display: none;">
    <ul class="mb-0"></ul>
</div>

<form action="{{ route('empleador.ofertas.update', $oferta) }}" method="POST" id="editOfertaForm" novalidate>
    @csrf
    @method('PUT')

    <!-- Tarjeta de Información Básica -->
    <div class="card form-section-card">
        <div class="card-header">
            Información Básica de la Oferta
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="titulo" class="form-label">Título de la oferta *</label>
                    <input type="text" class="form-control" 
                           id="titulo" name="titulo" value="{{ old('titulo', $oferta->titulo) }}" required
                           placeholder="Ej: Desarrollador Full Stack Senior" maxlength="100">
                    <div class="invalid-feedback" id="titulo-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="categoria" class="form-label">Categoría *</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría...</option>
                        @foreach($categorias as $key => $value)
                            <option value="{{ $key }}" {{ old('categoria', $oferta->categoria) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="categoria-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ubicacion" class="form-label">Ubicación *</label>
                    <input type="text" class="form-control" 
                           id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $oferta->ubicacion) }}" required
                           placeholder="Ej: Madrid, España" maxlength="100">
                    <div class="invalid-feedback" id="ubicacion-error"></div>
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
                    <select class="form-select" id="nivel_experiencia" name="nivel_experiencia" required>
                        <option value="">Seleccionar nivel...</option>
                        @foreach($nivelesExperiencia as $key => $value)
                            <option value="{{ $key }}" {{ old('nivel_experiencia', $oferta->nivel_experiencia) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="nivel_experiencia-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="modalidad_trabajo" class="form-label">Modalidad de trabajo *</label>
                    <select class="form-select" id="modalidad_trabajo" name="modalidad_trabajo" required>
                        <option value="">Seleccionar modalidad...</option>
                        @foreach($modalidadesTrabajo as $key => $value)
                            <option value="{{ $key }}" {{ old('modalidad_trabajo', $oferta->modalidad_trabajo) == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="modalidad_trabajo-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tipo_contrato" class="form-label">Tipo de contrato *</label>
                    <select class="form-select" id="tipo_contrato" name="tipo_contrato" required>
                        <option value="">Seleccionar...</option>
                        <option value="Indefinido" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                        <option value="Temporal" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                        <option value="Prácticas" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Prácticas' ? 'selected' : '' }}>Prácticas</option>
                        <option value="Formación" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Formación' ? 'selected' : '' }}>Formación</option>
                    </select>
                    <div class="invalid-feedback" id="tipo_contrato-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jornada" class="form-label">Jornada laboral *</label>
                    <select class="form-select" id="jornada" name="jornada" required>
                        <option value="">Seleccionar...</option>
                        <option value="Completa" {{ old('jornada', $oferta->jornada) == 'Completa' ? 'selected' : '' }}>Completa</option>
                        <option value="Parcial" {{ old('jornada', $oferta->jornada) == 'Parcial' ? 'selected' : '' }}>Parcial</option>
                        <option value="Por horas" {{ old('jornada', $oferta->jornada) == 'Por horas' ? 'selected' : '' }}>Por horas</option>
                    </select>
                    <div class="invalid-feedback" id="jornada-error"></div>
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
                        <input type="number" class="form-control" id="salario" name="salario" value="{{ old('salario', $oferta->salario) }}" placeholder="Ingrese el salario mensual" step="1000" min="0" max="999999999" required>
                        <div class="invalid-feedback" id="salario-error"></div>
                    </div>
                    <small class="form-text text-muted">Ingrese el salario mensual en pesos colombianos (COP)</small>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Beneficios laborales</label>
                    <div class="row g-3">
                        @php
                            $beneficiosGuardados = old('beneficios', $oferta->beneficios ?? []);
                        @endphp
                        @foreach($beneficiosDisponibles as $key => $value)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="beneficios[]" value="{{ $key }}" id="beneficio_{{ $key }}"
                                        {{ in_array($key, $beneficiosGuardados) ? 'checked' : '' }}>
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
                <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required placeholder="Describe las responsabilidades y funciones del puesto..." maxlength="2000">{{ old('descripcion', $oferta->descripcion) }}</textarea>
                <div class="invalid-feedback" id="descripcion-error"></div>
            </div>
            <div class="col-12 mb-3">
                <label for="requisitos" class="form-label">Requisitos *</label>
                <textarea class="form-control" id="requisitos" name="requisitos" rows="5" required placeholder="Lista los requisitos y habilidades necesarias..." maxlength="2000">{{ old('requisitos', $oferta->requisitos) }}</textarea>
                <div class="invalid-feedback" id="requisitos-error"></div>
            </div>
             <div class="col-12 mb-3">
                <label for="responsabilidades" class="form-label">Responsabilidades</label>
                <textarea class="form-control" id="responsabilidades" name="responsabilidades" rows="5" placeholder="Describe las responsabilidades específicas del puesto..." maxlength="2000">{{ old('responsabilidades', $oferta->responsabilidades) }}</textarea>
                <div class="invalid-feedback" id="responsabilidades-error"></div>
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
                    <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" value="{{ old('fecha_limite', $oferta->fecha_limite) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    <div class="invalid-feedback" id="fecha_limite-error"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado de la oferta *</label>
                    <div class="form-check form-switch fs-5">
                        <input class="form-check-input" type="checkbox" name="estado" value="activa" id="estadoSwitch" {{ old('estado', $oferta->estado) == 'activa' ? 'checked' : '' }}>
                        <label class="form-check-label" for="estadoSwitch" id="estadoLabel"></label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-secondary">
            <i class="fas fa-times me-2"></i>Cancelar
        </a>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-2"></i>Guardar Cambios
        </button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const estadoSwitch = document.getElementById('estadoSwitch');
    const estadoLabel = document.getElementById('estadoLabel');

    function updateLabel() {
        estadoLabel.textContent = estadoSwitch.checked ? 'Activa' : 'Inactiva';
    }
    updateLabel();
    estadoSwitch.addEventListener('change', updateLabel);

    // --- FORM VALIDATION ---
    const form = document.getElementById('editOfertaForm');
    const inputs = form.querySelectorAll('input[required]:not(#salario):not(#salario_max), select[required], textarea[required]');
    const salaryMinInput = document.getElementById('salario');
    const salaryMaxInput = document.getElementById('salario_max');

    function showError(input, message) {
        input.classList.add('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
        }
    }

    function clearError(input) {
        input.classList.remove('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    }

    function validateField(input) {
        clearError(input);
        if (input.hasAttribute('required') && !input.value.trim()) {
            showError(input, 'Este campo es obligatorio.');
            return false;
        }
        if (input.hasAttribute('maxlength') && input.value.length > parseInt(input.getAttribute('maxlength'))) {
            showError(input, `No puede exceder los ${input.getAttribute('maxlength')} caracteres.`);
            return false;
        }
        return true;
    }

    function validateSalaries() {
        clearError(salaryMinInput);
        clearError(salaryMaxInput);

        const minSalaryValue = salaryMinInput.value.trim();
        const maxSalaryValue = salaryMaxInput.value.trim();
        const minSalary = parseFloat(minSalaryValue);
        const maxSalary = parseFloat(maxSalaryValue);
        const maxLimit = 99999999.99;

        let isValid = true;

        // Validar Salario Mínimo
        if (minSalaryValue === '') {
            showError(salaryMinInput, 'El salario mínimo es obligatorio.');
            isValid = false;
        } else if (isNaN(minSalary) || minSalary < 0) {
            showError(salaryMinInput, 'Debe ser un número positivo.');
            isValid = false;
        } else if (minSalary > maxLimit) {
            showError(salaryMinInput, 'El valor no puede superar 99,999,999.99.');
            isValid = false;
        }

        // Validar Salario Máximo
        if (maxSalaryValue === '') {
            showError(salaryMaxInput, 'El salario máximo es obligatorio.');
            isValid = false;
        } else if (isNaN(maxSalary) || maxSalary < 0) {
            showError(salaryMaxInput, 'Debe ser un número positivo.');
            isValid = false;
        } else if (maxSalary > maxLimit) {
            showError(salaryMaxInput, 'El valor no puede superar 99,999,999.99.');
            isValid = false;
        }

        // Comparar salarios si ambos son válidos hasta ahora
        if (isValid && minSalaryValue !== '' && maxSalaryValue !== '') {
            if (maxSalary < minSalary) {
                showError(salaryMaxInput, 'El salario máximo no puede ser menor que el mínimo.');
                isValid = false;
            }
        }
        
        return isValid;
    }

    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
    });

    [salaryMinInput, salaryMaxInput].forEach(input => {
        input.addEventListener('blur', validateSalaries);
    });

    form.addEventListener('submit', function(event) {
        let formIsValid = true;

        inputs.forEach(input => {
            if (!validateField(input)) {
                formIsValid = false;
            }
        });

        if (!validateSalaries()) {
            formIsValid = false;
        }

        if (!formIsValid) {
            event.preventDefault();
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        }
    });
});
</script>
@endpush