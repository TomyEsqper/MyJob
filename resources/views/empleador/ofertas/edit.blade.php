@extends('layouts.empleador')

@section('content')
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Editar Oferta de Trabajo</h1>
                <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
                        </div>
                    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
                </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('empleador.ofertas.update', $oferta->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">Título de la oferta *</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo', $oferta->titulo) }}" required
                                       placeholder="Ej: Desarrollador Full Stack Senior">
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="categoria" class="form-label">Categoría *</label>
                                <select class="form-select @error('categoria') is-invalid @enderror" 
                                        id="categoria" name="categoria" required>
                                    <option value="">Seleccionar categoría...</option>
                                    @foreach($categorias as $key => $value)
                                        <option value="{{ $key }}" {{ old('categoria', $oferta->categoria) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nivel_experiencia" class="form-label">Nivel de experiencia *</label>
                                <select class="form-select @error('nivel_experiencia') is-invalid @enderror" 
                                        id="nivel_experiencia" name="nivel_experiencia" required>
                                    <option value="">Seleccionar nivel...</option>
                                    @foreach($nivelesExperiencia as $key => $value)
                                        <option value="{{ $key }}" {{ old('nivel_experiencia', $oferta->nivel_experiencia) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nivel_experiencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ubicacion" class="form-label">Ubicación *</label>
                                <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                                       id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $oferta->ubicacion) }}" required
                                       placeholder="Ej: Madrid, España">
                                @error('ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="modalidad_trabajo" class="form-label">Modalidad de trabajo *</label>
                                <select class="form-select @error('modalidad_trabajo') is-invalid @enderror" 
                                        id="modalidad_trabajo" name="modalidad_trabajo" required>
                                    <option value="">Seleccionar modalidad...</option>
                                    @foreach($modalidadesTrabajo as $key => $value)
                                        <option value="{{ $key }}" {{ old('modalidad_trabajo', $oferta->modalidad_trabajo) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('modalidad_trabajo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo_contrato" class="form-label">Tipo de contrato *</label>
                                <select class="form-select @error('tipo_contrato') is-invalid @enderror" 
                                        id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Indefinido" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                                    <option value="Temporal" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                                    <option value="Prácticas" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Prácticas' ? 'selected' : '' }}>Prácticas</option>
                                    <option value="Formación" {{ old('tipo_contrato', $oferta->tipo_contrato) == 'Formación' ? 'selected' : '' }}>Formación</option>
                                </select>
                                @error('tipo_contrato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jornada" class="form-label">Jornada laboral *</label>
                                <select class="form-select @error('jornada') is-invalid @enderror" 
                                        id="jornada" name="jornada" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Completa" {{ old('jornada', $oferta->jornada) == 'Completa' ? 'selected' : '' }}>Completa</option>
                                    <option value="Parcial" {{ old('jornada', $oferta->jornada) == 'Parcial' ? 'selected' : '' }}>Parcial</option>
                                    <option value="Por horas" {{ old('jornada', $oferta->jornada) == 'Por horas' ? 'selected' : '' }}>Por horas</option>
                                </select>
                                @error('jornada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salario" class="form-label">Salario mínimo</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control @error('salario') is-invalid @enderror" 
                                           id="salario" name="salario" value="{{ old('salario', $oferta->salario) }}" step="0.01"
                                           placeholder="Salario mínimo anual">
                                </div>
                                @error('salario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salario_max" class="form-label">Salario máximo</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control @error('salario_max') is-invalid @enderror" 
                                           id="salario_max" name="salario_max" value="{{ old('salario_max', $oferta->salario_max) }}" step="0.01"
                                           placeholder="Salario máximo anual">
                                </div>
                                @error('salario_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="beneficios" class="form-label">Beneficios laborales</label>
                                <div class="row g-3">
                                    @foreach($beneficiosDisponibles as $key => $value)
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="beneficios[]" value="{{ $key }}" 
                                                       id="beneficio_{{ $key }}"
                                                       {{ (is_array(old('beneficios', $oferta->beneficios)) && in_array($key, old('beneficios', $oferta->beneficios))) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="beneficio_{{ $key }}">
                                                    {{ $value }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('beneficios')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_limite" class="form-label">Fecha límite de aplicación</label>
                                <input type="date" class="form-control @error('fecha_limite') is-invalid @enderror" 
                                       id="fecha_limite" name="fecha_limite" value="{{ old('fecha_limite', $oferta->fecha_limite ? \Carbon\Carbon::parse($oferta->fecha_limite)->format('Y-m-d') : null) }}"
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                @error('fecha_limite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado de la oferta *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required>
                                    <option value="activa" {{ old('estado', $oferta->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                                    <option value="inactiva" {{ old('estado', $oferta->estado) == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción del puesto *</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" rows="6" required
                                          placeholder="Describe las responsabilidades y funciones principales del puesto...">{{ old('descripcion', $oferta->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Describe detalladamente las responsabilidades y funciones principales del puesto. Mínimo 100 caracteres.
                        </div>
                        </div>

                            <div class="col-12 mb-3">
                                <label for="requisitos" class="form-label">Requisitos *</label>
                                <textarea class="form-control @error('requisitos') is-invalid @enderror" 
                                          id="requisitos" name="requisitos" rows="6" required
                                          placeholder="Especifica la formación, experiencia y habilidades necesarias...">{{ old('requisitos', $oferta->requisitos) }}</textarea>
                                @error('requisitos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Especifica la formación, experiencia y habilidades necesarias para el puesto. Mínimo 50 caracteres.
                        </div>
                        </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Oferta
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border: none;
        border-radius: 10px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-primary:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endpush
@endsection