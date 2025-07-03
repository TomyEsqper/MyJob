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
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="{{ $icon }}"></i>
                </div>
                <div class="contact-info">
                    <span class="contact-label">{{ ucfirst($red) }}</span>
                    @if($valor)
                        @if($url)
                            <a class="contact-value" href="{{ $url }}" target="_blank" rel="noopener noreferrer">{{ $valor }}</a>
                        @else
                            <span class="contact-value">{{ $valor }}</span>
                        @endif
                    @else
                        <span class="contact-value">No especificado</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>  