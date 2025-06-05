<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Perfil Empleador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/empleador.css') }}">
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
                        <a href="{{ route('empleador.dashboard') }}" class="nav-link">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.ofertas') }}" class="nav-link">
                            <i class="fas fa-briefcase"></i> Mis Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.candidatos') }}" class="nav-link">
                            <i class="fas fa-users"></i> Candidatos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.notificaciones') }}" class="nav-link">
                            <i class="fas fa-bell"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.perfil') }}" class="nav-link active">
                            <i class="fas fa-building"></i> Perfil Empresa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('empleador.configuracion') }}" class="nav-link">
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
                    <h4 class="mb-0">Perfil de la Empresa</h4>
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
                                    <img src="{{ Auth::user()->logo_empresa ?? asset('images/default-company.png') }}" class="rounded-circle m-2" width="30">
                                    <span>{{ Auth::user()->nombre_empresa }}</span>
                                @endauth
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('empleador.perfil') }}">Perfil Empresa</a></li>
                                <li><a class="dropdown-item" href="{{ route('empleador.configuracion') }}">Configuración</a></li>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title">Información de la Empresa</h5>
                                    <button class="btn btn-primary btn-sm" id="edit-info-btn">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>
                                </div>
                                
                                <form action="{{ route('empleador.actualizar-perfil') }}" method="POST" id="info-form">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nombre de la Empresa</label>
                                        <input type="text" name="nombre_empresa" class="form-control" value="{{ Auth::user()->nombre_empresa }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sector</label>
                                        <input type="text" name="sector" class="form-control" value="{{ Auth::user()->sector ?? '' }}" readonly>
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
                                        <label class="form-label">Sitio Web</label>
                                        <input type="url" name="sitio_web" class="form-control" value="{{ Auth::user()->sitio_web ?? '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Número de Empleados</label>
                                        <input type="number" name="numero_empleados" class="form-control" value="{{ Auth::user()->numero_empleados ?? '' }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sobre la Empresa</label>
                                        <textarea name="descripcion" class="form-control" rows="4" readonly>{{ Auth::user()->descripcion ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Misión</label>
                                        <textarea name="mision" class="form-control" rows="3" readonly>{{ Auth::user()->mision ?? '' }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Visión</label>
                                        <textarea name="vision" class="form-control" rows="3" readonly>{{ Auth::user()->vision ?? '' }}</textarea>
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
</body>
</html> 