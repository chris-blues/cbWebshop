<?php
/* ################################################################### */
/* Hole Variablen aus POST-Formular */
$error = "0"; $posterror = "0";
if (!$_POST["reset_x"])
  {
    if ((isset($_POST["lang"])) && ($_POST["lang"] != "")) $lang = $_POST["lang"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "lang";}
    if ((isset($_POST["kartid"])) && ($_POST["kartid"] != "")) $kartid = $_POST["kartid"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "kartid";}
   }

/* ################################################################### */
/* Lese karttmpfile und Erzeuge Array Kart[1][item_sth] */
$kartfileerror = "0";
$kartfile = "tmp/kart-$kartid.tmp";
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
$errorreturn = "&amp;errorreturn=1";
if ($karthandle != NULL)
 {
  $buffer = fgets($karthandle); $country = trim($buffer,"\n"); if ($country == "") { $error = "1"; $errors['kartfile']['country'] = "empty"; }
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
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_preis'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_amount'] = trim($buffer,"\n");
    $kart["$kartamount"]['item_total'] = $kart["$kartamount"]['item_amount'] * $kart["$kartamount"]['item_preis'];
   }
 }
else { $error = "1"; $kartfileerror = "1"; }
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--; if ($kartamount < 1) {$kartamount = "0"; $error = "1"; $kartemptyerror = "1";}
/* ################################################################### */

/* Stelle Variablen zusammen */
$date = date("d.m.Y");
if ($opt == "1") 
  {
   $transfercost = "0.00";
   if ($lang == "english") { $payment = "Bank Transfer"; }
   else { $payment = "&Uuml;berweisung"; }
  }
if ($opt == "2") 
  { 
   $payment = "PayPal"; 
   if ($country == "Germany") { $transfercost = "0.68"; } 
   else { $transfercost = "1.13"; }
  }
if ($opt == "3") 
  {
   $transfercost = "5.65";
   if ($lang == "english") { $payment = "Pay On Delivery"; } 
   else { $payment = "Nachnahme"; }
  }
if ($country == "Germany") $shippingcost = "1.45";
else $shippingcost = "3.45";
$costs = $transfercost + $shippingcost;
if ($lang == "english")
     {
      $shipping = "Shipping";
      $total = "Total";
     }
else {
      $shipping = "Versand";
      $total = "Gesamt";
     }

/* ################################################################### */
?>


<?php
$current_page = "shop";
include('../header.html');

echo "<body bgcolor=\"#171410\""; 
if ($newsletter == "ja") echo " onload=\"document.jnl2_sign_form.submit();\""; 
echo ">\n";

include('../banner.php'); ?>
<!-- MENÜ -->
<table width="800" align="center" cellpadding="0" cellspacing="0" bgcolor="#544a31">
  <tr align="center" valign="bottom"> 
    <?php include ("http://musicchris.de/baustelle/menu.php?current_page=$current_page"); ?>
  </tr>
</table>
<table cellpadding="0" cellspacing="0" width="800" height="20" align="center" bgcolor="#544a31">
  <tr>
    <td width="800" height="20" align="center">
      <img src=
      <?php
        if ($current_page == "shop") echo "\"../pics/schatten.png\"";
        else echo "\"pics/schatten.png\"";
      ?> width="800" height="19" border="0">
      <font color="FF0000" align="center"><b>!!!BAUSTELLE!!!<br>Nur zu Testzwecken! Diese Seite k&ouml;nnte sich nicht so verhalten wie Sie es erwarten!<br>!!!BAUSTELLE!!!</b></font>
    </td>
  </tr>
</table>

<table border="0" width="800" height="600" align="center" cellpadding="5" cellspacing="0" bgcolor="#544a31">
  <tr align="center">
    <td width="750" align="center" valign="center">
      <br>
      <font face="Georgia" size="3"><em>
        <center>


<?php
/* Prepare strings for receits in mail and browser output and put it out! */

/* mail format */
$email_shop = "Folkadelic Shop <shop@folkadelic.de>";
$email_buyer = "$firstname $lastname <$email>";
$betreff_shop = "Bestellung @ folkadelic.de - ID:$kartid";
$kontoinfo = "Brian Brademann\nKto.Nr.: 915 660 540\nBLZ: 200 411 33\nIBAN: DE83200411330915660540\nBIC/Swift-Code: COBADEHD001\n\nPayPal-ID: LL5N934Z5GMT8\n";
$sum_items = $costs;
$mail_items = "";
for ($c = "1"; $c <= $kartamount; $c++)
  {
   $sum_items = $sum_items + $kart["$c"]['item_total'];
   $mail_items .= "{$kart["$c"]['item_type']} - {$kart["$c"]['item_name']} ({$kart["$c"]['item_amount']} x {$kart["$c"]['item_preis']} €) : {$kart["$c"]['item_total']} €\n";
  }
if ($lang == "english") 
  { $betreff_buyer = "Your order @ folkadelic.de - ID:$kartid";
    $mail_items .= "--------------------------------\nTransfercost($payment): $transfercost €\nShipping cost: $shippingcost €\n--------------------------------\nTotal: $sum_items €\n\n";
    $mail_opener_buyer = "For your information and as an invoice to your order at http://folkadelic.de\n\n$date\n\n";
    $mail_opener_buyer .= "Hello $firstname $lastname!\n\nThank you for your order and your interest in our work!\nHere is what you ordered:\n\n"; 
    $mail_opener_buyer .= "Kart-ID: $kartid\n\n";
    $mail_end_buyer = "Please transfer the amount to our account as soon as possible, so we can send you the shipment as soon as your money has arrived!\n\n";
    if ($newsletter == "ja") { $mail_end_buyer .= "You have submitted to our newsletter. You will receive a confirmation-mail soon.\n\n"; }
    $mail_end_buyer .= "We hope you enjoy our work and wish you all the best!\nFolkadelic Hobo Jamboree\nhttp://folkadelic.de\n\n\n\n";
  }
else 
  { $betreff_buyer = "Ihre Bestellung @ folkadelic.de - ID:$kartid";
    $mail_items .= "--------------------------------\nBankgebühren($payment): $transfercost €\nVersandkosten: $shippingcost €\n--------------------------------\nGesamt: $sum_items €\n\n";
    $mail_opener_buyer = "Zu Ihrer Information und als Rechnung für Ihre Bestellung bei http://folkadelic.de\n\n$date\n\n";
    $mail_opener_buyer .= "Hallo $firstname $lastname!\n\nVielen Dank für Ihre Bestellung und Ihr Interesse an unserer Arbeit!\nDas haben Sie bestellt:\n\n";
    $mail_opener_buyer .= "Kart-ID: $kartid\n\n";
    $mail_end_buyer = "Bitte überweisen Sie den Betrag schnellstmöglich auf unser Konto, damit wir die Sendung losschicken können sobald das Geld da ist!\n\n";
    if ($newsletter == "ja") { $mail_end_buyer .= "Sie haben sich für unseren Newsletter eingetragen. Sie werden in Kürze eine Bestätigungs-Mail erhalten.\n\n"; }
    $mail_end_buyer .= "Wir hoffen, daß Ihnen unsere Arbeit Spaß macht und wünschen alles Gute!\nFolkadelic Hobo Jamboree\nhttp://folkadelic.de\n\n\n\n";
  }
$mail_end_buyer .= $kontoinfo;
$mail_opener_shop = "$date\nKart-ID: $kartid\n\n$email_buyer (spricht $lang)\n$adress1\n$adress2\n$plz - $city\n$province\n$country\nbestellt:\n\n";
$mail_end_shop = "Newsletter: $newsletter\n\n";
$header = "Content-Type: text/plain; charset = \"UTF-8\";\r\n";
$header .= "Content-Transfer-Encoding: 8bit\r\n";
$header .= "\r\n";

$mail_buyer = $mail_opener_buyer . $mail_items . $mail_end_buyer;
$mail_buyer = wordwrap($mail_buyer, 70);
$header_buyer = "From: $email_shop\r\n";
$header_buyer .= $header;
/* if (!mail($email_buyer, $betreff_buyer, $mail_buyer, $header_buyer)) echo "<h3>ERROR!</h3>Failed to send mail to buyer!<br>\n"; */

$mail_shop = $mail_opener_shop . $mail_items . $mail_end_shop;
$mail_shop = wordwrap($mail_shop, 70);
$header_shop = "From: $email_buyer\r\n";
$header_shop .= $header;
/* if (!mail($email_shop, $betreff_shop, $mail_shop, $header_shop)) echo "<h3>ERROR!</h3>Failed to send mail to shop!<br>\n"; */

/* ################################################################### */
/* html format */
if ($lang == "english") $pieces = "pieces"; else $pieces = "St&uuml;ck";
echo "<table width=\"500\" align=\"center\" valign=\"center\" border=\"0\">\n<tr>\n<td align=\"center\" colspan=\"3\">\n";
if ($lang == "english") echo "<h3>Thank you for your order!</h3>\n";
                   else echo "<h3>Vielen Dank f&uuml;r Ihre Bestellung!</h3>\n";
echo "<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n";
echo "</td>\n</tr>\n";
for ($c = "1"; $c <= $kartamount; $c++)
  {
   $str_itemtotal = number_format($kart["$c"]['item_total'], 2, '.', ' ');
   echo "<tr><td align=\"right\" colspan=\"1\">{$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> </td>";
   echo "<td align=\"right\" colspan=\"1\"> ({$kart["$c"]['item_preis']} &euro; x {$kart["$c"]['item_amount']} $pieces) </td>";
   echo "<td align=\"right\" colspan=\"1\"><b>$str_itemtotal &euro;</b></td></tr>\n";
  }
$str_transfercost = number_format($transfercost, 2, '.', ' ');
$str_shippingcost = number_format($shippingcost, 2, '.', ' ');
$str_sum_items = number_format($sum_items, 2, '.', ' ');

echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$payment</b> ($country)</td><td align=\"right\" colspan=\"1\"><b>$str_transfercost &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$shipping</b> ($country)</td><td align=\"right\" colspan=\"1\"><b>$str_shippingcost &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$total</b></td><td align=\"right\" colspan=\"1\"><b>$str_sum_items &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n";
if ($opt == "1")
  {
   if ($lang == "english")
     {
      echo "Please send <u>$str_sum_items &euro;</u> to the following bank account:<br>\n<br>\n";
      echo "Brian Brademann<br>\nKto.Nr.: 915 660 540<br>\nBLZ: 200 411 33<br>\n<br>\nIBAN: DE83200411330915660540<br>\nBIC/Swift-Code: COBADEHD001<br>\n<br>\n";
      echo "As soon as your money arrives we'll send your shipment.<br>\n";
     }
   else
     {
      echo "Bitte &uuml;berweisen Sie <u>$str_sum_items &euro;</u> auf das folgende Bankkonto:<br>\n<br>\n";
      echo "Brian Brademann<br>\nKto.Nr.: 915 660 540<br>\nBLZ: 200 411 33<br>\n<br>\nIBAN: DE83200411330915660540<br>\nBIC/Swift-Code: COBADEHD001<br>\n<br>\n";
      echo "Sobald uns ihre Zahlung erreicht hat werden wir Ihre Bestellung verschicken.<br>\n";
     }
  }
if ($opt == "3")
  {
   if ($lang == "english")
     {
      echo "Your order will be sent soon! Please keep enough cash under your pillow to pay for the package, when it arrives!<br>\n";
     }
   else
     {
      echo "Ihre Bestellung wird demn&auml;chst versandt. Bitte behalten Sie genug Bargeld unter Ihrem Kopfkissen, um das Paket bezahlen zu k&ouml;nnen wenn es eintrifft!<br>\n";
     }
  }
echo "</td>\n</tr>\n</table>\n";
/* ################################################################### */

/* Newsletter entry */
echo "<form name=\"jnl2_sign_form\" method=\"post\" action=\"../../newsletter/validate.php?do=sign_in&language=german&ml_id=00\" target=\"nlbox\">\n";
echo "<input type=\"hidden\" name=\"email\" value=\"$email\">\n";
echo "<input type=\"hidden\" name=\"nick\" value=\"$firstname $lastname\">\n";
echo "<input type=\"hidden\" name=\"mail_format\" value=\"h\">\n";
echo "<input type=\"hidden\" name=\"grp_00\" value=\"1\" checked>\n</form>";


if (!unlink($kartfile)) echo "ERROR! Could not delete $kartfile.<br>\n";
?>
        <iframe name="nlbox" width="500" height="150" scrolling="auto" frameborder="0" src="bg.php" />
        </center>
        </em></font>
    </td>
  </tr>
</table>
<?php include('../fuss.php'); ?>
