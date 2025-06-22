@extends('layouts.empleador')

@section('title', 'Candidatos')
@section('page-description', 'Gestiona y revisa las aplicaciones de los candidatos')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Filtrar Candidatos</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('empleador.candidatos') }}" method="GET" class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="oferta" class="form-label">Filtrar por Oferta</label>
                <select name="oferta" id="oferta" class="form-select">
                    <option value="">Todas las ofertas</option>
                    @foreach($ofertas as $oferta)
                        <option value="{{ $oferta->id }}" {{ request('oferta') == $oferta->id ? 'selected' : '' }}>
                            {{ $oferta->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-select">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="aceptada" {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                    <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="orden" class="form-label">Ordenar por</label>
                <select name="orden" id="orden" class="form-select">
                    <option value="reciente" {{ request('orden') == 'reciente' ? 'selected' : '' }}>Más recientes</option>
                    <option value="antiguo" {{ request('orden') == 'antiguo' ? 'selected' : '' }}>Más antiguos</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-2"></i>Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

@if($aplicaciones->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Lista de Candidatos</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-vcenter mb-0">
                    <thead>
                        <tr>
                            <th>Candidato</th>
                            <th>Oferta</th>
                            <th>Fecha de Postulación</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aplicaciones as $aplicacion)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @php
                                            $avatarUrl = $aplicacion->empleado->foto_perfil;
                                            if ($avatarUrl && !Str::startsWith($avatarUrl, 'http')) {
                                                $avatarUrl = asset('storage/avatars/' . $avatarUrl);
                                            } else if (!$avatarUrl) {
                                                $avatarUrl = asset('images/user-default.svg');
                                            }
                                        @endphp
                                        <img src="{{ $avatarUrl }}" alt="Avatar" class="rounded-circle me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0">{{ $aplicacion->empleado->nombre_usuario }}</h6>
                                            <small class="text-muted">{{ $aplicacion->empleado->profesion ?? 'No especificada' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('empleador.ofertas.show', $aplicacion->oferta) }}">{{ $aplicacion->oferta->titulo }}</a>
                                </td>
                                <td>{{ $aplicacion->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $aplicacion->estado == 'aceptada' ? 'success' : ($aplicacion->estado == 'rechazada' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($aplicacion->estado) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" style="position: static;">
                                         <a href="{{ route('empleador.candidato.perfil', $aplicacion->empleado) }}" class="btn btn-sm btn-outline-primary" title="Ver Perfil"><i class="fas fa-eye"></i></a>
                                         <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                             <span class="visually-hidden">Toggle Dropdown</span>
                                         </button>
                                         <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <form action="{{ route('empleador.aplicaciones.actualizar', $aplicacion) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="estado" value="aceptada">
                                                    <button type="submit" class="dropdown-item"><i class="fas fa-check-circle me-2 text-success"></i>Aceptar</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('empleador.aplicaciones.actualizar', $aplicacion) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="estado" value="rechazada">
                                                    <button type="submit" class="dropdown-item"><i class="fas fa-times-circle me-2 text-danger"></i>Rechazar</button>
                                                </form>
                                            </li>
                                         </ul>
                                     </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if ($aplicaciones->hasPages())
            <div class="card-footer">
                {{ $aplicaciones->links() }}
            </div>
        @endif
    </div>
@else
    <div class="alert alert-info mt-4">
        No se encontraron candidatos con los filtros seleccionados.
    </div>
@endif

@endsection 