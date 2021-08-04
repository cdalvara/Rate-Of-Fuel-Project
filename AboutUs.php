<?php
  if(!isset($_SESSION))
  {
      session_start();
  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us</title>
    <link rel="stylesheet" href="style.css"> <!--links to css style sheet-->
  </head>

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

  <body>
    <div class = "maintext">
      Our team is a small one, started in June 2021, with the intent purpose of fullilling all your fuel quote needs.
      Our developers include Danny Phan, Dong Nguyen and Carlos Alvarado Ortuno. We hope that you find everything to your satisfication here today.
    </div>
  </body>

</html>
