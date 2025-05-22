document.addEventListener('DOMContentLoaded', function() {
    const mainContent = document.querySelector('body');
    const loadingScreen = document.querySelector('.loading-screen');
    
    // Initially hide the content
    mainContent.style.opacity = '0';
    
    setTimeout(function() {
        loadingScreen.classList.add('hidden');
        mainContent.style.opacity = '0';
        mainContent.style.transition = 'opacity 0.1s ease-in';
    }, 4500); // Extended duration
});