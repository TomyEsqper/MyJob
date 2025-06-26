// Sistema de Feedback Visual - Para usuarios que no prestan atención
window.showNotification = function(type, message, title = '') {
    const notification = document.createElement('div');
    notification.className = `feedback-notification feedback-${type}`;
    notification.id = `notification-${Date.now()}`;
    
    const icon = {
        'success': 'fas fa-check-circle',
        'error': 'fas fa-exclamation-triangle',
        'warning': 'fas fa-exclamation-circle',
        'info': 'fas fa-info-circle'
    }[type];
    
    const defaultTitle = {
        'success': '¡Éxito!',
        'error': '¡Error!',
        'warning': '¡Atención!',
        'info': 'Información'
    }[type];
    
    notification.innerHTML = `
        <div class="feedback-content">
            <div class="feedback-icon">
                <i class="${icon}"></i>
            </div>
            <div class="feedback-message">
                <h4>${title || defaultTitle}</h4>
                <p>${message}</p>
            </div>
            <button type="button" class="feedback-close" onclick="closeNotification('${notification.id}')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="feedback-progress"></div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        closeNotification(notification.id);
    }, 5000);
    
    return notification.id;
}

function closeNotification(id) {
    const notification = document.getElementById(id);
    if (notification) {
        notification.classList.add('fade-out');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }
}

function showSaveIndicator() {
    const indicator = document.getElementById('saveIndicator');
    if (indicator) {
        indicator.style.display = 'flex';
        indicator.classList.add('show');
    }
}

function hideSaveIndicator() {
    const indicator = document.getElementById('saveIndicator');
    if (indicator) {
        indicator.classList.remove('show');
        setTimeout(() => {
            indicator.style.display = 'none';
        }, 300);
    }
}

// Animación de conteo para stats
function animateCount(id, end) {
    let el = document.getElementById(id);
    if (!el) return;
    let start = 0;
    let duration = 900;
    let startTime = null;
    function animate(ts) {
        if (!startTime) startTime = ts;
        let progress = Math.min((ts - startTime) / duration, 1);
        el.textContent = Math.floor(progress * (end - start) + start);
        if (progress < 1) requestAnimationFrame(animate);
        else el.textContent = end;
    }
    requestAnimationFrame(animate);
}

// MANEJO SIMPLE Y DIRECTO DE TODOS LOS FORMULARIOS
// Experiencia
function setupExperienciaForm() {
    const experienciaForm = document.getElementById('experienciaForm');
    if (experienciaForm) {
        experienciaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('🚀 Enviando formulario de experiencia...');
            
            const btn = document.getElementById('btnGuardarExperiencia');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            
            const formData = new FormData(this);
            console.log('📦 Datos del formulario:', Object.fromEntries(formData));
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                console.log('📡 Respuesta recibida:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Datos de respuesta:', data);
                if (data.success) {
                    showNotification('success', data.message || '¡Experiencia guardada exitosamente!');
                    console.log('🔄 Recargando página en 800ms...');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showNotification('error', data.message || 'Error al guardar la experiencia. Verifica los datos.');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                showNotification('error', 'Error de conexión. Verifica tu internet e intenta nuevamente.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Experiencia</span>';
                }
            });
        });
    }
}

// Educación
function setupEducacionForm() {
    const educacionForm = document.getElementById('educacionForm');
    if (educacionForm) {
        educacionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('🚀 Enviando formulario de educación...');
            
            const btn = document.getElementById('btnGuardarEducacion');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            
            const formData = new FormData(this);
            console.log('📦 Datos del formulario:', Object.fromEntries(formData));
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                console.log('📡 Respuesta recibida:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Datos de respuesta:', data);
                if (data.success) {
                    showNotification('success', data.message || '¡Educación guardada exitosamente!');
                    console.log('🔄 Recargando página en 800ms...');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showNotification('error', data.message || 'Error al guardar la educación. Verifica los datos.');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                showNotification('error', 'Error de conexión. Verifica tu internet e intenta nuevamente.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Educación</span>';
                }
            });
        });
    }
}

// Idiomas
function setupIdiomaForm() {
    const idiomaForm = document.getElementById('idiomaForm');
    if (idiomaForm) {
        idiomaForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('🚀 Enviando formulario de idioma...');
            
            const btn = document.getElementById('btnGuardarIdioma');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            
            const formData = new FormData(this);
            console.log('📦 Datos del formulario:', Object.fromEntries(formData));
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                console.log('📡 Respuesta recibida:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Datos de respuesta:', data);
                if (data.success) {
                    showNotification('success', data.message || '¡Idioma guardado exitosamente!');
                    console.log('🔄 Recargando página en 800ms...');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showNotification('error', data.message || 'Error al guardar el idioma. Verifica los datos.');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                showNotification('error', 'Error de conexión. Verifica tu internet e intenta nuevamente.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Idioma</span>';
                }
            });
        });
    }
}

// Certificados
function setupCertificadoForm() {
    const certificadoForm = document.getElementById('certificadoForm');
    if (certificadoForm) {
        certificadoForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('🚀 Enviando formulario de certificado...');
            
            const btn = document.getElementById('btnGuardarCertificado');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            
            const formData = new FormData(this);
            console.log('📦 Datos del formulario:', Object.fromEntries(formData));
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                console.log('📡 Respuesta recibida:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Datos de respuesta:', data);
                if (data.success) {
                    showNotification('success', data.message || '¡Certificado guardado exitosamente!');
                    console.log('🔄 Recargando página en 800ms...');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showNotification('error', data.message || 'Error al guardar el certificado. Verifica los datos.');
                }
            })
            .catch(error => {
                console.error('❌ Error:', error);
                showNotification('error', 'Error de conexión. Verifica tu internet e intenta nuevamente.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Certificado</span>';
                }
            });
        });
    }
}

// HABILIDADES
function setupHabilidadesForm() {
    const habilidadesForm = document.getElementById('habilidadesForm');
    if (habilidadesForm) {
        habilidadesForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnGuardarHabilidades');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
            }
            // Asegura que el campo oculto tenga el array actualizado
            if (window.habilidades) {
                document.getElementById('habilidades_json').value = JSON.stringify(window.habilidades);
            }
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
                    showNotification('success', data.message || '¡Habilidades guardadas exitosamente!');
                    setTimeout(() => window.location.reload(), 800);
                } else {
                    showNotification('error', data.message || 'Error al guardar las habilidades.');
                }
            })
            .catch(error => {
                showNotification('error', 'Error de conexión. Intenta nuevamente.');
            })
            .finally(() => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-save"></i> <span class="btn-text">Guardar Habilidades</span>';
                }
            });
        });
    }
}

// Modal HTML
if (!document.getElementById('customConfirmModal')) {
    const modalHtml = `
    <div id="customConfirmModal" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(34,197,94,0.10);backdrop-filter:blur(2px);justify-content:center;align-items:center;">
      <div id="customConfirmBox" style="background:#fff;border-radius:18px;box-shadow:0 8px 32px 0 rgba(34,197,94,0.18);padding:2.2rem 2.2rem 1.5rem 2.2rem;max-width:95vw;width:370px;animation:modalPopIn .25s cubic-bezier(.5,1.8,.5,1.1);text-align:center;">
        <div style="font-size:2.2rem;color:#22c55e;margin-bottom:0.5rem;"><i class="fas fa-question-circle"></i></div>
        <div id="customConfirmMsg" style="font-size:1.13rem;color:#222;font-weight:500;margin-bottom:1.5rem;"></div>
        <div style="display:flex;gap:1rem;justify-content:center;">
          <button id="customConfirmCancel" style="flex:1;padding:0.7rem 0;border:none;border-radius:8px;background:#f3f4f6;color:#222;font-weight:600;font-size:1rem;cursor:pointer;transition:background .2s;">Cancelar</button>
          <button id="customConfirmOk" style="flex:1;padding:0.7rem 0;border:none;border-radius:8px;background:#22c55e;color:#fff;font-weight:700;font-size:1rem;cursor:pointer;box-shadow:0 2px 8px 0 #22c55e22;transition:background .2s;">Eliminar</button>
        </div>
      </div>
    </div>
    <style>
    @keyframes modalPopIn {0%{transform:scale(.7);opacity:0;}100%{transform:scale(1);opacity:1;}}
    #customConfirmModal.show {display:flex;}
    #customConfirmBox {animation:modalPopIn .25s cubic-bezier(.5,1.8,.5,1.1);}
    #customConfirmOk:active {background:#16a34a;}
    #customConfirmCancel:active {background:#e5e7eb;}
    </style>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

window.showConfirmModal = function(msg, onConfirm) {
    const modal = document.getElementById('customConfirmModal');
    const msgBox = document.getElementById('customConfirmMsg');
    const btnOk = document.getElementById('customConfirmOk');
    const btnCancel = document.getElementById('customConfirmCancel');
    msgBox.innerHTML = msg;
    modal.classList.add('show');
    function close() {
        modal.classList.remove('show');
        btnOk.onclick = null;
        btnCancel.onclick = null;
    }
    btnOk.onclick = function() { close(); if (typeof onConfirm === 'function') onConfirm(); };
    btnCancel.onclick = close;
    modal.onclick = function(e) { if (e.target === modal) close(); };
};

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎯 Inicializando formularios del perfil...');
    
    // Auto-cerrar notificaciones existentes después de 8 segundos
    setTimeout(() => {
        const notifications = document.querySelectorAll('.feedback-notification');
        notifications.forEach(notification => {
            if (notification.id) {
                closeNotification(notification.id);
            }
        });
    }, 8000);

    // Configurar todos los formularios
    setupExperienciaForm();
    setupEducacionForm();
    setupIdiomaForm();
    setupCertificadoForm();
    setupHabilidadesForm();
    
    console.log('✅ Formularios del perfil inicializados correctamente');
}); 