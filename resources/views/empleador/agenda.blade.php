@extends('layouts.empleador')

@section('title', 'Agenda de Entrevistas')
@section('page-description', 'Consulta todas las entrevistas programadas para tus ofertas.')

@section('content')
<div class="card animate__animated animate__fadeInUp">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Agenda de Entrevistas</h4>
    </div>
    <div class="card-body">
        @if($entrevistas->count())
            <ul class="list-group list-group-flush">
                @foreach($entrevistas as $entrevista)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('empleador.candidato.perfil', $entrevista->aplicacion->empleado) }}" style="font-weight:bold; text-decoration:underline; color:#219150;">
                                {{ $entrevista->aplicacion->empleado->nombre_usuario }}
                            </a>
                            <span class="text-muted">para</span>
                            <a href="{{ route('empleador.ofertas.show', $entrevista->aplicacion->oferta) }}" style="font-weight:bold; text-decoration:underline; color:#219150;">
                                {{ $entrevista->aplicacion->oferta->titulo }}
                            </a><br>
                            <div class="mt-1">
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($entrevista->fecha_hora)->format('d/m/Y H:i') }}
                                    @if($entrevista->lugar)
                                        | <i class="fas fa-map-marker-alt me-1"></i>{{ $entrevista->lugar }}
                                    @endif
                                </span>
                                @if($entrevista->notas)
                                    <div class="small text-muted mt-1">{{ $entrevista->notas }}</div>
                                @endif
                            </div>
                        </div>
                        <span class="badge bg-success">Agendada</span>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="mb-2">No hay entrevistas programadas</h5>
                <p class="text-muted">Cuando agendes una entrevista, aparecerá aquí.</p>
            </div>
        @endif
    </div>
</div>
@endsection 