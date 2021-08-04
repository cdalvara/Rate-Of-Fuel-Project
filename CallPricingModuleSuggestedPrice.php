<?php
  include_once "PricingModule.php";
  $_SESSION["getquote"] = new PricingModule ();
  $_SESSION["getquote"]->getLocationFactor();
  $_SESSION["getquote"]->getRateHistoryFactor();
  $_SESSION["getquote"]->getGallonsRequestedFactor($_POST["GallonsRequested"]);
  $_SESSION["getquote"]->getMargin();
  $_SESSION["getquote"]->getSuggestedPrice();
