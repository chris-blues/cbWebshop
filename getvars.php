<?php
if((!$_POST["reset_x"]))
  {
    $lang = ((isset($_POST["lang"])) && ($_POST["lang"] != "")) ? $_POST["lang"]:"";
    $name = ((isset($_POST["name"])) && ($_POST["name"] != "")) ? $_POST["name"]:"";
    $strasse = ((isset($_POST["strasse"])) && ($_POST["strasse"] != "")) ? $_POST["strasse"]:"";
    $stadt = ((isset($_POST["stadt"])) && ($_POST["stadt"] != "")) ? $_POST["stadt"]:"";
    $land = ((isset($_POST["land"])) && ($_POST["land"] != "")) ? $_POST["land"]:"";
    $province = ((isset($_POST["province"])) && ($_POST["province"] != "")) ? $_POST["province"]:"";
    $email = ((isset($_POST["email"])) && ($_POST["email"] != "")) ? $_POST["email"]:"";
    $newsletter = ((isset($_POST["newsletter"])) && ($_POST["newsletter"] != "")) ? $_POST["newsletter"]:"";
    $darkercolors = ((isset($_POST["darkercolors"])) && ($_POST["darkercolors"] != "")) ? $_POST["darkercolors"]:$darkercolors = "";
    $darkercolorsamount = ((isset($_POST["darkercolorsamount"])) && ($_POST["darkercolorsamount"] != "")) ? $_POST["darkercolorsamount"]:$darkercolorsamount = "";
    $livemix = ((isset($_POST["livemix"])) && ($_POST["livemix"] != "")) ? $_POST["livemix"]:$livemix = "";
    $livemixamount = ((isset($_POST["livemixamount"])) && ($_POST["livemixamount"] != "")) ? $_POST["livemixamount"]:$livemixamount = "";
    $roughmix = ((isset($_POST["roughmix"])) && ($_POST["roughmix"] != "")) ? $_POST["roughmix"]:$roughmix = "";
    $roughmixamount = ((isset($_POST["roughmixamount"])) && ($_POST["roughmixamount"] != "")) ? $_POST["roughmixamount"]:$roughmixamount = "";
    $ts_wtf = ((isset($_POST["ts_wtf"])) && ($_POST["ts_wtf"] != "")) ? $_POST["ts_wtf"]:$ts_wtf = "";
    $ts_wtfamount = ((isset($_POST["ts_wtfamount"])) && ($_POST["ts_wtfamount"] != "")) ? $_POST["ts_wtfamount"]:$ts_wtfamount = "";
    $payment = ((isset($_POST["payment"])) && ($_POST["payment"] !="")) ? $_POST["payment"]:$payment = "";
  }
?>
