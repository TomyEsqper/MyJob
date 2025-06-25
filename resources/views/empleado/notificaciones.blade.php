@extends('layouts.empleado')

@section('page-title', 'Notificaciones')
@section('page-description', 'Todas tus notificaciones importantes y novedades.')

@section('content')
<div class="card-empleado">
    <div class="card-header-empleado">
        <h5 class="mb-0">Notificaciones</h5>
    </div>
    <div class="card-body-empleado">
        @if(count($notificaciones))
            <div class="notificaciones-list">
                @foreach($notificaciones as $notificacion)
                    <div class="notificacion-tarjeta notificacion-{{ $notificacion['tipo'] }} d-flex align-items-start mb-3 p-3 rounded-3 shadow-sm position-relative">
                        <div class="notificacion-icon me-3 mt-1">
                            @if($notificacion['tipo'] === 'success')
                                <i class="fas fa-check-circle"></i>
                            @elseif($notificacion['tipo'] === 'warning')
                                <i class="fas fa-exclamation-triangle"></i>
                            @else
                                <i class="fas fa-info-circle"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="notificacion-mensaje">{!! $notificacion['mensaje'] !!}</div>
                            <div class="notificacion-fecha text-end small mt-2">{{ $notificacion['fecha'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">No tienes notificaciones nuevas.</p>
            </div>
        @endif
    </div>
</div>
@endsection 