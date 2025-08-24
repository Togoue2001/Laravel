<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat</title>
    <style>
        @page { margin: 0; }
        body {
            margin: 40px;
            font-family: DejaVu Sans, sans-serif;
            background: #f7f7f7;
            color: #333;
        }
        .wrapper {
            border: 8px double #2c3e50;
            padding: 40px;
            background: #fff;
        }
        .title { text-align: center; font-size: 28px; color: #2c3e50; margin-bottom: 10px; }
        .subtitle { text-align: center; font-size: 16px; margin-bottom: 40px; color: #7f8c8d; }
        .name { text-align: center; font-size: 24px; margin: 20px 0 10px; font-weight: bold; }
        .course { text-align: center; font-size: 18px; margin-bottom: 20px; }
        .meta { margin-top: 30px; display: flex; justify-content: space-between; font-size: 13px; color: #555; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #7f8c8d; }
        .sign { text-align: right; margin-top: 30px; font-size: 14px; }
        .badge { display: inline-block; padding: 6px 12px; background: #27ae60; color: #fff; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="title">Certificat d’achèvement</div>
    <div class="subtitle">Ce document atteste que</div>

    <div class="name">{{ $user->name }}</div>

    <div class="subtitle">a complété avec succès le cours</div>

    <div class="course"><strong>{{ $course->title }}</strong></div>

    <div class="meta">
        <div>Émis le : <strong>{{ $issuedAt->format('d/m/Y') }}</strong></div>
        <div>Code de vérification : <strong>{{ $code }}</strong></div>
    </div>

    <div class="sign">
        <span class="badge">Validé</span><br>
        Signature de l’instructeur
    </div>

    <div class="footer">
        Vérifiez ce certificat via le code ci-dessus.
    </div>
</div>
</body>
</html>
