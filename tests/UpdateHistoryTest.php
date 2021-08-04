<?php


use PHPUnit\Framework\TestCase;

class UpdateHistoryTest extends TestCase
{

    public function testUpdateHistory()
    {
        $UpdateHistoryTest = new UpdateHistory ();
        $result = $UpdateHistoryTest->UpdateHistory();

        if ($result ["usersId"] == 1 && $result ["GallonsRequested"] == 1 && $result ["DeliveryAddress"] == "12345 Random Address" && $result ["DeliveryDate"] == "2019-08-10" && $result ["SuggestedPriceperGallon"] == 4 && $result ["TotalAmountDue"] == 5) {
            $final = true;
        }
        else {
            $final = false;
        }

        $this->assertTrue($final);

    }
}
