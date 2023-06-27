<?php
// Supprimer_article.php

// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Supprimer l'article de la base de données
    $deleteArticle = $bdd->prepare('DELETE FROM articles WHERE id = ?');
    $deleteArticle->execute(array($articleId));

    // Rediriger vers la page flux.php après la suppression
    header("Location: home.php");
    exit;
}
?>
