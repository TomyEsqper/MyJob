@extends('layouts.admin')

@section('title', 'Gestión de Empresas')

@section('page-title', 'Gestión de Empresas')

@section('content')
<div class="filters-card">
    <h3><i class="fa-solid fa-filter me-2"></i>Filtros Avanzados</h3>
    <form method="GET" action="/admin/empresas" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Buscar</label>
            <input type="text" name="q" class="form-control" placeholder="Nombre, correo o ID..." value="{{ request('q') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Estado</label>
            <select name="activo" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activa</option>
                <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactiva</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Verificado</label>
            <select name="verificado" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('verificado') === '1' ? 'selected' : '' }}>Verificado</option>
                <option value="0" {{ request('verificado') === '0' ? 'selected' : '' }}>No verificado</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">
                <i class="fa-solid fa-search me-1"></i> Buscar
            </button>
        </div>
    </form>
</div>

<div class="table-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3><i class="fa-solid fa-building me-2"></i>Listado de Empresas</h3>
            <small class="text-muted">Selecciona empresas para aplicar acciones masivas</small>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success fs-6">{{ $empresas->count() }} empresas encontradas</span>
            <button class="btn btn-outline-primary btn-sm" onclick="selectAll()">
                <i class="fa-solid fa-check-double me-1"></i> Seleccionar todas
            </button>
            <button class="btn btn-outline-secondary btn-sm" onclick="deselectAll()">
                <i class="fa-solid fa-times me-1"></i> Deseleccionar
            </button>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="alert alert-info mb-3" style="display: none;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-building me-2"></i>
                <span id="selectedCount">0</span> empresas seleccionadas
            </div>
            <div class="btn-group">
                <button class="btn btn-success btn-sm" onclick="bulkAction('activar')">
                    <i class="fa-solid fa-check me-1"></i> Activar
                </button>
                <button class="btn btn-warning btn-sm" onclick="bulkAction('desactivar')">
                    <i class="fa-solid fa-ban me-1"></i> Desactivar
                </button>
                <button class="btn btn-info btn-sm" onclick="bulkAction('verificar')">
                    <i class="fa-solid fa-building-circle-check me-1"></i> Verificar
                </button>
                <button class="btn btn-danger btn-sm" onclick="bulkAction('eliminar')">
                    <i class="fa-solid fa-trash me-1"></i> Eliminar
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
                    <th>ID</th>
                    <th>Empresa</th>
                    <th>Correo</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($empresas as $empresa)
                    <tr>
                        <td>
                            <input type="checkbox" class="form-check-input empresa-checkbox" value="{{ $empresa->id_usuario }}">
                        </td>
                        <td>{{ $empresa->id_usuario }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="company-logo me-2">
                                    @if($empresa->empleador && $empresa->empleador->logo_empresa)
                                        <img src="{{ asset($empresa->empleador->logo_empresa) }}" alt="Logo" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-building text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $empresa->nombre_usuario }}</div>
                                    <div class="small text-muted">
                                        @if($empresa->verificado)
                                            <span class="badge bg-info"><i class="fa-solid fa-check me-1"></i>Verificado</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $empresa->correo_electronico }}</td>
                        <td>
                            @if($empresa->activo)
                                <span class="status-badge status-activa">Activa</span>
                            @else
                                <span class="status-badge status-inactiva">Inactiva</span>
                            @endif
                        </td>
                        <td>{{ $empresa->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-danger btn-action" onclick="eliminarEmpresa({{ $empresa->id_usuario }})" title="Eliminar empresa">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button class="btn btn-info btn-action" onclick="verificarEmpresa({{ $empresa->id_usuario }})" title="Verificar empresa">
                                    <i class="fa-solid fa-building-circle-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fa-solid fa-building fa-3x text-muted mb-3 d-block"></i>
                            <h5 class="text-muted">No se encontraron empresas</h5>
                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Funciones de selección
function selectAll() {
    document.querySelectorAll('.empresa-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    document.getElementById('selectAllCheckbox').checked = true;
    updateBulkActions();
}

function deselectAll() {
    document.querySelectorAll('.empresa-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkActions();
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.empresa-checkbox:checked');
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
        document.querySelectorAll('.empresa-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });
    
    // Individual checkboxes
    document.querySelectorAll('.empresa-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});

// Bulk actions
function bulkAction(action) {
    const selectedEmpresas = Array.from(document.querySelectorAll('.empresa-checkbox:checked')).map(cb => cb.value);
    
    if (selectedEmpresas.length === 0) {
        Swal.fire('Error', 'No hay empresas seleccionadas', 'error');
        return;
    }
    
    let title, text, confirmButtonText;
    
    switch(action) {
        case 'activar':
            title = '¿Activar empresas?';
            text = `¿Estás seguro de activar ${selectedEmpresas.length} empresas?`;
            confirmButtonText = 'Sí, activar';
            break;
        case 'desactivar':
            title = '¿Desactivar empresas?';
            text = `¿Estás seguro de desactivar ${selectedEmpresas.length} empresas?`;
            confirmButtonText = 'Sí, desactivar';
            break;
        case 'verificar':
            title = '¿Verificar empresas?';
            text = `¿Estás seguro de verificar ${selectedEmpresas.length} empresas?`;
            confirmButtonText = 'Sí, verificar';
            break;
        case 'eliminar':
            title = '¿Eliminar empresas?';
            text = `¿Estás seguro de eliminar ${selectedEmpresas.length} empresas? Esta acción no se puede deshacer.`;
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
            fetch(`/admin/empresas/bulk-action`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: action,
                    empresas: selectedEmpresas
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
function eliminarEmpresa(empresaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción eliminará la empresa y todas sus ofertas. No se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/empresas/${empresaId}/eliminar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', 'La empresa ha sido eliminada.', 'success')
                    .then(() => location.reload());
                } else {
                    Swal.fire('Error', 'No se pudo eliminar la empresa.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Ocurrió un error al eliminar la empresa.', 'error');
            });
        }
    });
}

function verificarEmpresa(empresaId) {
    fetch(`/admin/empresas/${empresaId}/verificar`, {
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
</script>
@endpush 