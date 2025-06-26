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
            @endphp
            <div class="contact-item" data-campo="{{ $red }}" data-red="{{ $red }}" data-valor="{{ $valor ? 'si' : 'no' }}">
                <div class="contact-icon">
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="contact-info">
                    <span class="contact-label">{{ ucfirst($red) }}</span>
                    <span class="contact-value valor-campo">{{ $valor ?: 'No especificado' }}</span>
                </div>
                <button class="contact-edit editar-campo" title="Editar">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
        @endforeach
    </div>
</div> 