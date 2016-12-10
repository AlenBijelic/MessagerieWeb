<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 13.06.2016
 * Time: 08:48
 */

session_start();

include "Classes/db_chat.php";

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if(isset($_GET['g']))
    {
        $group = htmlspecialchars($_GET['g']);

        $classe->leaveGroup($group);
    }

    header("Location: message.php");

}
else
{
    header("Location: index.php");
}

?>