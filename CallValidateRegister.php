<?php
  require_once("ValidateRegisterandLogin.php");
  $Register = new ValidateRegisterandLogin ($_POST["username"], $_POST["password"]);
  $UserValid = $Register->validateUsername();
  $PassValid = $Register->validatePassword();
  $RepeatUserValid = $Register->validateRepeatUsername();
  $Register->validateRegisterFields ($UserValid, $PassValid, $RepeatUserValid); //validates and creates user if valid
