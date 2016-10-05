<?php
$kartid = $_GET["kartid"];
$kartfile = "../tmp/$kartid";

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");

/* Lese karttmpfile falls vorhanden und Erzeuge Array Kart[1][item_sth] */
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
if ($karthandle != NULL)
 {
  $buffer = fgets($karthandle); $kartlang = trim($buffer,"\n");
  $buffer = fgets($karthandle); $countryname = trim($buffer,"\n");
  $buffer = fgets($karthandle); $opt = trim($buffer,"\n");
  $buffer = fgets($karthandle); $firstname = trim($buffer,"\n");
  $buffer = fgets($karthandle); $lastname = trim($buffer,"\n");
  $buffer = fgets($karthandle); $adress1 = trim($buffer,"\n");
  $buffer = fgets($karthandle); $adress2 = trim($buffer,"\n");
  $buffer = fgets($karthandle); $plz = trim($buffer,"\n");
  $buffer = fgets($karthandle); $city = trim($buffer,"\n");
  $buffer = fgets($karthandle); $province = trim($buffer,"\n");
  $buffer = fgets($karthandle); $email = trim($buffer,"\n");
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
   }
 }
else echo "Could not open $kartfile<br>";
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--;
if ($kartamount < 1) $kartamount = "0";

if ($opt == "1") { $paymentname = $loc_lang["banktransfer"]; }
if ($opt == "2") { $paymentname = $loc_lang["paypal"]; }
if ($opt == "3") { $paymentname = $loc_lang["payondelivery"]; }
if (!isset($paymentname)) { $paymentname = "[n/a]"; }

include('header_short.html');
?>

<!-- Output gathered data -->

<body>
<table width="600" height="280" border="0" rules="all">
  <tr>
    <td>Customer Data:</td>
    <td>Items: (<?php echo $kartid; ?>)</td>
  </tr>
  <tr>
<?php
  echo "<td valign=\"top\"><br><b>$firstname $lastname</b><br>";
  echo "<font size=\"1\">$kartlang<br>$email<br>Newsletter: $newsletter<br><br></font>";
  echo "$adress1<br>$adress2<br>";
  echo "$plz - $city<br>";
  echo "$province<br>$countryname<br><br>$opt: $paymentname</td>";
  
  echo "<td valign=\"top\"><ul>";
  $count = 1;
  while ($count <= $kartamount)
    {
     echo "<li>{$kart["$count"]['item_name']} ({$kart["$count"]['item_type']} - {$kart["$count"]['item_size']}) - {$kart["$count"]['item_amount']} x {$kart["$count"]['item_preis']}{$conf["_currency"]}</li>";
     $count++;
    }
  $kartidstr = str_replace("kart-","",$kartid);
  $kartidstr = str_replace(".tmp","",$kartidstr);
  echo "</ul><a href=\"../../index.php?page=shop&amp;kartid=$kartidstr&amp;display=order\" target=\"_blank\">Look up in shop</a></td>";
?>
  </tr>
</table>
</body>
</html>
