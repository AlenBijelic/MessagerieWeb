<!--Navbar-->
<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx">
            <!--Navbar Brand-->
            <a class="navbar-brand" href="index.php">Messagerie instantanée</a>
            <!--Links-->
            <ul class="nav navbar-nav">
                <?php

                if(!isset($_SESSION['user']))
                {
                    echo '
                    <li class="nav-item pull-xs-right">
                        <a class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-login">Se connecter</a>
                    </li>
                    <li class="nav-item pull-xs-right">
                        <a href="register.php" class="btn btn-primary btn-sm">S\'inscrire</a>
                    </li>
                    ';
                }
                else
                {
                    echo '    <div class="dropdown pull-xs-right">
                                  <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ' . $_SESSION['user'] . '
                                  </button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <a class="dropdown-item" href="message.php"><i class="fa fa-commenting" aria-hidden="true"></i> Conversations</a>
                                    <a class="dropdown-item" href="account.php"><i class="fa fa-cog" aria-hidden="true"></i> Paramètre</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="classLogout.php" class="dropdown-item"><i class="fa fa-lock" aria-hidden="true"></i> Déconnexion</a>
                                  </div>
                                </div>';
                }
                ?>
            </ul>
        </div>
        <!--/.Collapse content-->

    </div>

</nav>
<!--/.Navbar-->