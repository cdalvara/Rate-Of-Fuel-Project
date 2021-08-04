<?php
    if(!isset($_SESSION))
    {
        session_start();
    }
include_once "ValidateProfileManage.php";
include_once "ValidateFuelQuote.php";
include_once "UpdateHistory.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fuel Quote Form</title>
    <link rel="stylesheet" href="style.css"> <!--links to css style sheet-->
  </head>

  <body>

    <header>
      <div class = "topnav"> <!--top navigation bar-->
        <?php if(isset($_SESSION["useruid"])) {
                echo "<a href='profileDisplay.php'>Profile Management</a>";
                echo "<a href='AboutUs.php'><img src= 'icon.png'></a>";
                echo "<a href='fuelquote.php'>Fuel Quote</a>";
                echo "<a href='logout.php'>Logout</a>";
              }
              else {
                echo  "<a href='index.php'>Log in</a>";
              }
        ?>
      </div>
     </header>

    <div class="form"> <!--contains all form fields-->
      <form id="fuel-form" method = "post">
          <fieldset> <!--allows for the creation of a box around the form-->
            <h2>Fuel Quote Request Form</h2>
            <div class = "error">
            </div>
            <div>
              <label>Gallons Requested: </label>
              <input type="number" id = "GallonsRequest" name = "GallonsRequested" required>
            </div>
            <div>
              <label>Delivery Address: </label>
              <input type='text' id = 'DeliveryAddress' name = 'DeliveryAddress' readonly value = "<?php $test = new getDeliveryAddress();
                                                                                                         echo $test->getDeliveryAddress();
                                                                                                    ?>">
            </div>
            <div>
              <label>Delivery Date: </label>
              <input type="date" id="DeliveryDate" name = "DeliveryDate" min="<?php echo date("Y-m-d"); ?>">
            </div>
            <div>
              <label>Suggested Price / gallon: </label>
              <div class = "SuggestedPriceperGallon">
                <input type="number" id = "SuggestedPriceperGallon" name = "SuggestedPriceperGallon" readonly>
              </div>
            </div>
            <div>
              <label>Total Amount Due: </label>
              <div class = "TotalAmountDue">
                <input type="number" id= "TotalAmountDue" name= "TotalAmountDue" readonly>
              </div>
            </div>
            <div class = "button">
              <input type = "submit" class = "getquotebtn" value = "Get Quote" disabled = "disabled">
              <input type = "submit" class = "submitbtn" value = "Submit" disabled = "disabled">
            </div>
          </fieldset>
      </form>
    </div>

    <div class="table">
      <table id="fuel-history">
        <thead>
          <caption><h2>Fuel Quote History</h2></caption>
          <tr>
            <!--headers-->
            <th>Gallons Requested</th>
            <th>Delivery Address</th>
            <th>Delivery Date</th>
            <th>Suggested Price / gallon</th>
            <th>Total Amount Due</th>
          </tr>
          <?php $test1 = new UpdateHistory();
                $test1->UpdateHistory();
           ?>
        </thead>
      </table>
    </div>

     <script src = "jquery.js"></script>
     <script>
       $(".getquotebtn").click(function(e) {
         e.preventDefault();

         $.ajax({
           type: "post",
           url: "CallValidateGetQuote.php",
           data: $("#fuel-form").serialize(),
           success: function(data) {

             if (data == true) {
                 getSuggestedPrice();
             }

             else {
                 $(".error").empty(); //clears out error message above
                 $(".error").append(data);
             }
           }
         });
       });

      $(".submitbtn").click(function(e) {
        e.preventDefault();

        $.ajax({
          type: "post",
          url: "CallValidateFuelQuote.php",
          data: $("#fuel-form").serialize(),
          success: function(data) {

            if (data == true) {
                $("#fuel-form").submit();
            }

            else {
                $(".error").empty(); //clears out error message above
                $(".error").append(data);
            }
          }
        });
      });

      function getSuggestedPrice () {
        $.ajax({
          type: "post",
          url: "CallPricingModuleSuggestedPrice.php",
          data: $("#fuel-form").serialize(),
          success: function(data) {
              $(".error").empty();
              $(".SuggestedPriceperGallon").empty(); //clears out error message above
              $(".SuggestedPriceperGallon").append(data); //clears out error message above
              getTotalAmountDue();
          }
        });
      }

      function getTotalAmountDue () {
        $.ajax({
          type: "post",
          url: "CallPricingModuleTotalAmountDue.php",
          data: $("#fuel-form").serialize(),
          success: function(data) {
              $(".TotalAmountDue").empty(); //clears out error message above
              $(".TotalAmountDue").append(data); //clears out error message above
          }
        });
      }

      $("#GallonsRequest").keyup(function() {
          if (keystroke() == false) {
              $(".getquotebtn").removeAttr('disabled');
          }
          else {
              $(".getquotebtn").attr("disabled", "disabled");
          }
      });

      $("#DeliveryDate").on("keyup change", function() {
          if (keystroke() == false) {
              $(".getquotebtn").removeAttr('disabled');
              $(".submitbtn").removeAttr('disabled');
          }
          else {
              $(".submitbtn").attr("disabled", "disabled");
          }
        });

      function keystroke () {
          var empty = true;
          var GallonsEntered = false;
          var DeliveryAddressEntered = false;
          var DeliveryDateEntered = false;

          if ($("#GallonsRequest").val()) {
              GallonsEntered = true;
          }
          if ($("#DeliveryAddress").val()) {
              DeliveryAddressEntered = true;
          }
          if ($("#DeliveryDate").val()) {
              DeliveryDateEntered = true;
          }

          if (GallonsEntered && DeliveryAddressEntered && DeliveryDateEntered) {
              return empty = false;
          }
          else {
              return empty = true;
          }
      }

     </script>

  </body>

</html>
