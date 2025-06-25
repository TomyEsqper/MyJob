@extends('layouts.empleado')

@section('page-title', 'Mi Perfil')
@section('page-description', 'Actualiza tu información personal y profesional.')

@section('content')

@if (session('success') && session('success') === 'Tu foto de perfil ha sido actualizada.')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="perfil-portada mb-4 animate__animated animate__fadeInDown">
    @if(file_exists(public_path('images/portada-demo.jpg')))
        <img src="{{ asset('images/portada-demo.jpg') }}" alt="Portada">
    @endif
    <div class="perfil-portada-content">
        <div class="perfil-avatar-super">
            @if ($empleado->foto_perfil)
                <img id="previewFotoPerfil" src="{{ Str::startsWith($empleado->foto_perfil, 'http') ? $empleado->foto_perfil : asset('storage/' . $empleado->foto_perfil) }}" alt="Foto de Perfil">
            @else
                <img id="previewFotoPerfil" src="{{ asset('images/default-user.png') }}" alt="Foto de Perfil">
            @endif
            <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="fotoPerfilForm" style="position:relative;">
                @csrf
                <button type="button" class="perfil-avatar-btn" title="Cambiar foto de perfil" onclick="document.getElementById('foto_perfil_upload').click();">
                    <i class="fas fa-camera"></i>
                </button>
                <input type="file" name="foto_perfil" id="foto_perfil_upload" accept=".jpg,.jpeg,.png" hidden onchange="this.form.submit()">
            </form>
        </div>
        <div class="perfil-header-info">
            <h2>{{ $empleado->nombre_usuario }}</h2>
            <div class="perfil-frase">{{ $empleado->profesion ?? 'Sin profesión definida' }}</div>
        </div>
    </div>
</div>

<div class="perfil-main">
    <div class="perfil-social-card" style="min-height:unset; height:auto;">
        <h5 class="mb-3">
            <i class="fas fa-share-alt me-2"></i>
            Información de Contacto
        </h5>
        <div class="perfil-social-links" id="socialLinks">
            @foreach(['whatsapp','facebook','instagram','linkedin'] as $red)
                <div class="d-flex align-items-center mb-2" data-campo="{{ $red }}">
                    @php
                        $icon = [
                            'whatsapp' => 'fab fa-whatsapp',
                            'facebook' => 'fab fa-facebook',
                            'instagram' => 'fab fa-instagram',
                            'linkedin' => 'fab fa-linkedin',
                        ][$red];
                        $valor = $empleado->$red;
                    @endphp
                    <i class="{{ $icon }} me-2"></i>
                    <span class="valor-campo flex-grow-1">{{ $valor }}</span>
                    <input type="text" class="form-control form-control-sm d-none input-campo" value="{{ $valor }}" maxlength="100" style="max-width:200px;">
                    <button class="btn btn-sm btn-link text-primary editar-campo" title="Editar" type="button"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-link text-success guardar-campo d-none" title="Guardar" type="button"><i class="fas fa-check"></i></button>
                    <button class="btn btn-sm btn-link text-danger eliminar-campo ms-1" title="Eliminar" type="button" @if(!$valor) style="display:none" @endif><i class="fas fa-trash"></i></button>
                </div>
            @endforeach
        </div>
        <button class="btn btn-success w-100 mt-3">
            <i class="fab fa-whatsapp me-2"></i>
            Contactar
        </button>
    </div>

    <div class="perfil-timeline">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="mb-0">
                <i class="fas fa-briefcase me-2"></i>
                Experiencia Laboral
            </h5>
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus me-1"></i>
                Agregar
            </button>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-title">Cajero</div>
                <div class="timeline-period">Supermercado ABC • Ene 2022 - Dic 2023</div>
                <div class="timeline-desc">
                    Atención al cliente, manejo de caja, reposición de productos.
                    <span class="badge bg-success ms-2">
                        <i class="fas fa-trophy me-1"></i>
                        Mejor atención 2023
                    </span>
                </div>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-title">Auxiliar de Limpieza</div>
                <div class="timeline-period">Colegio XYZ • Feb 2021 - Dic 2021</div>
                <div class="timeline-desc">
                    Limpieza de aulas, baños y zonas comunes.
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
            <h5 class="mb-0">
                <i class="fas fa-graduation-cap me-2"></i>
                Educación
            </h5>
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus me-1"></i>
                Agregar
            </button>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-title">Bachillerato</div>
                <div class="timeline-period">Colegio Nacional • 2016 - 2021</div>
            </div>
        </div>
        
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-content">
                <div class="timeline-title">Curso de Manipulación de Alimentos</div>
                <div class="timeline-period">SENA • 2022</div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
            <h5 class="mb-0">
                <i class="fas fa-certificate me-2"></i>
                Certificados y Cursos
            </h5>
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-upload me-1"></i>
                Subir
            </button>
        </div>
        
        <div class="perfil-certificados-grid">
            <div class="perfil-cert-card">
                <i class="fas fa-file-pdf"></i>
                <div class="mt-2">
                    <strong>Certificado Manipulación de Alimentos</strong>
                    <div class="text-muted small">2022</div>
                </div>
            </div>
            <div class="perfil-cert-card">
                <i class="fas fa-file-image"></i>
                <div class="mt-2">
                    <strong>Curso de Servicio al Cliente</strong>
                    <div class="text-muted small">2023</div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
            <h5 class="mb-0">
                <i class="fas fa-language me-2"></i>
                Idiomas
            </h5>
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus me-1"></i>
                Agregar
            </button>
        </div>
        
        <div class="perfil-idiomas-chips">
            <span class="perfil-idioma-chip selected">
                <i class="fas fa-flag"></i>
                Español <span class="small">(Nativo)</span>
            </span>
            <span class="perfil-idioma-chip">
                <i class="fas fa-flag-usa"></i>
                Inglés <span class="small">(Básico)</span>
            </span>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4 mt-5">
            <h5 class="mb-0">
                <i class="fas fa-star me-2"></i>
                Habilidades Destacadas
            </h5>
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-edit me-1"></i>
                Editar
            </button>
        </div>
        
        <div class="perfil-habilidades-chips">
            <span class="perfil-habilidad-chip selected">
                <i class="fas fa-user-check"></i>
                Atención al cliente
            </span>
            <span class="perfil-habilidad-chip">
                <i class="fas fa-users"></i>
                Trabajo en equipo
            </span>
            <span class="perfil-habilidad-chip">
                <i class="fas fa-clock"></i>
                Puntualidad
            </span>
        </div>

        <div class="perfil-disponibilidad-widget">
            <i class="fas fa-calendar-check"></i>
            <div class="perfil-dispon-info" id="disponibilidadInfo">
                <h6 class="mb-3">Disponibilidad Laboral</h6>
                <div class="row text-center">
                    <div class="col-4" data-campo="disponibilidad_horario">
                        <div class="fw-bold">Horario</div>
                        <span class="valor-campo">{{ $empleado->disponibilidad_horario ?? '-' }}</span>
                        <button class="btn btn-sm btn-link text-primary editar-campo" title="Editar" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-link text-danger eliminar-campo ms-1" title="Eliminar" type="button" @if(!$empleado->disponibilidad_horario) style="display:none" @endif><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="col-4" data-campo="disponibilidad_jornada">
                        <div class="fw-bold">Jornada</div>
                        <span class="valor-campo">{{ $empleado->disponibilidad_jornada ?? '-' }}</span>
                        <button class="btn btn-sm btn-link text-primary editar-campo" title="Editar" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-link text-danger eliminar-campo ms-1" title="Eliminar" type="button" @if(!$empleado->disponibilidad_jornada) style="display:none" @endif><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="col-4" data-campo="disponibilidad_movilidad">
                        <div class="fw-bold">Movilidad</div>
                        <span class="valor-campo">{{ $empleado->disponibilidad_movilidad ? 'Sí' : 'No' }}</span>
                        <button class="btn btn-sm btn-link text-primary editar-campo" title="Editar" type="button"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-link text-danger eliminar-campo ms-1" title="Eliminar" type="button" @if(is_null($empleado->disponibilidad_movilidad)) style="display:none" @endif><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="perfil-form-cv-row mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card-empleado">
                <div class="card-header-empleado">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Información Personal
                    </h5>
                </div>
                <div class="card-body-empleado">
                    <form action="{{ route('empleado.perfil.update', $empleado->id_usuario) }}" method="POST" enctype="multipart/form-data" id="perfilForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre_usuario" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Nombre *
                                </label>
                                <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" value="{{ old('nombre_usuario', $empleado->nombre_usuario) }}" required maxlength="50">
                                <div class="invalid-feedback" id="nombre_usuario-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Teléfono
                                </label>
                                <input type="tel" class="form-control" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" maxlength="20">
                                <div class="invalid-feedback" id="telefono-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ciudad" class="form-label">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Ciudad
                                </label>
                                <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ old('ciudad', $empleado->ciudad) }}" maxlength="100">
                                <div class="invalid-feedback" id="ciudad-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp" class="form-label">
                                    <i class="fab fa-whatsapp me-1"></i>
                                    WhatsApp
                                </label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $empleado->whatsapp) }}" maxlength="30">
                                <div class="invalid-feedback" id="whatsapp-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="facebook" class="form-label">
                                    <i class="fab fa-facebook me-1"></i>
                                    Facebook
                                </label>
                                <input type="text" class="form-control" name="facebook" id="facebook" value="{{ old('facebook', $empleado->facebook) }}" maxlength="100">
                                <div class="invalid-feedback" id="facebook-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="instagram" class="form-label">
                                    <i class="fab fa-instagram me-1"></i>
                                    Instagram
                                </label>
                                <input type="text" class="form-control" name="instagram" id="instagram" value="{{ old('instagram', $empleado->instagram) }}" maxlength="100">
                                <div class="invalid-feedback" id="instagram-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="linkedin" class="form-label">
                                    <i class="fab fa-linkedin me-1"></i>
                                    LinkedIn
                                </label>
                                <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ old('linkedin', $empleado->linkedin) }}" maxlength="100">
                                <div class="invalid-feedback" id="linkedin-error"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profesion" class="form-label">
                                <i class="fas fa-briefcase me-1"></i>
                                Profesión / Titular
                            </label>
                            <input type="text" class="form-control" name="profesion" id="profesion" value="{{ old('profesion', $empleado->profesion) }}" placeholder="Ej: Mesero, Limpieza, Seguridad" maxlength="100">
                            <div class="invalid-feedback" id="profesion-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="resumen_profesional" class="form-label">
                                <i class="fas fa-file-alt me-1"></i>
                                Resumen Profesional
                            </label>
                            <textarea class="form-control" name="resumen_profesional" id="resumen_profesional" rows="4" maxlength="1000" placeholder="Describe tu experiencia y objetivos profesionales...">{{ old('resumen_profesional', $empleado->resumen_profesional) }}</textarea>
                            <div class="invalid-feedback" id="resumen_profesional-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="habilidades" class="form-label">
                                <i class="fas fa-star me-1"></i>
                                Habilidades (separadas por comas)
                            </label>
                            <textarea name="habilidades" class="form-control" rows="2" placeholder="Ej: Atención al cliente, Cocina, Ventas" maxlength="300">{{ old('habilidades', $empleado->habilidades) }}</textarea>
                            <div class="invalid-feedback" id="habilidades-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="disponibilidad_horario" class="form-label">
                                <i class="fas fa-clock me-1"></i>
                                Disponibilidad Horario
                            </label>
                            <input type="text" class="form-control" name="disponibilidad_horario" id="disponibilidad_horario" value="{{ old('disponibilidad_horario', $empleado->disponibilidad_horario) }}" maxlength="100">
                            <div class="invalid-feedback" id="disponibilidad_horario-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="disponibilidad_jornada" class="form-label">
                                <i class="fas fa-calendar-day me-1"></i>
                                Disponibilidad Jornada
                            </label>
                            <input type="text" class="form-control" name="disponibilidad_jornada" id="disponibilidad_jornada" value="{{ old('disponibilidad_jornada', $empleado->disponibilidad_jornada) }}" maxlength="100">
                            <div class="invalid-feedback" id="disponibilidad_jornada-error"></div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="disponibilidad_movilidad" id="disponibilidad_movilidad" value="1" {{ old('disponibilidad_movilidad', $empleado->disponibilidad_movilidad) ? 'checked' : '' }}>
                            <label class="form-check-label" for="disponibilidad_movilidad">
                                <i class="fas fa-car-side me-1"></i>
                                ¿Cuenta con movilidad propia?
                            </label>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Actualizar Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="perfil-cv-card">
                <div class="card-header-empleado">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Currículum Vitae (CV)
                    </h5>
                </div>
                <div class="card-body-empleado">
                    <label for="cv" class="form-label">
                        <i class="fas fa-upload me-1"></i>
                        Subir nuevo CV
                    </label>
                    <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        Formatos permitidos: PDF, DOC, DOCX (máx. 10MB)
                    </div>
                    <div class="invalid-feedback" id="cv-error"></div>
                    @if ($empleado->cv_path)
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="fas fa-file-pdf me-2"></i>
                            <strong>CV actual:</strong> {{ basename($empleado->cv_path) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="alerta-contacto" class="alert d-none mt-2" role="alert"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainForm = document.getElementById('perfilForm');
    const fotoForm = document.getElementById('fotoPerfilForm');
    const inputs = mainForm.querySelectorAll('input:not([type="file"]), textarea');
    
    // Función para mostrar error
    function showError(input, message) {
        input.classList.add('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = message;
        }
    }
    
    // Función para limpiar error
    function clearError(input) {
        input.classList.remove('is-invalid');
        const errorDiv = document.getElementById(input.id + '-error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }
    }
    
    // Validar teléfono (formato básico)
    function isValidPhone(phone) {
        if (!phone) return true; // Opcional
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]{7,20}$/;
        return phoneRegex.test(phone);
    }
    
    // Validar archivo de imagen
    function isValidImageFile(file) {
        if (!file) return true; // Opcional
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 5 * 1024 * 1024; // 5MB
        
        if (!allowedTypes.includes(file.type)) {
            return false;
        }
        
        if (file.size > maxSize) {
            return false;
        }
        
        return true;
    }
    
    // Validar archivo CV
    function isValidCVFile(file) {
        if (!file) return true; // Opcional
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (!allowedTypes.includes(file.type)) {
            return false;
        }
        
        if (file.size > maxSize) {
            return false;
        }
        
        return true;
    }
    
    // Validar campo individual
    function validateField(input) {
        const value = input.value.trim();
        
        // Limpiar error previo
        clearError(input);
        
        // Validar campos requeridos
        if (input.hasAttribute('required') && !value) {
            showError(input, 'Este campo es obligatorio.');
            return false;
        }
        
        // Validar longitud máxima
        if (input.hasAttribute('maxlength') && value.length > parseInt(input.getAttribute('maxlength'))) {
            showError(input, `Máximo ${input.getAttribute('maxlength')} caracteres.`);
            return false;
        }
        
        // Validaciones específicas
        switch (input.id) {
            case 'telefono':
                if (value && !isValidPhone(value)) {
                    showError(input, 'Ingresa un número de teléfono válido.');
                    return false;
                }
                break;
                
            case 'foto_perfil_upload':
                if (input.files.length > 0 && !isValidImageFile(input.files[0])) {
                    const file = input.files[0];
                    if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
                        showError(input, 'Solo se permiten archivos JPG y PNG.');
                    } else if (file.size > 5 * 1024 * 1024) {
                        showError(input, 'La imagen no puede pesar más de 5MB.');
                    }
                    return false;
                }
                break;
                
            case 'cv':
                if (input.files.length > 0 && !isValidCVFile(input.files[0])) {
                    const file = input.files[0];
                    if (!['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'].includes(file.type)) {
                        showError(input, 'Solo se permiten archivos PDF, DOC y DOCX.');
                    } else if (file.size > 10 * 1024 * 1024) {
                        showError(input, 'El archivo no puede ser mayor a 10MB.');
                    }
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    // Event listeners para validación en tiempo real
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
        input.addEventListener('input', () => {
            if (input.classList.contains('is-invalid')) {
                validateField(input);
            }
        });
    });
    
    // Validación al enviar el formulario
    mainForm.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validar todos los campos
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            // Mostrar mensaje de error general
            const firstError = mainForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.focus();
            }
        }
    });

    // Previsualización de la foto de perfil
    const fotoInput = document.getElementById('foto_perfil_upload');
    const previewFoto = document.getElementById('previewFotoPerfil');
    fotoInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewFoto.src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    function mostrarAlertaContacto(mensaje, tipo = 'success') {
        const alerta = document.getElementById('alerta-contacto');
        alerta.textContent = mensaje;
        alerta.className = 'alert alert-' + tipo + ' mt-2';
        alerta.classList.remove('d-none');
        setTimeout(() => alerta.classList.add('d-none'), 2500);
    }
    document.querySelectorAll('.editar-campo').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('[data-campo]');
            row.querySelector('.valor-campo').classList.add('d-none');
            row.querySelector('.input-campo').classList.remove('d-none');
            row.querySelector('.guardar-campo').classList.remove('d-none');
            this.classList.add('d-none');
        });
    });
    document.querySelectorAll('.guardar-campo').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('[data-campo]');
            const campo = row.getAttribute('data-campo');
            const input = row.querySelector('.input-campo');
            const valor = input.value;
            fetch("{{ route('empleado.perfil.campo') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ campo, valor })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    row.querySelector('.valor-campo').textContent = valor;
                    row.querySelector('.valor-campo').classList.remove('d-none');
                    input.classList.remove('is-invalid');
                    input.classList.add('d-none');
                    row.querySelector('.guardar-campo').classList.add('d-none');
                    row.querySelector('.editar-campo').classList.remove('d-none');
                    if(valor) row.querySelector('.eliminar-campo').style.display = '';
                    else row.querySelector('.eliminar-campo').style.display = 'none';
                    mostrarAlertaContacto('¡Guardado correctamente!', 'success');
                } else {
                    input.classList.add('is-invalid');
                    mostrarAlertaContacto('Error al guardar. Intenta de nuevo.', 'danger');
                }
            })
            .catch(() => {
                input.classList.add('is-invalid');
                mostrarAlertaContacto('Error de red. Intenta de nuevo.', 'danger');
            });
        });
    });
    document.querySelectorAll('.eliminar-campo').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('[data-campo]');
            const campo = row.getAttribute('data-campo');
            fetch("{{ route('empleado.perfil.campo.eliminar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ campo })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    row.querySelector('.valor-campo').textContent = '';
                    row.querySelector('.input-campo').value = '';
                    this.style.display = 'none';
                    mostrarAlertaContacto('Campo eliminado.', 'success');
                } else {
                    mostrarAlertaContacto('Error al eliminar. Intenta de nuevo.', 'danger');
                }
            })
            .catch(() => {
                mostrarAlertaContacto('Error de red. Intenta de nuevo.', 'danger');
            });
        });
    });
});
</script>
@endsection 