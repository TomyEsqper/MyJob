<div class="card-header">
    <i class="fas fa-graduation-cap"></i>
    <h3>Educación</h3>
    <button class="btn-add" id="btnAgregarEdu" onclick="mostrarFormularioEducacion()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body">
    <!-- Vista de educación -->
    <div class="education-container" id="educationView">
        <div class="education-list">
            @forelse($empleado->educaciones as $edu)
                <div class="education-item" data-id="{{ $edu->id }}">
                    <div class="education-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="education-content">
                        <h4>{{ $edu->titulo }}</h4>
                        <p class="education-institution">{{ $edu->institucion }}</p>
                        <span class="education-period">{{ $edu->periodo }}</span>
                    </div>
                    <button class="btn-delete btnEliminarEdu" onclick="eliminarEducacion({{ $edu->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-graduation-cap"></i>
                    <p>No hay educación registrada</p>
                    <button class="btn btn-primary btn-sm" onclick="mostrarFormularioEducacion()">Agregar Educación</button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Formulario de agregar educación -->
    <div class="education-form-container" id="educationFormContainer" style="display: none;">
        <form id="educacionForm" action="{{ route('empleado.perfil.educacion.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="titulo">Título o Grado <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('titulo') is-invalid @enderror" 
                       name="titulo" 
                       id="titulo" 
                       value="{{ old('titulo') }}" 
                       required 
                       placeholder="Ej: Ingeniero de Sistemas, Licenciado en Administración">
                @error('titulo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="institucion">Institución <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('institucion') is-invalid @enderror" 
                       name="institucion" 
                       id="institucion" 
                       value="{{ old('institucion') }}" 
                       required 
                       placeholder="Ej: Universidad Nacional, Instituto Tecnológico">
                @error('institucion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha_inicio_edu">Fecha de Inicio <span class="required-field">*</span></label>
                    <input type="date" 
                           class="modern-input @error('fecha_inicio_edu') is-invalid @enderror" 
                           name="fecha_inicio_edu" 
                           id="fecha_inicio_edu" 
                           value="{{ old('fecha_inicio_edu') }}" 
                           required>
                    @error('fecha_inicio_edu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-md-6">
                    <label for="fecha_fin_edu">Fecha de Fin</label>
                    <input type="date" 
                           class="modern-input @error('fecha_fin_edu') is-invalid @enderror" 
                           name="fecha_fin_edu" 
                           id="fecha_fin_edu" 
                           value="{{ old('fecha_fin_edu') }}">
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i> 
                        Déjalo vacío si estás estudiando actualmente
                    </small>
                    @error('fecha_fin_edu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion_edu">Descripción (Opcional)</label>
                <textarea class="modern-input @error('descripcion_edu') is-invalid @enderror" 
                          name="descripcion_edu" 
                          id="descripcion_edu" 
                          rows="3"
                          placeholder="Describe brevemente tu formación, especialización, etc...">{{ old('descripcion_edu') }}</textarea>
                @error('descripcion_edu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-modern" id="btnGuardarEducacion">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar Educación</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarEducacion()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones básicas para manejo de educación
function mostrarFormularioEducacion() {
    document.getElementById('educationView').style.display = 'none';
    document.getElementById('educationFormContainer').style.display = 'block';
    
    // Enfocar el primer campo
    setTimeout(() => {
        document.getElementById('titulo').focus();
    }, 100);
}

function cancelarEducacion() {
    document.getElementById('educationFormContainer').style.display = 'none';
    document.getElementById('educationView').style.display = 'block';
    
    // Limpiar formulario
    document.getElementById('educacionForm').reset();
}

function eliminarEducacion(id) {
    showConfirmModal('¿Estás seguro de que quieres eliminar esta educación?', function() {
        fetch("{{ route('empleado.perfil.educacion.destroy', ':id') }}".replace(':id', id), {
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
                    alert(data.message || 'Error al eliminar educación');
                });
            }
        })
        .catch(error => {
            alert('Error de conexión. Intenta nuevamente.');
        });
    });
}
</script> 