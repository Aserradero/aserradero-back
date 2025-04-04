<!DOCTYPE html>
<html>
<head>
    <title>Verificación de Correo</title>
</head>
<body>
    <h2>Hola,</h2>
    <p>Por favor, haz clic en el botón de abajo para verificar tu correo electrónico:</p>
    <a href="{{ url('/api/verify-email/'.$token) }}"
        style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
        Verificar Correo
    </a>
    <p>Si no solicitaste esta verificación, simplemente ignora este mensaje.</p>
</body>
</html>
