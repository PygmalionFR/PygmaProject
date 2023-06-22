<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');

// Récupérer tous les articles de la base de données ou uniquement ceux de l'utilisateur connecté
if (isset($_GET['user'])) {
    // Afficher les publications de l'utilisateur spécifié
    $getArticles = $bdd->prepare('SELECT * FROM articles WHERE sender = ? ORDER BY timestamp DESC');
    $getArticles->execute(array($_GET['user']));
} else {
    // Afficher toutes les publications
    $getArticles = $bdd->query('SELECT * FROM articles ORDER BY timestamp DESC');
}

$articles = $getArticles->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/flux.css">
    <title>Flux</title>
</head>
<body>

    <?php if (isset($_SESSION['pseudo'])) : ?>
        <!-- Formulaire d'envoi d'article -->
        <form action="" method="post" class="publier">
            <textarea name="article" placeholder="Votre article" required></textarea>
            <br>
            <input type="submit" name="poster" value="Publier">
        </form>

        <?php
        // Traitement de l'envoi d'article
        if (isset($_POST['poster'])) {
            $content = $_POST['article'];

            // Insérer l'article dans la base de données
            $insertArticle = $bdd->prepare('INSERT INTO articles (content, timestamp, sender) VALUES (?, NOW(), ?)');
            $insertArticle->execute(array($content, $_SESSION['id']));

            // Rafraîchir la page pour afficher le nouvel article
            header("Location: home.php");
            exit;
        }
        ?>
    <?php endif; ?>

    <h3>Fil d'actualité</h3>
    <!-- Afficher les articles -->
    <div class="publication">
        <?php foreach ($articles as $article) : ?>
            <?php
            // Récupérer le pseudo de l'expéditeur depuis la table des espace_membre
            $senderId = $article['sender'];
            $getSender = $bdd->prepare('SELECT pseudo FROM espace_membre WHERE id = ?');
            $getSender->execute(array($senderId));
            $sender = $getSender->fetch(PDO::FETCH_ASSOC)['pseudo'];
            ?>
            <div>
                <p class="p1">Auteur : <br><a href="profil.php?user=<?php echo $senderId; ?>"><?php echo $sender; ?></a></p>
                <p class="p2">Contenu : <?php echo $article['content']; ?></p>
                <p class="p3"><?php echo date('Y-m-d H:i', strtotime($article['timestamp'])); ?></p>
                <br>
                <a href="publication.php?id=<?php echo $article['id']; ?>">Voir les commentaires</a>
            </div>
            <hr>
            <br>
        <?php endforeach; ?>
    </div>

</body>
</html>
