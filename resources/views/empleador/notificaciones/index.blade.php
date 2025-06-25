@extends('layouts.empleador')

@section('title', 'Notificaciones')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-bell text-primary me-2"></i>
                        Notificaciones
                    </h5>
                    <div class="btn-group">
                        <button type="button" 
                                class="btn btn-outline-primary btn-sm" 
                                onclick="marcarTodasComoLeidas()">
                            <i class="fas fa-check-double me-1"></i>
                            Marcar todas como leídas
                        </button>
                        <button type="button" 
                                class="btn btn-outline-danger btn-sm" 
                                onclick="eliminarTodas()">
                            <i class="fas fa-trash me-1"></i>
                            Eliminar todas
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($notificaciones->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tienes notificaciones</p>
                        </div>
                    @else
                        <div class="list-group list-group-flush" id="notificaciones-lista">
                            @foreach($notificaciones as $notificacion)
                                <div class="list-group-item px-4 py-3 {{ $notificacion->leida ? 'bg-light' : 'bg-white' }}"
                                     id="notificacion-{{ $notificacion->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle p-2 {{ $notificacion->color_clase }} bg-opacity-10" 
                                                 style="width: 45px; height: 45px;">
                                                <i class="{{ $notificacion->icono_clase }} fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0 fw-semibold">{{ $notificacion->titulo }}</h6>
                                                <small class="text-muted">{{ $notificacion->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 text-muted">{{ $notificacion->mensaje }}</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <div class="btn-group">
                                                @if(!$notificacion->leida)
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary"
                                                            onclick="marcarComoLeida({{ $notificacion->id }})">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                @if($notificacion->url)
                                                    <a href="{{ $notificacion->url }}" 
                                                       class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @endif
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="eliminarNotificacion({{ $notificacion->id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="px-4 py-3">
                            {{ $notificaciones->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function marcarComoLeida(id) {
    axios.post(`/empleador/notificaciones/${id}/marcar-leida`)
        .then(response => {
            if (response.data.success) {
                const notificacion = document.getElementById(`notificacion-${id}`);
                notificacion.classList.remove('bg-white');
                notificacion.classList.add('bg-light');
                actualizarContadorNotificaciones();
            }
        })
        .catch(error => console.error('Error:', error));
}

function marcarTodasComoLeidas() {
    axios.post('/empleador/notificaciones/marcar-todas-leidas')
        .then(response => {
            if (response.data.success) {
                document.querySelectorAll('.list-group-item').forEach(item => {
                    item.classList.remove('bg-white');
                    item.classList.add('bg-light');
                });
                actualizarContadorNotificaciones();
            }
        })
        .catch(error => console.error('Error:', error));
}

function eliminarNotificacion(id) {
    if (!confirm('¿Estás seguro de que deseas eliminar esta notificación?')) return;

    axios.delete(`/empleador/notificaciones/${id}`)
        .then(response => {
            if (response.data.success) {
                const notificacion = document.getElementById(`notificacion-${id}`);
                notificacion.remove();
                actualizarContadorNotificaciones();
            }
        })
        .catch(error => console.error('Error:', error));
}

function eliminarTodas() {
    if (!confirm('¿Estás seguro de que deseas eliminar todas las notificaciones?')) return;

    axios.delete('/empleador/notificaciones/eliminar-todas')
        .then(response => {
            if (response.data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
}

function actualizarContadorNotificaciones() {
    axios.get('/empleador/notificaciones/no-leidas')
        .then(response => {
            const contador = document.getElementById('contador-notificaciones');
            if (contador) {
                contador.textContent = response.data.count;
                if (response.data.count === 0) {
                    contador.style.display = 'none';
                } else {
                    contador.style.display = 'inline-block';
                }
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection 