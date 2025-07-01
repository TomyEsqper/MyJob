<div class="card-header">
    <i class="fas fa-user-circle"></i>
    <h3>Sobre Mí</h3>
</div>
<div class="card-body">
    <div class="info-group">
        <label class="info-label">Nombre Completo</label>
        <div class="info-value">{{ $empleado->nombre_usuario ?: 'No especificado' }}</div>
    </div>
    <div class="info-group">
        <label class="info-label">Profesión</label>
        <div class="info-value">{{ $empleado->profesion ?: 'No especificado' }}</div>
    </div>
    <div class="info-group">
        <label class="info-label">Teléfono</label>
        <div class="info-value">{{ $empleado->telefono ?: 'No especificado' }}</div>
    </div>
    <div class="info-group">
        <label class="info-label">Resumen Profesional</label>
        <div class="info-value">{{ $empleado->resumen_profesional ?: 'No especificado' }}</div>
    </div>
</div> 