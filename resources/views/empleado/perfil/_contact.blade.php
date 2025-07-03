<div class="card-header">
    <i class="fas fa-share-alt"></i>
    <h3>Contacto</h3>
</div>
<div class="card-body">
    <div class="contact-grid">
        @foreach(['whatsapp','facebook','instagram','linkedin'] as $red)
            @php
                $icon = [
                    'whatsapp' => 'fab fa-whatsapp',
                    'facebook' => 'fab fa-facebook',
                    'instagram' => 'fab fa-instagram',
                    'linkedin' => 'fab fa-linkedin',
                ][$red];
                $valor = $empleado->$red;
                $url = null;
                if ($valor) {
                    if ($red === 'whatsapp') {
                        $url = 'https://wa.me/' . preg_replace('/\D/', '', $valor);
                    } elseif ($red === 'facebook') {
                        $url = preg_match('/^https?:\/\//', $valor) ? $valor : 'https://facebook.com/' . $valor;
                    } elseif ($red === 'instagram') {
                        $url = preg_match('/^https?:\/\//', $valor) ? $valor : 'https://instagram.com/' . $valor;
                    } elseif ($red === 'linkedin') {
                        $url = preg_match('/^https?:\/\//', $valor) ? $valor : 'https://linkedin.com/in/' . $valor;
                    }
                }
            @endphp
            <div class="contact-item" data-campo="{{ $red }}" data-red="{{ $red }}" data-valor="{{ $valor ? 'si' : 'no' }}">
                <div class="contact-icon">
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="contact-info">
                    <span class="contact-label">{{ ucfirst($red) }}</span>
                    @if($valor)
                        @if($url)
                            <a class="contact-value valor-campo" id="valor-{{ $red }}" href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $valor }}</a>
                        @else
                            <span class="contact-value valor-campo" id="valor-{{ $red }}">{{ $valor }}</span>
                        @endif
                        <input type="text" class="contact-input" id="input-{{ $red }}" value="{{ $valor }}" style="display:none;max-width:180px;">
                    @else
                        <span class="contact-value valor-campo" id="valor-{{ $red }}">No especificado</span>
                        <input type="text" class="contact-input" id="input-{{ $red }}" value="" style="display:none;max-width:180px;">
                    @endif
                </div>
                <button class="contact-edit editar-campo" title="Editar" onclick="editarContacto('{{ $red }}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="contact-edit guardar-campo" title="Guardar" id="guardar-{{ $red }}" style="display:none;" onclick="guardarContacto('{{ $red }}')">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        @endforeach
    </div>
</div>
<script>
function editarContacto(red) {
    document.getElementById('valor-' + red).style.display = 'none';
    const input = document.getElementById('input-' + red);
    input.style.display = 'inline-block';
    document.getElementById('guardar-' + red).style.display = 'inline-flex';
    input.focus();
    input.classList.remove('input-error');
    quitarError(red);
}
function guardarContacto(red) {
    const input = document.getElementById('input-' + red);
    const valor = input.value.trim();
    const span = document.getElementById('valor-' + red);
    if (!validarContacto(red, valor)) {
        input.classList.add('input-error');
        mostrarError(red, 'Formato inválido para ' + red);
        mostrarFeedback('error', 'Corrige el campo antes de guardar');
        return;
    }
    input.classList.remove('input-error');
    quitarError(red);
    fetch('/empleado/perfil/campo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
        },
        body: JSON.stringify({ campo: red, valor })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            span.textContent = valor || 'No especificado';
            span.style.display = 'inline';
            input.style.display = 'none';
            document.getElementById('guardar-' + red).style.display = 'none';
            mostrarFeedback('success', 'Contacto actualizado');
        } else {
            mostrarFeedback('error', 'No se pudo guardar');
        }
    })
    .catch(() => mostrarFeedback('error', 'Error de red'));
}
function validarContacto(red, valor) {
    if (!valor) return false;
    if (red === 'whatsapp') {
        // Solo números, 8-15 dígitos
        return /^\+?\d{8,15}$/.test(valor);
    }
    if (red === 'facebook') {
        // Username o URL válida de Facebook
        return /^[A-Za-z0-9\.]{5,}$/.test(valor) || /^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9\.]+\/?$/.test(valor);
    }
    if (red === 'instagram') {
        // Username IG o URL válida
        return /^([A-Za-z0-9_\.]){3,30}$/.test(valor) || /^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9_\.]+\/?$/.test(valor);
    }
    if (red === 'linkedin') {
        // Username o URL válida de LinkedIn
        return /^[A-Za-z0-9\-_.]{5,}$/.test(valor) || /^(https?:\/\/)?(www\.)?linkedin\.com\/[A-Za-z0-9\-_/]+\/?$/.test(valor);
    }
    return true;
}
function mostrarError(red, mensaje) {
    let err = document.getElementById('error-' + red);
    if (!err) {
        err = document.createElement('div');
        err.id = 'error-' + red;
        err.className = 'input-error-msg';
        document.getElementById('input-' + red).after(err);
    }
    // Mensajes personalizados
    if (!mensaje) {
        if (red === 'facebook') mensaje = 'La URL de Facebook debe ser válida (ejemplo: https://facebook.com/usuario).';
        else if (red === 'instagram') mensaje = 'La URL de Instagram debe ser válida (ejemplo: https://instagram.com/usuario).';
        else if (red === 'linkedin') mensaje = 'La URL de LinkedIn debe ser válida (ejemplo: https://linkedin.com/in/usuario).';
        else if (red === 'whatsapp') mensaje = 'El número de WhatsApp debe tener entre 8 y 15 dígitos.';
        else mensaje = 'Formato inválido para ' + red;
    }
    err.textContent = mensaje;
    err.style.display = 'block';
}
function quitarError(red) {
    let err = document.getElementById('error-' + red);
    if (err) err.style.display = 'none';
}
document.querySelectorAll('.contact-input').forEach(input => {
    input.addEventListener('input', function() {
        const red = this.id.replace('input-', '');
        if (validarContacto(red, this.value.trim())) {
            this.classList.remove('input-error');
            quitarError(red);
            document.getElementById('guardar-' + red).disabled = false;
        } else {
            this.classList.add('input-error');
            mostrarError(red, ''); // Mensaje personalizado según red
            document.getElementById('guardar-' + red).disabled = true;
        }
    });
});
function mostrarFeedback(tipo, mensaje) {
    let notif = document.createElement('div');
    notif.className = 'feedback-notification feedback-' + tipo;
    notif.innerHTML = `<div class='feedback-content'><div class='feedback-icon'><i class='fas fa-check-circle'></i></div><div class='feedback-message'><h4>${tipo === 'success' ? '¡Éxito!' : 'Error'}</h4><p>${mensaje}</p></div><button type='button' class='feedback-close' onclick='this.parentNode.parentNode.remove()'><i class='fas fa-times'></i></button></div>`;
    notif.style.position = 'fixed';
    notif.style.top = '0';
    notif.style.left = '0';
    notif.style.right = '0';
    notif.style.zIndex = '9999';
    document.body.appendChild(notif);
    setTimeout(() => { notif.remove(); }, 2500);
}
</script>
<style>
.input-error {
    border-color: #ef4444 !important;
    background: #fff0f0 !important;
}
.input-error-msg {
    color: #ef4444;
    font-size: 0.93rem;
    margin-top: 2px;
    margin-bottom: 2px;
    font-weight: 600;
    padding-left: 2px;
}
</style> 