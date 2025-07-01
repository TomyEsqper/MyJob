@extends('layouts.empleador')

@section('page-title', 'Perfil del Candidato')
@section('page-description', 'Revisa el perfil completo del candidato')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/empleado.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
.info-group {
    margin-bottom: 1.5rem;
}

.info-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    color: #1f2937;
    font-size: 1rem;
    line-height: 1.5;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-value:last-child {
    border-bottom: none;
}

.contact-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 0.75rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    font-size: 1.1rem;
}

.contact-info {
    flex: 1;
}

.contact-label {
    display: block;
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.contact-value {
    color: #1f2937;
    font-size: 1rem;
}

.skill-tag {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    margin: 0.25rem;
    font-size: 0.9rem;
    font-weight: 500;
}

.skill-tag i {
    margin-right: 0.5rem;
    font-size: 0.8rem;
}

.timeline-item {
    position: relative;
    padding-left: 2rem;
    margin-bottom: 2rem;
    border-left: 2px solid #e5e7eb;
}

.timeline-marker {
    position: absolute;
    left: -6px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: 2px solid white;
}

.timeline-header h4 {
    margin: 0 0 0.25rem 0;
    color: #1f2937;
    font-weight: 600;
}

.timeline-company {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
}

.timeline-period {
    color: #9ca3af;
    font-size: 0.8rem;
    margin: 0.5rem 0;
}

.timeline-description {
    color: #374151;
    line-height: 1.6;
    margin: 0.75rem 0;
}

.timeline-achievement {
    background: rgba(34, 197, 94, 0.1);
    color: #059669;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    font-size: 0.9rem;
    margin-top: 0.75rem;
    display: flex;
    align-items: center;
}

.timeline-achievement i {
    margin-right: 0.5rem;
}

.education-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.education-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    font-size: 1.2rem;
}

.education-content h4 {
    margin: 0 0 0.25rem 0;
    color: #1f2937;
    font-weight: 600;
}

.education-institution {
    color: #6b7280;
    font-size: 0.9rem;
    margin: 0 0 0.25rem 0;
}

.education-period {
    color: #9ca3af;
    font-size: 0.8rem;
}

.certificate-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.certificate-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    font-size: 1.2rem;
}

.certificate-content h4 {
    margin: 0 0 0.25rem 0;
    color: #1f2937;
    font-weight: 600;
}

.certificate-issuer {
    color: #6b7280;
    font-size: 0.9rem;
    margin: 0 0 0.25rem 0;
}

.certificate-date {
    color: #9ca3af;
    font-size: 0.8rem;
}

.language-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    margin-bottom: 0.75rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.language-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.language-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 1rem;
}

.language-level {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin: 0 0 1rem 0;
    font-size: 1rem;
}
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="animated-bg">
        <div class="bubble bubble1"></div>
        <div class="bubble bubble2"></div>
        <div class="bubble bubble3"></div>
        <div class="bubble bubble4"></div>
        <div class="bubble bubble5"></div>
    </div>
    <div class="profile-hero" style="position:relative;z-index:2;">
        <div class="profile-avatar-section fade-in-up">
            <div class="avatar-container" style="position:relative;">
                @if ($usuario->foto_perfil)
                    <img id="previewFotoPerfil" src="{{ Str::startsWith($usuario->foto_perfil, 'http') ? $usuario->foto_perfil : asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de Perfil" class="animated-avatar">
                @else
                    <img id="previewFotoPerfil" src="{{ asset('images/default-user.png') }}" alt="Foto de Perfil" class="animated-avatar">
                @endif
            </div>
        </div>
        <div class="profile-info fade-in-up delay-1">
            <h1 class="profile-name">
                {{ $usuario->nombre_usuario }}
                @if($usuario->verificado || $usuario->destacado)
                    <span title="Usuario verificado" style="color:#3b82f6; font-size:1.3em; vertical-align:middle; margin-left:0.3em;"><i class="fa-solid fa-circle-check"></i></span>
                @endif
            </h1>
            <p class="profile-title">{{ $usuario->profesion ?? 'Sin profesión definida' }}</p>
            <p class="profile-bio">{{ $usuario->resumen_profesional ?? 'Agrega un resumen profesional para destacar.' }}</p>
            <div class="profile-stats fade-in-up delay-2">
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-icon text-white"><i class="fas fa-briefcase"></i></span>
                        <span class="stat-number">{{ $usuario->experiencias->count() }}</span>
                        <span class="stat-label">EXPERIENCIAS</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon text-white"><i class="fas fa-graduation-cap"></i></span>
                        <span class="stat-number">{{ $usuario->educaciones->count() }}</span>
                        <span class="stat-label">EDUCACIÓN</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon text-white"><i class="fas fa-certificate"></i></span>
                        <span class="stat-number">{{ $usuario->certificados->count() }}</span>
                        <span class="stat-label">CERTIFICADOS</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-icon text-white"><i class="fas fa-language"></i></span>
                        <span class="stat-number">{{ $usuario->idiomas->count() }}</span>
                        <span class="stat-label">IDIOMAS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-content">
        <div class="content-grid">
            <div class="left-column">
                <div class="glass-card fade-in-up delay-2">
                    @include('empleador.candidatos._about', ['empleado' => $usuario])
                </div>
                <div class="glass-card fade-in-up delay-3">
                    @include('empleador.candidatos._contact', ['empleado' => $usuario])
                </div>
                <div class="glass-card fade-in-up delay-3">
                    @include('empleador.candidatos._skills', ['empleado' => $usuario])
                </div>
            </div>
            <div class="right-column">
                <div class="glass-card fade-in-up delay-2" id="experiencia-section">
                    @include('empleador.candidatos._experiencia', ['empleado' => $usuario])
                </div>
                <div class="glass-card fade-in-up delay-3" id="educacion-section">
                    @include('empleador.candidatos._educacion', ['empleado' => $usuario])
                </div>
                <div class="glass-card fade-in-up delay-3" id="certificados-section">
                    @include('empleador.candidatos._certificados', ['empleado' => $usuario])
                </div>
                <div class="glass-card fade-in-up delay-3" id="idiomas-section">
                    @include('empleador.candidatos._idiomas', ['empleado' => $usuario])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 