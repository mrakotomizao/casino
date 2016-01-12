<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link rel="stylesheet" href="<?php echo asset_url() ?>css/style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="<?= asset_url() ?>js/roulette.js"></script>
    <script src="<?= asset_url() ?>js/funcs.js"></script>
    <!--[if IE]>
    <script type="text/javascript" src="<?php echo asset_url() ?>js/roulette.js?>"></script>
    <![endif]-->
    <title>casino</title>
</head>

<body>
<div class="contenu">

    <header>
        <nav>
            <ul>
                <li class="menu_carte_li" id="li_gain"><a href="gains_houlgate.php" title="vos gains"
                                                          class="a_menu_principal">Vos gains</a></li>
                <li class="menu_carte_li" id="li_evenement"><a href="#" title="Evenements" class="a_menu_principal">Nos
                        évènements</a></li>
                <li class="menu_carte_li" id="li_machine"><a href="sample/demo.html" title="machine a sous"
                                                             class="a_menu_principal">Machine à sous</a></li>
                <li class="menu_carte_li" id="li_localisation"><a href="localisation.php" title="nous trouver"
                                                                  class="a_menu_principal">Nous trouver</a></li>
            </ul>
    </header>
    <!-- Jauge -->

    <div class="roulette">
        <div id="test-roul">
            <canvas id="wheelcanvas" width="500" height="500"></canvas>
            <script type="text/javascript">
                draw();
            </script>
            <div id="boxaction">
                <p>Nombre d'action du jour : <span class="circle" id="nbaction"><?php echo $nbaction ?></span></p>
                <p>Gain du jour : <span class="circle" id="dailyTotal"><?php echo @$dailyTotal ?></span></p>
            </div>
            <input id="submit" class="btn" type="button" value="JOUER" onClick="spin();"/>
        </div>
        <div id="niv">Niv.<?php echo($rank->id_rang) ?></div>
        <div id="colonne_jauge">
            <progress max="<?= $max ?>" value="<?= $diff ?>" form="form-id" id="redbar"></progress>
            <input type="hidden" name="total" id="total" value="<?= $total ?>">
            <input type="hidden" name="fbId" id="fbId" value="<?= $fbId ?>">
        </div>
    </div>

</div>
</body>
</html>