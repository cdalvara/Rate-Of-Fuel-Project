<?php

function displayClientInformation () {
  $serverName = "localhost";
  $dBUsername = "root";
  $dBPassword = "";
  $dBName = "fuelquote";
  $conn = mysqli_connect ($serverName, $dBUsername, $dBPassword, $dBName);

  $sql = "SELECT * FROM clientinformation WHERE usersId = ?;";
  $stmt = mysqli_stmt_init($conn);

  mysqli_stmt_prepare($stmt, $sql); //prepares statement

  mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]); //binds statement
  mysqli_stmt_execute($stmt); //executes

  $resultData = mysqli_stmt_get_result($stmt); //checks result
  $row = mysqli_fetch_assoc($resultData);
  mysqli_stmt_close($stmt); //closes
  if ($row) { //if true, data exists in database, proceed to display
    echo "<div class='flex-container'>
            <div class='flex-child'>
                <label><b>Full Name: </b></label>
            </div>
            <div class='flex-child'>
                <div> " , $row["FullName"], "</div>
            </div>
          </div>

          <div class='flex-container'>
              <div class='flex-child'>
                  <label><b>Address 1: </b></label>
              </div>
              <div class='flex-child'>
                  <div>", $row["Address1"], "</div>
              </div>
          </div>

          <div class='flex-container'>
              <div class='flex-child'>
                  <label><b>Address 2: </b></label>
              </div>
              <div class='flex-child'>
                  <div>", $row["Address2"], "</div>
              </div>
          </div>

          <div class='flex-container'>
              <div class='flex-child'>
                  <label><b>City: </b></label>
              </div>
              <div class='flex-child'>
                  <div>", $row["City"], "</div>
              </div>
          </div>

          <div class='flex-container'>
              <div class='flex-child'>
                  <label><b>State: </b></label>
              </div>
              <div class='flex-child'>
                  <div>", $row["State"], "</div>
              </div>
          </div>

          <div class='flex-container'>
              <div class='flex-child'>
                  <label><b>Zip Code: </b></label>
              </div>
              <div class='flex-child'>
                  <div>", $row["ZipCode"], "</div>
              </div>
          </div>";
          return $row;
  }
  else { //if false, data doesn't exist in database, display empty
        echo "<div class='flex-container'>
                <div class='flex-child'>
                    <label><b>Full Name: </b></label>
                </div>
                <div class='flex-child'>
                    <div></div>
                </div>
              </div>

              <div class='flex-container'>
                  <div class='flex-child'>
                      <label><b>Address 1: </b></label>
                  </div>
                  <div class='flex-child'>
                      <div></div>
                  </div>
              </div>

              <div class='flex-container'>
                  <div class='flex-child'>
                      <label><b>Address 2: </b></label>
                  </div>
                  <div class='flex-child'>
                      <div></div>
                  </div>
              </div>

              <div class='flex-container'>
                  <div class='flex-child'>
                      <label><b>City: </b></label>
                  </div>
                  <div class='flex-child'>
                      <div></div>
                  </div>
              </div>

              <div class='flex-container'>
                  <div class='flex-child'>
                      <label><b>State: </b></label>
                  </div>
                  <div class='flex-child'>
                      <div></div>
                  </div>
              </div>

              <div class='flex-container'>
                  <div class='flex-child'>
                      <label><b>Zip Code: </b></label>
                  </div>
                  <div class='flex-child'>
                      <div></div>
                  </div>
              </div>";
              return $row;
  }
}
