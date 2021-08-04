<?php


use PHPUnit\Framework\TestCase;
require_once "GetProfileDisplay.php";

class ValidateProfileManageandDisplayTest extends TestCase
{

    public function testValidEntries() //checks if having valid entries sets boolean return value to true for respective form field
    {
        //enter in valid values, should return a true boolean
        $ProfileManage = new ValidateProfileManage ("Carlos", "12345 Random Address", "temp", "Houston", "TX", 12345);
        $resultvalidateName = $ProfileManage->validateName();
        $resultvalidatefirstAddress = $ProfileManage->validatefirstAddress();
        $resultvalidatesecondAddress = $ProfileManage->validatesecondAddress();
        $resultvalidateCity = $ProfileManage->validateCity();
        $resultvalidateState = $ProfileManage->validateState();
        $resultvalidateZip = $ProfileManage->validateZip();

        $this->assertTrue($resultvalidateName);
        $this->assertTrue($resultvalidatefirstAddress);
        $this->assertTrue($resultvalidatesecondAddress);
        $this->assertTrue($resultvalidateCity);
        $this->assertTrue($resultvalidateState);
        $this->assertTrue($resultvalidateZip);
    }

    public function testinvalidentryProfileManage() //checks invalid entries return no value (expected)
    {
        //input in character, symbol, symbol, character, and character, all of which are invalid; should return empty
        $ProfileManage = new ValidateProfileManage ("@", "#", "#", "#", "TX", "^");

        $resultvalidateName = $ProfileManage->validateName();
        $resultvalidatefirstAddress = $ProfileManage->validatefirstAddress();
        $resultvalidatesecondAddress = $ProfileManage->validatesecondAddress();
        $resultvalidateCity = $ProfileManage->validateCity();
        $resultvalidateZip = $ProfileManage->validateZip();

        $this->assertFalse($resultvalidateName);
        $this->assertFalse($resultvalidatefirstAddress);
        $this->assertFalse($resultvalidatesecondAddress);
        $this->assertFalse($resultvalidateCity);
        $this->assertFalse($resultvalidateZip);
    }

    public function testemptyEntries() //checks if empty entries returns no value (expected)
    {
        $ProfileManage = new ValidateProfileManage (null, null, null, null, null, null);
        $resultvalidateName = $ProfileManage->validateName();
        $resultvalidatefirstAddress = $ProfileManage->validatefirstAddress();
        $resultvalidatesecondAddress = $ProfileManage->validatesecondAddress();
        $resultvalidateCity = $ProfileManage->validateCity();
        $resultvalidateState = $ProfileManage->validateState();
        $resultvalidateZip = $ProfileManage->validateZip();

        $this->assertFalse($resultvalidateName);
        $this->assertFalse($resultvalidatefirstAddress);
        $this->assertTrue($resultvalidatesecondAddress);
        $this->assertFalse($resultvalidateCity);
        $this->assertFalse($resultvalidateState);
        $this->assertFalse($resultvalidateZip);
    }

    public function testAllFieldsValid()
    {

        //testing that correct information is displayed in Profile Display when empty
        $row = displayClientInformation();
        if ($row) {
            $correctDisplay = true;
        }
        else {
            $correctDisplay = false;
        }

        $this->assertFalse($correctDisplay);

        $ProfileManageValid = new ValidateProfileManage ("Carlos", "12345 Random Address", "temp", "Houston", "TX", 12345);
        $N = $ProfileManageValid->validateName();
        $A = $ProfileManageValid->validatefirstAddress();
        $SA = $ProfileManageValid->validatesecondAddress();
        $C = $ProfileManageValid->validateCity();
        $S = $ProfileManageValid->validateState();
        $Z = $ProfileManageValid->validateZip();
        $validinput = $ProfileManageValid->AllFieldsValid($N,$A,$SA,$C,$S,$Z);

        $this->assertTrue($validinput);

        $ProfileManageUpdate = new ValidateProfileManage ("Billy", "12345 Random Address", "", "Houston", "TX", 12345);
        $N = $ProfileManageUpdate->validateName();
        $A = $ProfileManageUpdate->validatefirstAddress();
        $SA = $ProfileManageUpdate->validatesecondAddress();
        $C = $ProfileManageUpdate->validateCity();
        $S = $ProfileManageUpdate->validateState();
        $Z = $ProfileManageUpdate->validateZip();
        $updateinput = $ProfileManageUpdate->AllFieldsValid($N,$A,$SA,$C,$S,$Z);

        $this->assertTrue($updateinput);

        $ProfileManageInvalid = new ValidateProfileManage (null, null, null, null, null, null);
        $N1 = $ProfileManageInvalid->validateName();
        $A1 = $ProfileManageInvalid->validatefirstAddress();
        $A11 = $ProfileManageInvalid->validatesecondAddress();
        $C1 = $ProfileManageInvalid->validateCity();
        $S1 = $ProfileManageInvalid->validateState();
        $Z1 = $ProfileManageInvalid->validateZip();
        $invalidinput = $ProfileManageInvalid->AllFieldsValid($N1,$A1,$A11,$C1,$S1,$Z1);

        $this->assertFalse($invalidinput);

        //testing that correct information is displayed in Profile Display
        $row = displayClientInformation();
        if ($row["FullName"] == "Billy" && $row["Address1"] == "12345 Random Address" && $row["Address2"] == "" && $row["City"] == "Houston" && $row["State"] == "TX" && $row["ZipCode"] = 12345) {
            $correctDisplay = true;
            return $correctDisplay;
        }
        else {
            $correctDisplay = false;
            return $correctDisplay;
        }

        $this->assertTrue($correctDisplay);
    }

    public function testlengthFieldsValid() {
        //test first address length
        $ProfileManageTooLong = new ValidateProfileManage ("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa", "TX", 1111111111);
        $resultvalidateName = $ProfileManageTooLong->validateName();
        $resultvalidatefirstAddress = $ProfileManageTooLong->validatefirstAddress();
        $resultvalidatesecondAddress = $ProfileManageTooLong->validatesecondAddress();
        $resultvalidateCity = $ProfileManageTooLong->validateCity();
        $resultvalidateZip = $ProfileManageTooLong->validateZip();

        $this->assertFalse($resultvalidateName);
        $this->assertFalse($resultvalidatefirstAddress);
        $this->assertFalse($resultvalidatesecondAddress);
        $this->assertFalse($resultvalidateCity);
        $this->assertFalse($resultvalidateZip);

        $ProfileManageTooShort = new ValidateProfileManage ("a", "a", "a", "a", "TX", 1111);
        $resultvalidateZip1 = $ProfileManageTooShort->validateZip();

        $this->assertFalse($resultvalidateZip1);
    }
}
