<?php
session_start();

/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 31.05.2016
 * Time: 13:49
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Accueil - Messagerie instantanée</title>

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
            <ul>
                <li>
                    <h1 class="h1-responsive wow fadeInDown" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInDown;">Messagerie instantanée</h1></li>
                <li>
                    <p class="wow fadeInDown" style="visibility: visible; animation-name: fadeInDown;">La plus professionnelle des messageries instantanées</p>
                </li>
                <li>
                    <?php
                        if(!isset($_SESSION['user']))
                        {
                            print '
                                <a href="register.php" class="btn btn-primary btn-lg wow fadeInLeft waves-effect waves-light" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">S\'inscrire</a>
                                <a class="btn btn-default btn-lg wow fadeInRight waves-effect waves-light" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInRight;" data-toggle="modal" data-target="#modal-login">Se connecter</a>
                                ';
                        }
                        else
                        {
                            print'<a href="message.php" class="btn btn-primary btn-lg wow fadeInUp waves-effect waves-light" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;" href="">Mes conversations</a>';
                        }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <!--/.Mask-->

    <!-- Main container-->
    <div class="container">
        <div class="divider-new">
            <h2 class="h2-responsive wow bounceIn">À propos</h2>
        </div>

        <!--Section: About-->
        <section class="text-xs-center wow bounceIn" data-wow-delay="0.2s">

            <p>Ce site a été conçu par Alen Bijelic durant le projet DemoMot fait en deuxième année de la formation à l'ETML. Le but est de créer un site de messagerie instantanée destinée aux domaines professionnels.</p>

        </section>
        <!--Section: About-->

        <!--Section: Contact-->
        <div class="divider-new">
            <h2 class="h2-responsive wow fadeInUp">Contact</h2>
        </div>


        <section>
            <div class="row">
                <div class="col-md-12">
                    <div id="map-container" class="z-depth-1 wow fadeInUp" style="height: 300px"></div>
                </div>
            </div>
        </section>
        <!--Section: Contact-->

    </div>
    <!--/ Main container-->



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

    if(isset($_GET['errorlogin']) || isset($_GET['mail']))
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