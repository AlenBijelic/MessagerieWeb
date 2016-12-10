<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 13.06.2016
 * Time: 09:06
 */

session_start();

include "Classes/db_chat.php";

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if(isset($_POST['groupName']))
    {
        $group = htmlspecialchars($_POST['groupName']);

        $result = $classe->joinGroup($group);

        if($result == 0)
        {
            header("Location: message.php?g=$group");
        }
        elseif($result == 1)
        {
            header("Location: message.php?e=1");
        }
        elseif($result == 2)
        {
            header("Location: message.php?e=2");
        }
    }
    else
    {
        header("Location: message.php");
    }
}
else
{
    header("Location: index.php");
}

?>