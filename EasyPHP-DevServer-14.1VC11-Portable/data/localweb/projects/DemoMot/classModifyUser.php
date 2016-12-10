<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 01.06.2016
 * Time: 10:09
 */
session_start();

include("Classes/db_chat.php");

//Regex to check if the firstname and the lastname are correct
$nameRegex = "/^[\p{L}-. ]*$/u";

/*
 * Check if the user is already connected
 */
if(isset($_SESSION['id']))
{
    /*
     * Check if form send data
     */
    if(isset($_POST['modifyFirstName']) && isset($_POST['modifyLastName']) && isset($_POST['modifyMail']))
    {
        //Retrieve informations
        $firstName = htmlspecialchars($_POST['modifyFirstName']);
        $lastName = htmlspecialchars($_POST['modifyLastName']);
        $email = htmlspecialchars($_POST['modifyMail']);

        /*
         * Check if firstname is correct
         */
        if(preg_match($nameRegex, $firstName))
        {
            /*
             * Check if lastname is correct
             */
            if(preg_match($nameRegex, $lastName))
            {
                /*
                 * Check if the mail is valid
                 */
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    $modify = new db_chat();

                    //modify the user in the database
                    $modify->modifyUser($firstName, $lastName, $email);

                    $_SESSION['user'] = $firstName . ' ' . $lastName;

                    header('Location: index.php');
                }
                /*
                 * If the mail is not valid, the user is redirected to the modify page to display a error
                 */
                else
                {
                    header("Location: account.php?errorModify=3");
                }
            }
            else
            {
                header("Location: account.php?errorModify=2");
            }
        }
        else
        {
            header("Location: account.php?errorModify=1");
        }
        /*
         * If data are missing, the user is redirected to the modify page to display a error
         */
    }
    else
    {
        header("Location: account.php");
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