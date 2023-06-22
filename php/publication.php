<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');

if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Récupérer les détails de la publication
    $getArticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $getArticle->execute(array($articleId));
    $article = $getArticle->fetch(PDO::FETCH_ASSOC);

    // Récupérer les commentaires de la publication
    $getComments = $bdd->prepare('SELECT * FROM comments WHERE article_id = ? ORDER BY timestamp ASC');
    $getComments->execute(array($articleId));
    $comments = $getComments->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Redirection si l'ID de la publication n'est pas spécifié
    header("Location: flux.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/flux.css">
    <title>Publication</title>
</head>
<body>
    <header>
    <h1>PygmaProject</h1>
        <div>
            <button><a href="home.php">Accueill</a></button>
            <button><a href="deconnexion.php">Déconnexion</a></button>
        </div>
    </header>
        <button onclick="window.history.back();" class="back-button">Retour</button>
    <div class="publication">
        <div>
            <p class="p1">Auteur : <?php echo $article['sender']; ?></p>
            <p class="p2">Contenu : <?php echo $article['content']; ?></p>
            <p class="p3"><?php echo date('Y-m-d H:i', strtotime($article['timestamp'])); ?></p>
        </div>
        <hr>
        <br>

        <div class="comments-section">
            <?php foreach ($comments as $comment) : ?>
                <div class="comment">
                    <!-- Afficher les détails du commentaire -->
                    <p><?php echo $comment['content']; ?></p>
                    <p class="comment-timestamp"><?php echo date('Y-m-d H:i', strtotime($comment['timestamp'])); ?></p>
                    <br>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Formulaire pour ajouter un commentaire -->
        <form action="" method="post" class="comment-form">
            <input type="text" name="comment" placeholder="Ajouter un commentaire" required>
            <input type="hidden" name="article_id" value="<?php echo $articleId; ?>">
            <input type="submit" name="submit_comment" value="Commenter">
        </form>

        <?php
        // Traitement de l'envoi de commentaire
        if (isset($_POST['submit_comment'])) {
            $commentContent = $_POST['comment'];
            $articleId = $_POST['article_id'];

            // Insérer le commentaire dans la base de données
            $insertComment = $bdd->prepare('INSERT INTO comments (content, timestamp, article_id) VALUES (?, NOW(), ?)');
            $insertComment->execute(array($commentContent, $articleId));

            // Rafraîchir la page pour afficher le nouveau commentaire
            header("Location: publication.php?id=$articleId");
            exit;
        }
        ?>
    </div>
</body>
</html>
