<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 01.06.2016
 * Time: 09:55
 */
session_start();

if(!isset($_SESSION['id']))
{
    header("Location: index.php");
}

include("Classes/db_chat.php");

$classe = new db_chat();

$informations = $classe->getUserInformations();

$firstName = $informations['useFirstName'];

$lastName = $informations['useLastName'];

$mail = $informations['useMail'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Mon compte - Messagerie instantanée</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">

    <!-- Template styles -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

<?php
include("navbar.php");
include("login.php");
?>

<!--Mask-->
<div class="view hm-black-strong">
    <div class="full-bg-img flex-center">
        <!--Panel-->
        <div class="card">
            <h3 class="card-header primary-color white-text">Mon compte</h3>
            <div class="card-block" style="width: 1000px">
                <h3 class="text-primary">Modifier les informations du compte</h3>
                <form method="POST" action="classModifyUser.php">
                    <div class="row">
                        <div class="md-form input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input name="modifyFirstName" type="text" class="form-control" placeholder="Prénom" aria-describedby="basic-addon1" value="<?php print $firstName; ?>" required>
                        </div>
                        <?php
                        if(isset($_GET['errorModify']) && $_GET['errorModify'] == 1)
                        {
                            print '<p class="red-text">Le prénom n\'est pas valide.</p>';
                        }
                        ?>
                    </div>

                    <div class="row">
                        <div class="md-form input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                            <input name="modifyLastName" type="text" class="form-control" placeholder="Nom" aria-describedby="basic-addon1" value="<?php print $lastName; ?>" required>
                        </div>
                        <?php
                        if(isset($_GET['errorModify']) && $_GET['errorModify'] == 2)
                        {
                            print '<p class="red-text">Le nom n\'est pas valide.</p>';
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="md-form input-group">
                            <span class="input-group-addon" id="basic-addon1">@</span>
                            <input name="modifyMail" type="text" class="form-control" placeholder="Adresse mail" aria-describedby="basic-addon1" value="<?php print $mail; ?>" required>
                        </div>
                        <?php
                        if(isset($_GET['errorModify']) && $_GET['errorModify'] == 3)
                        {
                            print '<p class="red-text">L\'adresse mail n\'est pas valide ou n\'existe pas.</p>';
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="text-xs-right">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
                <h3 class="text-primary">Modifier le mot de passe</h3>
                <form method="post" action="modifyPassword.php">
                    <div class="row">
                        <div class="md-form input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            <input name="modifyPassword" type="password" class="form-control" placeholder="Mot de passe" aria-describedby="basic-addon1" required>
                        </div>
                        <?php
                        if(isset($_GET['errorModify']) && $_GET['errorModify'] == 4)
                        {
                            print '<p class="red-text">Les mots de passe ne correspondent pas.</p>';
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="md-form input-group">
                            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock" aria-hidden="true"></i></span>
                            <input name="modifyConfirmPassword" type="password" class="form-control" placeholder="Confirmer le mot de passe" aria-describedby="basic-addon1" required>
                        </div>
                        <?php
                        if(isset($_GET['errorModify']) && $_GET['errorModify'] == 4)
                        {
                            print '<p class="red-text">Les mots de passe ne correspondent pas.</p>';
                        }
                        ?>
                    </div>
                    <div class="row">
                        <div class="text-xs-right">
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--/.Panel-->
    </div>
</div>
<!--/.Mask-->

<?php
include("footer.php");
?>


<!-- SCRIPTS -->

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/tether.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>

<!--Google Maps-->
<script src="https://maps.google.ch/maps/api/js"></script>

<script>
    function init_map() {

        var var_location = new google.maps.LatLng(46.524018, 6.616012);

        var var_mapoptions = {
            center: var_location,

            zoom: 14
        };

        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title: "New York"
        });

        var var_map = new google.maps.Map(document.getElementById("map-container"),
            var_mapoptions);

        var_marker.setMap(var_map);

    }

    google.maps.event.addDomListener(window, 'load', init_map);
</script>

<!-- Animations init-->
<script>
    new WOW().init();
</script>

<?php

if(isset($_GET['errorlogin']))
{
    echo"
                <script>
                    $('#modal-login').modal('show')
                </script>
            ";
}
?>


</body>

</html>