<?php
    
    if(!isset($_SESSION))
    {
        session_start();
    }

    class PricingModule {
          public $CurrentPrice;
          public $Margin;
          public $LocationFactor;
          public $RateHistoryFactor;
          public $GallonsRequestedFactor;
          public $GallonsRequested;
          public $CompanyProfitFactor;
          public $SuggestedPrice;
          public $TotalAmountDue;
          public $serverName = "localhost";
          public $dBUsername = "root";
          public $dBPassword = "";
          public $dBName = "fuelquote";
          public $conn;

          public function __construct () {
              $this->CurrentPrice = 1.50;
              $this->CompanyProfitFactor = 0.1;
              $this->conn = mysqli_connect ($this->serverName, $this->dBUsername, $this->dBPassword, $this->dBName);
          }

          public function getLocationFactor () {
              $sql = "SELECT * FROM clientinformation WHERE usersId = ?;";
              $stmt = mysqli_stmt_init($this->conn);

              mysqli_stmt_prepare($stmt, $sql); //prepares statement
              mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]); //binds statement
              mysqli_stmt_execute($stmt); //executes

              $resultData = mysqli_stmt_get_result($stmt); //checks result
              $row = mysqli_fetch_assoc($resultData);

              if ($row["State"] == "TX") {
                  $this->LocationFactor = 0.02;
              }
              else {
                  $this->LocationFactor = 0.04;
              }
              mysqli_stmt_close($stmt); //closes

              return $this->LocationFactor;
          }

          public function getRateHistoryFactor () {
              $sql = "SELECT * FROM fuelquote WHERE usersId = ?;";
              $stmt = mysqli_stmt_init($this->conn);

              mysqli_stmt_prepare($stmt, $sql); //prepares statement
              mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]); //binds statement
              mysqli_stmt_execute($stmt); //executes

              $resultData = mysqli_stmt_get_result($stmt); //checks result
              if (mysqli_fetch_assoc($resultData) != NULL) {
                  $this->RateHistoryFactor = 0.01;
              }
              else {
                  $this->RateHistoryFactor = 0.00;
              }
              mysqli_stmt_close($stmt); //closes

              return $this->RateHistoryFactor;
          }

          public function getGallonsRequestedFactor ($Gallons) {
              $this->GallonsRequested = $Gallons;
              if ($this->GallonsRequested > 1000) {
                  $this->GallonsRequestedFactor = 0.02;
              }
              else {
                  $this->GallonsRequestedFactor = 0.03;
              }

              return $this->GallonsRequestedFactor;
          }

          public function getMargin () {
              $this->Margin = $this->CurrentPrice * ($this->LocationFactor - $this->RateHistoryFactor + $this->GallonsRequestedFactor + $this->CompanyProfitFactor);
              return $this->Margin;
          }

          public function getSuggestedPrice () {
              $this->SuggestedPrice = $this->Margin + $this->CurrentPrice;
              echo "<input type='number' step = 'any' id = 'SuggestedPriceperGallon' name = 'SuggestedPriceperGallon' readonly value = '$this->SuggestedPrice'>";
              return $this->SuggestedPrice;
          }

          public function getTotalAmountDue () {
              $this->TotalAmountDue = $this->GallonsRequested * $this->SuggestedPrice;
              echo "<input type='number' step = 'any' id= 'TotalAmountDue' name= 'TotalAmountDue' readonly value = '$this->TotalAmountDue'>";
              return $this->TotalAmountDue;
          }
    }
