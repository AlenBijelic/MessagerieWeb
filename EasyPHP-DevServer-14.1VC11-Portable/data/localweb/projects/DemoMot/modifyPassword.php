<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 10.06.2016
 * Time: 13:12
 */
session_start();

include("Classes/db_chat.php");

/*
 * Check if the user is already connected
 */
if(isset($_SESSION['id']))
{
    /*
     * Check if form send data
     */
    if(isset($_POST['modifyPassword']) && isset($_POST['modifyConfirmPassword']))
    {
        //Retrieve informations
        $password = htmlspecialchars($_POST['modifyPassword']);
        $confirmPassword = htmlspecialchars($_POST['modifyConfirmPassword']);

        if($password == $confirmPassword)
        {
            $modify = new db_chat();

            //modify the user in the database
            $modify->modifyPassword($password);

            header('Location: index.php');
        }
        /*
         * If the mail is not valid, the user is redirected to the modify page to display a error
         */
        else
        {
            header("Location: account.php?errorModify=4");
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

