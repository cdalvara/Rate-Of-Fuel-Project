<?php
    require_once("ValidateFuelQuote.php");
    $getquote = new ValidateFuelQuote ($_POST["GallonsRequested"], $_POST["DeliveryAddress"], $_POST["DeliveryDate"], $_POST["SuggestedPriceperGallon"], $_POST["TotalAmountDue"]);
    $GR = $getquote->validateGallonsRequested();
    $DA = $getquote->validateDeliveryAddress();
    $DD = $getquote->validateDeliveryDate();
    if ($GR && $DA && $DD) {
        echo true;
    }
