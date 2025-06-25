@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Gestión de Usuarios</h1>
            <p class="mb-0">Administra los usuarios del sistema</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-download me-2"></i>Exportar
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
                <div class="col-12 col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" 
                           class="form-control" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Nombre o correo electrónico">
                </div>
                <div class="col-12 col-md-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-select" id="rol" name="rol">
                        <option value="">Todos</option>
                        <option value="empleado" {{ request('rol') === 'empleado' ? 'selected' : '' }}>Empleado</option>
                        <option value="empleador" {{ request('rol') === 'empleador' ? 'selected' : '' }}>Empleador</option>
                        <option value="admin" {{ request('rol') === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label for="status" class="form-label">Estado</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), [
                                'sort' => 'nombre_usuario',
                                'direction' => request('sort') === 'nombre_usuario' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}" class="text-decoration-none text-dark">
                                Usuario
                                @if(request('sort') === 'nombre_usuario')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), [
                                'sort' => 'correo_electronico',
                                'direction' => request('sort') === 'correo_electronico' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}" class="text-decoration-none text-dark">
                                Correo
                                @if(request('sort') === 'correo_electronico')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>
                            <a href="{{ route('admin.users.index', array_merge(request()->query(), [
                                'sort' => 'created_at',
                                'direction' => request('sort') === 'created_at' && request('direction') === 'asc' ? 'desc' : 'asc'
                            ])) }}" class="text-decoration-none text-dark">
                                Registro
                                @if(request('sort') === 'created_at')
                                    <i class="fas fa-sort-{{ request('direction') === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </a>
                        </th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $user->foto_perfil ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->nombre_usuario) }}" 
                                     class="rounded-circle me-2" 
                                     width="32" 
                                     height="32"
                                     alt="{{ $user->nombre_usuario }}">
                                {{ $user->nombre_usuario }}
                            </div>
                        </td>
                        <td>{{ $user->correo_electronico }}</td>
                        <td>
                            <span class="badge bg-{{ $user->rol === 'admin' ? 'danger' : ($user->rol === 'empleador' ? 'primary' : 'success') }}">
                                {{ ucfirst($user->rol) }}
                            </span>
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="status-{{ $user->id_usuario }}"
                                       {{ $user->activo ? 'checked' : '' }}
                                       onchange="toggleUserStatus({{ $user->id_usuario }})">
                            </div>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="btn btn-sm btn-info text-white"
                                   title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-sm btn-warning text-white"
                                   title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $user->id_usuario }})"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted mb-2">No se encontraron usuarios</h5>
                                <p class="text-muted mb-0">Intenta ajustar los filtros de búsqueda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Exportación -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exportar Usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.export') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Formato</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatXLSX" value="xlsx" checked>
                                <label class="form-check-label" for="formatXLSX">Excel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatCSV" value="csv">
                                <label class="form-check-label" for="formatCSV">CSV</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="formatPDF" value="pdf">
                                <label class="form-check-label" for="formatPDF">PDF</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Campos a exportar</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" value="nombre_usuario" id="fieldName" checked>
                                    <label class="form-check-label" for="fieldName">Nombre</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" value="correo_electronico" id="fieldEmail" checked>
                                    <label class="form-check-label" for="fieldEmail">Correo</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" value="rol" id="fieldRole" checked>
                                    <label class="form-check-label" for="fieldRole">Rol</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fields[]" value="created_at" id="fieldDate" checked>
                                    <label class="form-check-label" for="fieldDate">Fecha de registro</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="document.querySelector('#exportModal form').submit()">
                    <i class="fas fa-download me-2"></i>Exportar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar usuario -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
function toggleUserStatus(userId) {
    fetch(`/admin/users/${userId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            // Revertir el cambio en el switch
            document.getElementById(`status-${userId}`).checked = !document.getElementById(`status-${userId}`).checked;
            // Mostrar mensaje de error
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Revertir el cambio en el switch
        document.getElementById(`status-${userId}`).checked = !document.getElementById(`status-${userId}`).checked;
        alert('Error al cambiar el estado del usuario');
    });
}

function confirmDelete(userId) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/users/${userId}`;
        form.submit();
    }
}
</script>
@endpush
