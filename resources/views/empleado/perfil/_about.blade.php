<div class="card-header">
    <i class="fas fa-user-circle"></i>
    <h3>Sobre Mí</h3>
</div>
<div class="card-body">
    <form action="{{ route('empleado.perfil.update', $empleado->id_usuario) }}" method="POST" enctype="multipart/form-data" id="perfilForm">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre_usuario">Nombre Completo <span class="required-field">*</span></label>
            <input type="text" 
                   class="modern-input @error('nombre_usuario') is-invalid @enderror" 
                   name="nombre_usuario" 
                   id="nombre_usuario" 
                   value="{{ old('nombre_usuario', $empleado->nombre_usuario) }}" 
                   required 
                   placeholder="Ej: Juan Carlos Pérez García">
            @error('nombre_usuario')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="profesion">Profesión <span class="recommended-field">*</span></label>
            <input type="text" 
                   class="modern-input @error('profesion') is-invalid @enderror" 
                   name="profesion" 
                   id="profesion" 
                   value="{{ old('profesion', $empleado->profesion) }}"
                   placeholder="Ej: Desarrollador Web Full Stack">
            @error('profesion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="tel" 
                   class="modern-input @error('telefono') is-invalid @enderror" 
                   name="telefono" 
                   id="telefono" 
                   value="{{ old('telefono', $empleado->telefono) }}"
                   placeholder="Ej: +57 300 123 4567">
            @error('telefono')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="resumen_profesional">Resumen Profesional</label>
            <textarea class="modern-input @error('resumen_profesional') is-invalid @enderror" 
                      name="resumen_profesional" 
                      id="resumen_profesional" 
                      rows="4"
                      placeholder="Cuéntanos brevemente sobre tu experiencia, habilidades y objetivos profesionales...">{{ old('resumen_profesional', $empleado->resumen_profesional) }}</textarea>
            @error('resumen_profesional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                <i class="fas fa-info-circle"></i> 
                Este resumen aparecerá en tu perfil público. Sé conciso pero descriptivo.
            </small>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-modern" id="btnGuardarPerfil">
                <i class="fas fa-save"></i>
                <span class="btn-text">Guardar Cambios</span>
                <span class="btn-loading" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i>
                    Guardando...
                </span>
            </button>
        </div>
    </form>
</div> 