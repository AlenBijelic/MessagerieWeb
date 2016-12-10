<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 07.06.2016
 * Time: 13:27
 */

session_start();

include("Classes/db_chat.php");

$classe = new db_chat();

if(isset($_GET['id']) && isset($_GET['g']))
{

    $id = (int) $_GET['id']; //Check if id is a number

    $userId = $_SESSION['id'];

    $result = $classe->getMessage($_GET['id'], $_GET['g'], $userId);

    $messages = null;

    foreach($result as $row)
    {
        $id = $row['idMessage'];
        $firstName = $row['useFirstName'];
        $lastName = $row['useLastName'];
        $message = $row['mesMessage'];
        $attachment = $row['mesAttachment'];

        if($attachment != '')
        {
            if(strtolower(pathinfo($row['mesAttachment'], PATHINFO_EXTENSION)) == 'pdf')
            {
                $messages.= '
                    <div id="' . $row['idMessage'] . '">
                        <div style="text-align: left">
                            <div class="chip">
                                <a target="_blank" href="Upload/'. $row['mesAttachment'] .'">' . $row['mesAttachment'] . '</a> <span style="font-size: 9px">' . gmdate("H:i", strtotime($row['mesSendTime']) + 7200) . '</span>
                            </div>
                        </div>
                    </div>
                ';
            }
            else
            {
                $messages.= '
                    <div id="'. $row['idMessage'] . '">
                        <div style="text-align: left; max-width:50%; height:auto; margin-top:15px;">
                            <img src="Upload/'. $row['mesAttachment'] .'" alt="Image" class="figure-img img-thumbnail">
                            <figcaption class="figure-caption"><span style="font-size: 9px">' . gmdate("H:i", strtotime($row['mesSendTime']) + 7200) . '</span></figcaption>
                        </div>
                    </div>
                ';
            }
        }
        else
        {
            $messages .= '<div id="' . $id . '"><div style="text-align: left"><div class="chip">' . $firstName . ' ' . $lastName . ': ' . $message . ' <span style="font-size: 9px">' . gmdate("H:i",strtotime($row['mesSendTime']) + 7200 ) . '</span></div></div></div>';
        }
    }

    echo $messages;
}

?>
