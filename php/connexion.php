<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page de profil
if(isset($_SESSION['pseudo'])){
    header("Location: profil.php");
    exit;
}

// Traitement du formulaire de connexion
if(isset($_POST['connexion'])){
    // Récupérer les données du formulaire
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // Valider les données (effectuez des validations supplémentaires selon vos besoins)

    // Vérifier les informations de connexion dans la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');
    $getUser = $bdd->prepare('SELECT * FROM espace_membre WHERE pseudo = ? AND password = ?');
    $getUser->execute([$pseudo, $password]);
    $user = $getUser->fetch(PDO::FETCH_ASSOC);

    if($user){
        // Authentification réussie, créer la session et rediriger vers la page de profil
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['id'] = $user['id'];
        header("Location: home.php");
        exit;
    }else{
        // Informations de connexion invalides, afficher un message d'erreur
        $error = "Pseudo ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/logsignin.css">
    <title>Connexion</title>
</head>
<body>
    
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
    <h2>Connexion</h2>
    <br>
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <input type="submit" name="connexion" value="Se connecter">
        <br><br>
        <p>Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
    </form>
    
</body>
</html>
