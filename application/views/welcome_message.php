<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Application Casino</title>
    <meta property="og:url" content="<?= site_url('welcome') ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="Casino Houlogate"/>
    <meta property="og:description" content="Try our application and have some fun"/>
    <meta property="og:image" content="<?php echo asset_url() ?>img/bg_rouge.jpg"/>
    <link rel="stylesheet" href="<?php echo asset_url() ?>css/style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<!--JAVASCRIPT-->
<div id="fb-root"></div>

<body>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.5&appId=465732286935321";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!--JAVASCRIPT-->
<div id="fb-root"></div>

<div class="contenu">
    <header id="index">
        <h1 id="titre_intdex">L'application du<br/><span class="titre">casino</span><br/><span class="sous_titre">d'Houlgate</span>
        </h1>
    </header>
    <section class="bouton">
        <?php var_dump($user_profile)?>
        <br/>
        <form action="<?= site_url('roulette') ?>" name="fbInfo" method="post">
            <?php if (@$user_profile):  // call var_dump($user_profile) to view all data ?>
                <a href="#" onclick="fbInfo.submit();" title="jouez">
                    <span class="bouton_play">
                        Jouez
                    </span>
                </a>
                <input type="checkbox" name="newsletter" value="1" id="newsletter"/>
                <label for="newsletter" class="news" id="optin_newsletter">
                    Cochez cette case si vous souhaitez recevoir notre newsletter
                </label>
            <?php else: ?>
                <a id="submit-index" href="<?= $login_url ?>"><span class="bouton_fb">Connexion</span></a>
            <?php endif; ?>
        </form>
    </section>
    <!-- Your like button code -->
    <div class="fb-like"
         data-href="<?php echo site_url('welcome') ?>"
         data-layout="standard"
         data-action="like"
         data-show-faces="true"
         data-share="true">
    </div>
</div>
<script>

</script>
</body>
</html>
