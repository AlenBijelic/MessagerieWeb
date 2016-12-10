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
if(!isset($_SESSION['user']))
{
    /*
     * Check if form send data
     */
    if(isset($_POST['registerFirstName']) && isset($_POST['registerLastName']) && isset($_POST['registerMail']) && isset($_POST['registerPassword']) && isset($_POST['registerConfirmPassword']))
    {
        //Retrieve informations
        $firstName = htmlspecialchars($_POST['registerFirstName']);
        $lastName = htmlspecialchars($_POST['registerLastName']);
        $email = htmlspecialchars($_POST['registerMail']);
        $password = htmlspecialchars($_POST['registerPassword']);
        $confirmPassword = htmlspecialchars($_POST['registerConfirmPassword']);

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
                    /*
                     * Check if passwords are same
                     */
                    if($password === $confirmPassword)
                    {
                        $register = new db_chat();

                        //Register the user in the database
                        $result = $register->createUser($firstName, $lastName, $email, $password);

                        header("Location: index.php?mail=$email");
                        /*
                         * Check if there is any error
                         */
                        if($result != '')
                        {
                            //Display the error on register page
                            header("Location: register.php?errorRegister=$result");
                        }
                    }
                    else
                    {
                        header("Location: register.php?errorRegister=4");
                    }
                }
                /*
                 * If the mail is not valid, the user is redirected to the register page to display a error
                 */
                else
                {
                    header("Location: register.php?errorRegister=3");
                }
            }
            else
            {
                header("Location: register.php?errorRegister=2");
            }
        }
        else
        {
            header("Location: register.php?errorRegister=1");
        }
    /*
     * If data are missing, the user is redirected to the register page to display a error
     */
    }
    else
    {
        header("Location: register.php");
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