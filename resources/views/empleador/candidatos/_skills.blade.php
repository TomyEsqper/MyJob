<div class="card-header">
    <i class="fas fa-star"></i>
    <h3>Habilidades</h3>
</div>
<div class="card-body">
    <div class="skills-container">
        <div class="skills-grid">
            @if($empleado->habilidades)
                @foreach(explode(',', $empleado->habilidades) as $habilidad)
                    @if(trim($habilidad))
                        <div class="skill-tag">
                            <i class="fas fa-check"></i>
                            <span class="skill-text">{{ trim($habilidad) }}</span>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        
        @if(!$empleado->habilidades || empty(explode(',', $empleado->habilidades)))
            <div class="empty-state">
                <i class="fas fa-star"></i>
                <p>No hay habilidades registradas</p>
            </div>
        @endif
    </div>
</div> 