<style>
    * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }
  
    header {
        background-color: #192436;
        color: #ffffff;
        height: 60px;
        width: 100%;
        display: flex;
        align-items: center;
    }
  
    header div {
        width: 300px;
        display: flex;
        margin-right: 20%;
        margin-left: auto;

    }
  
    h1 {
        margin-left: 20%;
    }
  
    header div button {
        box-shadow: inset 0px 1px 0px 0px #54a3f7;
        background: linear-gradient(to bottom, #007dc1 5%, #0061a7 100%);
        background-color: #007dc1;
        border-radius: 3px;
        border: 1px solid #124d77;
        display: inline-block;
        cursor: pointer;
        color: #ffffff;
        font-family: Arial;
        font-size: 13px;
        padding: 7px 24px;
        text-decoration: none;
        text-shadow: 0px 1px 0px #154682;
        width: 130px;
    }
  
    header div button:hover {
        background: linear-gradient(to bottom, #0061a7 5%, #007dc1 100%);
        background-color: #0061a7;
    }
  
    header div button:active {
        position: relative;
        top: 1px;
    }
  
    button a {
        text-decoration: none;
        color: white;
    }
</style>
<header>
    <?php if ($page === 'index') : ?>
        <h1>PygmaProject</h1>
        <div>
            <button><a href="php/connexion.php">Se connecter</a></button>
            <button><a href="php/inscription.php">S'inscrire</a></button>
        </div>
    <?php else : ?>
        <h1>PygmaProject</h1>
        
            <?php if ($page === 'profil') : ?>
                <div>
                    <button><a href="home.php">Accueil</a></button>
                    <button> <a href='deconnexion.php'>Déconnexion</a></button>
                </div>
            <?php elseif ($page === 'home') : ?>
                <div>
                    <button><a href="profil.php">Profil</a></button>
                    <button> <a href='deconnexion.php'>Déconnexion</a></button>
                </div>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</header>
