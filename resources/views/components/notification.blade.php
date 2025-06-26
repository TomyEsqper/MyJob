@props([
    'type' => 'info',
    'message',
    'title' => null,
    'duration' => 3000
])
<div class="feedback-notification feedback-{{ $type }}" role="alert" aria-live="assertive" tabindex="0" style="z-index:9999;">
    <div class="feedback-content">
        <div class="feedback-icon">
            @if($type === 'success')
                <i class="fas fa-check-circle"></i>
            @elseif($type === 'error')
                <i class="fas fa-times-circle"></i>
            @elseif($type === 'warning')
                <i class="fas fa-exclamation-triangle"></i>
            @else
                <i class="fas fa-info-circle"></i>
            @endif
        </div>
        <div class="feedback-message">
            @if($title)
                <h4>{{ $title }}</h4>
            @endif
            <p>{{ $message }}</p>
        </div>
        <button type="button" class="feedback-close" onclick="this.closest('.feedback-notification').remove()" aria-label="Cerrar notificación">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
<script>
setTimeout(() => {
    const notif = document.currentScript.previousElementSibling;
    if (notif && notif.classList.contains('feedback-notification')) notif.remove();
}, {{ $duration }});
</script> 