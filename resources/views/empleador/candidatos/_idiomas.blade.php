<div class="card-header">
    <i class="fas fa-language"></i>
    <h3>Idiomas</h3>
</div>
<div class="card-body">
    <div class="languages-container">
        <div class="languages-grid">
            @forelse($empleado->idiomas as $idioma)
                <div class="language-item">
                    <div class="language-info">
                        <span class="language-name">{{ $idioma->idioma }}</span>
                        <span class="language-level">{{ $idioma->nivel }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-language"></i>
                    <p>No hay idiomas registrados</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 