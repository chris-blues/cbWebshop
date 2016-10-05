<?php

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
   $paymentname = $loc_lang["banktransfer"];
  }
if ($opt == "2")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["paypal"]["home"];
   else $transfercost = $payment["paypal"]["foreign"];
   $paymentname = $loc_lang["paypal"];
  }
if ($opt == "3")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["payondelivery"]["home"];
   else $transfercost = $payment["payondelivery"]["foreign"];
   $paymentname = $loc_lang["payondelivery"];
  }
$costs = $transfercost + $shippingcost;

/* ################################################################### */
/* Prepare strings for receits in browser/mail output and put it out! */
/* mail format */
$email_shop = $conf["_email_shopkeeper"];
$email_buyer = "$firstname $lastname <$email>";
$betreff_shop = "{$loc_lang["mail"]["your_order"]} @ {$conf["this_domain"]} - ID:$kartid";
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

$betreff_buyer = "{$loc_lang["mail"]["your_order"]} @ {$conf["this_domain"]} - ID:$kartid";
$mail_items .= "--------------------------------\n{$loc_lang["mail"]["transfer_cost"]}($paymentnamemail): $transfercost {$conf["_currency"]}\n{$loc_lang["mail"]["shipping_cost"]} $shippingcost {$conf["_currency"]}\n--------------------------------\n{$loc_lang["mail"]["total"]}: $sum_items {$conf["_currency"]}\n\n";
$mail_opener_buyer = "{$loc_lang["mail"]["for_invoice_to_order"]} {$conf["this_domain"]}\n\n$date\n\n";
$mail_opener_buyer .= "{$loc_lang["mail"]["hello"]} $firstname $lastname!\n\n{$loc_lang["mail"]["thx_4_order"]}\n\n"; 
$mail_opener_buyer .= "{$loc_lang["mail"]["kart_id"]} $kartid\n\n";
$mail_end_buyer = "{$loc_lang["mail"]["transfer_money_to_account"]}\n\n";
//if ($newsletter == "ja") { $mail_end_buyer .= "{$loc_lang["mail"]["submitted_to_newsletter"]}\n\n"; }
$mail_end_buyer .= "{$loc_lang["mail"]["hope_you_enjoy"]}\n{$conf["this_organization"]}\n{$conf["this_domain"]}\n\n\n\n";

$mail_end_buyer .= $kontoinfo;
$mail_opener_shop = "$date\nKart-ID: $kartid\n\n$email_buyer ({$loc_lang["mail"]["speaks"]} $lang)\n$adress1\n";
if ($adress2 != "") $mail_opener_shop .= "$adress2\n";
$mail_opener_shop .= "$plz - $city\n";
if ($province != "") $mail_opener_shop .= "$province\n";
$mail_opener_shop .= "$countryname\n\n{$loc_lang["mail"]["orders"]}:\n\n";
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
echo "<div class=\"shadow\">\n";
echo "<table width=\"75%\" align=\"center\" valign=\"center\" border=\"0\">\n<tr>\n<td align=\"center\" colspan=\"3\">\n";
echo "<h3>{$loc_lang["thx_4_order"]}</h3>\n";
echo "<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n";
echo "</td>\n</tr>\n";

foreach($kart as $c => $value)
  {
   if ($kart["$c"]['item_id'] == "") continue 1;
   if ($kart["$c"]['item_size'] == "") echo "<tr><td align=\"left\" colspan=\"1\">$c - {$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> </td>";
   else echo "<tr><td align=\"left\" colspan=\"1\">$c - {$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> ({$kart["$c"]['item_size']}) </td>";
   echo "<td align=\"right\" colspan=\"1\"> ({$kart["$c"]['item_preis']} {$conf["_currency"]} x {$kart["$c"]['item_amount']} {$loc_lang["pieces"]}) </td>";
 //  $kart["$c"]['item_total'] = $kart["$c"]['item_amount'] * $kart["$c"]['item_preis'];
   $str_itemtotal = number_format($kart["$c"]['item_total'], 2, '.', ' ');
   echo "<td align=\"right\" colspan=\"1\"><b>$str_itemtotal {$conf["_currency"]}</b></td></tr>\n";
 //  $sum_items = $sum_items + $kart["$c"]['item_total'];
  }
  
$str_transfercost = number_format($transfercost, 2, '.', ' ');
$str_shippingcost = number_format($shippingcost, 2, '.', ' ');
$str_sum_items = number_format($sum_items, 2, '.', ' ');

echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$paymentname</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_transfercost {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>{$loc_lang["shipping"]}</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_shippingcost {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>{$loc_lang["total"]}</b></td><td align=\"right\" colspan=\"1\"><b>$str_sum_items {$conf["_currency"]}</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:100%; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n";
if ($opt == "1")
  {
   echo "{$loc_lang["please_send"]} <b>$str_sum_items {$conf["_currency"]}</b> {$loc_lang["to_following_account"]}<br>\n<br>\n";
   echo nl2br($conf["bankaccount_info"],false) . "<br>\n";
   echo "{$loc_lang["as_soon_as_money_arrives"]}<br>\n";
  }
if ($opt == "3")
  {
   echo "{$loc_lang["will_be_sent_soon"]}<br>\n";
  }
echo "</td>\n</tr>\n</table>\n</div>\n";
if ($newsletter=="ja")
  {
   $_GET["order"] = "check";
   $_POST["name"] = "$firstname";
   $_POST["email"] = $email;
   include('newsletter/newsletter.php');
  }
echo "<br><div class=\"shadow\" style=\"text-align: center;\">";
if ($mailerrorbuyer == "1") 
  {
   echo $loc_lang["mailerror"] . "<br>\n";
   echo $loc_lang["datastoredonserver"] . "<br>\n";
  }
else
  {
   echo $loc_lang["mailsent"] . "<br>\n";
   if (!unlink("shop/tmp/kart-$kartid.tmp")) echo "<h3>ERROR!</h3>{$loc_lang["error_data_erase"]}<br>\n";
   else echo "<br>\n{$loc_lang["data_erased"]}<br>\n";
  }
echo "</div>\n";
?>
