<?php
    require_once("ValidateFuelQuote.php");
    $fuelformrequest1 = new ValidateFuelQuote ($_POST["GallonsRequested"], $_POST["DeliveryAddress"], $_POST["DeliveryDate"], $_POST["SuggestedPriceperGallon"], $_POST["TotalAmountDue"]);
    $GR = $fuelformrequest1->validateGallonsRequested();
    $DA = $fuelformrequest1->validateDeliveryAddress();
    $DD = $fuelformrequest1->validateDeliveryDate();
    $PPpG = $fuelformrequest1->validateSuggestedPriceperGallon();
    $TAD = $fuelformrequest1->validateTotalAmountDue();
    $fuelformrequest1->AllFieldsValid($GR,$DA,$DD,$PPpG,$TAD);