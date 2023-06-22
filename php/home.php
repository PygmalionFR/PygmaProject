<?php 
session_start();

if(!isset($_SESSION['pseudo'])){
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit;
}

$pseudo = $_SESSION['pseudo'];

if(isset($_POST['deconnexion'])){
    // Détruire la session et rediriger vers la page de connexion
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/homecss.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>PygmaProject</h1>
        <div>
            <button><a href="profil.php">Profil</a></button>
            <button><a href="deconnexion.php">Déconnexion</a></button>
        </div>
    </header>
    <div>
     <?php include "flux.php"?>
    </div>
</body>
</html>