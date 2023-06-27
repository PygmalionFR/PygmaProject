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

// Vérifier si l'utilisateur est connecté
session_start();
if (isset($_SESSION['pseudo'])) {
    $userId = $_SESSION['id']; // Utilisez la colonne 'id' au lieu de 'pseudo'
} else {
    // Redirection si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/publication.css">
    <title>Publication</title>
</head>
<body>
    <button onclick="window.history.back();" class="back-button">Retour</button>
    <div class="publication">
        <div>
            <?php
                // Récupérer le pseudo de l'expéditeur depuis la table des utilisateurs
                $senderId = $article['sender'];
                $getSender = $bdd->prepare('SELECT pseudo FROM espace_membre WHERE id = ?');
                $getSender->execute(array($senderId));
                $sender = $getSender->fetch(PDO::FETCH_ASSOC)['pseudo'];
            ?>
            <p class="p1"><br><a href="profil.php?user=<?php echo $senderId; ?>"><?php echo $sender; ?></a></p>
            <p class="p2"><?php echo !empty($article) ? $article['content'] : ''; ?></p>
            <p class="p3"><?php echo date('Y-m-d H:i', strtotime($article['timestamp'])); ?></p>
        </div>
        <hr>
        <br>

        <div class="comments-section">
            <?php if ($getComments->rowCount() > 0) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment">
                        <!-- Récupérer le pseudo de la personne qui commente -->
                        <?php
                            $commentUserId = $comment['user_id']; // Utilisez la colonne 'user_id'
                            $getCommentUser = $bdd->prepare('SELECT pseudo FROM espace_membre WHERE id = ?');
                            $getCommentUser->execute(array($commentUserId));
                            $commentUser = $getCommentUser->fetch(PDO::FETCH_ASSOC)['pseudo'];
                        ?>
                        <p><a href="profil.php?user=<?php echo $commentUserId; ?>"><?php echo $commentUser; ?></a></p>
                        <p><?php echo $comment['content']; ?></p>
                        <p class="comment-timestamp"><?php echo date('Y-m-d H:i', strtotime($comment['timestamp'])); ?></p>
                        <br>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun commentaire disponible.</p>
            <?php endif; ?>
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

            // Insérer le commentaire dans la base de données avec l'ID de l'utilisateur
            $insertComment = $bdd->prepare('INSERT INTO comments (content, timestamp, article_id, user_id) VALUES (?, NOW(), ?, ?)');
            $insertComment->execute(array($commentContent, $articleId, $userId));

            // Rafraîchir la page pour afficher le nouveau commentaire
            header("Location: publication.php?id=$articleId");
            exit;
        }
        ?>
    </div>
</body>
</html>
