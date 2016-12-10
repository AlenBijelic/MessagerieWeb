<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 01.06.2016
 */
session_start();

if(!isset($_SESSION['user']) && !isset($_SESSION['id']))
{
    header("Location: index.php");
}

include("Classes/db_chat.php");

$classe = new db_chat();


if(isset($_GET['g']))
{
	$group = $_GET['g'];

    $isInGroup = $classe->isUserInGroup($group);

    if(!isset($isInGroup['idMemberGroup']))
    {
        header('Location: message.php');
    }
}
else
{
	$group = "Message";
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title><?php print $group; ?> - Messagerie instantanée</title>

	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
	
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Material Design Bootstrap -->
    <link href="css/mdb.css" rel="stylesheet">

    <!-- Template styles -->
    <link href="css/style.css" rel="stylesheet">
	
	<!--Import Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <style>
        body {
            display: flex;
        }

        .navbar {
         background-color: #4285F4;
        }
        
        .side-nav {
            margin-top: 60px;
        }
    </style>

</head>

<body>

<?php
include("navbar.php");
include("login.php");
?>
<main>
    <div class="section">
        <div class="container">
            <nav>
                <ul id="slide-out" class="side-nav fixed">

                    <?php

                    $result = $classe->getGroup();

                    foreach($result as $row)
                    {
                        print('<li><a href="message.php?g='. $row['groName'] .'">' . $row['groName'] . '</a></li><div class="divider"></div>');
                    }
                    ?>

                </ul>
            </nav>

            <div class="row">
                <div style="margin-top: 50px;">
                    <nav>
                        <div class="nav-wrapper" style="width:120%;">
                            <a href="#" style="color:#444" href="#" class="brand-logo"><?php if(isset($_GET['g'])){print $_GET['g'];}else{print "Messages";}?></a>
                            <ul class="right hide-on-med-and-down">
                                <?php
                                    if(isset($_GET['g']))
                                    {
                                        print '<li><a style="color:#444" data-toggle="modal" data-target="#modal2" class="modal-trigger" style="color:#444" href="#modal2"><i class="material-icons">note_add</i></a></li>';
                                    }
                                ?>
                                <li><a data-toggle="modal" data-target="#myModal" class="modal-trigger" style="color:#444" href="#modal1"><i class="material-icons">more_vert</i></a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="modal2Label">Ajouter une pièce jointe</h4>
                        </div>
                        <div class="modal-body">
                            <h5>Ajouter une image ou un fichier PDF</h5>
                            <form action="addAttachment.php?g=<?php print $_GET['g'] ?>" method="post" enctype="multipart/form-data">
                                <input type="file" name="fileToUpload" accept="image/*, application/pdf" required>
                                <button name="btnSubmit" class="btn btn-primary btn-sm" type="submit">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel"><?php if(isset($_GET['g'])){ print $group; }else{ print 'Nouveau groupe'; } ?></h4>
                        </div>
                        <div class="modal-body">
                            <h5>Créer un nouveau du groupe</h5>
                            <form method="post" action="createGroup.php" class="form-inline">
                                <div class="md-form form-group">
                                    <input type="text" id="newGroup" class="form-control" name="newGroup">
                                    <label for="newGroup">Nom du groupe</label>
                                </div>
                                <div class="md-form form-group">
                                    <button class="btn btn-primary btn-sm" type="submit">Créer</button>
                                </div>
                            </form>

                            <h5>Rejoindre un groupe</h5>
                            <form method="post" action="joinGroup.php" class="form-inline">
                                <div class="md-form form-group">
                                    <input type="text" id="groupName" class="form-control" name="groupName">
                                    <label for="groupName">Nom du groupe</label>
                                </div>
                                <div class="md-form form-group">
                                    <button class="btn btn-primary btn-sm" type="submit">Rejoindre</button>
                                </div>
                            </form>
                            <?php

                            if(isset($_GET['e']))
                            {
                                $e = $_GET['e'];

                                if($e == 1)
                                {
                                    print '<p class="red-text">Vous êtes déjà dans le groupe!</p>';
                                }
                                if($e == 2)
                                {
                                    print '<p class="red-text">Le groupe choisi n\'existe pas!</p>';
                                }
                            }

                            if(isset($_GET['g']))
                            {
                            print '<h4>Membres du groupe</h4>';
                                print '<div class="list-group">';

                                        $groupMember = $classe->getGroupMember($_GET['g']);

                                        foreach($groupMember as $member)
                                        {
                                            print '<a class="list-group-item">
                                                    <p class="list-group-item-heading">' . $member['useFirstName'] . ' ' . $member['useLastName'] . '</p>
                                                  </a>';
                                        }

                                print '</div>';

                            print '
                            <br />
                            <div>
                                <h4>Options</h4>
                                <br/>

                                <h5>Modifer le nom du groupe</h5>
                                <form method="post" action="modifyGroup.php?g='. $_GET['g'] . '" class="form-inline">
                                    <div class="md-form form-group">
                                        <input type="hidden" name="oldGroupName" value="'. $_GET['g'] . '">
                                        <input type="text" id="newGroup" class="form-control" name="newGroupName" value="'. $_GET['g'].'">
                                        <label for="newGroup">Nom du groupe</label>
                                    </div>

                                    <div class="md-form form-group">
                                        <button class="btn btn-primary btn-lg" type="submit">Modifier</button>
                                    </div>
                                </form>

                                <br/>

                                <h5>Supprimer le groupe</h5>
                                <form method="post" action="deleteGroup.php?g='.$_GET['g'].'" class="form-inline">
                                    <div class="md-form form-group">
                                        <button class="btn btn-danger" type="submit">Supprimer</button>
                                    </div>
                                </form>

                                <h5>Quitter le groupe</h5>
                                <form method="post" action="leaveGroup.php?g='.$_GET['g'].'" class="form-inline">
                                    <div class="md-form form-group">
                                        <button class="btn btn-danger" type="submit">Quitter</button>
                                    </div>
                                </form>
                            </div>
                            ';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="scrollBar" class="input-field col s12" style="height: 650px; width: 120%; overflow-y: scroll">

                    <?php

                        $message = "";

                        if(isset($_GET['g']))
                        {
                            print '<div id="newMessage">';

                            $message = $classe->displayMessage($_GET['g']);

                            foreach($message as $row)
                            {
                                if(isset($_GET['g']))
                                {
                                    if($_SESSION['id'] == $row['fkUser'])
                                    {
                                        if($row['mesAttachment'] != "")
                                        {
                                            if(strtolower(pathinfo($row['mesAttachment'], PATHINFO_EXTENSION)) == 'pdf')
                                            {
                                                print('
                                                <div id="' . $row['idMessage'] . '">
                                                    <div style="text-align: right">
														<div style="text-align: right; max-width:50%; height:auto; margin-left:50%; margin-top:15px;">
															<embed style="width:100%; height:500px;" src="Upload/'. $row['mesAttachment'] .'">
														</div>
                                                    </div>
                                                </div>

                                                ');
                                            }
                                            else
                                            {
                                                print('
                                                <div id="' . $row['idMessage'] . '">
                                                    <div style="text-align: right; max-width:50%; height:auto; margin-left:50%; margin-top:15px;">
                                                            <img src="Upload/'. $row['mesAttachment'] .'" alt="Image" class="figure-img img-thumbnail">
                                                            <figcaption class="figure-caption"><span style="font-size: 9px">' . gmdate("H:i", strtotime($row['mesSendTime']) + 7200) . '</span></figcaption>
                                                    </div>
                                                </div>

                                                ');
                                            }
                                        }
                                        else
                                        {
                                            print('
                                            <div id="' . $row['idMessage'] . '">
                                                <div style="text-align: right">
                                                    <div class="chip blue white-text">
                                                        ' . $row['mesMessage'] . ' <span style="font-size: 9px">' . gmdate("H:i", strtotime($row['mesSendTime']) + 7200) . '</span>
                                                    </div>
                                                </div>
                                            </div>
                                            ');
                                        }
                                    }
                                    else
                                    {
                                        if($row['mesAttachment'] != "")
                                        {
                                            if(strtolower(pathinfo($row['mesAttachment'], PATHINFO_EXTENSION)) == 'pdf')
                                            {
                                                print('
                                                <div id="' . $row['idMessage'] . '">
                                                    <div style="text-align: left">
														<div style="text-align: right; max-width:50%; height:auto; margin-top:15px;">
															<embed style="width:100%; height:500px;" src="Upload/'. $row['mesAttachment'] .'">
														</div>
                                                    </div>
                                                </div>

                                                ');
                                            }
                                            else
                                            {
                                                print('
                                                <div id="'. $row['idMessage'] . '">
                                                    <div style="text-align: left; max-width:50%; height:auto; margin-top:15px;">
                                                        <img src="Upload/'. $row['mesAttachment'] .'" alt="Image" class="figure-img img-thumbnail">
                                                        <figcaption class="figure-caption"><span style="font-size: 9px">' . gmdate("H:i", strtotime($row['mesSendTime']) + 7200) . '</span></figcaption>
                                                    </div>
                                                </div>

                                                ');
                                            }
                                        }
                                        else
                                        {
                                            print('
                                            <div id="'. $row['idMessage'] . '">
                                                <div style="text-align: left">
                                                    <div class="chip">
                                                        '. $row['useFirstName'] . ' ' . $row['useLastName'] . ': ' . $row['mesMessage'] . '  <span style="font-size: 9px">' . gmdate("H:i",strtotime($row['mesSendTime']) + 7200 ) . '</span>
                                                    </div>
                                                </div>
                                            </div>
                                            ');
                                        }
                                    }
                                }
                            }

                            print '</div>';
                        }
                        else
                        {
                            print '
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="card-panel blue center">
                                                <span class="white-text">Séléctionnez un groupe situé sur le menu à gauche pour débuter une conversation.</span>
                                            </div>
                                        </div>
                                    </div>
                                ';
                        }

                        ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    if(isset($_GET['g']))
    {
        print '
            <footer>
                <div class="row textbox">
                    <div class="input-field col s12">
                        <form method="post" action="addMessage.php">
                            <div class="md-form input-group col s11">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-send" aria-hidden="true"></i></span>
                                <input type="text" class="form-control" aria-describedby="basic-addon1" name="message" id="message">
                            </div>
                            <button id="messagebutton" class="btn btn-primary btn-sm" type="submit">Envoyer</button>
                        </form>
                    </div>
                </div>
            </footer>
        ';
    }
?>

<!-- SCRIPTS -->

<!-- JQuery -->
<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>

<script type="text/javascript" src="js/main.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/tether.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>

<!-- Materialize -->
<script type="text/javascript" src="js/materialize.min.js"></script>

    <?php

    if(isset($_GET['e']))
    {
        echo"
            <script>
                $('#myModal').modal('show')
            </script>
        ";
    }
    ?>

</body>

</html>