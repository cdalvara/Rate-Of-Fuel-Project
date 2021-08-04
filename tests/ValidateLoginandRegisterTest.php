<?php

use PHPUnit\Framework\TestCase;

class ValidateLoginandRegisterTest extends TestCase
{
    public function testemptyEntries() //checks if empty entries returns no value (expected)
    {
        //input in null, should return empty/no value
        $RegisterEmpty = new ValidateRegisterandLogin (null, null);

        $resultRegisterUser = $RegisterEmpty->validateUsername();
        $resultRegisterPassword = $RegisterEmpty->validatePassword();
        $resultUserRepeatEmpty = $RegisterEmpty->validateRepeatUsername();

        $this->assertFalse($resultRegisterUser);
        $this->assertFalse($resultRegisterPassword);
        $this->assertFalse($resultUserRepeatEmpty);

        $LoginEmpty = new ValidateRegisterandLogin (null, null);

        $resultRegisterUser = $RegisterEmpty->validateUsername();
        $resultRegisterPassword = $RegisterEmpty->validatePassword();
        $resultUserLoginEmpty = $RegisterEmpty->validateLoginUsername();

        $this->assertFalse($resultRegisterUser);
        $this->assertFalse($resultRegisterPassword);
        $this->assertFalse($resultUserLoginEmpty);
    }

    public function testAllFieldsValid()
    {
        //testing valid username registration
        $RegisterValid = new ValidateRegisterandLogin ("Billy", "1234");
        $resultUserValid = $RegisterValid->validateUsername();
        $resultPasswordValid = $RegisterValid->validatePassword();
        $resultUserRepeatValid = $RegisterValid->validateRepeatUsername();
        $validregisterinput = $RegisterValid->validateRegisterFields($resultUserValid,$resultPasswordValid, $resultUserRepeatValid);

        $this->assertTrue($validregisterinput);

        //testing valid existing username and password login
        $LoginValid = new ValidateRegisterandLogin ("Billy", "1234");
        $resultUserValid = $LoginValid->validateUsername();
        $resultPasswordValid = $LoginValid->validatePassword();
        $resultUserLoginValid = $LoginValid->validateLoginUsername();
        $validlogininput = $LoginValid->validateLoginFields($resultUserValid,$resultPasswordValid, $resultUserLoginValid);

        $this->assertTrue($validlogininput);

        //testing invalid repeated username registration
        $RegisterInvalid = new ValidateRegisterandLogin ("Billy", "1234");
        $resultUserInvalid = $RegisterInvalid->validateUsername();
        $resultPasswordInvalid = $RegisterInvalid->validatePassword();
        $resultUserRepeatInvalid = $RegisterInvalid->validateRepeatUsername();
        $invalidregisterinput = $RegisterInvalid->validateRegisterFields($resultUserInvalid,$resultPasswordInvalid,$resultUserRepeatInvalid);

        $this->assertFalse($invalidregisterinput);

        //testing incorrect login username
        $LoginInvalid = new ValidateRegisterandLogin ("Billy1", "1234");
        $resultUserInvalid = $LoginInvalid->validateUsername();
        $resultPasswordInvalid = $LoginInvalid->validatePassword();
        $resultUserLoginInvalid = $LoginInvalid->validateLoginUsername();
        $invalidlogininput = $LoginInvalid->validateLoginFields($resultUserInvalid,$resultPasswordInvalid,$resultUserLoginInvalid);

        $this->assertFalse($invalidlogininput);

        //testing incorrect login password
        $LoginInvalid = new ValidateRegisterandLogin ("Billy", "12345");
        $resultUserInvalid = $LoginInvalid->validateUsername();
        $resultPasswordInvalid = $LoginInvalid->validatePassword();
        $resultUserLoginInvalid = $LoginInvalid->validateLoginUsername();
        $invalidlogininput = $LoginInvalid->validateLoginFields($resultUserInvalid,$resultPasswordInvalid,$resultUserLoginInvalid);

        $this->assertFalse($invalidlogininput);
        session_unset();
    }

}
