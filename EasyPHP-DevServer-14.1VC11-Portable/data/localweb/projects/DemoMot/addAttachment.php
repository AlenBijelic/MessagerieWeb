<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 13.06.2016
 * Time: 13:14
 */

session_start();

include "Classes/db_chat.php";

$classe = new db_chat();

if(isset($_SESSION['id']))
{
    if (isset($_GET['g']) && isset($_FILES['fileToUpload']['name']))
    {
        $group = htmlspecialchars($_GET['g']);

        $type = Array(1 => 'jpg', 2 => 'tif', 3 => 'png', 4 => 'gif', 5 => 'pdf');

        $originalName = $_FILES['fileToUpload']['name'];
        $originalPath = pathinfo($originalName);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $strPath = "./Upload/";

        $tempFile = $_FILES['fileToUpload']['tmp_name'];
        $strDestination = date('Ymdhis') . "-" . $originalName;

        $errorValue = $_FILES['fileToUpload']['error'];


        if ($errorValue == 0)
        {
            if (!(in_array($ext, $type)))
            {
                header("Location: message.php?g=$group&fileError=1");
            }
            else
            {
                if (move_uploaded_file($tempFile, $strPath . $strDestination))
                {
                    $classe->createMessageAttachment($strDestination, $group);

                    header("Location: message.php?g=$group");
                }
                else
                {
                    header("Location: message.php?g=$group&fileError=2");
                }

            }
        }
        else
        {
            header("Location: message.php?g=$group&fileError=$errorValue");

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