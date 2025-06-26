<div class="card-header">
    <i class="fas fa-briefcase"></i>
    <h3>Experiencia Laboral</h3>
    <button class="btn-add" id="btnAgregarExp" onclick="mostrarFormularioExperiencia()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body">
    <!-- Vista de experiencias -->
    <div class="experiences-container" id="experiencesView">
        <div class="timeline">
            @forelse($empleado->experiencias as $exp)
                <div class="timeline-item" data-id="{{ $exp->id }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <h4>{{ $exp->puesto }}</h4>
                            <span class="timeline-company">{{ $exp->empresa }}</span>
                        </div>
                        <div class="timeline-period">{{ $exp->periodo }}</div>
                        <p class="timeline-description">{{ $exp->descripcion }}</p>
                        @if($exp->logro)
                            <div class="timeline-achievement">
                                <i class="fas fa-trophy"></i>
                                {{ $exp->logro }}
                            </div>
                        @endif
                        <button class="btn-delete btnEliminarExp" onclick="eliminarExperiencia({{ $exp->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-briefcase"></i>
                    <p>No hay experiencia registrada</p>
                    <button class="btn btn-primary btn-sm" onclick="mostrarFormularioExperiencia()">Agregar Experiencia</button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Formulario de agregar experiencia -->
    <div class="experience-form-container" id="experienceFormContainer" style="display: none;">
        <form id="experienciaForm" action="{{ route('empleado.perfil.experiencia.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="puesto">Puesto <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('puesto') is-invalid @enderror" 
                       name="puesto" 
                       id="puesto" 
                       value="{{ old('puesto') }}" 
                       required 
                       placeholder="Ej: Desarrollador Web Full Stack">
                @error('puesto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="empresa">Empresa <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('empresa') is-invalid @enderror" 
                       name="empresa" 
                       id="empresa" 
                       value="{{ old('empresa') }}" 
                       required 
                       placeholder="Ej: Google, Microsoft, etc.">
                @error('empresa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha_inicio">Fecha de Inicio <span class="required-field">*</span></label>
                    <input type="date" 
                           class="modern-input @error('fecha_inicio') is-invalid @enderror" 
                           name="fecha_inicio" 
                           id="fecha_inicio" 
                           value="{{ old('fecha_inicio') }}" 
                           required>
                    @error('fecha_inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-md-6">
                    <label for="fecha_fin">Fecha de Fin</label>
                    <input type="date" 
                           class="modern-input @error('fecha_fin') is-invalid @enderror" 
                           name="fecha_fin" 
                           id="fecha_fin" 
                           value="{{ old('fecha_fin') }}">
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Déjalo vacío si es tu trabajo actual
                    </small>
                    @error('fecha_fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción de Responsabilidades</label>
                <textarea class="modern-input @error('descripcion') is-invalid @enderror" 
                          name="descripcion" 
                          id="descripcion" 
                          rows="4"
                          placeholder="Describe tus responsabilidades y logros principales...">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="logro">Logro Principal (Opcional)</label>
                <input type="text" 
                       class="modern-input @error('logro') is-invalid @enderror" 
                       name="logro" 
                       id="logro" 
                       value="{{ old('logro') }}" 
                       placeholder="Ej: Incrementé las ventas en un 25%">
                @error('logro')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-modern" id="btnGuardarExperiencia">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar Experiencia</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarExperiencia()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones básicas para manejo de experiencia
function mostrarFormularioExperiencia() {
    document.getElementById('experiencesView').style.display = 'none';
    document.getElementById('experienceFormContainer').style.display = 'block';
    
    // Enfocar el primer campo
    setTimeout(() => {
        document.getElementById('puesto').focus();
    }, 100);
}

function cancelarExperiencia() {
    document.getElementById('experienceFormContainer').style.display = 'none';
    document.getElementById('experiencesView').style.display = 'block';
    
    // Limpiar formulario
    document.getElementById('experienciaForm').reset();
}

function eliminarExperiencia(id) {
    showConfirmModal('¿Estás seguro de que quieres eliminar esta experiencia?', function() {
        fetch("{{ route('empleado.perfil.experiencia.destroy', ':id') }}".replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                return response.json().then(data => {
                    alert(data.message || 'Error al eliminar experiencia');
                });
            }
        })
        .catch(error => {
            alert('Error de conexión. Intenta nuevamente.');
        });
    });
}
</script> 