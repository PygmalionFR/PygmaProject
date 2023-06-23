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
    <title>Fil d'actualité</title>
    <link rel="stylesheet" href="../style/flux.css">
    <style>
        /* Ajoutez ici vos styles personnalisés */
    </style>
</head>
<body>
    <h3>Fil d'actualité</h3>

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
            <div class="box">
                <div>
                    <p class="p1">Auteur : <br><a href="profil.php?user=<?php echo $senderId; ?>"><?php echo $sender; ?></a></p>
                    <div class="post-content">
                        <p class="p2"><?php echo $article['content']; ?></p>
                        <?php if (strlen($article['content']) > 60) : ?>
                            <input type="checkbox" class="toggle-content" id="toggle-<?php echo $article['id']; ?>">
                            <label for="toggle-<?php echo $article['id']; ?>" class="toggle-label toggle-label-show"></label>
                        <?php endif; ?>
                    </div>
                    <p class="p3"><?php echo date('Y-m-d H:i', strtotime($article['timestamp'])); ?></p>
                    <div class="full-content"><?php echo $article['content']; ?></div>
                </div>
            </div>
            <hr>
            <br>
        <?php endforeach; ?>
    </div>

    <script>
        var toggleCheckboxes = document.getElementsByClassName('toggle-content');

        for (var i = 0; i < toggleCheckboxes.length; i++) {
            toggleCheckboxes[i].addEventListener('change', function() {
                var parentBox = this.parentNode;
                var postContent = parentBox.getElementsByClassName('post-content')[0];
                var fullContent = parentBox.getElementsByClassName('full-content')[0];

            if (this.checked) {
                parentBox.classList.add('show-full'); // Ajouter la classe show-full
                postContent.style.maxHeight = 'none';
            } else {
                parentBox.classList.remove('show-full'); // Retirer la classe show-full
                postContent.style.maxHeight = '60px';
            }
        });
    }
    </script>
</body>
</html>
