<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perfil Empleado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleado.css') }}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-auto p-0 sidebar">
                <div class="logo d-flex align-items-center p-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
                </div>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a href="{{ route('empleado.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.aplicaciones') }}" class="nav-link">
                            <i class="fas fa-briefcase text-success"></i> Mis Aplicaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.buscar') }}" class="nav-link">
                            <i class="fas fa-search"></i> Buscar Empleos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.cv') }}" class="nav-link">
                            <i class="fas fa-file-alt"></i> Mi CV
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.notificaciones') }}" class="nav-link">
                            <i class="fas fa-bell"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.perfil') }}" class="nav-link active">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleado.configuracion') }}" class="nav-link">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <form action="{{ route('logout') }}" method="POST" class="nav-link">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger p-0">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col main-content">
                <!-- Header -->
                <div class="header">
                    <h4 class="mb-0">Mi Perfil</h4>
                    <div class="user-profile">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle text-decoration-none" data-bs-toggle="dropdown">
                                <i class="fas fa-bell text-muted"></i>
                                <span class="badge rounded-pill bg-danger">3</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Notificación 1</a></li>
                                <li><a class="dropdown-item" href="#">Notificación 2</a></li>
                                <li><a class="dropdown-item" href="#">Notificación 3</a></li>
                            </ul>
                        </div>
                        <div class="dropdown ms-3">
                            <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                                @auth
                                    <img src="{{ Auth::user()->foto_perfil ?? asset('images/default-user.png') }}" class="rounded-circle m-2" width="30">
                                    <span>{{ Auth::user()->nombre_usuario }}</span>
                                @endauth
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('empleado.perfil') }}">Mi Perfil</a></li>
                                <li><a class="dropdown-item" href="{{ route('empleado.configuracion') }}">Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

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
                                <img src="{{ Auth::user()->foto_perfil ?? asset('images/default-user.png') }}" class="rounded-circle mb-3" width="150" id="preview-foto">
                                <h5 class="card-title">{{ Auth::user()->nombre_usuario }}</h5>
                                <p class="card-text text-muted">{{ Auth::user()->profesion ?? 'Profesión no especificada' }}</p>
                                <form action="{{ route('empleado.actualizar-foto') }}" method="POST" enctype="multipart/form-data" id="foto-form">
                                    @csrf
                                    <input type="file" name="foto" id="foto" class="d-none" accept="image/*">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('foto').click()">
                                        <i class="fas fa-edit"></i> Editar Foto
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
                                <p class="mb-0">
                                    <i class="fas fa-map-marker-alt text-muted me-2"></i>
                                    {{ Auth::user()->ubicacion ?? 'No especificada' }}
                                </p>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0">Curriculum Vitae</h6>
                                    <form action="{{ route('empleado.actualizar-cv') }}" method="POST" enctype="multipart/form-data" id="cv-form">
                                        @csrf
                                        <input type="file" name="cv" id="cv" class="d-none" accept=".pdf,.doc,.docx">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('cv').click()">
                                            <i class="fas fa-upload"></i> Subir CV
                                        </button>
                                    </form>
                                </div>
                                @if(Auth::user()->cv_path)
                                    <div class="mt-3">
                                        <a href="{{ Auth::user()->cv_path }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                                            <i class="fas fa-file-pdf"></i> Ver CV
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title">Información Personal</h5>
                                    <button class="btn btn-primary btn-sm" id="edit-info-btn">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </div>
                                
                                <form action="{{ route('empleado.actualizar-perfil') }}" method="POST" id="info-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nombre Completo</label>
                                        <input type="text" name="nombre_usuario" class="form-control" value="{{ Auth::user()->nombre_usuario }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Profesión</label>
                                        <input type="text" name="profesion" class="form-control" value="{{ Auth::user()->profesion ?? '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ Auth::user()->telefono ?? '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ubicación</label>
                                        <input type="text" name="ubicacion" class="form-control" value="{{ Auth::user()->ubicacion ?? '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sobre Mí</label>
                                        <textarea name="descripcion" class="form-control" rows="4" readonly>{{ Auth::user()->descripcion ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Experiencia</label>
                                        <textarea name="experiencia" class="form-control" rows="4" readonly>{{ Auth::user()->experiencia ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Educación</label>
                                        <textarea name="educacion" class="form-control" rows="4" readonly>{{ Auth::user()->educacion ?? '' }}</textarea>
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
                                    <h5 class="card-title">Habilidades</h5>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#habilidadesModal">
                                        <i class="fas fa-plus"></i> Añadir
                                    </button>
                                </div>
                                <div class="skills" id="skills-container">
                                    @foreach(explode(',', Auth::user()->habilidades ?? '') as $habilidad)
                                        @if(trim($habilidad) != '')
                                            <span class="badge bg-primary me-2 mb-2">{{ trim($habilidad) }}</span>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Habilidades -->
    <div class="modal fade" id="habilidadesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestionar Habilidades</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="habilidades-form">
                        <div class="mb-3">
                            <label class="form-label">Habilidades Actuales</label>
                            <div id="habilidades-list">
                                @foreach(explode(',', Auth::user()->habilidades ?? '') as $habilidad)
                                    @if(trim($habilidad) != '')
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="habilidades[]" value="{{ trim($habilidad) }}">
                                            <button type="button" class="btn btn-danger remove-habilidad">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-habilidad-btn">
                                <i class="fas fa-plus"></i> Agregar Habilidad
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="save-habilidades-btn">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Manejo del formulario de información
        const editInfoBtn = document.getElementById('edit-info-btn');
        const cancelEditBtn = document.getElementById('cancel-edit-btn');
        const formButtons = document.getElementById('form-buttons');
        const infoForm = document.getElementById('info-form');
        let formInputs = infoForm.querySelectorAll('input, textarea');

        editInfoBtn.addEventListener('click', () => {
            formInputs.forEach(input => input.removeAttribute('readonly'));
            formButtons.classList.remove('d-none');
            editInfoBtn.classList.add('d-none');
        });

        cancelEditBtn.addEventListener('click', () => {
            formInputs.forEach(input => input.setAttribute('readonly', true));
            formButtons.classList.add('d-none');
            editInfoBtn.classList.remove('d-none');
        });

        // Manejo de la foto de perfil
        const fotoInput = document.getElementById('foto');
        const fotoPreview = document.getElementById('preview-foto');
        const fotoForm = document.getElementById('foto-form');

        fotoInput.addEventListener('change', () => {
            const file = fotoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    fotoPreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
                fotoForm.submit();
            }
        });

        // Manejo del CV
        const cvInput = document.getElementById('cv');
        const cvForm = document.getElementById('cv-form');

        cvInput.addEventListener('change', () => {
            if (cvInput.files[0]) {
                cvForm.submit();
            }
        });

        // Manejo de habilidades
        const addHabilidadBtn = document.getElementById('add-habilidad-btn');
        const habilidadesList = document.getElementById('habilidades-list');
        const saveHabilidadesBtn = document.getElementById('save-habilidades-btn');
        const habilidadesModal = document.getElementById('habilidadesModal');
        const skillsContainer = document.getElementById('skills-container');

        addHabilidadBtn.addEventListener('click', () => {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="text" class="form-control" name="habilidades[]" placeholder="Nueva habilidad">
                <button type="button" class="btn btn-danger remove-habilidad">
                    <i class="fas fa-times"></i>
                </button>
            `;
            habilidadesList.appendChild(div);
        });

        habilidadesList.addEventListener('click', (e) => {
            if (e.target.closest('.remove-habilidad')) {
                e.target.closest('.input-group').remove();
            }
        });

        saveHabilidadesBtn.addEventListener('click', async () => {
            const habilidades = Array.from(habilidadesList.querySelectorAll('input[name="habilidades[]"]'))
                .map(input => input.value.trim())
                .filter(value => value !== '');

            try {
                const response = await fetch('{{ route("empleado.actualizar-habilidades") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ habilidades })
                });

                const data = await response.json();

                if (data.success) {
                    skillsContainer.innerHTML = habilidades
                        .map(habilidad => `<span class="badge bg-primary me-2 mb-2">${habilidad}</span>`)
                        .join('');
                    
                    const modal = bootstrap.Modal.getInstance(habilidadesModal);
                    modal.hide();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    </script>
</body>
</html> 