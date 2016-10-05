<?php
include('conf/shop_conf.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');
include('header_short.html');

/* ################################################################### */
/* Hole Variablen aus POST-Formular */
$error = "0"; $posterror = "0";
if (!$_POST["reset_x"])
  {
    if ((isset($_POST["lang"])) && ($_POST["lang"] != "")) $lang = $_POST["lang"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "lang";}
    if ((isset($_POST["kartid"])) && ($_POST["kartid"] != "")) $kartid = $_POST["kartid"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "kartid";}
   }

/* ################################################################### */

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
$kartmode = "action";
include('read_kartfile.php');

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

if ($newsletter == "ja") $onload = "document.jnl2_sign_form.submit();";
echo "<body bgcolor=\"{$conf["bgcolor"]}\" onload=\"$onload\">\n";
echo "<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">{$conf["font_style"]}\n";

/* Prepare strings for receits in browser output and put it out! */

$kontoinfo = "Brian Brademann\nKto.Nr.: 915 660 540\nBLZ: 200 411 33\nIBAN: DE83200411330915660540\nBIC/Swift-Code: COBADEHD001\n\nPayPal-ID: LL5N934Z5GMT8\n";
$sum_items = $costs;
for ($c = "1"; $c <= $kartamount; $c++)
  {
   $sum_items = $sum_items + $kart["$c"]['item_total'];
  }

/* ################################################################### */
/* html format */

echo "<table width=\"500\" align=\"center\" valign=\"center\" border=\"0\">\n<tr>\n<td align=\"center\" colspan=\"3\">\n";
echo "<h3>{$loc_lang["thx_4_order"]}</h3>\n";
echo "<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n";
echo "</td>\n</tr>\n";
for ($c = "1"; $c <= $kartamount; $c++)
  {
   $str_itemtotal = number_format($kart["$c"]['item_total'], 2, '.', ' ');
   echo "<tr><td align=\"right\" colspan=\"1\">{$kart["$c"]['item_type']} - <b>{$kart["$c"]['item_name']}</b> </td>";
   echo "<td align=\"right\" colspan=\"1\"> ({$kart["$c"]['item_preis']} &euro; x {$kart["$c"]['item_amount']} {$loc_lang["pieces"]}) </td>";
   echo "<td align=\"right\" colspan=\"1\"><b>$str_itemtotal &euro;</b></td></tr>\n";
  }
$str_transfercost = number_format($transfercost, 2, '.', ' ');
$str_shippingcost = number_format($shippingcost, 2, '.', ' ');
$str_sum_items = number_format($sum_items, 2, '.', ' ');

echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>$paymentname</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_transfercost &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>{$loc_lang["shipping"]}</b> ($countryname)</td><td align=\"right\" colspan=\"1\"><b>$str_shippingcost &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"right\" colspan=\"2\"><b>{$loc_lang["total"]}</b></td><td align=\"right\" colspan=\"1\"><b>$str_sum_items &euro;</b></td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n<hr style=\"width:500px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:center;\">\n</td>\n</tr>\n";
echo "<tr>\n<td align=\"center\" colspan=\"3\">\n";
if ($opt == "1")
  {
   echo "{$loc_lang["please_send"]} <b>$str_sum_items &euro;</b> {$loc_lang["to_following_account"]}<br>\n<br>\n";
   echo "Brian Brademann<br>\nKto.Nr.: 915 660 540<br>\nBLZ: 200 411 33<br>\n<br>\nIBAN: DE83200411330915660540<br>\nBIC/Swift-Code: COBADEHD001<br>\n<br>\n";
   echo "{$loc_lang["as_soon_as_money_arrives"]}<br>\n";
  }
if ($opt == "3")
  {
   echo "{$loc_lang["will_be_sent_soon"]}<br>\n";
  }
echo "</td>\n</tr>\n</table>\n";
echo "<center><iframe src=\"bg.php\" name=\"nlbox\" id=\"nlbox\" width=\"350\" height=\"200\" frameborder=\"0\" border=\"0\"></iframe></center>\n";
/* ################################################################### */

// if (!unlink($kartfile)) echo "ERROR! Could not delete $kartfile.<br>\n";

   /* Newsletter entry */
   echo "<form name=\"jnl2_sign_form\" method=\"post\" action=\"../newsletter/validate.php?do=sign_in&language=german&ml_id=00\" target=\"nlbox\">\n";
   echo "<input type=\"hidden\" name=\"email\" value=\"$email\">\n";
   echo "<input type=\"hidden\" name=\"nick\" value=\"$firstname $lastname\">\n";
   echo "<input type=\"hidden\" name=\"mail_format\" value=\"h\">\n";
   echo "<input type=\"hidden\" name=\"grp_00\" value=\"1\" checked>\n</form>";
   echo "<p><b><a href=\"{$conf["this_domain"]}\" target=\"_top\">{$conf["this_domain"]}</a></b></p>";
?>
</em>
</font>
</body>
</html>
