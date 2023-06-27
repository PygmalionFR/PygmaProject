<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');

// Vérifier si l'ID de l'article est fourni
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Récupérer l'article correspondant à l'ID
    $getArticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $getArticle->execute(array($articleId));
    $article = $getArticle->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'article existe
    if (!$article) {
        // Rediriger vers la page d'accueil ou afficher un message d'erreur
        header("Location: home.php");
        exit;
    }
} else {
    // Rediriger vers la page d'accueil ou afficher un message d'erreur
    header("Location: home.php");
    exit;
}

// Vérifier si le formulaire de modification est soumis
if (isset($_POST['modifier'])) {
    $newContent = $_POST['new_content'];

    // Mettre à jour le contenu de l'article dans la base de données
    $updateArticle = $bdd->prepare('UPDATE articles SET content = ? WHERE id = ?');
    $updateArticle->execute(array($newContent, $articleId));

    // Rediriger vers la page d'accueil ou afficher un message de succès
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
    <link rel="stylesheet" href="../style/modifier_article.css">
</head>
<body>
    <h3>Modifier l'article</h3>

    <form action="" method="post" class="modifier-article-form">
        <textarea name="new_content" placeholder="Nouveau contenu de l'article" required><?php echo $article['content']; ?></textarea>
        <br>
        <input type="submit" name="modifier" value="Modifier">
    </form>
</body>
</html>
