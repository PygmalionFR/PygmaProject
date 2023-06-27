<head>
    <link rel="stylesheet" href="../style/headercss.css">
</head>
<header>
    <?php if ($page === 'index') : ?>
        <h1>PygmaProject</h1>
        <div>
            <button class="btn"><a href="php/connexion.php">Se connecter</a></button>
            <button class="btn"><a href="php/inscription.php">S'inscrire</a></button>
        </div>
    <?php else : ?>
        <h1>PygmaProject</h1>
        
            <?php if ($page === 'profil') : ?>
                <div>
                    <button class="btn"><a href="home.php">Accueil</a></button>
                    <button class="btn"> <a href='deconnexion.php'>Déconnexion</a></button>
                </div>
            <?php elseif ($page === 'home') : ?>
                <div>
                    <button class="btn"><a href="profil.php">Profil</a></button>
                    <button class="btn"> <a href='deconnexion.php'>Déconnexion</a></button>
                </div>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</header>
