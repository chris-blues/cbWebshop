<?php
include('header_short.html');
$job = $_GET["job"];
$id = $_GET["id"];
$c = $_GET["c"];
$lang = $_GET["lang"];
$kartid = $_GET["kartid"];
$kartfile = "tmp/kart-$kartid.tmp";

include('read_index.php');

if (!isset($newitem)) $job = "";

/* ################################################# */

if ($job == "reset")
  {
   if (!unlink($kartfile)) echo "ERROR! Could not delete $kartfile.<br>\n";
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
   if (isset($_POST["country"]) and $_POST["country"] != "") $country = $_POST["country"];
   if (isset($_POST["email"])) $email = $_POST["email"];
   if (isset($_POST["newsletter"])) $newsletter = $_POST["newsletter"];
   if ($_POST["newsletter"] != "ja") $newsletter = "nein";
   else $newsletter = "ja";
   include('write_kartfile.php');
  }

/* ################################################# */

if ($job == "addopt")
  {
   if ($country == "0") $country = "Germany";
   if ($country == "1") $country = "Germany";
   if ($country == "2") $country = "Great Britain"; 
   if ($country == "3") $country = "Poland"; 
   if ($country == "4") $country = "USA"; 
   if ($country == "5") $country = "other";
   if ($country == "remove") $country = "";
   if ($opt == "remove") $opt = "";
   
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
</head>
<body bgcolor="#544a31">
<table border="0" bgcolor="#544a31">
<tr>
<td>
  <em><font face="Georgia" size="3">
  <?php echo "<font size=\"5\"><a href=\"shopcontent.php?lang=$lang&amp;kartid=$kartid\" target=\"shop\">\n";
        if ($lang == "english") echo "Back to shop";
        else echo "Zur&uuml;ck zum Shop";
        echo "</a></font>\n<br>\n<br>\n";
        if ($kartamount > 0)
         {
          echo "<hr style=\"color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:left;\">\n<font size=\"2\">\n";
          for ($counter = "1"; $counter <= $kartamount; $counter++)
            {
             $total = $kart["$counter"]['item_amount'] * $kart["$counter"]['item_preis']; $total = number_format($total, 2, '.', '');
             $kart["$counter"]['item_preis'] = number_format($kart["$counter"]['item_preis'], 2, '.', '');
             $kart_total = $kart_total + $total; $kart_total = number_format($kart_total, 2, '.', '');
             echo "<table width=\"200\" border=\"0\" bgcolor=\"#544a31\"><tr><td width=\"184\" align=\"left\">";
             /* Item Name and Type, link to item's page */
             echo "<a href=\"item.php?item={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"shop\">";
             echo "{$kart["$counter"]['item_name']} ({$kart["$counter"]['item_type']})</a></td><td width=\"16\" align=\"right\">";
             /* Remove button */
             if ($lang == "english") $alt = "remove"; else $alt = "entfernen";
             echo "<a href=\"kartline.php?job=remove&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\">";
             echo "<img src=\"pics/del.png\" alt=\"$alt\" title=\"$alt\"></a></td></tr></table>\n<table width=\"200\" border=\"0\"><tr><td width=\"29\" align=\"left\">";
             /* more & less buttons */
             echo "<a href=\"kartline.php?job=additem&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\"><img src=\"pics/more.png\"></a>&nbsp;";
             echo "<a href=\"kartline.php?job=less&amp;id={$kart["$counter"]['item_id']}&amp;lang=$lang&amp;kartid=$kartid\" target=\"kart\"><img src=\"pics/less.png\"></a></td>";
             /* Show amount * price = total */
             $total = number_format($total, 2, '.', ' ');
             echo "<td width=\"170\" align=\"right\">({$kart["$counter"]['item_amount']} x)&nbsp; <b>$total &euro;</b></td></tr></table>\n";
            }
          echo "<hr style=\"color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:left;\">\n";
          $show_kart_total = number_format($kart_total, 2, '.', ' ');
          echo "<table width=\"200\" border=\"0\" bgcolor=\"#544a31\"><tr><td align=\"right\"><b>$show_kart_total &euro;</b></td></tr></table>\n";
          
          if ($country == "" or $country == "0") 
            {
             if ($lang == "english") 
               {
                echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
                echo "<select name=\"country\" size=\"1\" onchange=\"self.location='kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;country='+this.selectedIndex\">\n";
                echo "<option value=\"\" selected=\"selected\">Select country!</option>\n";  /* index = 0 */
                echo "<option value=\"Germany\">Germany</option>\n";             /* index = 1 */
                echo "<option value=\"GreatBritain\">Great Britain</option>";        /* index = 2 */
                echo "<option value=\"Poland\">Poland</option>";                     /* index = 3 */
                echo "<option value=\"USA\">USA</option>";                           /* index = 4 */
                echo "<option value=\"other\">other</option>";                      /* index = 5 */
                echo "</select></td></tr></table>\n";
               }
             else 
               {
                echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
                echo "<select name=\"country\" size=\"1\" onchange=\"self.location='kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;country='+this.selectedIndex\">\n";
                echo "<option value=\"\" selected=\"selected\">W&auml;hle Land!</option>\n";  /* index = 0 */
                echo "<option value=\"Germany\">Deutschland</option>\n";             /* index = 1 */
                echo "<option value=\"GreatBritain\">Gro&szlig;britannien</option>";        /* index = 2 */
                echo "<option value=\"Poland\">Polen</option>";                     /* index = 3 */
                echo "<option value=\"USA\">USA</option>";                           /* index = 4 */
                echo "<option value=\"other\">Anderes</option>";                      /* index = 5 */
                echo "</select></td></tr></table>\n";
               }
            }
          else
            {
             echo "<table width=\"200\" border=\"0\" bgcolor=\"#544a31\"><tr><td align=\"left\" width=\"140\"><a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;country=remove\" target=\"kart\">";
             if ($country == "Germany") { $shipcost = "1.45"; } else $shipcost = "3.45";
             if ($lang == "english") 
               {
                if ($country == "Germany") $country_trans = $country;
                if ($country == "Great Britain") $country_trans = $country;
                if ($country == "Poland") $country_trans = $country;
                if ($country == "USA") $country_trans = $country;
                echo "Shipping $country_trans";
               }
             else 
               {
                if ($country == "Germany") $country_trans = "Deutschland";
                if ($country == "Great Britain") $country_trans = "Gro&szlig;britannien";
                if ($country == "Poland") $country_trans = "Polen";
                if ($country == "USA") $country_trans = $country;
                echo "Versand $country_trans";
               }
             echo "</a></td><td align=\"right\" width=\"60\">+ $shipcost &euro;</td></tr></table>\n";
            }

           if ($opt == "" or !isset($opt))
           {
            echo "<table width=\"200\" border=\"0\"><tr><td align=\"left\">\n";
            echo "<select name=\"payment\" size=\"0\" onchange=\"self.location='kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;opt='+this.selectedIndex\">";
            if ($lang == "english")
             {
                echo "<option value=\"Bank Transfer\" selected=\"selected\">Choose payment!</option>";
                echo "<option value=\"Bank Transfer\">Bank Transfer (+ 0.00 &euro;)</option>";
                echo "<option value=\"PayPal\">PayPal (+ 1.13 &euro;)</option>";
                echo "<option value=\"Pay On Delivery\">Pay on delivery (+ 5.65 &euro;)</option>";
             }
            else
             {
                echo "<option value=\"Bank Transfer\" selected=\"selected\">W&auml;hle Zahlung!</option>";
                echo "<option value=\"Bank Transfer\">&Uuml;berweisung (+ 0.00 &euro;)</option>";
                echo "<option value=\"PayPal\">PayPal (+ 1.13 &euro;)</option>";
                echo "<option value=\"Pay On Delivery\">Nachnahme (+ 5.65 &euro;)</option>";
             }
            echo "</select></td></tr></table>\n";
           }
          else
           {
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
            echo "<table width=\"200\" border=\"0\" bgcolor=\"#544a31\"><tr><td align=\"left\"><a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=addopt&amp;opt=remove\" target=\"kart\">";
            echo "$payment</a></td><td align=\"right\">+ $transfercost &euro;</td></tr></table>\n";
           }
          echo "<hr style=\"color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:left;\">\n";
          echo "<table width=\"200\" border=\"0\" bgcolor=\"#544a31\"><tr><td align=\"left\">";
          if ($lang == "english") $alt = "reset shopping kart"; else $alt = "Verwerfe Warenkorb";
          echo "<a href=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=reset\" target=\"kart\"><img src=\"pics/del.png\" alt=\"$alt\" title=\"$alt\"></a> ";
          $complete = $kart_total + $transfercost + $shipcost; $complete = number_format($complete, 2, '.', ' ');
          if ($lang == "english") echo " Total:</td><td align=\"right\">";
          else echo " Gesamt:</td><td align=\"right\">";
          echo "<b>$complete &euro;</b></td></tr></table>\n</font>\n";
          echo "<hr style=\"color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:left;\">\n";
          

/* Check, if all userdata is already received. If all is there,change enter data to change data AND display BUY-link below the kart-list! */
          $datamissing = "0";
          if($country == "") $datamissing = "1";
          if($opt == "") $datamissing = "1";
          if($firstname == "") $datamissing = "1";
          if($lastname == "") $datamissing = "1";
          if($adress1 == "") $datamissing = "1";
          if($plz == "") $datamissing = "1";
          if($city == "") $datamissing = "1";
          if($email == "") $datamissing = "1";

          if ($datamissing == "0")
            {
             echo "<table width=\"100%\"><tr><td align=\"right\">\n";
             echo "<font size=\"3\">\n<a href=\"order.php?lang=$lang&amp;kartid=$kartid\" target=\"shop\"><b>";
             if ($lang == "english") { echo "Change shipping data"; $finalbuy = " Finally buy! >>> "; }  /* Spracheinstellung  */
             else { echo "Adresse &auml;ndern"; $finalbuy = " Jetzt kaufen! >>> "; }
             echo "</b></a>\n</font><br>\n";
             echo "<form action=\"orderaction.php\" target=\"shop\" method=\"post\" accept-charset=\"UTF-8\">\n";
             echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
             echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
             echo "<input type=\"submit\" value=\"$finalbuy\">\n";
            }
          else
            {
             echo "<table width=\"100%\"><tr><td align=\"right\">\n";
             echo "<font size=\"3\">\n<a href=\"order.php?lang=$lang&amp;kartid=$kartid\" target=\"shop\"><b>";
             if ($lang == "english") { echo "Enter shipping data"; }  /* Spracheinstellung  */
             else { echo "Adresse angeben"; }
             echo "</b></a>\n</font><br>\n";
            }
         }
      ?>
  </font></em>
</td>
</tr>
</table>
</body>
</html>
