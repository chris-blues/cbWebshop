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

$kartmode = "action";
include('read_kartfile.php');

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
if ($country == "Germany") $country_code = "DE";
if ($country == "Great Britain") $country_code = "GB";
if ($country == "Poland") $country_code = "PL";
if ($country == "USA") $country_code = "US";

/* ################################################################### */

include('header_short.html');
$onload = "document.checkout_form.submit();";
if ($newsletter == "ja") $onload .= "document.jnl2_sign_form.submit();";
echo "<body bgcolor=\"#544a31\" onload=\"$onload\">\n";  ?>
<em><font face="Georgia" size="3">
<table width="500" height="600" align="center" border="0" bgcolor="#544a31">
  <tr>
    <td align="center" valign="center">
<?php

/* ################################################################### */

/* Check for missing data and exit if so - else redirect to checkout-site (PayPal / leaveshop.php) */
if ($error != "0")
  {
   echo "<table border=\"0\" bgcolor=\"#544a31\"><tr><td align=\"center\"><font color=\"F61818\"><h4><u><b>ERROR!</b></u></h4></font></td></tr><tr><td align=\"left\">\n<ol>\n";
   if ($kartemptyerror == "1") 
     {if ($lang == "english") $errormessage .= "<li>Kart seems to be emtpy!</li><br>\n";
                         else $errormessage .= "<li>Warenkorb scheint leer zu sein!</li><br>\n";
     }
   if ($errors['kartfile']['country'] == "empty" and $kartemptyerror != "1")
     {if($lang == "english") $errormessage .= "<li>You didn't choose your country in the kart! Please do so!</li><br>\n";
                        else $errormessage .= "<li>Sie haben im Warenkorb ihr Land nicht angegeben! Tun Sie das bitte!</li><br>\n";}
   if ($errors['kartfile']['opt'] == "empty" and $kartemptyerror != "1")
     {if($lang == "english") $errormessage .= "<li>You didn't choose your preferred payment method in the kart! Please do so!</li><br>\n";
                        else $errormessage .= "<li>Sie haben im Warenkorb ihre bevorzugte Zahlungsmethode nicht angegeben! Tun Sie das bitte!</li><br>\n";
     }
   if ($kartemptyerror != "1")
     { if ($errors['kartfile']['firstname'] == "empty" or $errors['kartfile']['lastname'] == "empty" or $errors['kartfile']['adress1'] == "empty" or $errors['kartfile']['plz'] == "empty" or $errors['kartfile']['city'] == "empty" or $errors['kartfile']['email'] == "empty")
     {if($lang == "english") $errormessage .= "<li>You didn't enter all necessary information! Use the button below to return!</li><br>\n";
                        else $errormessage .= "<li>Sie haben nicht alle n&ouml;tigen Informationen angegeben! Nutzen Sie den Knopf unten um zur&uuml;ck zu gelangen!</li><br>\n";
     }}
   echo $errormessage;
   echo "</ol><br>\n";
   if ($lang == "english") $backtoshop = "BACK TO ORDER-FORM!";
                      else $backtoshop = "ZUR&Uuml;CK ZUM BESTELL-FORMULAR!";
   echo "</td></tr><tr><td align=\"center\">\n<a href=\"order.php?kartid=$kartid&amp;lang=$lang$errorreturn\" target=\"shop\"><b>$backtoshop</b></a><br>\n</td></tr></table></td></tr></table></body></html>";
   exit;
  }
  
/* NO ERRORS => Go on! */
  
else
  {
/* Prepare strings for receits in mail output and send it! */
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
$mail_opener_shop = "$date\nKart-ID: $kartid\n\n$email_buyer (spricht $lang)\n$adress1\n";
if ($adress2 != "") $mail_opener_shop .= "$adress2\n";
$mail_opener_shop .= "$plz - $city\n";
if ($province != "") $mail_opener_shop .= "$province\n";
$mail_opener_shop .= "$country\n\nbestellt:\n\n";
$mail_end_shop = "Newsletter: $newsletter\n\n";
$header = "Content-Type: text/plain; charset = \"UTF-8\";\r\n";
$header .= "Content-Transfer-Encoding: 8bit\r\n";
$header .= "\r\n";

$mail_buyer = $mail_opener_buyer . $mail_items . $mail_end_buyer;
$mail_buyer = wordwrap($mail_buyer, 70);
$header_buyer = "From: $email_shop\r\n";
$header_buyer .= $header;
if (!mail($email_buyer, $betreff_buyer, $mail_buyer, $header_buyer)) echo "<h3>ERROR!</h3>Failed to send mail to buyer!<br>\n";

$mail_shop = $mail_opener_shop . $mail_items . $mail_end_shop;
$mail_shop = wordwrap($mail_shop, 70);
$header_shop = "From: $email_buyer\r\n";
$header_shop .= $header;
if (!mail($email_shop, $betreff_shop, $mail_shop, $header_shop)) echo "<h3>ERROR!</h3>Failed to send mail to shop!<br>\n";

/* ########################################## */

   if ($lang == "english") echo "<b>One moment!</b><br>\n"; else echo "<b>Einen Moment!</b><br>\n";
   if ($opt == "2")
     {
      if ($lang == "english") {$lc = "EN"; echo "Redirecting you to PayPal.\n";} else {$lc = "DE"; echo "Sie werden zu PayPal weitergeleitet.\n";}
      echo "<form id=\"checkout_form\" name=\"checkout_form\" method=\"post\" action=\"https://www.paypal.com/cgi-bin/webscr\" accept-charset=\"UTF-8\" target=\"_blank\">\n";
        echo "<input id=\"cmd\" name=\"cmd\" type=\"hidden\" value=\"_cart\" />\n";
        echo "<input id=\"upload\" name=\"upload\" type=\"hidden\" value=\"1\" />\n";
        echo "<input id=\"charset\" name=\"charset\" type=\"hidden\" value=\"utf-8\" />\n";
        echo "<input id=\"no_shipping\" name=\"no_shipping\" type=\"hidden\" value=\"2\" />\n";
        echo "<input id=\"no_note\" name=\"no_note\" type=\"hidden\" value=\"0\" />\n";
        echo "<input id=\"rm\" name=\"rm\" type=\"hidden\" value=\"2\" />\n";
        echo "<input id=\"business\" name=\"business\" type=\"hidden\" value=\"kassenwart@folkadelic.de\" />\n";
        echo "<input id=\"cbt\" name=\"cbt\" type=\"hidden\" value=\"Return to The Folkadelic Shop\" />\n";
        echo "<input id=\"currency_code\" name=\"currency_code\" type=\"hidden\" value=\"EUR\" />\n";
        echo "<input id=\"lc\" name=\"lc\" type=\"hidden\" value=\"$lc\" />\n";
        echo "<input id=\"invoice\" name=\"invoice\" type=\"hidden\" value=\"$kartid\" />\n";
        echo "<input id=\"shopping_url\" name=\"shopping_url\" type=\"hidden\" value=\"http://folkadelic.de\" />\n";
        echo "<input id=\"return\" name=\"return\" type=\"hidden\" value=\"http://folkadelic.de\" />\n";
        echo "<input id=\"cancel_return\" name=\"cancel_return\" type=\"hidden\" value=\"http://folkadelic.de\" />\n";
        echo "<input id=\"notify_url\" name=\"notify_url\" type=\"hidden\" value=\"http://folkadelic.de\" />\n";
        echo "<input id=\"bn\" name=\"bn\" type=\"hidden\" value=\"Folkadelic Hobo Jamboree\" />\n";
        echo "<input id=\"tax_cart\" name=\"tax_cart\" type=\"hidden\" value=\"0\" />\n";
        echo "<input id=\"first_name\" name=\"first_name\" type=\"hidden\" value=\"$firstname\" \>\n";
        echo "<input id=\"last_name\" name=\"last_name\" type=\"hidden\" value=\"$lastname\" \>\n";
        echo "<input id=\"address1\" name=\"address1\" type=\"hidden\" value=\"$adress1\" \>\n";
        echo "<input id=\"address2\" name=\"address2\" type=\"hidden\" value=\"$adress2\" \>\n";
        echo "<input id=\"zip\" name=\"zip\" type=\"hidden\" value=\"$plz\" \>\n";
        echo "<input id=\"city\" name=\"city\" type=\"hidden\" value=\"$city\" \>\n";
        echo "<input id=\"state\" name=\"state\" type=\"hidden\" value=\"$province\" \>\n";
        echo "<input id=\"country\" name=\"country\" type=\"hidden\" value=\"$country\" \>\n";
        echo "<input id=\"country_code\" name=\"country_code\" type=\"hidden\" value=\"$country_code\" \>\n";
        echo "<input id=\"email-address\" name=\"email\" type=\"hidden\" value=\"$email\" \>\n";

      for ($c = "1"; $c <= $kartamount; $c++)
       {   
        echo "<input id=\"item_number_$c\" name=\"item_number_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_id']}\" />\n";
        echo "<input id=\"quantity_$c\" name=\"quantity_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_amount']}\" />\n";
        echo "<input id=\"item_name_$c\" name=\"item_name_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_name']}\" />\n";
        echo "<input id=\"amount_$c\" name=\"amount_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_preis']}\" />\n";
       }

        echo "<input id=\"shipping_1\" name=\"shipping_1\" type=\"hidden\" value=\"$costs\" />\n";
        echo "<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/de_DE/i/scr/pixel.gif\" width=\"1\" height=\"1\">\n";
      echo "</form>\n";
      if (!unlink($kartfile)) echo "ERROR! Could not delete $kartfile.<br>\n";
     }
   else
     {
      echo "<form name=\"checkout_form\" action=\"leaveshop.php\" method=\"post\" accept-charset=\"UTF-8\" target=\"_top\">\n";
      echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
      echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
      echo "</form>\n";
     }
   /* Newsletter entry */
   echo "<form name=\"jnl2_sign_form\" method=\"post\" action=\"../newsletter/validate.php?do=sign_in&language=german&ml_id=00\" target=\"nlbox\">\n";
   echo "<input type=\"hidden\" name=\"email\" value=\"$email\">\n";
   echo "<input type=\"hidden\" name=\"nick\" value=\"$firstname $lastname\">\n";
   echo "<input type=\"hidden\" name=\"mail_format\" value=\"h\">\n";
   echo "<input type=\"hidden\" name=\"grp_00\" value=\"1\" checked>\n</form>";
  }

?>

    </td>
  </tr>
</table>
</font></em>
</body>
</html>
