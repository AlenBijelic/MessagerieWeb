<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 10.06.2016
 * Time: 09:28
 */

session_start();

include('Classes/db_chat.php');

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if(isset($_GET['g']))
    {
        $groupName = htmlspecialchars($_GET['g']);

        $classe->deleteGroup($groupName);

        print $groupName;

        header("Location: message.php");
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