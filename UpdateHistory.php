<?php
class UpdateHistory {
  function UpdateHistory () {
      $serverName = "localhost";
      $dBUsername = "root";
      $dBPassword = "";
      $dBName = "fuelquote";
      $conn = mysqli_connect ($serverName, $dBUsername, $dBPassword, $dBName);

      $sql = "SELECT * FROM fuelquote WHERE usersId = ?;";
      $stmt = mysqli_stmt_init($conn);

      mysqli_stmt_prepare($stmt, $sql); //prepares statement
      mysqli_stmt_bind_param($stmt, "i", $_SESSION["userid"]); //binds statement
      mysqli_stmt_execute($stmt); //executes

      $resultData = mysqli_stmt_get_result($stmt); //checks result
      while($row = mysqli_fetch_assoc($resultData)) {
        $result = $row;
        echo  "<tr>
              <td>", $row['GallonsRequested'], "</td>
              <td>", $row['DeliveryAddress'], "</td>
              <td>", $row['DeliveryDate'], "</td>
              <td>", $row['SuggestedPriceperGallon'], "</td>
              <td>", $row['TotalAmountDue'], "</td>
            </tr>";
      }
      mysqli_stmt_close($stmt); //closes
      //return $result;
  }
}
