<?php
unset($item_exists);
unset($item_pointer);

//echo "DEBUG: read_kartfile.php<br>\nfile: $dir / $kartfile<br>\n";
$kartfile = "shop/tmp/kart-$kartid.tmp";
if ($kartmode == "kart")
{
/* Lese karttmpfile falls vorhanden und Erzeuge Array Kart[1][item_sth] */
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
if ($karthandle != NULL)
 {
  $buffer = fgets($karthandle); $kartlang = trim($buffer,"\n");
  $buffer = fgets($karthandle); $countryname = trim($buffer,"\n"); if ($countryname == "") $countryname = $_GET["countryname"]; if ($_GET["countryname"] == "remove") $countryname = "remove";
  $buffer = fgets($karthandle); $opt = trim($buffer,"\n"); if ($opt == "") $opt = $_GET["opt"]; if ($_GET["opt"] == "remove") $opt = "remove";
  $buffer = fgets($karthandle); $firstname = trim($buffer,"\n"); if ($firstname == "") $firstname = $_GET["firstname"];
  $buffer = fgets($karthandle); $lastname = trim($buffer,"\n"); if ($lastname == "") $lastname = $_GET["lastname"];
  $buffer = fgets($karthandle); $adress1 = trim($buffer,"\n"); if ($adress1 == "") $adress1 = $_GET["adress1"];
  $buffer = fgets($karthandle); $adress2 = trim($buffer,"\n"); if ($adress2 == "") $adress2 = $_GET["adress2"];
  $buffer = fgets($karthandle); $plz = trim($buffer,"\n"); if ($plz == "") $plz = $_GET["plz"];
  $buffer = fgets($karthandle); $city = trim($buffer,"\n"); if ($city == "") $city = $_GET["city"];
  $buffer = fgets($karthandle); $province = trim($buffer,"\n"); if ($province == "") $province = $_GET["province"];
  $buffer = fgets($karthandle); $email = trim($buffer,"\n"); if ($email == "") $email = $_GET["email"];
  $buffer = fgets($karthandle); $newsletter = trim($buffer,"\n"); if ($newsletter == "") $newsletter = $_GET["newsletter"];
  while (!feof($karthandle))
   {
    $kartamount++;
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_id'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_type'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_size'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_preis'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_amount'] = trim($buffer,"\n");
    if ($kart["$kartamount"]['item_id'] == $id)
        {
         if (strcmp($kart["$kartamount"]['item_size'],$size) == "0" or $kart["$kartamount"]['item_size'] == "")
           { $item_exists = "ja"; $item_pointer = $kartamount; }
        }
    /*  if ($kart["$kartamount"]['item_size'] == "XXL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 2;
      if ($kart["$kartamount"]['item_size'] == "XL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 1;
      if ($kart["$kartamount"]['item_size'] == "M") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 1;
      if ($kart["$kartamount"]['item_size'] == "S") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 2; */
    /* echo "{$kart["$kartamount"]['item_id']} {$kart["$kartamount"]['item_amount']}x $item_exists $item_pointer<br>"; */
   }
 }
//else echo "Could not open $kartfile<br>kartmode=$kartmode<br>\n";
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--;
if ($kartamount < 1) $kartamount = "0";
}

/* ################################################# */

if ($kartmode == "order")
{
/* Lese karttmpfile und Erzeuge Array Kart[1][item_sth]   ORDER */
//$kartfile = "shop/tmp/kart-$kartid.tmp";
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
if ($karthandle != NULL)
 {
  $buffer = fgets($karthandle); $kartlang = trim($buffer,"\n");
  $buffer = fgets($karthandle); $countryname = trim($buffer,"\n");
  $buffer = fgets($karthandle); $opt = trim($buffer,"\n");
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["firstname"])) $firstname = " style=\"background-color:#FF4B4B;\""; else { $firstname = trim($buffer,"\n"); $firstname = " value=\"$firstname\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["lastname"])) $lastname = " style=\"background-color:#FF4B4B;\""; else { $lastname = trim($buffer,"\n"); $lastname = " value=\"$lastname\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["adress1"])) $adress1 = " style=\"background-color:#FF4B4B;\""; else { $adress1 = trim($buffer,"\n"); $adress1 = " value=\"$adress1\""; }
  $buffer = fgets($karthandle); $adress2 = trim($buffer,"\n"); $adress2 = " value=\"$adress2\"";
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["plz"])) $plz = " style=\"background-color:#FF4B4B;\""; else { $plz = trim($buffer,"\n"); $plz = " value=\"$plz\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["city"])) $city = " style=\"background-color:#FF4B4B;\""; else { $city = trim($buffer,"\n"); $city = " value=\"$city\""; }
  $buffer = fgets($karthandle); $province = trim($buffer,"\n"); $province = " value=\"$province\"";
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["email"])) $email = " style=\"background-color:#FF4B4B;\""; else { $email = trim($buffer,"\n"); $email = " value=\"$email\""; }
  $buffer = fgets($karthandle); $newsletter = trim($buffer,"\n");
  while (!feof($karthandle))
   {
    $kartamount++;
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_id'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_type'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_size'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_preis'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_amount'] = trim($buffer,"\n");
    /*  if ($kart["$kartamount"]['item_size'] == "XXL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 2;
      if ($kart["$kartamount"]['item_size'] == "XL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 1;
      if ($kart["$kartamount"]['item_size'] == "M") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 1;
      if ($kart["$kartamount"]['item_size'] == "S") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 2; */
   }
 }
else echo "Could not open $kartfile<br>kartmode=$kartmode<br>\n";
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--;
if ($kartamount < 1) $kartamount = "0";
}

/* ################################################################### */

if ($kartmode == "action")
{
/* Lese karttmpfile und Erzeuge Array Kart[1][item_sth]   ORDERACTION */
$kartfile = "{$kartfilepath}/kart-$kartid.tmp";
$kartfileerror = "0";
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
$errorreturn = "&amp;errorreturn=1";
if ($karthandle != NULL)
 { /* Lese Adressdaten */
  $buffer = fgets($karthandle); $kartlang = trim($buffer,"\n");
  $buffer = fgets($karthandle); $countryname = trim($buffer,"\n"); if ($countryname == "") { $error = "1"; $errors['kartfile']['country'] = "empty"; }
  $buffer = fgets($karthandle); $opt = trim($buffer,"\n"); if ($opt == "") { $error = "1"; $errors['kartfile']['opt'] = "empty"; }
  $buffer = fgets($karthandle); $firstname = trim($buffer,"\n"); if ($firstname == "") { $error = "1"; $errors['kartfile']['firstname'] = "empty"; $errorreturn .= "&amp;firstname=$firstname"; }
  $buffer = fgets($karthandle); $lastname = trim($buffer,"\n"); if ($lastname == "") { $error = "1"; $errors['kartfile']['lastname'] = "empty"; $errorreturn .= "&amp;lastname=$lastname"; }
  $buffer = fgets($karthandle); $adress1 = trim($buffer,"\n"); if ($adress1 == "") { $error = "1"; $errors['kartfile']['adress1'] = "empty"; $errorreturn .= "&amp;adress1=$adress1"; }
  $buffer = fgets($karthandle); $adress2 = trim($buffer,"\n"); if ($adress2 == "") { $errors['kartfile']['adress2'] = "empty"; $errorreturn .= "&amp;adress2=$adress2"; }
  $buffer = fgets($karthandle); $plz = trim($buffer,"\n"); if ($plz == "") { $error = "1"; $errors['kartfile']['plz'] = "empty"; $errorreturn .= "&amp;plz=$plz"; }
  $buffer = fgets($karthandle); $city = trim($buffer,"\n"); if ($city == "") { $error = "1"; $errors['kartfile']['city'] = "empty"; $errorreturn .= "&amp;city=$city"; }
  $buffer = fgets($karthandle); $province = trim($buffer,"\n"); if ($province == "") { $errors['kartfile']['province'] = "empty"; $errorreturn .= "&amp;province=$province"; }
  $buffer = fgets($karthandle); $email = trim($buffer,"\n"); if ($email == "") { $error = "1"; $errors['kartfile']['email'] = "empty"; $errorreturn .= "&amp;email=$email"; }
  $buffer = fgets($karthandle); $newsletter = trim($buffer,"\n"); if ($newsletter == "") { $errors['kartfile']['newsletter'] = "empty"; $errorreturn .= "&amp;newsletter=$newsletter"; }
  while (!feof($karthandle))   /* Lese gesamtes Kartfile und erzeuge $kart-array */
   {
    $kartamount++;
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_id'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_type'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_size'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_preis'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_amount'] = trim($buffer,"\n");
    /*  if ($kart["$kartamount"]['item_size'] == "XXL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 2;
      if ($kart["$kartamount"]['item_size'] == "XL") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] + 1;
      if ($kart["$kartamount"]['item_size'] == "M") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 1;
      if ($kart["$kartamount"]['item_size'] == "S") $kart["$kartamount"]['item_preis'] = $kart["$kartamount"]['item_preis'] - 2; */
    $kart["$kartamount"]['item_total'] = $kart["$kartamount"]['item_amount'] * $kart["$kartamount"]['item_preis'];
   }
 }
else { $error = "1"; $kartfileerror = "1"; $errors['kartfile']['file'] = "Unable to read kartfile."; }
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--; 
if ($kartamount < 1) {$kartamount = "0"; $error = "1"; $kartemptyerror = "1";}
}

/* ################################################################### */
//echo "read_kartfile.php:<br>\nkartfile: $kartfile<br>\nlastname: $lastname<br>\ncountryname: $countryname<br>\nerror: $error<br>\nkartemptyerror: $kartemptyerror<br>\nerrorreturn: $errorreturn<br>\nkartamount: $kartamount<br>\n";
//echo "<pre>"; print_r($kart); echo "</pre>\n";
//echo "<pre style=\"font-size: 0.85em;\">"; print_r($errors); echo "</pre>\n";
?>
