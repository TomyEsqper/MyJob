@extends('layouts.empleador')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Profile Content -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->logo_empresa ?? asset('images/default-company.png') }}" class="rounded-circle mb-3" width="150" id="preview-logo">
                    <h5 class="card-title">{{ Auth::user()->nombre_empresa }}</h5>
                    <p class="card-text text-muted">{{ Auth::user()->sector ?? 'Sector no especificado' }}</p>
                    <form action="{{ route('empleador.actualizar-logo') }}" method="POST" enctype="multipart/form-data" id="logo-form">
                        @csrf
                        <input type="file" name="logo" id="logo" class="d-none" accept="image/*">
                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('logo').click()">
                            <i class="fas fa-edit"></i> Editar Logo
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">Información de Contacto</h6>
                    <p class="mb-2">
                        <i class="fas fa-envelope text-muted me-2"></i>
                        {{ Auth::user()->correo_electronico }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone text-muted me-2"></i>
                        {{ Auth::user()->telefono ?? 'No especificado' }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted me-2"></i>
                        {{ Auth::user()->ubicacion ?? 'No especificada' }}
                    </p>
                    <p class="mb-0">
                        <i class="fas fa-globe text-muted me-2"></i>
                        <a href="{{ Auth::user()->sitio_web }}" target="_blank" class="text-decoration-none">
                            {{ Auth::user()->sitio_web ?? 'No especificado' }}
                        </a>
                    </p>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">Estadísticas</h6>
                    <p class="mb-2">
                        <i class="fas fa-briefcase text-muted me-2"></i>
                        Ofertas Activas: {{ Auth::user()->ofertas_count ?? '0' }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-users text-muted me-2"></i>
                        Total Empleados: {{ Auth::user()->numero_empleados ?? 'No especificado' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Perfil de la Empresa</h5>
                        <button type="button" class="btn btn-primary" id="edit-btn">
                            <i class="fas fa-edit me-2"></i>Editar Perfil
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('empleador.actualizar-perfil') }}" method="POST" id="info-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIT *</label>
                                <input type="text" name="nit" class="form-control" value="{{ Auth::user()->empleador->nit ?? '' }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Empresarial *</label>
                                <input type="email" name="correo_empresarial" class="form-control" value="{{ Auth::user()->empleador->correo_empresarial ?? '' }}" readonly required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre de la Empresa *</label>
                                <input type="text" name="nombre_empresa" class="form-control" value="{{ Auth::user()->empleador->nombre_empresa ?? '' }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sector</label>
                                <input type="text" name="sector" class="form-control" value="{{ Auth::user()->empleador->sector ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono de Contacto *</label>
                                <input type="text" name="telefono_contacto" class="form-control" value="{{ Auth::user()->empleador->telefono_contacto ?? '' }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ubicación</label>
                                <input type="text" name="ubicacion" class="form-control" value="{{ Auth::user()->empleador->ubicacion ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dirección de la Empresa *</label>
                                <input type="text" name="direccion_empresa" class="form-control" value="{{ Auth::user()->empleador->direccion_empresa ?? '' }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sitio Web</label>
                                <input type="url" name="sitio_web" class="form-control" value="{{ Auth::user()->empleador->sitio_web ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Número de Empleados</label>
                            <input type="number" name="numero_empleados" class="form-control" value="{{ Auth::user()->empleador->numero_empleados ?? '' }}" readonly min="1">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción de la Empresa</label>
                            <textarea name="descripcion" class="form-control" rows="4" readonly>{{ Auth::user()->empleador->descripcion ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Misión</label>
                            <textarea name="mision" class="form-control" rows="3" readonly>{{ Auth::user()->empleador->mision ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Visión</label>
                            <textarea name="vision" class="form-control" rows="3" readonly>{{ Auth::user()->empleador->vision ?? '' }}</textarea>
                        </div>

                        <div class="text-end d-none" id="form-buttons">
                            <button type="button" class="btn btn-secondary me-2" id="cancel-edit-btn">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title">Beneficios para Empleados</h5>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#beneficiosModal">
                            <i class="fas fa-plus"></i> Añadir
                        </button>
                    </div>
                    <div class="benefits" id="benefits-container">
                        @foreach(explode(',', Auth::user()->beneficios ?? '') as $beneficio)
                            @if(trim($beneficio) != '')
                                <span class="badge bg-success me-2 mb-2">{{ trim($beneficio) }}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Beneficios -->
<div class="modal fade" id="beneficiosModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestionar Beneficios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="beneficios-form">
                    <div class="mb-3">
                        <label class="form-label">Beneficios Actuales</label>
                        <div id="beneficios-list">
                            @foreach(explode(',', Auth::user()->beneficios ?? '') as $beneficio)
                                @if(trim($beneficio) != '')
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="beneficios[]" value="{{ trim($beneficio) }}">
                                        <button type="button" class="btn btn-danger remove-beneficio">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-beneficio-btn">
                            <i class="fas fa-plus"></i> Agregar Beneficio
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="save-beneficios-btn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Manejo del formulario de información
    const form = document.getElementById('info-form');
    const editBtn = document.getElementById('edit-btn');
    const cancelBtn = document.getElementById('cancel-edit-btn');
    const formButtons = document.getElementById('form-buttons');
    const inputs = form.querySelectorAll('input, textarea');
    
    editBtn.addEventListener('click', function() {
        inputs.forEach(input => input.readOnly = false);
        editBtn.classList.add('d-none');
        formButtons.classList.remove('d-none');
    });
    
    cancelBtn.addEventListener('click', function() {
        inputs.forEach(input => input.readOnly = true);
        editBtn.classList.remove('d-none');
        formButtons.classList.add('d-none');
        form.reset();
    });

    // Manejo del logo
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('preview-logo');
    const logoForm = document.getElementById('logo-form');

    logoInput.addEventListener('change', () => {
        const file = logoInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                logoPreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
            logoForm.submit();
        }
    });

    // Manejo de beneficios
    const addBeneficioBtn = document.getElementById('add-beneficio-btn');
    const beneficiosList = document.getElementById('beneficios-list');
    const saveBeneficiosBtn = document.getElementById('save-beneficios-btn');
    const beneficiosModal = document.getElementById('beneficiosModal');
    const beneficiosContainer = document.getElementById('benefits-container');

    addBeneficioBtn.addEventListener('click', () => {
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="beneficios[]" placeholder="Nuevo beneficio">
            <button type="button" class="btn btn-danger remove-beneficio">
                <i class="fas fa-times"></i>
            </button>
        `;
        beneficiosList.appendChild(div);
    });

    beneficiosList.addEventListener('click', (e) => {
        if (e.target.closest('.remove-beneficio')) {
            e.target.closest('.input-group').remove();
        }
    });

    saveBeneficiosBtn.addEventListener('click', async () => {
        const beneficios = Array.from(beneficiosList.querySelectorAll('input[name="beneficios[]"]'))
            .map(input => input.value.trim())
            .filter(value => value !== '');

        try {
            const response = await fetch('{{ route("empleador.actualizar-beneficios") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ beneficios })
            });

            const data = await response.json();

            if (data.success) {
                beneficiosContainer.innerHTML = beneficios
                    .map(beneficio => `<span class="badge bg-success me-2 mb-2">${beneficio}</span>`)
                    .join('');
                
                const modal = bootstrap.Modal.getInstance(beneficiosModal);
                modal.hide();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
</script>
@endpush

@push('styles')
<style>
.card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.badge {
    padding: 0.5em 1em;
}
</style>
@endpush
@endsection 