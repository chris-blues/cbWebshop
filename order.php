<?php
include('conf/shop_conf.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');
include('conf/countries.php');
include('header_short.html');
$lang = $_GET["lang"];
$kartid = $_GET["kartid"];

/* ######################################################## */

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
$kartmode = "order";
include('read_kartfile.php');

/* ################################################################### */

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
echo "<body align=\"center\" valign=\"top\" bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "{$conf["font_style"]}<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\" color=\"{$conf["color"]}\">\n";
echo "<table width=\"540\" height=\"600\" border=\"0\" align=\"center\" valign=\"top\" bgcolor=\"{$conf["bgcolor"]}\">\n";
?>


  <tr>
    <td align="justify" valign="top">
      <?php
        echo "{$loc_lang["explain_order_form_1"]}<br>\n<br>\n";
        echo "<form action=\"kartline.php?kartid=$kartid&amp;lang=$lang&amp;job=adduserdata\" id=\"submit_shipping_data\" method=\"post\" accept-charset=\"UTF-8\" target=\"kart\">\n";
        echo "<table align=\"center\" valign=\"top\" border=\"0\" bgcolor=\"{$conf["bgcolor"]}\">\n";
      ?>
        <tr>
          <td align="right">
            <?php echo $loc_lang["first_name"]; ?>
          </td>
          <td width="300">
            <input maxlength="100" size="20" name="firstname"<?php echo "$firstname"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["last_name"]; ?>
          </td>
          <td width="300">
            <input maxlength="100" size="20" name="lastname"<?php echo "$lastname"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["street"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="adress1"<?php echo "$adress1"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["address_2"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="adress2"<?php echo "$adress2"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["zip"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="plz"<?php echo "$plz"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["city"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="city"<? echo "$city"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["province"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="province"<?php echo "$province"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["country"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="countryname"<?php echo " value=\"$countryname\""; ?> onblur="this.form.submit();">
          </td>
        </tr>
        
        <tr>
          <td align="right">
            Email: 
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="email"<?php echo "$email"; ?> onblur="this.form.submit();">
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <?php if ($newsletter == "ja") $checked = " checked=\"checked\""; else $checked = "";
              echo"<input type=\"checkbox\" name=\"newsletter\" value=\"ja\"$checked onchange=\"this.form.submit();\">\n";
              echo "{$loc_lang["join_newsletter"]}\n";
              echo "</td></tr></table>\n";
              echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
              echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
              echo "<table width=\"100%\"><tr><td align=\"center\" bgcolor=\"#544a31\">";
              echo "<a href=\"javascript:\" onclick=\"document.getElementById('submit_shipping_data').submit();\"><b>{$loc_lang["submit_data"]}</b></a>\n";
              echo "</td></tr><tr><td align=\"justify\"><br>";
              echo $loc_lang["once_money_arrived"];
              echo "</td></tr></table></form>";
            ?>
    </td>
  </tr>
</table>
</font>
<?php echo "{$conf["font_style_close"]}\n"; ?>
</body>
</html>
