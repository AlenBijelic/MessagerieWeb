<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 31.05.2016
 * Time: 13:56
 */

session_start();

include("Classes/db_chat.php");

if(isset($_SESSION['user']))
{
    $logout = new db_chat();

    $logout->logout();

    header("Location: index.php");

}
else
{
    header("Location: index.php");
}

?>

