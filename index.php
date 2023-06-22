<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/indexcss.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>PygmaProject</h1>
        <div>
        <button><a href="php/connexion.php">Se connecter</a></button>
        <button><a href="php/inscription.php">S'inscrire</a></button>
        </div>
    </header>

    <div>
        <?php 
            include "php/flux.php"
        ?>
    </div>
</body>
</html>