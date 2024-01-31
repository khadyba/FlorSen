<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reinitialisation du mot de passe</title>
</head>
<body>
    <img src="{{ asset('/public/WhatsApp Image 2024-01-23 à 09.32.38_1d9cd651.jpg') }}" alt="Votre Logo">
    <a href="{{ route('password.reset', ['token' => $token]) }}">Cliquez ici pour réinitialiser votre mot de passe !</a>

</body>
</html>