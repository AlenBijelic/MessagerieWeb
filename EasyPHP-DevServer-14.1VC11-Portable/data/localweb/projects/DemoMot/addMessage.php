<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 06.06.2016
 * Time: 10:15
 */
session_start();

include_once('Classes/db_chat.php');

if(isset($_POST['message']) && $_POST != "" && $_GET['g'])
{
    $message = htmlspecialchars($_POST['message']);

    $group = $_GET['g'];

    $classe = new db_chat();

    $classe->createMessage($message, $group);

    header("Location: message.php?g=$group");
}
?>

