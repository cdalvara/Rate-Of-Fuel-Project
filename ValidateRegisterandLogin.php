<?php

class ValidateRegisterandLogin{
    public  $Username;
    public  $Password;
    public  $PasswordHash;
    public  $logindata;
    public  $conn;
    public  $UidValid;
    public  $PwdValid;
    public  $serverName = "localhost";
    public  $dBUsername = "root";
    public  $dBPassword = "";
    public  $dBName = "fuelquote";

    public function __construct($aUsername, $aPassword){
        $this->Username = $aUsername;
        $this->Password = $aPassword;
        $this->PasswordHash = password_hash($this->Password, PASSWORD_DEFAULT);
        $this->conn = mysqli_connect ($this->serverName, $this->dBUsername, $this->dBPassword, $this->dBName);
    }

    public function validateUsername() {
        if (empty($this->Username)){
            echo "Username is empty. <br>";
            $this->UidValid = false;
        }
        else{
            $this->UidValid = true;
        }
        return $this->UidValid;
    }

    public function validatePassword() {
        if (empty($this->Password)){
            echo "Password is empty. <br>";
            $this->PwdValid = false;
        }
        else{
            $this->PwdValid = true;
        }
        return $this->PwdValid;
    }

    public function validateRepeatUsername() {
        if ($this->UidValid == true) {
            $sql = "SELECT * FROM usercredentials WHERE usersUid = ?;";
            $stmt = mysqli_stmt_init($this->conn);

            mysqli_stmt_prepare($stmt, $sql); //prepares statement

            mysqli_stmt_bind_param($stmt, "s", $this->Username); //binds statement
            mysqli_stmt_execute($stmt); //executes

            $resultData = mysqli_stmt_get_result($stmt); //checks result

            if (mysqli_fetch_assoc($resultData)) { //if true, data exists in database
                echo "Username is taken. Please enter a different one. <br>";
                $this->UidValid = false;
            }
            return $this->UidValid;
        }
        else {
            return $this->UidValid;
        }
        my_sqli_stmt_close($stmt);
    }

    public function validateLoginUsername() {
        if ($this->UidValid == true) {
            $sql = "SELECT * FROM usercredentials WHERE usersUid = ?;";
            $stmt = mysqli_stmt_init($this->conn);

            mysqli_stmt_prepare($stmt, $sql); //prepares statement

            mysqli_stmt_bind_param($stmt, "s", $this->Username); //binds statement
            mysqli_stmt_execute($stmt); //executes

            $resultData = mysqli_stmt_get_result($stmt); //checks result
            $this->logindata = mysqli_fetch_assoc($resultData);

            if ($this->logindata) { //if true, data exists in database, put in class variable to use later
                $this->UidValid = true;
            }
            else {
                echo "Please enter an existing username. <br>";
                $this->UidValid = false;
            }
            return $this->UidValid;
        }
        else {
            return $this->UidValid;
        }
        my_sqli_stmt_close($stmt);
    }

    public function validateRegisterFields ($UsernameValid, $PasswordValid, $ValidateRepeatUsername) {
        if ($UsernameValid && $PasswordValid && $ValidateRepeatUsername) {
            $this->createUser();
            echo true;
            return true;
        }
        else {
            return false;
        }
    }

    public function validateLoginFields ($UsernameValid, $PasswordValid, $ValidateLoginUsername) {
        if ($UsernameValid && $PasswordValid && $ValidateLoginUsername) {
            if ($this->loginUser()) {
                echo true;
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    public function createUser() {

        $sql = "INSERT INTO usercredentials (usersUid, usersPwd) VALUES (?, ?);";
        $stmt = mysqli_stmt_init($this->conn);

        mysqli_stmt_prepare($stmt, $sql); //prepares statement

        mysqli_stmt_bind_param($stmt, "ss", $this->Username, $this->PasswordHash); //binds statement
        mysqli_stmt_execute($stmt); //executes
        mysqli_stmt_close($stmt); //closes
    }

    public function loginUser() {

        $this->UidValid;
        $this->PasswordHash;
        $pwdcheck = password_verify($this->Password, $this->logindata["usersPwd"]); //grabs the password from the current user login

        if ($pwdcheck) {
            
            if(!isset($_SESSION))
            {
                session_start();
            }

            $_SESSION["userid"] = $this->logindata["usersId"];
            $_SESSION["useruid"] = $this->logindata["usersUid"];
            return true;
        }
        else {
            echo "The password was incorrect. <br>";
            return false;
        }
    }
}
