<?php
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

/* ################################################################### */

$current_page = "shop";
echo "<body bgcolor=\"#171410\""; 
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
/* Prepare strings for receits in browser output and put it out! */

$kontoinfo = "Brian Brademann\nKto.Nr.: 915 660 540\nBLZ: 200 411 33\nIBAN: DE83200411330915660540\nBIC/Swift-Code: COBADEHD001\n\nPayPal-ID: LL5N934Z5GMT8\n";
$sum_items = $costs;
for ($c = "1"; $c <= $kartamount; $c++)
  {
   $sum_items = $sum_items + $kart["$c"]['item_total'];
  }



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

if (!unlink($kartfile)) echo "ERROR! Could not delete $kartfile.<br>\n";
?>
        </center>
        </em></font>
    </td>
  </tr>
</table>
<?php include('../fuss.php'); ?>
