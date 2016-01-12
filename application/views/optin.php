<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application Casino</title>
    <link rel="stylesheet" href="<?php echo asset_url() ?>css/style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
<div class="contenu">
    <header id="optin">
        <h1 id="titre_optin">La<br/><span class="gros_titre">Newsletter</span><br/><span class="petit_titre">du casino</span></h1>
    </header>
    <form method="post" action="roulette">
        <label for="nom" id="nom">Nom</label>
        <input class="input_emplacement" type="text" name="nom" placeholder="Firstname" required /><br /><br />
        <label for="prenom" id="prenom">Prénom</label>
        <input class="input_emplacement" type="text" name="prenom" placeholder="prenom" required /><br /><br />
        <label for="pseudo" id="pseudo">Pseudo*</label>
        <input class="input_emplacement" type="text" name="pseudo" placeholder="Pseudo" required /><br /><br />
        <label for="email" id="email">E-mail*</label>
        <input  class="input_emplacement_newsletter" type="text" name="email" placeholder="exemple@gmail.com" required /><br /><br />
        <label for="newsletter"class="news" id="optin_newsletter">
            Cochez cette case si vous souhaitez recevoir notre newsletter
        </label>
        <input type="checkbox" name="newsletter" value="oui" id="newsletter"/>
        <input id="submit_newsletter" class="bouton_app_newsletter" type="submit" value="Envoyer"/>
    </form>
    <section class="bouton">
        <br/>
        <a href="roulette" title="connexion">
            <span class="bouton_play">
            Ignorez
            </span>
        </a>
    </section>

</div>

</body>
</html>