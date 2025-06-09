@extends('layouts.empleador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Crear Nueva Oferta de Trabajo</h1>
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
                    <form action="{{ route('empleador.ofertas.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titulo" class="form-label">Título de la oferta *</label>
                                <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ubicacion" class="form-label">Ubicación *</label>
                                <input type="text" class="form-control @error('ubicacion') is-invalid @enderror" 
                                       id="ubicacion" name="ubicacion" value="{{ old('ubicacion') }}" required>
                                @error('ubicacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="salario" class="form-label">Salario</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" class="form-control @error('salario') is-invalid @enderror" 
                                           id="salario" name="salario" value="{{ old('salario') }}" step="0.01">
                                </div>
                                @error('salario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="tipo_contrato" class="form-label">Tipo de contrato *</label>
                                <select class="form-select @error('tipo_contrato') is-invalid @enderror" 
                                        id="tipo_contrato" name="tipo_contrato" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Indefinido" {{ old('tipo_contrato') == 'Indefinido' ? 'selected' : '' }}>Indefinido</option>
                                    <option value="Temporal" {{ old('tipo_contrato') == 'Temporal' ? 'selected' : '' }}>Temporal</option>
                                    <option value="Prácticas" {{ old('tipo_contrato') == 'Prácticas' ? 'selected' : '' }}>Prácticas</option>
                                    <option value="Formación" {{ old('tipo_contrato') == 'Formación' ? 'selected' : '' }}>Formación</option>
                                </select>
                                @error('tipo_contrato')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="jornada" class="form-label">Jornada laboral *</label>
                                <select class="form-select @error('jornada') is-invalid @enderror" 
                                        id="jornada" name="jornada" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Completa" {{ old('jornada') == 'Completa' ? 'selected' : '' }}>Completa</option>
                                    <option value="Parcial" {{ old('jornada') == 'Parcial' ? 'selected' : '' }}>Parcial</option>
                                    <option value="Por horas" {{ old('jornada') == 'Por horas' ? 'selected' : '' }}>Por horas</option>
                                    <option value="Flexible" {{ old('jornada') == 'Flexible' ? 'selected' : '' }}>Flexible</option>
                                </select>
                                @error('jornada')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="descripcion" class="form-label">Descripción del puesto *</label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Describe las responsabilidades y funciones principales del puesto.
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="requisitos" class="form-label">Requisitos *</label>
                                <textarea class="form-control @error('requisitos') is-invalid @enderror" 
                                          id="requisitos" name="requisitos" rows="4" required>{{ old('requisitos') }}</textarea>
                                @error('requisitos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Especifica la formación, experiencia y habilidades necesarias.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado de la oferta *</label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" name="estado" required>
                                    <option value="activa" {{ old('estado') == 'activa' ? 'selected' : '' }}>Activa</option>
                                    <option value="inactiva" {{ old('estado') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('empleador.ofertas.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Oferta
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
</style>
@endpush
@endsection
