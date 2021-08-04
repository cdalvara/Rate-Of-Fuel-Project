<?php
  if(!isset($_SESSION))
  {
      session_start();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel = "stylesheet" href="./profile.css">

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
    <h1 style="text-align: center;">Profile Management</h1>

    <div class="information">
        <form action = "profileDisplay.php" id="ProfileManage" method="post">
            <div class = "error"></div>
            <h3 style="font-size: x-large;">Edit Personal Information</h3>
            <div class="flex-container">
                <div class="flex-child">
                    <label><b>Full Name: </b></label>
                </div>
                <div class="flex-child">
                    <input type = "text" name = "fullName" maxlength="50" required>
                </div>
            </div>

            <div class="flex-container">
                <div class="flex-child">
                    <label><b>Address 1: </b></label>
                </div>
                <div class="flex-child">
                    <input type = "text" name = "firstAddress" maxlength="100" required>
                </div>
            </div>

            <div class="flex-container">
                <div class="flex-child">
                    <label><b>Address 2: </b></label>
                </div>
                <div class="flex-child">
                    <input type="text" name = "secondAddress" maxlength="100">
                </div>
            </div>

            <div class="flex-container">
                <div class="flex-child">
                    <label for="city"><b>City: </b></label>
                </div>
                <div class="flex-child">
                    <input type="text"name = "city" maxlength="100" required>
                </div>
            </div>

            <div class="flex-container">
                <div class="flex-child">
                    <label for="state"><b>State: </b></label>
                </div>
                <div class="flex-child">
                    <select name = "State" id = "State" required>
                        <option value=""></option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                    </select>

                </div>
            </div>

            <div class="flex-container">
                <div class="flex-child">
                    <label for="zipCode"><b>Zip Code: </b></label>
                </div>
                <div class="flex-child">
                    <input name = "ZipCode" type="text" minlength="5" maxlength="9" required>

                </div>
            </div>
              <div class = "button">
                  <input type = "submit" class = "btn" value= "Submit">
              </div>
            </a>
        </form>
    </div>

    <script src = "jquery.js"></script>
    <script>
        $(".btn").click(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "CallValidateProfileManage.php",
                data: $("#ProfileManage").serialize(),
                success: function(data) {

                    if (data == true) {
                        $("#ProfileManage").submit();
                    }

                    else {
                       $(".error").empty(); //clears out error message above
                       $(".error").append(data);
                    }
                }
            });
        });
    </script>

</body>
</html>
