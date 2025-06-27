<div class="card-header">
    <i class="fas fa-language"></i>
    <h3>Idiomas</h3>
    <button class="btn-add" id="btnAgregarIdioma" onclick="mostrarFormularioIdioma()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body">
    <!-- Vista de idiomas -->
    <div class="languages-container" id="languagesView">
        <div class="languages-grid">
            @forelse($empleado->idiomas as $idioma)
                <div class="language-item" data-id="{{ $idioma->id }}">
                    <div class="language-info">
                        <span class="language-name">{{ $idioma->idioma }}</span>
                        <span class="language-level">{{ $idioma->nivel }}</span>
                    </div>
                    <button class="btn-delete btnEliminarIdioma" onclick="eliminarIdioma({{ $idioma->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-language"></i>
                    <p>No hay idiomas registrados</p>
                    <button class="btn btn-primary btn-sm" onclick="mostrarFormularioIdioma()">Agregar Idioma</button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Formulario de agregar idioma -->
    <div class="language-form-container" id="languageFormContainer" style="display: none;">
        <form id="idiomaForm" action="{{ route('empleado.perfil.idioma.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="idioma">Idioma <span class="required-field">*</span></label>
                <select class="modern-input @error('idioma') is-invalid @enderror" 
                        name="idioma" 
                        id="idioma" 
                        required>
                    <option value="">Selecciona un idioma</option>
                    <option value="Español" {{ old('idioma') == 'Español' ? 'selected' : '' }}>Español</option>
                    <option value="Inglés" {{ old('idioma') == 'Inglés' ? 'selected' : '' }}>Inglés</option>
                    <option value="Francés" {{ old('idioma') == 'Francés' ? 'selected' : '' }}>Francés</option>
                    <option value="Alemán" {{ old('idioma') == 'Alemán' ? 'selected' : '' }}>Alemán</option>
                    <option value="Italiano" {{ old('idioma') == 'Italiano' ? 'selected' : '' }}>Italiano</option>
                    <option value="Portugués" {{ old('idioma') == 'Portugués' ? 'selected' : '' }}>Portugués</option>
                    <option value="Chino" {{ old('idioma') == 'Chino' ? 'selected' : '' }}>Chino</option>
                    <option value="Japonés" {{ old('idioma') == 'Japonés' ? 'selected' : '' }}>Japonés</option>
                    <option value="Coreano" {{ old('idioma') == 'Coreano' ? 'selected' : '' }}>Coreano</option>
                    <option value="Ruso" {{ old('idioma') == 'Ruso' ? 'selected' : '' }}>Ruso</option>
                    <option value="Árabe" {{ old('idioma') == 'Árabe' ? 'selected' : '' }}>Árabe</option>
                    <option value="Otro" {{ old('idioma') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
                @error('idioma')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="nivel">Nivel <span class="required-field">*</span></label>
                <select class="modern-input @error('nivel') is-invalid @enderror" 
                        name="nivel" 
                        id="nivel" 
                        required>
                    <option value="">Selecciona tu nivel</option>
                    <option value="Básico" {{ old('nivel') == 'Básico' ? 'selected' : '' }}>Básico</option>
                    <option value="Intermedio" {{ old('nivel') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                    <option value="Avanzado" {{ old('nivel') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                    <option value="Nativo" {{ old('nivel') == 'Nativo' ? 'selected' : '' }}>Nativo</option>
                </select>
                @error('nivel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="descripcion_idioma">Descripción (Opcional)</label>
                <textarea class="modern-input @error('descripcion_idioma') is-invalid @enderror" 
                          name="descripcion_idioma" 
                          id="descripcion_idioma" 
                          rows="2"
                          placeholder="Describe brevemente tu dominio del idioma...">{{ old('descripcion_idioma') }}</textarea>
                @error('descripcion_idioma')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-modern" id="btnGuardarIdioma">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar Idioma</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarIdioma()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones básicas para manejo de idiomas
function mostrarFormularioIdioma() {
    document.getElementById('languagesView').style.display = 'none';
    document.getElementById('languageFormContainer').style.display = 'block';
    
    // Enfocar el primer campo
    setTimeout(() => {
        document.getElementById('idioma').focus();
    }, 100);
}

function cancelarIdioma() {
    document.getElementById('languageFormContainer').style.display = 'none';
    document.getElementById('languagesView').style.display = 'block';
    
    // Limpiar formulario
    document.getElementById('idiomaForm').reset();
}

function eliminarIdioma(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres eliminar este idioma?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('empleado.perfil.idioma.destroy', ':id') }}".replace(':id', id), {
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
                        Swal.fire('Error', data.message || 'Error al eliminar idioma', 'error');
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error de conexión. Intenta nuevamente.', 'error');
            });
        }
    });
}
</script> 