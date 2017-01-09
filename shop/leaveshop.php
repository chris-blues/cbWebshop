<?php
error_reporting(0);
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/www/admin/logs/php-error.log");

/* ################################################################### */
/* Hole Variablen aus POST-Formular */
$error = "0"; $posterror = "0";
if (!$_POST["reset_x"])
  {
    if ((isset($_POST["lang"])) && ($_POST["lang"] != "")) $lang = $_POST["lang"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "lang";}
    if (isset($lastkart))
      {
       $kartid = $lastkart;
      }
    else
      {
       if ((isset($_POST["kartid"])) && ($_POST["kartid"] != "")) $kartid = $_POST["kartid"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "kartid";}
      }
   }


/*   if (isset($_GET["kartid"])) $kartid = $_GET["kartid"];
   if (isset($_GET["lang"])) $lang = $_GET["lang"]; */


/* ################################################################### */

$kartmode = "action";
$kartfilepath = "shop/tmp";
include('shop/read_kartfile.php');

/* ################################################################### */

/* Stelle Variablen zusammen */
$date = date("d.m.Y");
if ($countryname == $cost["_homecountry"]) $shippingcost = "{$cost["shipping_home"]}"; else $shippingcost = "{$cost["shipping_foreign"]}";
if ($opt == "1")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["banktransfer"]["home"];
   else $transfercost = $payment["banktransfer"]["foreign"];
   $paymentname = gettext("Bank Transfer");
  }
if ($opt == "2")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["paypal"]["home"];
   else $transfercost = $payment["paypal"]["foreign"];
   $paymentname = gettext("PayPal");
  }
if ($opt == "3")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["payondelivery"]["home"];
   else $transfercost = $payment["payondelivery"]["foreign"];
   $paymentname = gettext("Pay on delivery");
  }
$costs = $transfercost + $shippingcost;

/* ################################################################### */
/* Prepare strings for receits in browser/mail output and put it out! */
/* mail format */
$email_shop = $conf["_email_shopkeeper"];
$email_buyer = "$firstname $lastname <$email>";
$betreff_shop = gettext("Your order") . " @ {$conf["this_domain"]} - ID:$kartid";
$kontoinfo = $conf["bankaccount_info"];
$sum_items = $costs;
$mail_items = "";

//echo "<pre>"; print_r($kart); echo "</pre>\n";

foreach ($kart as $c => $value)
  {
   if ($kart["$c"]['item_id'] == "") continue 1;
   $kart["$c"]['item_total'] = $kart["$c"]['item_preis'] * $kart["$c"]['item_amount'];
   $sum_items = $sum_items + $kart["$c"]['item_total'];
   if ($kart["$c"]['item_size'] == "")
     $mail_items .= "{$kart["$c"]['item_type']} - {$kart["$c"]['item_name']} ({$kart["$c"]['item_amount']} x {$kart["$c"]['item_preis']} {$conf["_currency"]}) : {$kart["$c"]['item_total']} {$conf["_currency"]}\n";
   else
     $mail_items .= "{$kart["$c"]['item_type']} - {$kart["$c"]['item_name']} ({$kart["$c"]['item_size']}) ({$kart["$c"]['item_amount']} x {$kart["$c"]['item_preis']} {$conf["_currency"]}) : {$kart["$c"]['item_total']} {$conf["_currency"]}\n";
  }

$betreff_buyer = gettext("Your order") . " @ {$conf["this_domain"]} - ID:$kartid";
$mail_items .= "--------------------------------\n" . gettext("Transfercost") . "($paymentname): $transfercost {$conf["_currency"]}\n" . gettext("Shipping cost") . " $shippingcost {$conf["_currency"]}\n--------------------------------\n" . gettext("Total") . ": $sum_items {$conf["_currency"]}\n\n";
$mail_opener_buyer = gettext("For your information and as an invoice to your order at") . " {$conf["this_domain"]}\n\n$date\n\n";
$mail_opener_buyer .= gettext("Hello $firstname $lastname!") . "\n\n" . gettext("Thank you for your order and your interest in our work!") . "\n" . gettext("Here is what you ordered:") . "\n\n"; 
$mail_opener_buyer .= gettext("Kart-ID:") . " $kartid\n\n";
$mail_end_buyer = gettext("Please transfer the amount to our account as soon as possible, so we can send you the shipment as soon as your money has arrived!") . "\n\n";
$mail_end_buyer .= gettext("We hope you enjoy our work and wish you all the best!") . "\n{$conf["this_organization"]}\n{$conf["this_domain"]}\n\n\n\n";

$mail_end_buyer .= $kontoinfo;
$mail_opener_shop = "$date\nKart-ID: $kartid\n\n$email_buyer (" . gettext("speaks") . " $lang)\n$adress1\n";
if ($adress2 != "") $mail_opener_shop .= "$adress2\n";
$mail_opener_shop .= "$plz - $city\n";
if ($province != "") $mail_opener_shop .= "$province\n";
$mail_opener_shop .= "$countryname\n\n" . gettext("orders") . ":\n\n";
$mail_end_shop = "Newsletter: $newsletter\n\n";

date_default_timezone_set('Europe/Berlin'); $maildate = date(DATE_RFC2822);
$header = "Content-Type: text/plain; charset = \"UTF-8\";\r\n";
$header .= "Content-Transfer-Encoding: 8bit\r\n";
$header .= "Date: $maildate\r\n";
$header .= "\r\n";

$mail_buyer = $mail_opener_buyer . $mail_items . $mail_end_buyer;
$mail_buyer = wordwrap($mail_buyer, 70);
$header_buyer = "From: $email_shop\r\n";
$header_buyer .= $header;
if (!mail($email_buyer, $betreff_buyer, $mail_buyer, $header_buyer)) { echo "<h3>ERROR!</h3>Failed to send mail to buyer!<br>\n"; $mailerrorbuyer = "1"; }

$mail_shop = $mail_opener_shop . $mail_items . $mail_end_shop;
if ($mailerrorbuyer == "1") $mail_shop .= "\n\n=============================\nFailed to send mail to buyer!\n=============================\n";
$mail_shop = wordwrap($mail_shop, 70);
$header_shop = "From: $email_buyer\r\n";
$header_shop .= $header;
if (!mail($email_shop, $betreff_shop, $mail_shop, $header_shop)) { echo "<h3>ERROR!</h3>Failed to send mail to shopkeeper!<br>\n"; $mailerrorshop = "1"; }


/* html format */
echo "<div class=\"leaveshop shadow\">\n";
echo "<table width=\"75%\" align=\"center\" valign=\"center\" border=\"0\">\n<tr>\n<td align=\"center\" colspan=\"3\">\n";
echo "<h3>" . gettext("Thank you for your order!") . "</h3>\n";
echo "<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n";
echo "</td>\n</tr>\n";

foreach($kart as $c => $value)
  {
   if ($kart["$c"]['item_id'] == "") continue 1;
   if ($kart["$c"]['item_size'] == "") echo "<tr><td align=\"left\" colspan=\"1\">$c - {$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> </td>";
   else echo "<tr><td align=\"left\" colspan=\"1\">$c - {$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> ({$kart["$c"]['item_size']}) </td>";
   echo "<td align=\"right\" colspan=\"1\"> ({$kart["$c"]['item_preis']} {$conf["_currency"]} x {$kart["$c"]['item_amount']} " . gettext("pieces") . ") </td>";
 //  $kart["$c"]['item_total'] = $kart["$c"]['item_amount'] * $kart["$c"]['item_preis'];
   $str_itemtotal = number_format($kart["$c"]['item_total'], 2, '.', ' ');
   echo "<td align=\"right\" colspan=\"1\"><b>$str_itemtotal {$conf["_currency"]}</b></td></tr>\n";
 //  $sum_items = $sum_items + $kart["$c"]['item_total'];
  }
  
$str_transfercost = number_format($transfercost, 2, '.', ' ');
$str_shippingcost = number_format($shippingcost, 2, '.', ' ');
$str_sum_items = number_format($sum_items, 2, '.', ' ');

echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$paymentname</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_transfercost {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>" . gettext("Shipping") . "</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_shippingcost {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>" . gettext("Total") . "</b></td><td align=\"right\" colspan=\"1\"><b>$str_sum_items {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n";
if ($opt == "1")
  {
   printf (gettext("Please send <b>%s %s</b> to the following bank account:"),$str_sum_items, $conf["_currency"]);
   echo "<br>\n<br>\n";
   echo nl2br($conf["bankaccount_info"],false) . "<br>\n";
   echo gettext("As soon as your money arrives we'll send your shipment.") . "<br>\n";
  }
if ($opt == "3")
  {
   echo gettext("Your order will be sent soon! Please keep enough cash under your pillow to pay for the package, when it arrives!") . "<br>\n";
  }
echo "</td>\n</tr>\n</table>\n</div>\n";
if ($newsletter=="ja")
  {
   $_GET["order"] = "check";
   $_POST["name"] = "$firstname";
   $_POST["email"] = $email;
   include('newsletter/newsletter.php');
  }
echo "<br><div class=\"leaveshop shadow\" style=\"text-align: center;\">";
if ($mailerrorbuyer == "1") 
  {
   echo gettext("Something went wrong! We couldn't send an email to you! But we have been notified and will get in touch with you!") . "<br>\n";
   echo gettext("Your data was kept on the server for error tracking. It will be erased as soon as we have completed.") . "<br>\n";
  }
else
  {
   echo gettext("An email has been sent to you, containing all the information you'll need to finalize this business.") . "<br>\n";
   if (!unlink("shop/tmp/kart-$kartid.tmp")) echo "<h3>ERROR!</h3>" . gettext("Your data could not be erased!") . "<br>\n";
   else echo "<br>\n" . gettext("Your data has been erased from the server!") . "<br>\n";
  }
echo "</div>\n";
?>
