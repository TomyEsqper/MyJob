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

<div class="perfil-container perfil-nuevo-layout">
    {{-- Cabecera tipo tarjeta --}}
    <div class="perfil-header-card mb-5 animate__animated animate__fadeInDown">
        <div class="perfil-header-bg">
            @if(file_exists(public_path('images/portada-demo.jpg')))
                <img src="{{ asset('images/portada-demo.jpg') }}" alt="Portada">
            @endif
        </div>
        <div class="perfil-header-content d-flex flex-column align-items-center justify-content-center text-center">
            <div class="perfil-avatar-xl mb-3">
                @if ($empleado->foto_perfil)
                    <img id="previewFotoPerfil" src="{{ Str::startsWith($empleado->foto_perfil, 'http') ? $empleado->foto_perfil : asset('storage/' . $empleado->foto_perfil) }}" alt="Foto de Perfil">
                @else
                    <img id="previewFotoPerfil" src="{{ asset('images/default-user.png') }}" alt="Foto de Perfil">
                @endif
                <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="fotoPerfilForm" style="position:relative;">
                    @csrf
                    <button type="button" class="perfil-avatar-btn-xl" title="Cambiar foto de perfil" onclick="document.getElementById('foto_perfil_upload').click();">
                        <i class="fas fa-camera"></i>
                    </button>
                    <input type="file" name="foto_perfil" id="foto_perfil_upload" accept=".jpg,.jpeg,.png" hidden onchange="this.form.submit()">
                </form>
            </div>
            <h2 class="perfil-nombre-xl mb-1">{{ $empleado->nombre_usuario }}</h2>
            <div class="perfil-profesion-xl mb-2">{{ $empleado->profesion ?? 'Sin profesión definida' }}</div>
            <div class="perfil-resumen-xl">{{ $empleado->resumen_profesional ?? 'Agrega un resumen profesional para destacar.' }}</div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="row g-4">
                <div class="col-md-6">
                    {{-- Información de Contacto --}}
                    <section class="perfil-card perfil-section-card h-100">
                        <h5 class="mb-3"><i class="fas fa-share-alt me-2"></i> Contacto</h5>
                        <div class="perfil-social-links-grid">
                            @foreach(['whatsapp','facebook','instagram','linkedin'] as $red)
                                @php
                                    $icon = [
                                        'whatsapp' => 'fab fa-whatsapp',
                                        'facebook' => 'fab fa-facebook',
                                        'instagram' => 'fab fa-instagram',
                                        'linkedin' => 'fab fa-linkedin',
                                    ][$red];
                                    $valor = $empleado->$red;
                                @endphp
                                <div class="d-flex align-items-center mb-2" data-campo="{{ $red }}">
                                    <i class="{{ $icon }} me-2"></i>
                                    <span class="valor-campo flex-grow-1">{{ $valor }}</span>
                                    <button class="btn btn-sm btn-link text-primary editar-campo ms-2" title="Editar" type="button"><i class="fas fa-edit"></i></button>
                                </div>
                            @endforeach
                        </div>
                        <button class="btn btn-success w-100 mt-3">
                            <i class="fab fa-whatsapp me-2"></i>
                            Contactar
                        </button>
                    </section>
                </div>
                <div class="col-md-6">
                    {{-- Disponibilidad Laboral --}}
                    <section class="perfil-card perfil-section-card h-100">
                        <h5 class="mb-3"><i class="fas fa-calendar-check me-2"></i> Disponibilidad</h5>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="fw-bold">Horario</div>
                                <span class="valor-campo">{{ $empleado->disponibilidad_horario ?? '-' }}</span>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold">Jornada</div>
                                <span class="valor-campo">{{ $empleado->disponibilidad_jornada ?? '-' }}</span>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold">Movilidad</div>
                                <span class="valor-campo">{{ $empleado->disponibilidad_movilidad ? 'Sí' : 'No' }}</span>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-12">
                    {{-- Habilidades Destacadas --}}
                    <section class="perfil-card perfil-section-card">
                        <h5 class="mb-3"><i class="fas fa-star me-2"></i> Habilidades</h5>
                        <div class="perfil-list mb-2">
                            @foreach(explode(',', $empleado->habilidades ?? '') as $habilidad)
                                @if(trim($habilidad))
                                    <span class="badge badge-habilidad selected">
                                        <i class="fas fa-check-circle"></i> {{ trim($habilidad) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            {{-- Información Personal y CV --}}
            <section class="perfil-card perfil-section-card mb-4">
                <h5 class="mb-3"><i class="fas fa-user-edit me-2"></i> Información Personal</h5>
                <form action="{{ route('empleado.perfil.update', $empleado->id_usuario) }}" method="POST" enctype="multipart/form-data" id="perfilForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label"><i class="fas fa-user me-1"></i> Nombre *</label>
                        <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" value="{{ old('nombre_usuario', $empleado->nombre_usuario) }}" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label"><i class="fas fa-phone me-1"></i> Teléfono</label>
                        <input type="tel" class="form-control" name="telefono" id="telefono" value="{{ old('telefono', $empleado->telefono) }}" maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label for="ciudad" class="form-label"><i class="fas fa-map-marker-alt me-1"></i> Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" id="ciudad" value="{{ old('ciudad', $empleado->ciudad) }}" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="profesion" class="form-label"><i class="fas fa-briefcase me-1"></i> Profesión</label>
                        <input type="text" class="form-control" name="profesion" id="profesion" value="{{ old('profesion', $empleado->profesion) }}" maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label for="resumen_profesional" class="form-label"><i class="fas fa-file-alt me-1"></i> Resumen</label>
                        <textarea class="form-control" name="resumen_profesional" id="resumen_profesional" rows="3" maxlength="1000">{{ old('resumen_profesional', $empleado->resumen_profesional) }}</textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-2"></i> Guardar Cambios</button>
                    </div>
                </form>
            </section>
            <section class="perfil-card perfil-section-card">
                <h5 class="mb-3"><i class="fas fa-file-alt me-2"></i> Currículum Vitae (CV)</h5>
                <label for="cv" class="form-label"><i class="fas fa-upload me-1"></i> Subir nuevo CV</label>
                <input type="file" class="form-control" name="cv" id="cv" accept=".pdf,.doc,.docx">
                <div class="form-text"><i class="fas fa-info-circle me-1"></i> Formatos permitidos: PDF, DOC, DOCX (máx. 10MB)</div>
                @if ($empleado->cv_path)
                    <div class="mt-3">
                        <div class="alert alert-info"><i class="fas fa-file-pdf me-2"></i> <strong>CV actual:</strong> {{ basename($empleado->cv_path) }}</div>
                    </div>
                @endif
            </section>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            {{-- Experiencia Laboral --}}
            <section class="perfil-card perfil-section-card h-100">
                <h5 class="mb-3"><i class="fas fa-briefcase me-2"></i> Experiencia</h5>
                <div class="perfil-list">
                    @forelse($empleado->experiencias as $exp)
                        <div class="mb-3">
                            <div class="perfil-card-title">{{ $exp->puesto }}</div>
                            <div class="perfil-card-sub">{{ $exp->empresa }} • {{ $exp->periodo }}</div>
                            <div class="perfil-card-desc">{{ $exp->descripcion }}
                                @if($exp->logro)
                                    <span class="badge badge-habilidad ms-2">{{ $exp->logro }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Sin experiencia registrada.</div>
                    @endforelse
                </div>
            </section>
        </div>
        <div class="col-md-6 col-lg-4">
            {{-- Educación --}}
            <section class="perfil-card perfil-section-card h-100">
                <h5 class="mb-3"><i class="fas fa-graduation-cap me-2"></i> Educación</h5>
                <div class="perfil-list">
                    @forelse($empleado->educaciones as $edu)
                        <div class="mb-3">
                            <div class="perfil-card-title">{{ $edu->titulo }}</div>
                            <div class="perfil-card-sub">{{ $edu->institucion }} • {{ $edu->periodo }}</div>
                        </div>
                    @empty
                        <div class="text-muted">Sin educación registrada.</div>
                    @endforelse
                </div>
            </section>
        </div>
        <div class="col-md-12 col-lg-4">
            {{-- Certificados y Cursos --}}
            <section class="perfil-card perfil-section-card h-100">
                <h5 class="mb-3"><i class="fas fa-certificate me-2"></i> Certificados y Cursos</h5>
                <div class="perfil-list perfil-list-grid">
                    @forelse($empleado->certificados as $cert)
                        <div class="perfil-card perfil-card-cert mb-2">
                            <i class="fas fa-file-pdf fa-2x"></i>
                            <div>
                                <strong>{{ $cert->nombre }}</strong>
                                <div class="perfil-card-sub">{{ $cert->anio }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Sin certificados registrados.</div>
                    @endforelse
                </div>
            </section>
        </div>
        <div class="col-md-6 col-lg-4">
            {{-- Idiomas --}}
            <section class="perfil-card perfil-section-card h-100">
                <h5 class="mb-3"><i class="fas fa-language me-2"></i> Idiomas</h5>
                <div class="perfil-list">
                    @forelse($empleado->idiomas as $idioma)
                        <span class="badge badge-idioma mb-2" data-id="{{ $idioma->id }}">
                            <i class="fas fa-flag"></i> {{ $idioma->idioma }} <span class="small">({{ $idioma->nivel }})</span>
                        </span>
                    @empty
                        <div class="text-muted">Sin idiomas registrados.</div>
                    @endforelse
                </div>
            </section>
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
        btn.onclick = function() {
            const row = this.closest('[data-campo]');
            row.querySelector('.valor-campo').classList.add('d-none');
            row.querySelector('.input-campo').classList.remove('d-none');
            row.querySelector('.guardar-campo').classList.remove('d-none');
            this.classList.add('d-none');
        };
    });
    document.querySelectorAll('.guardar-campo').forEach(btn => {
        btn.onclick = function() {
            const row = this.closest('[data-campo]');
            const campo = row.getAttribute('data-campo');
            const input = row.querySelector('.input-campo');
            const valor = input.value;
            const errorDiv = row.querySelector('.error-campo');
            fetch("{{ route('empleado.perfil.campo') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                },
                body: JSON.stringify({ campo, valor })
            })
            .then(async res => {
                if(res.ok) return res.json();
                const data = await res.json();
                throw data;
            })
            .then(data => {
                row.querySelector('.valor-campo').textContent = valor;
                row.querySelector('.valor-campo').classList.remove('d-none');
                input.classList.remove('is-invalid');
                input.classList.add('d-none');
                errorDiv.style.display = 'none';
                errorDiv.textContent = '';
                row.querySelector('.guardar-campo').classList.add('d-none');
                row.querySelector('.editar-campo').classList.remove('d-none');
                if(valor) row.querySelector('.eliminar-campo').style.display = '';
                else row.querySelector('.eliminar-campo').style.display = 'none';
            })
            .catch(data => {
                let msg = 'Error al guardar.';
                if(data && data.errors && data.errors.valor && data.errors.valor.length) {
                    msg = data.errors.valor[0];
                }
                input.classList.add('is-invalid');
                errorDiv.textContent = msg;
                errorDiv.style.display = '';
            });
        };
    });
    document.querySelectorAll('.eliminar-campo').forEach(btn => {
        btn.onclick = function() {
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
        };
    });

    document.getElementById('btnAgregarExp').onclick = function() {
        document.getElementById('formAgregarExp').classList.remove('d-none');
    };
    document.getElementById('cancelarAgregarExp').onclick = function() {
        document.getElementById('formAgregarExp').classList.add('d-none');
    };
    document.getElementById('formAgregarExp').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        fetch("{{ route('empleado.perfil.experiencia.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
    };
    document.querySelectorAll('.btnEliminarExp').forEach(btn => {
        btn.onclick = function() {
            if(!confirm('¿Eliminar esta experiencia?')) return;
            const id = this.closest('.timeline-item').getAttribute('data-id');
            fetch(`/empleado/perfil/experiencia/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                }
            }).then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
        };
    });

    document.getElementById('btnAgregarEdu').onclick = function() {
        document.getElementById('formAgregarEdu').classList.remove('d-none');
    };
    document.getElementById('cancelarAgregarEdu').onclick = function() {
        document.getElementById('formAgregarEdu').classList.add('d-none');
    };
    document.getElementById('formAgregarEdu').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        fetch("{{ route('empleado.perfil.educacion.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
    };
    document.querySelectorAll('.btnEliminarEdu').forEach(btn => {
        btn.onclick = function() {
            if(!confirm('¿Eliminar esta educación?')) return;
            const id = this.closest('.timeline-item').getAttribute('data-id');
            fetch(`/empleado/perfil/educacion/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                }
            }).then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
        };
    });

    document.getElementById('btnAgregarIdioma').onclick = function() {
        document.getElementById('formAgregarIdioma').classList.remove('d-none');
    };
    document.getElementById('cancelarAgregarIdioma').onclick = function() {
        document.getElementById('formAgregarIdioma').classList.add('d-none');
    };
    document.getElementById('formAgregarIdioma').onsubmit = function(e) {
        e.preventDefault();
        const form = e.target;
        fetch("{{ route('empleado.perfil.idioma.store') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json',
            },
            body: new FormData(form)
        })
        .then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
    };
    document.querySelectorAll('.btnEliminarIdioma').forEach(btn => {
        btn.onclick = function() {
            if(!confirm('¿Eliminar este idioma?')) return;
            const id = this.closest('.perfil-idioma-chip').getAttribute('data-id');
            fetch(`/empleado/perfil/idioma/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                }
            }).then(res => res.ok ? location.reload() : res.json().then(data => alert(data.message || 'Error')));
        };
    });
});
</script>
@endsection 