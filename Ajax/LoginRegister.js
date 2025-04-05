$(document).ready(function() {
    $('#formulario-registro').submit(function(e) {
        e.preventDefault(); // Evita que el formulario se envíe de forma predeterminada
        $.ajax({
            type: 'POST', // Asegúrate de que sea POST
            url: '../../../Controllers/Auth/registerController.php',
            data: $(this).serialize(), // Envía los datos del formulario
            success: function(response) {
                alert(response); // Muestra la respuesta del servidor
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Muestra errores en la consola
            }
        });
    });
});