<?php


use PHPUnit\Framework\TestCase;

class PricingModuleTest extends TestCase
{

    public function testInStatePreviousHistoryLessThan1000 ()
    {
        $InStatePreviousHistoryLessThan1000 = new PricingModule ();

        //testing TX location factor
        $result = $InStatePreviousHistoryLessThan1000->getLocationFactor();
        $this->assertEquals(0.02, $result);

        //testing Previous History factor
        $result = $InStatePreviousHistoryLessThan1000->getRateHistoryFactor();
        $this->assertEquals(0.01, $result);

        //testing Less Than 1000 gallons request factor
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
        $row = mysqli_fetch_assoc($resultData);
        mysqli_stmt_close($stmt); //closes

        $result = $InStatePreviousHistoryLessThan1000->getGallonsRequestedFactor($row["GallonsRequested"]);
        $this->assertEquals(0.03, $result);

        //testing margin factor for above tests
        $result = $InStatePreviousHistoryLessThan1000->getMargin();
        $this->assertEquals(0.21, $result);

        //testing suggestedprice for above
        $result = $InStatePreviousHistoryLessThan1000->getSuggestedPrice();
        $this->assertEquals(1.71,$result);

        //testing totalamountdue for above
        $result = $InStatePreviousHistoryLessThan1000->getTotalAmountDue();
        $this->assertEquals(1.71,$result); //just 1 * 1.71
    }

    public function testOutStateNoHistoryGreaterThan1000 () {
        $OutStateNoHistoryGreaterThan1000 = new PricingModule ();

        $serverName = "localhost";
        $dBUsername = "root";
        $dBPassword = "";
        $dBName = "fuelquote";
        $conn = mysqli_connect ($serverName, $dBUsername, $dBPassword, $dBName);

        //change state information to non-texas
        $sql = "UPDATE clientinformation SET State = ? WHERE usersId = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql); //prepares statement
        $newstate = "NY";
        mysqli_stmt_bind_param($stmt, "si", $newstate, $_SESSION["userid"]); //binds statement
        mysqli_stmt_execute($stmt); //executes
        mysqli_stmt_close($stmt); //closes

        //change gallons to greater than 1000
        $sql1 = "UPDATE fuelquote SET GallonsRequested = ? WHERE usersId = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql1); //prepares statement
        $newgallons = 1050;
        mysqli_stmt_bind_param($stmt, "ii", $newgallons, $_SESSION["userid"]); //binds statement
        mysqli_stmt_execute($stmt); //executes
        mysqli_stmt_close($stmt); //closes

        //testing outside TX location factor
        $result = $OutStateNoHistoryGreaterThan1000->getLocationFactor();
        $this->assertEquals(0.04, $result);

        //testing Greater Than 1000 gallons request factor
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
        $row = mysqli_fetch_assoc($resultData);
        mysqli_stmt_close($stmt); //closes

        $result = $OutStateNoHistoryGreaterThan1000->getGallonsRequestedFactor($row["GallonsRequested"]);
        $this->assertEquals(0.02, $result);

        //change userid so there's no "history" for the current user
        $sql1 = "UPDATE fuelquote SET usersId = ? WHERE usersId = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql1); //prepares statement
        $newuserid = 2;
        mysqli_stmt_bind_param($stmt, "ii", $newuserid, $_SESSION["userid"]); //binds statement
        mysqli_stmt_execute($stmt); //executes
        mysqli_stmt_close($stmt); //closes

        //testing Previous History factor
        $result = $OutStateNoHistoryGreaterThan1000->getRateHistoryFactor();
        $this->assertEquals(0.00, $result);

        //testing margin factor for above tests
        $result = $OutStateNoHistoryGreaterThan1000->getMargin();
        $this->assertEquals(0.24, $result);

        //testing suggestedprice for above
        $result = $OutStateNoHistoryGreaterThan1000->getSuggestedPrice();
        $this->assertEquals(1.74,$result);

        //testing totalamountdue for above
        $result = $OutStateNoHistoryGreaterThan1000->getTotalAmountDue();
        $this->assertEquals(1827,$result); //just 1050 * 1.74

    }
}
