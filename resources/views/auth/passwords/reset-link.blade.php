<p>Hola,</p>
<p>Recibiste este correo porque se solicitó un restablecimiento de contraseña para tu cuenta.</p>
<p>
    <a href="{{ url('password/reset/'.$token.'?correo_electronico='.urlencode($correo_electronico)) }}">
        Haz clic aquí para restablecer tu contraseña
    </a>
</p>
<p>Si no solicitaste este cambio, puedes ignorar este correo.</p>
<p>Gracias,<br>El equipo de MyJob</p> 