<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 31.05.2016
 * Time: 13:56
 */

session_start();

include("Classes/db_chat.php");

/*
 * Check if the user is already connected
 */
if(!isset($_SESSION['user']))
{
    /*
     * Check if form send data
     */
    if(isset($_POST['email']) && isset($_POST['password']) )
    {
        //Retrieve email and password
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);

        /*
         * Check if the mail is valid
         */
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
                $login = new db_chat();

                $result = $login->login($email, $password);

                if($result != '')
                {
                    header("Location: index.php?errorlogin=$result");
                }
        }
        /*
         * If the mail is not valid, the user is redirected to the index to display a error
         */
        else
        {
            header("Location: index.php?errorlogin=1");
        }
    /*
     * If data are missing, the user is redirected to the index to display a error
     */
    }
    else
    {
        header("Location: index.php");
    }
/*
* If the user is already connected, the user is redirected to the index
*/
}
else
{
    header("Location: index.php");
}

?>