<?php
include_once "ValidateProfileManage.php";
class ValidateFuelQuote {
  public $GallonsRequested;
  public $DeliveryAddress;
  public $DeliveryDate;
  public $SuggestedPriceperGallon;
  public $TotalAmountDue;
  public $conn;
  public $serverName = "localhost";
  public $dBUsername = "root";
  public $dBPassword = "";
  public $dBName = "fuelquote";

  public function __construct($aGallonsRequested, $aDeliveryAddress, $aDeliveryDate, $aSuggestedPriceperGallon, $aTotalAmountDue) {
    $this->GallonsRequested = $aGallonsRequested;
    $this->DeliveryAddress = $aDeliveryAddress;
    $this->DeliveryDate = $aDeliveryDate;
    $this->SuggestedPriceperGallon = $aSuggestedPriceperGallon;
    $this->TotalAmountDue = $aTotalAmountDue;
    $this->conn = mysqli_connect ($this->serverName, $this->dBUsername, $this->dBPassword, $this->dBName);
  }

  public function validateGallonsRequested () {
      if (empty($this->GallonsRequested)) {
          echo "The Gallons Requested Field is required. <br>";
          return false;
      }
      else {
          if (!filter_var($this->GallonsRequested, FILTER_VALIDATE_FLOAT)) {
              echo "Please enter a numeric value into the Gallons Requested Field. <br>";
              return false;
          }
          else {
              return true;
          }
      }
  }

  public function validateDeliveryAddress () {
    if (empty($this->DeliveryAddress)) {
      echo "The Delivery Address is empty.<br>";
      return false;
    }
    else if (!preg_match("/^[a-zA-Z\d\s]+$/", $this->DeliveryAddress)) {
        echo "Delivery Address input is invalid, please enter alphanumeric characters. <br>";
        return false;
    }
    else {
      return true;
    }
  }

  public function validateDeliveryDate () {
    if (empty($this->DeliveryDate)) {
      echo "The Delivery Date is empty. <br>";
      return false;
    }
    else {
      return true;
    }
  }

  public function validateSuggestedPriceperGallon () {
    if (empty($this->SuggestedPriceperGallon)) {
      echo "The Suggested Price / gallon is not calculated. Please press get quote first. <br>";
      return false;
    }
    else {
      if (!filter_var($this->SuggestedPriceperGallon, FILTER_VALIDATE_FLOAT)) {
        echo "The Suggested Price / gallon is not numeric. <br>";
        return false;
      }
      else {
          return true;
      }
    }
  }

  public function validateTotalAmountDue () {
    if (empty($this->TotalAmountDue)) {
      echo "The Total Amount Due is not calculated. Please press get quote first.<br>";
      return false;
    }
    else {
      if (!filter_var($this->TotalAmountDue, FILTER_VALIDATE_FLOAT)) {
        echo "The Total Amount Due is not numeric. <br>";
        return false;
      }
      else {
          return true;
      }
    }
  }

  public function AllFieldsValid ($GallonsRequestedValid, $DeliveryAddressValid, $DeliveryDateValid, $SuggestedPriceperGallonValid, $TotalAmountDueValid) {
    if ($GallonsRequestedValid && $DeliveryAddressValid && $DeliveryDateValid && $SuggestedPriceperGallonValid && $TotalAmountDueValid) {
        $test = new getDeliveryAddress();
        $result = $test->getDeliveryAddress();
        if ($result != $this->DeliveryAddress) {
            echo "Please refresh the page and make sure the Delivery Address is the same as Profile Management Address 1.";
            return false;
        }
        else {
            echo true;
            $this->AddFuelQuoteDB();
            return $result;
        }
    }
    else {
        return false;
    }
  }

  public function AddFuelQuoteDB () {
      $sql = "INSERT INTO fuelquote (usersId, GallonsRequested, DeliveryAddress, DeliveryDate, SuggestedPriceperGallon, TotalAmountDue) VALUES (?, ?, ?, ?, ?, ?);";
      $stmt = mysqli_stmt_init($this->conn);

      mysqli_stmt_prepare($stmt, $sql); //prepares statement

      mysqli_stmt_bind_param($stmt, "iissdd", $_SESSION["userid"], $this->GallonsRequested, $this->DeliveryAddress, $this->DeliveryDate, $this->SuggestedPriceperGallon, $this->TotalAmountDue); //binds statement
      mysqli_stmt_execute($stmt); //executes
      mysqli_stmt_close($stmt); //closes
  }
}
