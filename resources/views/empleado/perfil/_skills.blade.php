<div class="card-header">
    <i class="fas fa-star"></i>
    <h3>Habilidades</h3>
    <button class="btn-add" id="btnAgregarHabilidad" title="Agregar nueva habilidad">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body">
    <!-- Vista de habilidades -->
    <div class="skills-container" id="skillsView">
        <div class="skills-grid" id="skillsGrid">
            @if($empleado->habilidades)
                @foreach(explode(',', $empleado->habilidades) as $habilidad)
                    @if(trim($habilidad))
                        <div class="skill-tag" data-skill="{{ trim($habilidad) }}">
                            <i class="fas fa-check"></i>
                            <span class="skill-text">{{ trim($habilidad) }}</span>
                            <button class="skill-delete" onclick="eliminarHabilidad('{{ trim($habilidad) }}')" title="Eliminar habilidad">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        
        @if(!$empleado->habilidades || empty(explode(',', $empleado->habilidades)))
            <div class="empty-state">
                <i class="fas fa-star"></i>
                <p>No hay habilidades registradas</p>
                <button class="btn btn-primary btn-sm" onclick="mostrarFormularioHabilidades()">Agregar Habilidades</button>
            </div>
        @endif
    </div>

    <!-- Formulario de edición de habilidades -->
    <div class="skills-form-container" id="skillsFormContainer" style="display: none;">
        <form id="habilidadesForm" action="{{ route('empleado.actualizar-habilidades') }}" method="POST">
            @csrf
            <input type="hidden" name="habilidades_json" id="habilidades_json" value="">
            
            <div class="form-group">
                <label for="habilidades_input">Mis Habilidades <span class="required-field">*</span></label>
                <div class="skills-input-container">
                    <div class="skills-tags-input" id="skillsTagsInput">
                        <!-- Las etiquetas se generan dinámicamente aquí -->
                    </div>
                    <input type="text" 
                           id="habilidades_input" 
                           class="modern-input skills-input" 
                           placeholder="Escribe una habilidad y presiona Enter..."
                           autocomplete="off">
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Escribe cada habilidad y presiona Enter. Puedes agregar múltiples habilidades.
                </small>
                <div class="text-danger mt-2" style="font-size: 0.9rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Importante:</strong> Debes presionar ENTER para agregar cada habilidad antes de guardar. Si no lo haces, la habilidad no se guardará.
                </div>
                <div class="skills-suggestions" id="skillsSuggestions" style="display: none;">
                    <div class="suggestions-header">
                        <i class="fas fa-lightbulb"></i>
                        <span>Sugerencias populares:</span>
                    </div>
                    <div class="suggestions-grid" id="suggestionsGrid">
                        <!-- Las sugerencias se generan dinámicamente -->
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-modern" id="btnGuardarHabilidades">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar Habilidades</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarEdicionHabilidades()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
window.habilidades = [];

window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.skill-tag[data-skill]').forEach(tag => {
        window.habilidades.push(tag.getAttribute('data-skill'));
    });
    renderHabilidadesEdit();
});

function mostrarFormularioHabilidades() {
    document.getElementById('skillsView').style.display = 'none';
    document.getElementById('skillsFormContainer').style.display = 'block';
    renderHabilidadesEdit();
    setTimeout(() => {
        document.getElementById('habilidades_input').focus();
    }, 100);
}
function cancelarEdicionHabilidades() {
    document.getElementById('skillsFormContainer').style.display = 'none';
    document.getElementById('skillsView').style.display = 'block';
    document.getElementById('habilidades_input').value = '';
}
document.getElementById('btnAgregarHabilidad').onclick = mostrarFormularioHabilidades;

// Manejo de input para agregar habilidades
const input = document.getElementById('habilidades_input');
input.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const valor = input.value.trim();
        if (!valor) {
            if (typeof showNotification === 'function') {
                showNotification('warning', 'Escribe una habilidad antes de agregarla.', 'Campo vacío');
            }
            return;
        }
        if (window.habilidades.includes(valor)) {
            if (typeof showNotification === 'function') {
                showNotification('warning', 'Ya agregaste esa habilidad.', 'Duplicado');
            }
            return;
        }
        window.habilidades.push(valor);
        input.value = '';
        renderHabilidadesEdit();
        if (typeof showNotification === 'function') {
            showNotification('success', 'Habilidad agregada. Presiona Guardar para confirmar.', '¡Agregado!');
        }
    }
});

function renderHabilidadesEdit() {
    const container = document.getElementById('skillsTagsInput');
    if (!container) return;
    container.innerHTML = '';
    window.habilidades.forEach(hab => {
        const tag = document.createElement('div');
        tag.className = 'skill-tag-editable';
        tag.innerHTML = `<i class='fas fa-check'></i> <span class='skill-text'>${hab}</span> <button type='button' class='skill-delete' onclick='eliminarHabilidadEdit("${hab}")' title='Eliminar'><i class='fas fa-times'></i></button>`;
        container.appendChild(tag);
    });
    document.getElementById('habilidades_json').value = JSON.stringify(window.habilidades);
}

window.eliminarHabilidadEdit = function(hab) {
    window.habilidades = window.habilidades.filter(h => h !== hab);
    renderHabilidadesEdit();
};

document.getElementById('habilidadesForm').onsubmit = function(e) {
    e.preventDefault();
    const btn = document.getElementById('btnGuardarHabilidades');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
    }
    document.getElementById('habilidades_json').value = JSON.stringify(window.habilidades);
    const formData = new FormData(this);
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (typeof showNotification === 'function') {
                showNotification('success', data.message || '¡Habilidades guardadas exitosamente!');
            } else {
                alert(data.message || '¡Habilidades guardadas exitosamente!');
            }
            setTimeout(() => window.location.reload(), 800);
        } else {
            if (typeof showNotification === 'function') {
                showNotification('error', data.message || 'Error al guardar las habilidades.');
            } else {
                alert(data.message || 'Error al guardar las habilidades.');
            }
        }
    })
    .catch(error => {
        if (typeof showNotification === 'function') {
            showNotification('error', 'Error de conexión. Intenta nuevamente.');
        } else {
            alert('Error de conexión. Intenta nuevamente.');
        }
    })
    .finally(() => {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Habilidades</span>';
        }
    });
    return false;
};

// Notificación si intenta guardar sin habilidades
const habilidadesForm = document.getElementById('habilidadesForm');
if (habilidadesForm) {
    habilidadesForm.addEventListener('submit', function(e) {
        const input = document.getElementById('habilidades_input');
        const valor = input.value.trim();
        if (valor) {
            e.preventDefault();
            if (typeof showNotification === 'function') {
                showNotification('error', 'Debes presionar Enter para agregar la habilidad antes de guardar.', 'Agrega la habilidad');
                showNotification('info', 'Escribe la habilidad y presiona Enter para agregarla a la lista.', 'Sugerencia');
            }
            return false;
        }
        if (!window.habilidades || window.habilidades.length === 0) {
            e.preventDefault();
            if (typeof showNotification === 'function') {
                showNotification('error', 'Debes agregar al menos una habilidad antes de guardar.', 'Sin habilidades');
            }
            return false;
        }
        document.getElementById('habilidades_json').value = JSON.stringify(window.habilidades);
    });
}
</script> 