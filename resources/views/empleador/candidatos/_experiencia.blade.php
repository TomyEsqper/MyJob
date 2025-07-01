<div class="card-header">
    <i class="fas fa-briefcase"></i>
    <h3>Experiencia Laboral</h3>
</div>
<div class="card-body">
    <div class="experiences-container">
        <div class="timeline">
            @forelse($empleado->experiencias as $exp)
                <div class="timeline-item">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <div class="timeline-header">
                            <h4>{{ $exp->puesto }}</h4>
                            <span class="timeline-company">{{ $exp->empresa }}</span>
                        </div>
                        <div class="timeline-period">{{ $exp->periodo }}</div>
                        <p class="timeline-description">{{ $exp->descripcion }}</p>
                        @if($exp->logro)
                            <div class="timeline-achievement">
                                <i class="fas fa-trophy"></i>
                                {{ $exp->logro }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-briefcase"></i>
                    <p>No hay experiencia registrada</p>
                </div>
            @endforelse
        </div>
    </div>
</div> 