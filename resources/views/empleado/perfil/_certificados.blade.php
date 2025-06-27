<div class="card-header">
    <i class="fas fa-certificate"></i>
    <h3>Certificados</h3>
    <button class="btn-add" id="btnAgregarCert" onclick="mostrarFormularioCertificado()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body">
    <!-- Vista de certificados -->
    <div class="certificates-container" id="certificatesView">
        <div class="certificates-grid">
            @forelse($empleado->certificados as $cert)
                <div class="certificate-item" data-id="{{ $cert->id }}">
                    <div class="certificate-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="certificate-content">
                        <h4>{{ $cert->nombre }}</h4>
                        <p class="certificate-issuer">{{ $cert->emisor }}</p>
                        <span class="certificate-date">{{ $cert->fecha_emision }}</span>
                    </div>
                    <button class="btn-delete btnEliminarCert" onclick="eliminarCertificado({{ $cert->id }})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-certificate"></i>
                    <p>No hay certificados registrados</p>
                    <button class="btn btn-primary btn-sm" onclick="mostrarFormularioCertificado()">Agregar Certificado</button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Formulario de agregar certificado -->
    <div class="certificate-form-container" id="certificateFormContainer" style="display: none;">
        <form id="certificadoForm" action="{{ route('empleado.perfil.certificado.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre_cert">Nombre del Certificado <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('nombre_cert') is-invalid @enderror" 
                       name="nombre_cert" 
                       id="nombre_cert" 
                       value="{{ old('nombre_cert') }}" 
                       required 
                       placeholder="Ej: AWS Certified Solutions Architect">
                @error('nombre_cert')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="emisor">Emisor <span class="required-field">*</span></label>
                <input type="text" 
                       class="modern-input @error('emisor') is-invalid @enderror" 
                       name="emisor" 
                       id="emisor" 
                       value="{{ old('emisor') }}" 
                       required 
                       placeholder="Ej: Amazon Web Services, Microsoft, Google">
                @error('emisor')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="fecha_emision_cert">Fecha de Emisión <span class="required-field">*</span></label>
                <input type="date" 
                       class="modern-input @error('fecha_emision_cert') is-invalid @enderror" 
                       name="fecha_emision_cert" 
                       id="fecha_emision_cert" 
                       value="{{ old('fecha_emision_cert') }}" 
                       required>
                @error('fecha_emision_cert')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="fecha_vencimiento_cert">Fecha de Vencimiento</label>
                <input type="date" 
                       class="modern-input @error('fecha_vencimiento_cert') is-invalid @enderror" 
                       name="fecha_vencimiento_cert" 
                       id="fecha_vencimiento_cert" 
                       value="{{ old('fecha_vencimiento_cert') }}">
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Déjalo vacío si no tiene fecha de vencimiento
                </small>
                @error('fecha_vencimiento_cert')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="descripcion_cert">Descripción (Opcional)</label>
                <textarea class="modern-input @error('descripcion_cert') is-invalid @enderror" 
                          name="descripcion_cert" 
                          id="descripcion_cert" 
                          rows="3"
                          placeholder="Describe brevemente el certificado y sus beneficios...">{{ old('descripcion_cert') }}</textarea>
                @error('descripcion_cert')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-modern" id="btnGuardarCertificado">
                    <i class="fas fa-save"></i>
                    <span class="btn-text">Guardar Certificado</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="cancelarCertificado()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones básicas para manejo de certificados
function mostrarFormularioCertificado() {
    document.getElementById('certificatesView').style.display = 'none';
    document.getElementById('certificateFormContainer').style.display = 'block';
    
    // Enfocar el primer campo
    setTimeout(() => {
        document.getElementById('nombre_certificado').focus();
    }, 100);
}

function cancelarCertificado() {
    document.getElementById('certificateFormContainer').style.display = 'none';
    document.getElementById('certificatesView').style.display = 'block';
    
    // Limpiar formulario
    document.getElementById('certificadoForm').reset();
}

function eliminarCertificado(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres eliminar este certificado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("{{ route('empleado.perfil.certificado.destroy', ':id') }}".replace(':id', id), {
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
                        Swal.fire('Error', data.message || 'Error al eliminar certificado', 'error');
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