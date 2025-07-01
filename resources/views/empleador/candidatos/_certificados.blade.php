<div class="card-header">
    <i class="fas fa-certificate"></i>
    <h3>Certificados</h3>
</div>
<div class="card-body">
    <div class="certificates-container">
        <div class="certificates-grid">
            @forelse($empleado->certificados as $cert)
                <div class="certificate-item">
                    <div class="certificate-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="certificate-content">
                        <h4>{{ $cert->nombre }}</h4>
                        <p class="certificate-issuer">{{ $cert->emisor }}</p>
                        <span class="certificate-date">{{ $cert->fecha_emision }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-certificate"></i>
                    <p>No hay certificados registrados</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 