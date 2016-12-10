<?php
/**
 * Created by PhpStorm.
 * User: bijelical
 * Date: 31.05.2016
 * Time: 13:55
 */

/*
 * The db_chat class
 */
class db_chat {

    public $conn;
    public $mail;
    public $password;

    /*
     * Set mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /*
     * Return mail
     */
    public function getMail()
    {
        return $this->mail;
    }

    /*
     * Set password
     */
    public function setPassword($password)
    {
        $this->mail = $password;
    }

    /*
     * Return Password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /*
     * Default Constructor
     */
    public function __Construct()
    {
        // Connection information
        $serverName = "localhost";
        $dbname = "db_chat";
        $username = "root";
        $password = "";

        //Connection to the database
        try {

            //Connection with the database
            $this->conn = new PDO("mysql:host=$serverName;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));

            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            //display error
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /*
     * Try to login the user
     */
    public function login($mail, $password)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_user WHERE useMail='$mail'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $account = $stmt->fetchAll();

        $count = $stmt->rowCount();

        if($count == 1)
        {
            foreach($account as $row)
            {
                //Verify if the password hash matches   with the one in the DB
                if (password_verify($password, $row['usePassword']))
                {
                    //Set the user session var with the pseudo
                    $_SESSION['user'] = $row['useFirstName'] . ' ' . $row['useLastName'];

                    $_SESSION['id'] = $row['idUser'];

                    //Redirect to the index
                    header('Location: ./index.php');
                }
                else
                {
                    return 2;
                }
            }
        }
        else
        {
            return 1;
        }
    }

    /*
     * Logout the user
     */
    public function logout()
    {
        session_destroy();
    }

    /*
     * Create a new user
     */
    public function createUser($firstname, $lastname, $mail, $password)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_user WHERE useMail='$mail'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $stmt->fetchAll();

        //Count how many row the result have
        $count = $stmt->rowCount();

        //Hash the password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        //Check if user already exist
        if($count == 0)
        {
            $sql = "INSERT INTO t_user (useFirstName, useLastName, useMail, usePassword) VALUES ('$firstname', '$lastname', '$mail', '$hashPassword')";

            //Prepare the query
            $stmt2 = $this->conn->prepare($sql);

            //Execute the query
            $stmt2->execute();
        }
        else
        {
            return 5;
        }
    }

    /*
     * Modify user firstname, lastname, and email
     */
    public function modifyUser($firstname, $lastname, $mail)
    {
        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare('UPDATE t_user SET useFirstName = ? , useLastName = ?, useMail = ? WHERE idUser = ?');

        //Execute the query
        $stmt->execute(array($firstname, $lastname, $mail, $id));
    }

    /*
     * Modify user password
     */
    public function modifyPassword($password)
    {
        $id = $_SESSION['id'];

        //Hash the password
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE t_user SET usePassword=? WHERE idUser=?";

        //Prepare the query
        $stmt = $this->conn->prepare($sql);

        //Execute the query
        $stmt->execute(array($hashPassword, $id));
    }

    /*
     * Display the user informations by the id
     */
    public function getUserName()
    {
        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_user WHERE idUser = '$id'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetch();

        return $result;
    }

    /*
     * Display group where user belongs
     */
    public function getGroup()
    {
        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("SELECT groName FROM t_group, t_MemberGroup WHERE fkGroup = idGroup AND fkUser = '.$id.'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetchAll();

        return $result;
    }

    /*
     * Display message of a group
     */
    public function displayMessage($group)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_message, t_group, t_user WHERE fkGroup = idGroup AND groName = '$group' AND fkUser = idUser ORDER BY idMessage");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetchAll();

        return $result;
    }

    /*
     * Create a new message
     */
    public function createMessage($message, $groupQuery)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_group WHERE groName = '$groupQuery'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetchAll();

        $group = $result[0][0];

        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("INSERT INTO t_message (mesMessage, fkUser, fkGroup) VALUES ('$message', '$id', '$group')");

        //Execute the query
        $stmt->execute();
    }

    /*
     * Display user informations
     */
    public function getUserInformations()
    {
        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_user WHERE idUser = '$id'");

        //Execute the query
        $stmt->execute();

        //Fetch data to array
        $result = $stmt->fetch();

        //Return data
        return $result;
    }

    /*
     * Get all new message
     */
    public function getMessage($id, $group, $userID)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_message, t_group, t_user WHERE fkGroup = idGroup AND groName = '$group' AND fkUser = idUser AND fkUser != '$userID' AND idMessage > '$id' ORDER BY idMessage");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetchAll();

        $stmt->closeCursor();

        return $result;
    }

    /*
     * Check which users are in a group
     */
    public function isUserInGroup($group)
    {
        $userId = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("SELECT idGroup FROM t_group WHERE groName = '$group'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetch();

        $groupId = $result['idGroup'];

        $query = $this->conn->prepare("SELECT * FROM t_membergroup WHERE fkUser = '$userId' AND fkGroup = '$groupId'");

        $query->execute();

        $finalResult = $query->fetch();

        return $finalResult;
    }

    /*
     * Display all users of a group
     */
    public function getGroupMember($group)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT idGroup FROM t_group WHERE groName = '$group'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetch();

        $groupId = $result['idGroup'];

        $query = $this->conn->prepare("SELECT * FROM t_membergroup, t_User WHERE fkGroup = '$groupId' AND fkUser = idUser");

        $query->execute();

        $finalResult = $query->fetchAll();

        return $finalResult;
    }

    /*
     * Display a admin of a group
     */
    public function getAdmin()
    {

    }

    /*
     * Modify a group
     */
    public function modifyGroup($oldName, $newName)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM t_group WHERE groName = '$oldName'");

        $stmt->execute();

        $oldGroup = $stmt->fetch();

        $idGroup = $oldGroup['idGroup'];

        $stmt2 = $this->conn->prepare("UPDATE t_Group SET groName = '$newName' WHERE idGroup = '$idGroup'");

        $stmt2->execute();
    }

    /*
     * Delete a group
     */
    public function deleteGroup($groupName)
    {
        $stmt = $this->conn->prepare("DELETE FROM t_group WHERE groName = '$groupName'");

        $stmt->execute();
    }

    /*
     * Create new group
     */
    public function createGroup($group)
    {
        $id = $_SESSION['id'];//Prepare the query

        $stmt = $this->conn->prepare("INSERT INTO t_group (groName, fkAdmin) VALUES ('$group', '$id')");

        //Execute the query
        $stmt->execute();

        $stmt2= $this->conn->prepare("SELECT idGroup FROM t_Group WHERE groName = '$group'");

        $stmt2->execute();

        $result = $stmt2->fetch();

        $newGroup = $result['idGroup'];

        $stmt3 = $this->conn->prepare("INSERT INTO t_membergroup(fkUser, fkGroup) VALUES ('$id', '$newGroup')");

        $stmt3->execute();
    }

    /*
     * Delete link between an user and a group to leave the group
     */
    public function leaveGroup($group)
    {
        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("SELECT idGroup FROM t_group WHERE groName = '$group'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetch();

        $groupId = $result['idGroup'];

        $stmt2 = $this->conn->prepare("DELETE FROM t_memberGroup WHERE fkGroup = '$groupId' AND fkUser = '$id'");

        $stmt2->execute();
    }

    /*
     * Join to a existing group
     */
    public function joinGroup($group)
    {
        $id = $_SESSION['id'];

        //Check if the user is already in the group that he want to join
        $stmt = $this->conn->prepare("SELECT * FROM t_memberGroup, t_Group WHERE fkGroup = idGroup AND groName = '$group' AND fkUser = '$id'");

        $stmt->execute();

        $count = $stmt->rowCount();

        //Check if the group exist
        $stmt2 = $this->conn->prepare("SELECT idGroup FROM t_group WHERE groName = '$group'");

        $stmt2->execute();

        $exist = $stmt2->fetch();

        $groupId = $exist['idGroup'];

        $stmt3 = $this->conn->prepare("INSERT INTO t_membergroup(fkUser, fkGroup) VALUES ('$id', '$groupId')");

        //Check if group exist
        if($exist['idGroup'] != null)
        {
            //Check if the user is already in the group
            if($count == 0)
            {
                $stmt3->execute();

                return 0;
            }
            //The user is in the group, return 1 and display a error message
            else
            {
                return 1;
            }
        }
        //The group does not exist, return 2 and display a error message
        else
        {
            return 2;
        }
    }

    /*
     * Create a new message witch an attachment
     */
    public function createMessageAttachment($attachment, $group)
    {
        //Prepare the query
        $stmt = $this->conn->prepare("SELECT idGroup FROM t_group WHERE groName = '$group'");

        //Execute the query
        $stmt->execute();

        //Set the result in a array
        $result = $stmt->fetch();

        $groupId = $result['idGroup'];

        $id = $_SESSION['id'];

        //Prepare the query
        $stmt = $this->conn->prepare("INSERT INTO t_message (mesAttachment, fkUser, fkGroup) VALUES ('$attachment', '$id', '$groupId')");

        //Execute the query
        $stmt->execute();
    }

    /*
	* Default destructor
	*/
    public function __destruct()
    {
        unset($this->conn); //Unset the connection to the database
    }
}