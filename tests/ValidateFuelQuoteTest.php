<?php


use PHPUnit\Framework\TestCase;

class ValidateFuelQuoteTest extends TestCase
{

    public function testValidEntries() //checks if having valid entries sets boolean return value to true for respective form field
    {
        //enter in valid values, should return a true boolean
        $FuelQuote = new ValidateFuelQuote(1,"12345 Random Address","2019-08-10",4,5);

        $resultGallonsRequested = $FuelQuote->validateGallonsRequested();
        $resultDeliveryAddress = $FuelQuote->validateDeliveryAddress();
        $resultDeliveryDate = $FuelQuote->validateDeliveryDate();
        $resultSuggestedPriceperGallon = $FuelQuote ->validateSuggestedPriceperGallon();
        $resultTotalAmountDue = $FuelQuote->validateTotalAmountDue();

        $this->assertTrue($resultGallonsRequested);
        $this->assertTrue($resultDeliveryAddress);
        $this->assertTrue($resultDeliveryDate);
        $this->assertTrue($resultSuggestedPriceperGallon);
        $this->assertTrue($resultTotalAmountDue);
    }

    public function testemptyEntries() //checks if empty entries returns no value (expected)
    {
        //input in null, should return empty/no value
        $FuelQuote = new ValidateFuelQuote (null, null, null, null, null);

        $resultGallonsRequested = $FuelQuote->validateGallonsRequested();
        $resultDeliveryAddress = $FuelQuote->validateDeliveryAddress();
        $resultDeliveryDate = $FuelQuote->validateDeliveryDate();
        $resultSuggestedPriceperGallon = $FuelQuote ->validateSuggestedPriceperGallon();
        $resultTotalAmountDue = $FuelQuote->validateTotalAmountDue();

        $this->assertFalse($resultGallonsRequested);
        $this->assertFalse($resultDeliveryAddress);
        $this->assertFalse($resultDeliveryDate);
        $this->assertFalse($resultSuggestedPriceperGallon);
        $this->assertFalse($resultTotalAmountDue);
    }

    public function testinvalidentryGallonsRequested() //checks invalid entries return no value (expected)
    {
        //input in character, symbol, symbol, character, and character, all of which are invalid; should return empty
        $FuelQuote = new ValidateFuelQuote ("a", "$12345 Random Address", "2019-08-10", "b", "c");

        $resultGallonsRequested = $FuelQuote->validateGallonsRequested();
        $resultDeliveryAddress = $FuelQuote->validateDeliveryAddress();
        $resultSuggestedPriceperGallon = $FuelQuote ->validateSuggestedPriceperGallon();
        $resultTotalAmountDue = $FuelQuote->validateTotalAmountDue();

        $this->assertFalse($resultGallonsRequested);
        $this->assertFalse($resultDeliveryAddress);
        $this->assertFalse($resultSuggestedPriceperGallon);
        $this->assertFalse($resultTotalAmountDue);
    }

    public function testAllFieldsValid()
    {
        $FuelQuoteValid = new ValidateFuelQuote(1,"12345 Random Address","2019-08-10",4,5);
        $GR = $FuelQuoteValid->validateGallonsRequested();
        $DA = $FuelQuoteValid->validateDeliveryAddress();
        $DD = $FuelQuoteValid->validateDeliveryDate();
        $PPpG = $FuelQuoteValid->validateSuggestedPriceperGallon();
        $TAD = $FuelQuoteValid->validateTotalAmountDue();
        $validinput = $FuelQuoteValid->AllFieldsValid($GR,$DA,$DD,$PPpG,$TAD);

        $this->assertEquals("12345 Random Address", $validinput);

        //test that incorrect delivery address needs refresh
        $FuelQuoteValid->DeliveryAddress = "63463 Random Address";
        $invalidinput = $FuelQuoteValid->AllFieldsValid($GR,$DA,$DD,$PPpG,$TAD);

        $this->assertFalse($invalidinput);
        
        $FuelQuoteInvalid = new ValidateFuelQuote ("a", "$12345 Random Address", "2019-08-10", "b", "c");
        $GR1 = $FuelQuoteInvalid->validateGallonsRequested();
        $DA1= $FuelQuoteInvalid->validateDeliveryAddress();
        $DD1 = $FuelQuoteInvalid->validateDeliveryDate();
        $PPpG1 = $FuelQuoteInvalid->validateSuggestedPriceperGallon();
        $TAD1 = $FuelQuoteInvalid->validateTotalAmountDue();
        $invalidinput = $FuelQuoteInvalid->AllFieldsValid($GR1,$DA1,$DD1,$PPpG1,$TAD1);

        $this->assertEmpty($invalidinput);
    }
}
