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
    <form action="{{route('password.newpassword', $token)}}">
        <input type="hidden" name="token" value="{{ $token }}">
        <label for="email">votre adresse email</label>
        <input type="email" name="email">
        <label for="password">Nouveau mot de passe</label>
        <input type="password" name="password">
        <label for="password_confirmation">Confirmer votre mot de passe</label>
        <input type="password" name="password_confirmation">
        <input type="submit">

    </form>

</body>
</html>