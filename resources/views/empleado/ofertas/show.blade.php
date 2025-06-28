@extends('layouts.empleado')

@section('page-title', 'Detalle de la Oferta')
@section('page-description', 'Información completa de la oferta de empleo.')

@section('content')
<div class="card-empleado" style="box-shadow: 0 8px 32px 0 rgba(62,160,85,0.10);">
    <div class="card-header-empleado" style="border-radius: 1.5rem 1.5rem 0 0;">
        <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Detalle de la Oferta</h5>
    </div>
    <div class="card-body-empleado">
        @if(isset($oferta))
            <div class="row g-4 align-items-start">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-4 bg-white shadow-sm" style="border: 1.5px solid #e6f4ea;">
                        <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle me-3" style="width: 56px; height: 56px; overflow: hidden;">
                            @if(isset($oferta->empleador->empleador->logo_empresa) && $oferta->empleador->empleador->logo_empresa)
                                <img src="{{ $oferta->empleador->empleador->logo_empresa }}" alt="Logo Empresa" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fas fa-building fa-2x text-success"></i>
                            @endif
                        </div>
                        <div>
                            <h2 class="mb-1" style="font-weight: 800; color: #219150; letter-spacing: 1px;">{{ $oferta->titulo }}</h2>
                            <span class="badge bg-light text-dark border px-3 py-2" style="font-size: 1rem; font-weight: 600;"><i class="fas fa-user-tie me-1"></i> {{ $oferta->empleador->empleador->nombre_empresa ?? 'Empresa no especificada' }}
                            @if(optional($oferta->empleador->empleador)->verificado)
                                <span title="Empresa verificada" style="color:#3b82f6; font-size:1.1em; vertical-align:middle; margin-left:0.2em;"><i class="fa-solid fa-circle-check"></i></span>
                            @endif
                            </span>
                        </div>
                    </div>
                    <div class="mb-4 p-4 rounded-4 bg-light border shadow-sm" style="max-width: 100%;">
                        <h6 class="mb-2" style="color: #219150; font-weight: 700;"><i class="fas fa-align-left me-2"></i>Descripción</h6>
                        <p class="mb-0" style="white-space: pre-line; word-break: break-word; font-size: 1.1rem; color: #333;">{{ $oferta->descripcion }}</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 bg-white border shadow-sm h-100">
                                <h6 class="mb-2" style="color: #43e97b; font-weight: 700;"><i class="fas fa-check-circle me-2"></i>Requisitos</h6>
                                <p class="mb-0" style="white-space: pre-line; word-break: break-word; color: #444;">{{ $oferta->requisitos ?? 'No especificados' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 rounded-4 bg-white border shadow-sm h-100">
                                <h6 class="mb-2" style="color: #7B61FF; font-weight: 700;"><i class="fas fa-tasks me-2"></i>Responsabilidades</h6>
                                <p class="mb-0" style="white-space: pre-line; word-break: break-word; color: #444;">{{ $oferta->responsabilidades ?? 'No especificadas' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 mb-3" style="border-radius: 1.2rem;">
                        <div class="card-body p-4">
                            <h6 class="card-title mb-3 text-secondary" style="font-weight: 700;"><i class="fas fa-info-circle me-2"></i>Información de la Oferta</h6>
                            <ul class="list-unstyled mb-4" style="font-size: 1.05rem;">
                                <li class="mb-2">
                                    <i class="fas fa-building text-success me-2"></i>
                                    <strong>Empresa:</strong>
                                    @if(isset($oferta->empleador->empleador) && $oferta->empleador->empleador && $oferta->empleador->empleador->nombre_empresa)
                                        {{ $oferta->empleador->empleador->nombre_empresa }}
                                    @else
                                        No especificada
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                    <strong>Ubicación:</strong> {{ $oferta->ubicacion }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <strong>Tipo de Contrato:</strong> {{ $oferta->tipo_contrato }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-money-bill-wave text-warning me-2"></i>
                                    <strong>Salario:</strong>
                                    @if(isset($oferta->salario_minimo) && isset($oferta->salario_maximo) && ($oferta->salario_minimo > 0 || $oferta->salario_maximo > 0))
                                        ${{ number_format($oferta->salario_minimo) }} - ${{ number_format($oferta->salario_maximo) }}
                                    @elseif(isset($oferta->salario) && $oferta->salario > 0)
                                        ${{ number_format($oferta->salario) }}
                                    @else
                                        No especificado
                                    @endif
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-calendar text-info me-2"></i>
                                    <strong>Publicada:</strong> {{ $oferta->created_at->diffForHumans() }}
                                </li>
                            </ul>
                            <div class="d-grid gap-2">
                                @if(!$yaAplicado)
                                <form action="{{ route('empleado.aplicar', $oferta) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn" style="background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); color: #fff; font-weight: 700; font-size: 1.1rem; border-radius: 999px; box-shadow: 0 4px 15px rgba(67,233,123,0.13);">
                                        <i class="fas fa-paper-plane me-1"></i> Aplicar a esta Oferta
                                    </button>
                                </form>
                                @else
                                    <button class="btn" style="background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); color: #fff; font-weight: 700; font-size: 1.1rem; border-radius: 999px; box-shadow: 0 4px 15px rgba(67,233,123,0.13);" disabled>
                                        <i class="fas fa-check-circle me-1"></i> Ya aplicaste
                                    </button>
                                @endif
                                <a href="{{ route('empleado.dashboard') }}" class="btn btn-outline-secondary" style="border-radius: 999px;">
                                    <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <h5>Oferta no encontrada</h5>
                <p class="text-muted">La oferta que buscas no existe o ha sido eliminada.</p>
                <a href="{{ route('empleado.dashboard') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 