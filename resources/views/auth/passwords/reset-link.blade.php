<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - MyJob</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            background: white;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(67,233,123,0.2);
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .footer {
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #eee;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        .logo span {
            color: #1a3c1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">My<span>Job</span></div>
            <h1>Restablecimiento de Contraseña</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en MyJob. Si no realizaste esta solicitud, puedes ignorar este correo de forma segura.</p>
            <p>Para continuar con el proceso de restablecimiento de contraseña, haz clic en el siguiente botón:</p>
            <div style="text-align: center;">
                <a href="{{ url('password/reset/'.$token.'?correo_electronico='.urlencode($correo_electronico)) }}" class="button">Restablecer mi contraseña</a>
            </div>
            <p>Si el botón no funciona, puedes copiar y pegar el siguiente enlace en tu navegador:</p>
            <p style="word-break: break-all; color: #666; font-size: 14px;">{{ url('password/reset/'.$token.'?correo_electronico='.urlencode($correo_electronico)) }}</p>
            <p>Por razones de seguridad, este enlace expirará en 60 minutos.</p>
        </div>
        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>&copy; {{ date('Y') }} MyJob. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>