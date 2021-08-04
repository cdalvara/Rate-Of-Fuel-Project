<?php
  require_once("ValidateRegisterandLogin.php");
  $LogIn = new ValidateRegisterandLogin ($_POST["usname"], $_POST["pword"]);
  $UserValid = $LogIn->validateUsername();
  $PassValid = $LogIn->validatePassword();
  $LoginUserValid = $LogIn->validateLoginUsername();
  $LogIn->validateLoginFields ($UserValid, $PassValid, $LoginUserValid); //validates and logins user if found
