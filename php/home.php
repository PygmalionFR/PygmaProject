<?php 
session_start();

if(!isset($_SESSION['pseudo'])){
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit;
}
$page = 'home';
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
    <title>Acceuil</title>
</head>
<body>
    <?php include "header.php" ?>
    <section>
        <div class="box1">
        
        </div>
        <div class="box2">
        <?php include "flux.php"?>
        </div>
        <div class="box3">
        
        </div>
    </section>
</body>
</html>