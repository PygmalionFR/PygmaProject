<?php
session_start();

if (!isset($_SESSION['pseudo'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: connexion.php");
    exit;
}

$pseudo = $_SESSION['pseudo'];

if (isset($_POST['deconnexion'])) {
    // Détruire la session et rediriger vers la page de connexion
    session_destroy();
    header("Location: ../index.php");
    exit;
}
$page = 'profil';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/profilcss.css">
    <title>Profil</title>
</head>

<body>
    <?php 
        include "header.php"
    ?>

    <article class="article">
        <?php
        // Inclure le contenu de flux.php en tant que fonction
        function includeFlux($userId, $pseudo)
        {
            // Connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');

            // Récupérer le pseudo de l'utilisateur
            $getUser = $bdd->prepare('SELECT pseudo FROM espace_membre WHERE id = ?');
            $getUser->execute([$userId]);
            $user = $getUser->fetch(PDO::FETCH_ASSOC)['pseudo'];

            echo '<h3>Profil de ' . $user . '</h3>';

            // Récupérer tous les articles de l'utilisateur
            $getArticles = $bdd->prepare('SELECT * FROM articles WHERE sender = ? ORDER BY timestamp DESC');
            $getArticles->execute([$userId]);

            $articles = $getArticles->fetchAll(PDO::FETCH_ASSOC);

            // Afficher les articles
            foreach ($articles as $article) {
                // Récupérer le pseudo de l'expéditeur depuis la table des espace_membre
                $senderId = $article['sender'];
                $getSender = $bdd->prepare('SELECT pseudo FROM espace_membre WHERE id = ?');
                $getSender->execute([$senderId]);
                $sender = $getSender->fetch(PDO::FETCH_ASSOC)['pseudo'];

                // Afficher les détails de l'article
                echo '<div class="article">';
                echo '<p class="p1">Auteur : <br><a href="profil.php?user=' . $senderId . '">' . $sender . '</a></p>';
                echo '<p class="p2">Contenu : ' . $article['content'] . '</p>';
                echo '<p class="p3">' . date('Y-m-d H:i', strtotime($article['timestamp'])) . '</p>';
                echo '<br>';
                echo '<a href="publication.php?id=' . $article['id'] . '" class="voir-commentaires">Voir les commentaires</a>';
                echo '</div>';
                echo '<hr><br>';
            }
        }

        // Vérifier si l'utilisateur est en train de consulter son propre profil ou un autre profil
        if (isset($_GET['user'])) {
            // Afficher les publications de l'utilisateur spécifié
            $userId = $_GET['user'];
            includeFlux($userId, $pseudo);
        } else {
            // Afficher les publications de l'utilisateur connecté
            $userId = $_SESSION['id'];
            includeFlux($userId, $pseudo);
        }
        ?>
    </article>

    
</body>

</html>
