<div class="card-header">
    <i class="fas fa-graduation-cap"></i>
    <h3>Educación</h3>
</div>
<div class="card-body">
    <div class="education-container">
        <div class="education-list">
            @forelse($empleado->educaciones as $edu)
                <div class="education-item">
                    <div class="education-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="education-content">
                        <h4>{{ $edu->titulo }}</h4>
                        <p class="education-institution">{{ $edu->institucion }}</p>
                        <span class="education-period">{{ $edu->periodo }}</span>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-graduation-cap"></i>
                    <p>No hay educación registrada</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 