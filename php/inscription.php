<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté, le rediriger vers la page de profil
if(isset($_SESSION['pseudo'])){
    header("Location: profil.php");
    exit;
}

// Traitement du formulaire d'inscription
if(isset($_POST['inscription'])){
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Valider les données
    if(empty($email) || empty($pseudo) || empty($password) || empty($confirmPassword)){
        $error = "Veuillez remplir tous les champs";
    }elseif($password !== $confirmPassword){
        $error = "Les mots de passe ne correspondent pas";
    }else{
        // Enregistrer l'utilisateur dans la base de données
        $bdd = new PDO('mysql:host=localhost;dbname=PygmaProject;charset=utf8', 'root', '');
        $insertUser = $bdd->prepare('INSERT INTO espace_membre (email, pseudo, password) VALUES (?, ?, ?)');
        $insertUser->execute([$email, $pseudo, $password]);

        // Rediriger l'utilisateur vers la page de connexion
        header("Location: connexion.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/logsignin.css">
    <title>Inscription</title>
</head>
<body>
    
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
    <h2>Inscription</h2>
        <label for="email">Adresse e-mail :</label>
        <input type="email" name="email" required><br>

        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <label for="confirm_password">Confirmer le mot de passe :</label>
        <input type="password" name="confirm_password" required><br>

        <input type="submit" name="inscription" value="S'inscrire">
    </form>
</body>
</html>
