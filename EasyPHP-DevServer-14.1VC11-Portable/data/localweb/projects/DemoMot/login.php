<!-- Modal Login -->
<div class="modal fade modal-ext" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3>Connexion</h3>
            </div>

            <?php
                if(isset($_GET['mail']))
                {
                    $mail = $_GET['mail'];
                }
            ?>

            <!--Body-->
            <form method="POST" action="classLogin.php">
                <div class="modal-body">
                    <div class="md-form input-group">
                        <span class="input-group-addon" id="basic-addon1">@</span>
                        <input required type="text" class="form-control" placeholder=" Email" name="email" aria-describedby="basic-addon1" value="<?php if(isset($mail)){print $mail;} ?>">
                    </div>
                    <?php
                        if(isset($_GET['errorlogin']) && $_GET['errorlogin'] == 1)
                        {
                            print '<p class="red-text">L\'adresse mail n\'est pas valide ou n\'existe pas.</p>';
                        }
                    ?>

                    <div class="md-form input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-lock"></i></span>
                        <input required type="password" class="form-control" placeholder=" Mot de passe" name="password" aria-describedby="basic-addon1">
                    </div>
                    <?php
                    if(isset($_GET['errorlogin']) && $_GET['errorlogin'] == 2)
                    {
                        print '<p class="red-text">Le mot de passe n\'est pas valide.</p>';
                    }
                    ?>
                    <div class="text-xs-center">
                        <button class="btn btn-primary btn-lg" type="submit">Connexion</button>
                    </div>
                </div>
            </form>

            <!--Footer-->
            <div class="modal-footer">
                <div class="options">
                    <p>Vous n'avez pas de compte? Inscrivez vous <a href="register.php">ici</a></p>
                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>