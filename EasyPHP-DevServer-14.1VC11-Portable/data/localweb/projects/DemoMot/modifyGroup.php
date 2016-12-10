<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 10.06.2016
 * Time: 08:43
 */

session_start();

include('Classes/db_chat.php');

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if(isset($_GET['g']))
    {
        if(isset($_POST['newGroupName']) && isset($_POST['oldGroupName']))
        {
            $newGroupName = htmlspecialchars($_POST['newGroupName']);

            $oldGroupName = htmlspecialchars($_POST['oldGroupName']);

            $classe->modifyGroup($oldGroupName, $newGroupName);

            header("Location: message.php?g=$newGroupName");
        }
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