<?php
include('conf/shop_conf.php');
include('conf/countries.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');

$job = $_GET["job"];
$id = $_GET["id"];
$c = $_GET["c"];
$lang = $_GET["lang"];
$kartid = $_GET["kartid"];
$kartfile = "tmp/kart-$kartid.tmp";

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
include('read_index.php');

if (!isset($newitem)) $job = "";

/* ################################################# */

if ($job == "reset")
  {
   if (!unlink($kartfile)) echo "ERROR! Cannot delete $kartfile.<br>\n";
   $kartamount = "0";
  }
/* ################################################# */

$kartmode = "kart";
include('read_kartfile.php');

/* ################################################# */

if ($job == "adduserdata")
  {
   if (isset($_POST["firstname"])) $firstname = $_POST["firstname"];
   if (isset($_POST["lastname"])) $lastname = $_POST["lastname"];
   if (isset($_POST["adress1"])) $adress1 = $_POST["adress1"];
   if (isset($_POST["adress2"])) $adress2 = $_POST["adress2"];
   if (isset($_POST["plz"])) $plz = $_POST["plz"];
   if (isset($_POST["city"])) $city = $_POST["city"];
   if (isset($_POST["province"])) $province = $_POST["province"];
   if (isset($_POST["countryname"]) and $_POST["countryname"] != "") $countryname = $_POST["countryname"];
   if (isset($_POST["email"])) $email = $_POST["email"];
   if (isset($_POST["newsletter"])) $newsletter = $_POST["newsletter"];
   if ($_POST["newsletter"] != "ja") $newsletter = "nein";
   else $newsletter = "ja";
   include('write_kartfile.php');
  }

/* ################################################# */

if ($job == "addopt")
  {
   if ($_GET["copt"] == "remove") $countryname = "";  // if Country wants to be changed
   if ($_GET["copt"] != "remove")
     {
      if (isset($_GET["copt"])) 
        {
         foreach($country as $key => $value) { }
         $copt = $_GET["copt"]; $copt--;
         $countryname = $country[$copt];
         if ($copt > $key) $countryname = $loc_lang["country_other"];
        }
     }
   if ($opt == "remove") $opt = "";   // if Payment wants to be changed
   include('write_kartfile.php');
  }

/* ################################################# */

if ($job == "less")
  {
   $kart["$item_pointer"]['item_amount']--;
   include('write_kartfile.php');
   if ($kart["$item_pointer"]['item_amount'] == "0") echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL=kartline.php?job=remove&amp;id={$kart["$item_pointer"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\">\n";
  }

/* Entferne Artikel aus dem Kart! */
if ($job == "remove")
  {
   include('write_kartfile.php');
   echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL=kartline.php?id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\">\n";
  }

/* Füge neuen Artikel zum Kart hinzu! */
if ($job == "additem")
  {
   if ($item_exists == "ja")    /* Falls item schon im Kart ist, erhöhe Anzahl */
     {
      $kart["$item_pointer"]['item_amount']++;
     }
   else                         /* Falls Item noch nicht im Kart ist, erzeuge neuen Array-Zweig mit Menge 1 */
     {
      $kartamount++;
      $kart["$kartamount"]['item_id'] = $data["$newitem"]['item_id'];
      $kart["$kartamount"]['item_name'] = $data["$newitem"]['item_name'];
      $kart["$kartamount"]['item_type'] = $data["$newitem"]['item_type'];
      $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'];
      $kart["$kartamount"]['item_amount'] = "1";
     }
   include('write_kartfile.php');
  }
?>
<!DOCTYPE html>
<html>
<head>
<title>folkadelic hobo jamboree - symphonic punk disco folk</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="page-topic" content="folkadelic hobo jamboree - symphonic punk disco folk">
<meta name="description" content="folkadelic hobo jamboree - a musical mystery, a fine waste of time, a name german fans still can‘t pronounce? Yes! All that and more...">
<link rel="stylesheet" href="shop.css" type="text/css">
<?php
echo "</head>\n<body bgcolor=\"{$conf["bgcolor"]}\">\n<div class=\"kart\">\n";
echo "<h1><b>{$loc_lang["kart"]}</b></h1>";
        if ($kartamount > 0)
         {
          for ($counter = "1"; $counter <= $kartamount; $counter++)
            {
             $total = $kart["$counter"]['item_amount'] * $kart["$counter"]['item_preis']; $total = number_format($total, 2, '.', '');
             $kart["$counter"]['item_preis'] = number_format($kart["$counter"]['item_preis'], 2, '.', '');
             $kart_total = $kart_total + $total; $kart_total = number_format($kart_total, 2, '.', '');
             echo "<table width=\"200\" border=\"0\"><tr><td width=\"184\" align=\"left\">";
             /* Item Name and Type, link to item's page */
             echo "<a href=\"item.php?item={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"shop\">";
             echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']})</a></td><td width=\"16\" align=\"right\">";
             /* Remove button */
             echo "<a href=\"kartline.php?job=remove&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\">";
             echo "<img src=\"pics/del.png\" alt=\"{$loc_lang["remove"]}\" title=\"{$loc_lang["remove"]}\" border=\"0\"></a></td></tr></table>\n<table width=\"200\" border=\"0\"><tr>\n";
             /* more & less buttons */
           /*  echo "<td width=\"40\" align=\"left\">";
             echo "<a href=\"kartline.php?job=additem&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\"><img src=\"pics/more.png\" border=\"0\"></a>\n";
             echo "<a href=\"kartline.php?job=less&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\"><img src=\"pics/less.png\" border=\"0\"></a></td>\n"; */
             /* Show amount * price = total */
             $total = number_format($total, 2, '.', ' ');
             echo "<td align=\"right\">({$kart["$counter"]['item_amount']} x {$kart["$counter"]['item_preis']} &euro;)&nbsp; <b>$total &euro;</b></td></tr></table>\n";
            }
          $show_kart_total = number_format($kart_total, 2, '.', ' ');
          echo "<table width=\"200\" border=\"0\" style=\"border-top:2px dotted black; padding-left:10px;\"><tr><td align=\"left\">{$loc_lang["sub_total"]}</td><td align=\"right\"><b>$show_kart_total &euro;</b></td></tr></table>\n<br>";
          
          if ($countryname == "") 
            {
             echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
             echo "<select name=\"countryname\" size=\"1\" onchange=\"self.location='kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;copt='+this.selectedIndex\">\n";
             echo "<option selected=\"selected\">{$loc_lang["select_country"]}</option>\n";
             foreach($country as $key => $value)
               {
                echo "<option value=\"$key\">$value</option>\n";
               }
             echo "<option>{$loc_lang["country_other"]}</option>\n";
             echo "</select></td></tr></table>\n";
            }
          else
            {
             echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\" width=\"130\">\n<a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;copt=remove\" target=\"kart\">";
             if ($countryname == $cost["_homecountry"]) $shipcost = "{$cost["shipping_home"]}"; else $shipcost = "{$cost["shipping_foreign"]}";
             echo "{$loc_lang["shipping"]} $countryname";
             echo "</a></td><td align=\"right\" width=\"70\">+ $shipcost &euro;</td></tr></table>\n";
            }

           if ($opt == "" or !isset($opt))
           {
            echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
            echo "<select name=\"payment\" size=\"0\" onchange=\"self.location='kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;opt='+this.selectedIndex\">";
            echo "<option value=\"payment\" selected=\"selected\">{$loc_lang["choose_payment"]}</option>\n";
            foreach($payment as $key => $value)
               {
                $paymentname = $loc_lang[$key];
                if ($countryname == $cost["_homecountry"]) $transfercost = $payment[$key]["home"];
                else $transfercost = $payment[$key]["foreign"];
                echo "<option value=\"$key\">$paymentname (+ $transfercost &euro;)</option>\n";
               }
            $transfercost = "0.00";
            echo "</select></td></tr></table>\n";
           }
          else
           {
            if ($opt == "1") 
              {
               if ($countryname == $cost["_homecountry"]) $transfercost = $payment["banktransfer"]["home"];
               else $transfercost = $payment["banktransfer"]["foreign"];
               $paymentname = $loc_lang["banktransfer"];
              }
            if ($opt == "2") 
              { 
               $paymentname = "PayPal"; 
               if ($countryname == $cost["_homecountry"]) $transfercost = $payment["paypal"]["home"];
               else $transfercost = $payment["paypal"]["foreign"];
              }
            if ($opt == "3") 
              {
               if ($countryname == $cost["_homecountry"]) $transfercost = $payment["payondelivery"]["home"];
               else $transfercost = $payment["payondelivery"]["foreign"];
               $paymentname = $loc_lang["payondelivery"];
              }
            echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\"><a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;opt=remove\" target=\"kart\">";
            echo "$paymentname</a></td><td align=\"right\">+ $transfercost &euro;</td></tr></table>\n";
           }
          echo "<br><table width=\"200\" border=\"0\" style=\"border-top:2px dotted black; padding-left:10px;\"><tr><td align=\"left\">";
          echo "<a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=reset\" target=\"kart\"><img src=\"pics/del.png\" alt=\"{$loc_lang["reset_kart"]}\" title=\"{$loc_lang["reset_kart"]}\" border=\"0\"></a> ";
          $complete = $kart_total + $transfercost + $shipcost; $complete = number_format($complete, 2, '.', ' ');
          echo " {$loc_lang["total"]}:</td><td align=\"right\">";
          echo "<b>$complete &euro;</b></td></tr></table>\n</div>\n<br>\n";

/* Check, if all userdata is already received. If all is there,change enter data to change data AND display BUY-link below the kart-list! */
          $datamissing = "0";
          if($countryname == "") $datamissing = "1";
          if($opt == "") $datamissing = "1";
          if($firstname == "") $datamissing = "1";
          if($lastname == "") $datamissing = "1";
          if($adress1 == "") $datamissing = "1";
          if($plz == "") $datamissing = "1";
          if($city == "") $datamissing = "1";
          if($email == "") $datamissing = "1";

          if ($datamissing == "0")
            {
             echo "<div class=\"kasse\">\n<table width=\"100%\"><tr><td align=\"right\">\n";
             echo "<a href=\"order.php?lang=$lang&amp;kartid=$kartid\" target=\"shop\"><b>";
             echo $loc_lang["change_shipping_data"];
             echo "</b></a>\n<br>\n";
             echo "<form action=\"orderaction.php\" target=\"shop\" id=\"orderform\" method=\"post\" accept-charset=\"UTF-8\">\n";
             echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
             echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
             echo "<br><a href=\"javascript:\" onclick=\"document.getElementById('orderform').submit();\"><b>{$loc_lang["final_buy"]}</b></a>\n";
            }
          else
            {
             echo "<div class=\"kasse\">\n<table width=\"100%\"><tr><td align=\"right\">\n";
             echo "<a href=\"order.php?lang=$lang&amp;kartid=$kartid\" target=\"shop\"><b>";
             echo $loc_lang["enter_shipping_data"];
             echo "</b></a>\n<br>\n";
            }
         }
//     echo "</font>{$conf["font_style_close"]}\n";
  ?>
</td>
</tr>
</table>
</div>
</body>
</html>
