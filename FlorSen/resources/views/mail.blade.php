<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel Article Disponible</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #555555;
        }

        .cta-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chère Abonné,</h1>
        <p>Un nouvel article est disponible! Ne perdez pas de temps, profitez des précieux conseils offerts.</p>
        <a href="{{ url('/lien-vers-votre-article') }}" class="cta-button">Lire l'article</a>

        <p>Merci de rester connecté!</p>
    </div>
</body>
</html>