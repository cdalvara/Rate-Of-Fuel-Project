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

    <h1 style="text-align: center;">Profile Display</h1>

    <div class="information">
        <form action="./getProfileInfo.php">
            <h3 style="font-size: x-large;">Personal Information</h3>
            <?php include_once "GetProfileDisplay.php";
                displayClientInformation();
             ?>
            <div class = "button">
              <a href="profileManage.php">
                <input type = "button" class = "btn" value= "Edit">
              </a>
            </div>
        </form>
    </div>
</body>
</html>
