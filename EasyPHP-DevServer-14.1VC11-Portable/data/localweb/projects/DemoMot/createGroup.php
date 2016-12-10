<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 10.06.2016
 * Time: 08:27
 */

session_start();

include('Classes/db_chat.php');

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if(isset($_POST['newGroup']))
    {
        $newGroup = htmlspecialchars($_POST['newGroup']);

        $classe->createGroup($newGroup);

        header("Location: message.php?g=$newGroup");
    }
    else
    {
        header('Location: message.php');
    }
}
else
{
    header('Location: index.php');
}

?>

