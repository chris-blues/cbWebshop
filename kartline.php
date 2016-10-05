<?php
echo "<!-- BEGIN KARTLINE.PHP -->\n";
$job = $_GET["job"];
$id = $_GET["id"];
$size = $_GET["size"];
$c = $_GET["c"];
$kartfile = "shop/tmp/kart-$kartid.tmp";
$shopdir = getcwd();

//echo "DEBUG kartline.php:<br>\nlang: $lang<br>\nkartid: $kartid<br>\njob: $job<br>\nid: $id<br>\nkartfile: $shopdir/$kartfile<br>\n";

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
   /* ?><pre><?php print_r($_POST); ?></pre><?php */
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
   if ($kart["$item_pointer"]['item_amount'] <= "0") echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL=index.php?page=shop&amp;job=remove&amp;id={$kart["$item_pointer"]['item_id']}&amp;size={$kart["$item_pointer"]['item_size']}&amp;lang=$lang&amp;kartid=$kartid\">\n";
  }

/* Entferne Artikel aus dem Kart! */
if ($job == "remove")
  {
   include('write_kartfile.php');
   echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL=index.php?page=shop&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;lang=$lang&amp;kartid=$kartid&amp;kart=show\">\n";
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
      $kart["$kartamount"]['item_id'] = "{$data["$newitem"]['item_id']}";
      $kart["$kartamount"]['item_name'] = "{$data["$newitem"]['item_name']}";
      $kart["$kartamount"]['item_type'] = "{$data[$newitem]['item_type']}";
      $kart["$kartamount"]['item_size'] = $_GET["size"];
      $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'];
      if ($kart["$kartamount"]['item_size'] == "XXL") $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'] + 2;
      if ($kart["$kartamount"]['item_size'] == "XL") $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'] + 1;
      if ($kart["$kartamount"]['item_size'] == "M") $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'] - 1;
      if ($kart["$kartamount"]['item_size'] == "S") $kart["$kartamount"]['item_preis'] = $data["$newitem"]['item_preis'] - 2;
      $kart["$kartamount"]['item_amount'] = "1";
     }
   include('write_kartfile.php');
  }
//include('header_full.html');
//echo "<body class=\"framed\">\n";
?>

<div class="kart shadow" id="kart">
<?php
echo "<b class=\"karthead\"><a href=\"javascript:show_kart();\" id=\"show-hide\" name=\"show-hide\" onfocus=\"this.blur();\">{$loc_lang["kart"]}&nbsp;</a></b>\n";
?>

  <script type="text/javascript">
    function show_kart()
      {
       if (document.getElementsByName("karthide")["0"].style.display != "block")
         {
          document.getElementsByName("karthide")["0"].style.display = "block";
         }
       else
         {
          document.getElementsByName("karthide")["0"].style.display = "none";
         }
       kart.height = document.getElementById("kart_frame").contentDocument.documentElement.offsetHeight;
      }

    function show_items()
      {
       if (document.getElementsByName("hideable")["0"].style.display == "none")
         {
          document.getElementById("show-details").firstChild.data = <?php echo "\"{$loc_lang["hidedetails"]}\""; ?>;
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideDown( 500 );
            }
         }
       else
         {
          document.getElementById("show-details").firstChild.data = <?php echo "\"{$loc_lang["showdetails"]}\""; ?>;
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideUp( 500 );
            }
         }
      }
    </script>

<?php
if ($_GET["kart"] == "show") { echo "<div class=\"karthide\" name=\"karthide\" id=\"kartshow\">\n"; }
else { echo "<div class=\"karthide\" name=\"karthide\" id=\"karthide\">\n"; }
        if ($kartamount > 0)
         {
          echo "<center><a href=\"javascript:show_items();\" id=\"show-details\">{$loc_lang["hidedetails"]}</a></center>\n";
          echo "<div class=\"hideable\" name=\"hideable\" id=\"hideable\" style=\"margin: 0px; padding: 0px;\">";
          echo "<table width=\"200\" border=\"0\">\n";
          for ($counter = "1"; $counter <= $kartamount; $counter++)
            {
             $total = $kart["$counter"]['item_amount'] * $kart["$counter"]['item_preis']; $total = number_format($total, 2, '.', '');
             $kart["$counter"]['item_preis'] = number_format($kart["$counter"]['item_preis'], 2, '.', '');
             $kart_total = $kart_total + $total; $kart_total = number_format($kart_total, 2, '.', '');
             echo "<tr><td width=\"184\" align=\"left\" colspan=\"2\">\n";
             /* Item Name and Type */
             if ($kart[$counter]['item_size'] != "") { echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']} - {$kart[$counter]['item_size']})</td>\n";
                                                       echo "<td width=\"16\" align=\"right\" colspan=\"1\">"; }
             else { echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']})</td>\n<td width=\"16\" align=\"right\" colspan=\"1\">"; }
             /* Remove button */
             echo "<a href=\"index.php?page=shop&amp;job=remove&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;lang=$lang&amp;kartid=$kartid&amp;kart=show\" target=\"_top\">";
             echo "<img src=\"shop/pics/del.png\" alt=\"{$loc_lang["remove"]}\" title=\"{$loc_lang["remove"]}\" border=\"0\"></a></td></tr>\n<tr>\n";
             /* more & less buttons */
             echo "<td width=\"40\" align=\"left\" colspan=\"1\">";
             echo "<a href=\"index.php?page=shop&amp;job=additem&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;lang=$lang&amp;kartid=$kartid&amp;kart=show\" target=\"_top\"><img src=\"shop/pics/more.png\" border=\"0\"></a>\n";
             echo "<a href=\"index.php?page=shop&amp;job=less&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;lang=$lang&amp;kartid=$kartid&amp;kart=show\" target=\"_top\"><img src=\"shop/pics/less.png\" border=\"0\"></a></td>\n";
             /* Show amount * price = total */
             $total = number_format($total, 2, '.', ' ');
             echo "<td align=\"right\" colspan=\"2\">({$kart["$counter"]['item_amount']} x {$kart["$counter"]['item_preis']} {$conf["_currency"]})&nbsp; <b>$total {$conf["_currency"]}</b></td></tr>\n";
            }
          echo "</table>\n";
          $show_kart_total = number_format($kart_total, 2, '.', ' ');
          echo "<table width=\"200\" border=\"0\" style=\"border-top:2px dotted black; padding-left:10px;\"><tr><td align=\"left\">{$loc_lang["sub_total"]}</td><td align=\"right\"><b>$show_kart_total {$conf["_currency"]}</b></td></tr></table>\n</div>\n";
          
          if ($countryname == "") 
            {
             echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
             echo "<select name=\"countryname\" size=\"1\" onchange=\"self.location='index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;kart=show&amp;job=addopt&amp;copt='+this.selectedIndex\">\n";
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
             echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\" width=\"130\">\n<a href=\"index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;copt=remove&amp;kart=show\" target=\"_top\">";
             if ($countryname == $cost["_homecountry"]) $shipcost = "{$cost["shipping_home"]}"; else $shipcost = "{$cost["shipping_foreign"]}";
             echo "{$loc_lang["shipping"]} $countryname";
             echo "</a></td><td align=\"right\" width=\"70\">+ $shipcost {$conf["_currency"]}</td></tr></table>\n";
            }

           if ($opt == "" or !isset($opt))
           {
            echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
            echo "<select name=\"payment\" size=\"0\" onchange=\"self.location='index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;kart=show&amp;job=addopt&amp;opt='+this.selectedIndex\">";
            echo "<option value=\"payment\" selected=\"selected\">{$loc_lang["choose_payment"]}</option>\n";
            foreach($payment as $key => $value)
               {
                $paymentname = $loc_lang[$key];
                if ($countryname == $cost["_homecountry"]) $transfercost = $payment[$key]["home"];
                else $transfercost = $payment[$key]["foreign"];
                echo "<option value=\"$key\">$paymentname (+ $transfercost {$conf["_currency"]})</option>\n";
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
            echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\"><a href=\"index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;opt=remove&amp;kart=show\" target=\"_top\">";
            echo "$paymentname</a></td><td align=\"right\">+ $transfercost {$conf["_currency"]}</td></tr></table>\n";
           }
          echo "<div class=\"hideable\" name=\"hideable\" id=\"hideable\" style=\"margin: 0px; padding: 0px;\">";
          echo "<table width=\"200\" border=\"0\" style=\"border-top:2px dotted black; padding-left:10px;\"><tr><td align=\"left\">";
          echo "<a href=\"index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;job=reset\" target=\"_top\"><img src=\"shop/pics/del.png\" alt=\"{$loc_lang["reset_kart"]}\" title=\"{$loc_lang["reset_kart"]}\" border=\"0\"></a> ";
          $complete = $kart_total + $transfercost + $shipcost; $complete = number_format($complete, 2, '.', ' ');
          echo " {$loc_lang["total"]}:</td><td align=\"right\">";
          echo "<b>$complete {$conf["_currency"]}</b></td></tr></table>\n<br>\n</div>\n";
          echo "<script type=\"text/javascript\">document.getElementById(\"show-hide\").firstChild.data = \"{$loc_lang["kart"]} ($complete {$conf["_currency"]}) \";</script>\n";

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
             //echo "<div class=\"kart\" id=\"kasse\">\n";
             echo "<form action=\"shop/orderaction.php?kartid=$kartid&amp;lang=$lang\" id=\"orderform\" method=\"post\" accept-charset=\"UTF-8\">\n";
             echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
             echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
             echo "<table border=\"0\" width=\"200\"><tr><td align=\"left\">\n";
             echo "<a class=\"iframe int\" id=\"media\" href=\"index.php?page=shop&amp;lang=$lang&amp;kartid=$kartid&amp;display=order\"><b>{$loc_lang["change_shipping_data"]}</b></a></td><td align=\"right\">";
             echo "<a href=\"javascript:\" onclick=\"document.getElementById('orderform').submit();\"><b>{$loc_lang["final_buy"]}</b></a>\n</td></tr></table></form>";
            }
          else
            {
             //echo "<div class=\"kart\" id=\"kasse\">\n";
             echo "<a href=\"index.php?page=shop&amp;lang=$lang&amp;kartid=$kartid&amp;display=order\"><b>";
             echo $loc_lang["enter_shipping_data"];
             echo "</b></a>\n";
            }
         }
        else
         {
          echo $loc_lang["kart_empty"];
         }
  ?>
  </div>
</div>
<!-- END KARTLINE.PHP -->
