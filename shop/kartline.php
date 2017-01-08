<?php
echo "<!-- BEGIN KARTLINE.PHP -->\n";

$job = $_GET["job"];
$id = $_GET["id"];
$size = $_GET["size"];
$c = $_GET["c"];
$kartfile = "shop/tmp/kart-$kartid.tmp";
$shopdir = getcwd();

include('read_index.php');

if (!isset($newitem)) $job = "";

/* ################################################# */

if ($job == "reset")
  {
   if (!unlink($kartfile)) echo gettext("ERROR! Cannot delete $kartfile.") . "<br>\n";
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
         if ($copt > $key) $countryname = gettext("other");
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
   if ($kart["$item_pointer"]['item_amount'] <= "0") echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL={$conf["callup"]}{$link}job=remove&amp;id={$kart["$item_pointer"]['item_id']}&amp;size={$kart["$item_pointer"]['item_size']}\">\n";
  }

/* ################################################# */
/* Entferne Artikel aus dem Kart! */
if ($job == "remove")
  {
   include('write_kartfile.php');
   echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL={$conf["callup"]}{$link}kart=show\">\n";
  }

/* ################################################# */
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

/* ################################################# */ ?>

<div class="kart shadow" id="kart">
<?php
echo "<center><b class=\"karthead\"><a href=\"javascript:\" id=\"show-hide\" name=\"show-hide\">";
  echo gettext("Shopping kart");
echo "</a></b></center>\n";
?>

<?php
        if ($_GET["kart"] == "show") { echo "<div class=\"karthide\" name=\"karthide\" id=\"kartshow\">\n"; }
        else { echo "<div class=\"karthide\" name=\"karthide\" id=\"karthide\">\n"; } ?>
      <div class="hideable" name="hideable" id="hideable" style="padding: 5px;"></div>
        <?php
        if ($kartamount > 0)
         {
          echo "<center><a href=\"javascript:\" id=\"show-details\">" . gettext("Hide Details") . "</a></center>\n";
          echo "<div class=\"hideable\" name=\"hideable\" id=\"hideable\" style=\"margin: 0px; padding: 0px; padding-top: 10px;\">";
          for ($counter = "1"; $counter <= $kartamount; $counter++)
            {
             $total = $kart["$counter"]['item_amount'] * $kart["$counter"]['item_preis']; $total = number_format($total, 2, '.', '');
             $kart["$counter"]['item_preis'] = number_format($kart["$counter"]['item_preis'], 2, '.', '');
             $kart_total = $kart_total + $total; $kart_total = number_format($kart_total, 2, '.', '');
             /* Item Name and Type */
             ?><div class="kartitem">
             <div class="firstkartitem">
             <?php
             if ($kart[$counter]['item_size'] != "") { echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']} - {$kart[$counter]['item_size']})</div>\n"; }
             else { echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']})</div>\n"; }
             /* Remove button */
             echo "\n<div class=\"secondkartitem\"><a href=\"{$conf["callup"]}{$link}job=remove&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;kart=show\" target=\"_top\">";
             echo "<img src=\"shop/pics/del.png\" alt=\"" . gettext("remove") . "\" title=\"" . gettext("remove") . "\" border=\"0\"></a></div></div>\n";
             /* more & less buttons */
             echo "<div class=\"kartitem\">\n<div class=\"firstkartitem\"><a href=\"{$conf["callup"]}{$link}job=additem&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;kart=show\" target=\"_top\"><img src=\"shop/pics/more.png\" border=\"0\"></a>\n";
             echo "<a href=\"{$conf["callup"]}{$link}job=less&amp;id={$kart["$counter"]['item_id']}&amp;size={$kart["$counter"]['item_size']}&amp;kart=show\" target=\"_top\"><img src=\"shop/pics/less.png\" border=\"0\"></a></div>\n";
             /* Show amount * price = total */
             $total = number_format($total, 2, '.', ' ');
             echo "<div class=\"secondkartitem\">({$kart["$counter"]['item_amount']} x {$kart["$counter"]['item_preis']} {$conf["_currency"]})&nbsp; <b>$total {$conf["_currency"]}</b></div></div>\n<hr>\n";
            }
          $show_kart_total = number_format($kart_total, 2, '.', ' ');
          echo "<div class=\"kartitem\">\n<div class=\"firstkartitem\">\n" . gettext("Sub-Total") . "</div>\n<div class=\"secondkartitem\"><b>$show_kart_total {$conf["_currency"]}</b>\n</div></div></div>\n";

          if ($countryname == "")
            { ?><div class="kartitem"><div class="firstkartitem">
             <select name="countryname" id="countryname" size="1">
             <?php echo "<option selected=\"selected\">" . gettext("Select country!") . "</option>\n";
             foreach($country as $key => $value)
               {
                echo "<option value=\"$key\">$value</option>\n";
               }
             echo "<option>" . gettext("other") . "</option>\n";
             echo "</select>\n</div></div>\n";
            }
          else
            {
             echo "<div class=\"kartitem\"><div class=\"firstkartitem\"><a href=\"{$conf["callup"]}{$link}job=addopt&amp;copt=remove&amp;kart=show\" target=\"_top\">";
             if ($countryname == $cost["_homecountry"]) $shipcost = "{$cost["shipping_home"]}"; else $shipcost = "{$cost["shipping_foreign"]}";
             echo gettext("Shipping") . " $countryname";
             echo "</a></div>\n<div class=\"secondkartitem\">+ $shipcost {$conf["_currency"]}</div></div>\n";
            }

           if ($opt == "" or !isset($opt))
           { ?><div class="kartitem"><div class="firstkartitem">
            <select name="payment" id="payment" size="0">
            <?php echo "<option value=\"payment\" selected=\"selected\">" . gettext("Choose payment!") . "</option>\n";
            foreach($payment as $key => $value)
               {
                $paymentname = $payment[$key]["text"];
                if ($countryname == $cost["_homecountry"]) $transfercost = $payment[$key]["home"];
                else $transfercost = $payment[$key]["foreign"];
                echo "<option value=\"$key\">$paymentname (+ $transfercost {$conf["_currency"]})</option>\n";
               }
            $transfercost = "0.00";
            echo "</select>\n</div></div>\n";
           }
          else
           {
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
            echo "<div class=\"kartitem\"><div class=\"firstkartitem\"><a href=\"{$conf["callup"]}{$link}job=addopt&amp;opt=remove&amp;kart=show\" target=\"_top\">\n";
            echo "$paymentname</a></div><div class=\"secondkartitem\">+ $transfercost {$conf["_currency"]}</div></div>\n";
           }
          echo "<div class=\"hideable\" name=\"hideable\" id=\"hideable\" style=\"margin: 0px; padding: 0px;\">\n<hr>\n";
          echo "<div class=\"kartitem\">\n<div class=\"firstkartitem\">\n<a href=\"{$conf["callup"]}{$link}job=reset\" target=\"_top\"><img src=\"shop/pics/del.png\" alt=\"" . gettext("reset shopping kart (including all adress data)") . "\" title=\"" . gettext("reset shopping kart (including all adress data)") . "\" border=\"0\"></a></div> ";
          $complete = $kart_total + $transfercost + $shipcost; $complete = number_format($complete, 2, '.', ' ');
          echo "<div class=\"secondkartitem\"> " . gettext("Total") . ": <b>$complete {$conf["_currency"]}</b>\n</div></div></div>\n";

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
             echo "<form action=\"{$conf["callup"]}{$link}display=orderaction\" id=\"orderform\" method=\"post\" accept-charset=\"UTF-8\">\n";
             foreach($conf["call"] as $call => $value)
               {
                echo "<input type=\"hidden\" name=\"$call\" value=\"$value\">\n";
               }
             echo "<a class=\"iframe int\" href=\"{$conf["callup"]}{$link}display=order\"><b>" . gettext("Change shipping data") . "</b></a>";
             echo "<a id=\"final_buy\" href=\"javascript:\"><b> " . gettext("Finally buy!") . " &gt;&gt;&gt; </b></a>\n<div class=\"clear\"></div>\n</form>";
            }
          else
            {
             //echo "<div class=\"kart\" id=\"kasse\">\n";
             echo "<a href=\"{$conf["callup"]}{$link}display=order\"><b>";
             echo gettext("Enter shipping data");
             echo "</b></a>\n<div class=\"clear\"></div>\n";
            }
         }
        else
         {
          echo gettext("Kart is empty.");
         }
  ?>
  </div>
</div>
<!-- END KARTLINE.PHP -->

<?php // echo "<pre>Kart:"; print_r($kart); echo "</pre>Data:<pre>"; print_r($data); echo "</pre>\n"; ?>
