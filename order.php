<?php
include('../header.html');
$lang = $_GET["lang"];
$kartid = $_GET["kartid"];

/* ######################################################## */

/* Lese karttmpfile und Erzeuge Array Kart[1][item_sth] */
$kartfile = "tmp/kart-$kartid.tmp";
$karthandle = fopen($kartfile, "r");
$kartamount = "0";
$kart_total = "0";
if ($karthandle != NULL)
 {
  $buffer = fgets($karthandle); $country = trim($buffer,"\n");
  $buffer = fgets($karthandle); $opt = trim($buffer,"\n");
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["firstname"])) $firstname = " style=\"background-color:#FF4B4B;\""; else { $firstname = trim($buffer,"\n"); $firstname = " value=\"$firstname\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["lastname"])) $lastname = " style=\"background-color:#FF4B4B;\""; else { $lastname = trim($buffer,"\n"); $lastname = " value=\"$lastname\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["adress1"])) $adress1 = " style=\"background-color:#FF4B4B;\""; else { $adress1 = trim($buffer,"\n"); $adress1 = " value=\"$adress1\""; }
  $buffer = fgets($karthandle); $adress2 = trim($buffer,"\n"); $adress2 = " value=\"$adress2\"";
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["plz"])) $plz = " style=\"background-color:#FF4B4B;\""; else { $plz = trim($buffer,"\n"); $plz = " value=\"$plz\""; }
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["city"])) $city = " style=\"background-color:#FF4B4B;\""; else { $city = trim($buffer,"\n"); $city = " value=\"$city\""; }
  $buffer = fgets($karthandle); $province = trim($buffer,"\n"); $province = " value=\"$province\"";
  $buffer = fgets($karthandle); if ($_GET["errorreturn"] == "1" and isset($_GET["email"])) $email = " style=\"background-color:#FF4B4B;\""; else { $email = trim($buffer,"\n"); $email = " value=\"$email\""; }
  $buffer = fgets($karthandle); $newsletter = trim($buffer,"\n");
  while (!feof($karthandle))
   {
    $kartamount++;
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_id'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_type'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_preis'] = trim($buffer,"\n");
    $buffer = fgets($karthandle); $kart["$kartamount"]['item_amount'] = trim($buffer,"\n");
   }
 }
fclose($karthandle);
chmod($kartfile, 0777);
$kartamount--;
if ($kartamount < 1) $kartamount = "0";

/* ################################################################### */

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

?>
<body align="center" valign="top" bgcolor="#544a31">
<em><font face="Georgia" size="3" color="#000000">
<table width="540" height="600" border="0" align="center" valign="top" bgcolor="#544a31">
  <tr>
    <td align="justify" valign="top">
      <?php
        if ($lang == "english")
          {
           echo "Now we need to know, where we shall send the order. You still can make changes to the contents of the shopping kart!<br>\n<br>\n";
          }
        else
          {
           echo "Jetzt m&uuml;ssen wir nur noch erfahren wohin die Bestellung geschickt werden soll. Sie k&ouml;nnen immer noch &Auml;nderungen am Warenkorb vornehmen!<br>\n<br>\n";
          }
      ?>
      <table align="center" valign="top" border="0" bgcolor="#544a31">
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "First name: \n";
                  else echo "Vorname: \n";
            ?>
          </td>
          <td width="300">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="firstname"<?php echo "$firstname"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "Last name: ";
                  else echo "Nachname: ";
            ?>
          </td>
          <td width="300">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="lastname"<?php echo "$lastname"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "Street No: "; 
                  else echo"Strasse Nr: "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="adress1"<?php echo "$adress1"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "Adress line 2: (optional) "; 
                  else echo"Zusatz: (optional) "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="adress2"<?php echo "$adress2"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "ZIP: "; 
                  else echo"PLZ: "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="plz"<?php echo "$plz"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "City: "; 
                  else echo"Stadt: "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="city"<? echo "$city"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "Province: (optional) "; 
                  else echo "Land/Provinz: (optional) "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="province"<?php echo "$province"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php if ($lang == "english") echo "Country: "; 
                  else echo"Staat: "; ?>
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="country"<?php echo " value=\"$country\""; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            Email: 
          </td>
          <td align="left">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n"; ?>
            <input maxlength="100" size="20" name="email"<?php echo "$email"; ?> onblur="this.form.submit();">
            </form>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <?php echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata&amp;newsletter=changed\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n";
                  if ($newsletter == "ja") $checked = " checked=\"checked\""; else $checked = "";
                  if ($lang == "english") { echo"<input type=\"checkbox\" name=\"newsletter\" value=\"ja\"$checked onchange=\"this.form.submit();\">\n";
                                            echo "I want to sign in to the Folkadelic Newsletter!\n"; }
                  else { echo "<input type=\"checkbox\" name=\"newsletter\" value=\"ja\"$checked onchange=\"this.form.submit();\">\n";
                         echo "Ich m&ouml;chte in den Folkadelic Newsletter eingetragen werden!\n"; }
            echo "</form></td></tr></table>\n";
       echo "<form action=\"orderaction.php\" method=\"post\" accept-charset=\"UTF-8\" target=\"shop\">\n";
       echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
       echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
       echo "<table width=\"100%\"><tr><td align=\"center\" bgcolor=\"#544a31\">";
       if ($lang == "english") echo "<input type=\"submit\" value=\" >>> Buy now! \">\n";
       else echo "<input type=\"submit\" value=\" >>> Jetzt kaufen! \"><br>\n";
       echo "</td></tr><tr><td align=\"justify\"><br>";
       if ($lang == "english") echo "Once you press the button 'buy now' the order will be sent.<br>\nOnce your money is received, the package will be sent on its way to you!<br>";
       else echo "Wenn Sie den Knopf 'Jetzt kaufen' dr&uuml;cken wird die Bestellung abgeschickt. Sobald Ihr Geld uns erreicht hat werden wir das Paket auf Reisen schicken!<br>";
       
       echo "</td></tr></table>";
            ?>
    </td>
  </tr>
</table>
</font>
</em>
</body>
</html>
