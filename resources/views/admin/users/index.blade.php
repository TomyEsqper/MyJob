@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="filters-card">
    <h3><i class="fa-solid fa-filter me-2"></i>Filtros Avanzados</h3>
    <form method="GET" action="/admin/usuarios" class="row g-3">
        <div class="col-lg-4 col-md-6 col-12">
            <label class="form-label">Buscar</label>
            <input type="text" name="q" class="form-control" placeholder="Nombre, correo o ID..." value="{{ request('q') }}">
        </div>
        <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label">Estado</label>
            <select name="activo" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label">Verificado</label>
            <select name="verificado" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('verificado') === '1' ? 'selected' : '' }}>Verificado</option>
                <option value="0" {{ request('verificado') === '0' ? 'selected' : '' }}>No verificado</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-3 col-6">
            <label class="form-label">Destacado</label>
            <select name="destacado" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('destacado') === '1' ? 'selected' : '' }}>Destacado</option>
                <option value="0" {{ request('destacado') === '0' ? 'selected' : '' }}>No destacado</option>
            </select>
        </div>
        <div class="col-lg-2 col-md-3 col-6 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">
                <i class="fa-solid fa-search me-1"></i> <span class="d-none d-md-inline">Buscar</span>
            </button>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
        <div>
            <h3><i class="fa-solid fa-users me-2"></i>Listado de Usuarios</h3>
            <small class="text-muted">Selecciona usuarios para aplicar acciones masivas</small>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-2">
            <span class="badge bg-success fs-6">{{ $usuarios->count() }} usuarios encontrados</span>
            <div class="btn-group" role="group">
                <button class="btn btn-outline-primary btn-sm" onclick="selectAll()">
                    <i class="fa-solid fa-check-double me-1"></i> <span class="d-none d-sm-inline">Seleccionar todos</span>
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="deselectAll()">
                    <i class="fa-solid fa-times me-1"></i> <span class="d-none d-sm-inline">Deseleccionar</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="alert alert-info mb-3" style="display: none;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <i class="fa-solid fa-users me-2"></i>
                <span id="selectedCount">0</span> usuarios seleccionados
            </div>
            <div class="btn-group flex-wrap" role="group">
                <button class="btn btn-success btn-sm" onclick="bulkAction('activar')">
                    <i class="fa-solid fa-check me-1"></i> <span class="d-none d-sm-inline">Activar</span>
                </button>
                <button class="btn btn-warning btn-sm" onclick="bulkAction('desactivar')">
                    <i class="fa-solid fa-ban me-1"></i> <span class="d-none d-sm-inline">Desactivar</span>
                </button>
                <button class="btn btn-info btn-sm" onclick="bulkAction('verificar')">
                    <i class="fa-solid fa-user-check me-1"></i> <span class="d-none d-sm-inline">Verificar</span>
                </button>
                <button class="btn btn-primary btn-sm" onclick="bulkAction('destacar')">
                    <i class="fa-solid fa-star me-1"></i> <span class="d-none d-sm-inline">Destacar</span>
                </button>
                <button class="btn btn-danger btn-sm" onclick="bulkAction('eliminar')">
                    <i class="fa-solid fa-trash me-1"></i> <span class="d-none d-sm-inline">Eliminar</span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="50">
                        <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                    </th>
                    <th class="d-none d-md-table-cell">ID</th>
                    <th>Usuario</th>
                    <th class="d-none d-lg-table-cell">Correo</th>
                    <th>Estado</th>
                    <th class="d-none d-md-table-cell">Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $usuario->id_usuario }}">
                        </td>
                        <td class="d-none d-md-table-cell">{{ $usuario->id_usuario }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-2">
                                    @if($usuario->foto_perfil)
                                        <img src="{{ asset($usuario->foto_perfil) }}" alt="Avatar" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-user text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">
                                        <a href="/admin/usuarios/{{ $usuario->id_usuario }}/perfil" class="text-decoration-none text-dark">
                                            {{ $usuario->nombre_usuario }}
                                        </a>
                                    </div>
                                    <div class="small text-muted d-md-none">
                                        {{ Str::limit($usuario->correo_electronico, 25) }}
                                    </div>
                                    <div class="small text-muted">
                                        @if($usuario->verificado)
                                            <span class="badge bg-info me-1"><i class="fa-solid fa-check me-1"></i><span class="d-none d-sm-inline">Verificado</span></span>
                                        @endif
                                        @if($usuario->destacado)
                                            <span class="badge bg-warning"><i class="fa-solid fa-star me-1"></i><span class="d-none d-sm-inline">Destacado</span></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="d-none d-lg-table-cell">{{ $usuario->correo_electronico }}</td>
                        <td>
                            @if($usuario->activo)
                                <span class="status-badge status-activa">Activo</span>
                            @else
                                <span class="status-badge status-inactiva">Inactivo</span>
                            @endif
                        </td>
                        <td class="d-none d-md-table-cell">{{ $usuario->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/admin/usuarios/{{ $usuario->id_usuario }}/perfil" class="btn btn-primary btn-action" title="Ver perfil completo">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <button class="btn btn-danger btn-action" onclick="eliminarUsuario({{ $usuario->id_usuario }})" title="Eliminar usuario">
                                    <i class="fa-solid fa-user-xmark"></i>
                                </button>
                                <button class="btn btn-info btn-action" onclick="verificarUsuario({{ $usuario->id_usuario }})" title="Verificar usuario">
                                    <i class="fa-solid fa-user-check"></i>
                                </button>
                                <button class="btn btn-warning btn-action" onclick="destacarUsuario({{ $usuario->id_usuario }})" title="Destacar usuario">
                                    <i class="fa-solid fa-star"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa-solid fa-users fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No se encontraron usuarios</h5>
                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($usuarios->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $usuarios->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Funciones de selección
function selectAll() {
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    document.getElementById('selectAllCheckbox').checked = true;
    updateBulkActions();
}

function deselectAll() {
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.user-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (checkboxes.length > 0) {
        bulkActions.style.display = 'block';
        selectedCount.textContent = checkboxes.length;
    } else {
        bulkActions.style.display = 'none';
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Select all checkbox
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
    
    // Individual checkboxes
    document.querySelectorAll('.user-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});

// Bulk actions
function bulkAction(action) {
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);
    
    if (selectedUsers.length === 0) {
        Swal.fire('Error', 'No hay usuarios seleccionados', 'error');
        return;
    }
    
    let title, text, confirmButtonText;
    
    switch(action) {
        case 'activar':
            title = '¿Activar usuarios?';
            text = `¿Estás seguro de activar ${selectedUsers.length} usuarios?`;
            confirmButtonText = 'Sí, activar';
            break;
        case 'desactivar':
            title = '¿Desactivar usuarios?';
            text = `¿Estás seguro de desactivar ${selectedUsers.length} usuarios?`;
            confirmButtonText = 'Sí, desactivar';
            break;
        case 'verificar':
            title = '¿Verificar usuarios?';
            text = `¿Estás seguro de verificar ${selectedUsers.length} usuarios?`;
            confirmButtonText = 'Sí, verificar';
            break;
        case 'destacar':
            title = '¿Destacar usuarios?';
            text = `¿Estás seguro de destacar ${selectedUsers.length} usuarios?`;
            confirmButtonText = 'Sí, destacar';
            break;
        case 'eliminar':
            title = '¿Eliminar usuarios?';
            text = `¿Estás seguro de eliminar ${selectedUsers.length} usuarios? Esta acción no se puede deshacer.`;
            confirmButtonText = 'Sí, eliminar';
            break;
    }
    
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: confirmButtonText,
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/usuarios/bulk-action`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    users: selectedUsers
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Éxito!', data.message, 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al procesar la acción.', 'error');
            });
        }
    });
}

// Funciones individuales existentes
function eliminarUsuario(usuarioId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/usuarios/${usuarioId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'El usuario ha sido eliminado.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', 'No se pudo eliminar el usuario.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar el usuario.', 'error');
            });
        }
    });
}

function verificarUsuario(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/verificar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de verificación ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar la verificación.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar la verificación.', 'error');
    });
}

function destacarUsuario(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/destacar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('¡Actualizado!', 'El estado de destacado ha sido cambiado.', 'success')
            .then(() => location.reload());
        } else {
            Swal.fire('Error', 'No se pudo cambiar el destacado.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Ocurrió un error al cambiar el destacado.', 'error');
    });
}
</script>
@endpush 