<?php
include('shop/conf/shop_conf.php');
include('shop/conf/cost_conf.php');
include('shop/conf/payment_conf.php');
include('shop/conf/countries.php');
//include('header_short.html');
if ($lang == "" or !isset($lang)) $lang = $_GET["lang"];
if ($kartid == "" or !isset($kartid)) $kartid = $_GET["kartid"];

/* ######################################################## */

define( "LOC_LANG", $lang );
include('shop/locale/' . LOC_LANG . '.php');
$kartmode = "order";
include('shop/read_kartfile.php');

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

/* ################################################################### */
// Begin Output:
?>
<div class="shop-content" id="orderform">
<table border="0">
  <tr>
    <td align="justify" valign="top">
      <?php
      if ($conf["surpress_ssl_warning"] != "TRUE")
       {
        if (!isset($_SERVER[HTTPS]) or $_SERVER[HTTPS] == "")
          {
           echo "<p style=\"font-weight: bold;\">" . $loc_lang["ssl_off"] . "\n";
           ?>
           <form action="https://<?php echo $_SERVER["HTTP_HOST"] . "/" . $conf["callup"]; ?>" method="get" accept-charset="UTF-8">
           <?php foreach($conf["call"] as $call => $value) { ?>
             <input type="hidden" name="<?php echo $call; ?>" value="<?php echo $value; ?>">
            <?php } ?>
             <input type="hidden" name="display" value="order">
             <input type="submit" value="<?php echo $loc_lang["encrypt"]; ?>">
           </form></p>
           
           <?php
          }
        else { ?> <img src="pics/ssl20.png" style="vertical-align: middle;" alt="<?php echo $loc_lang["ssl_on"]; ?>" title="<?php echo $loc_lang["ssl_on"]; ?>"><br> <?php }
       }
        echo "{$loc_lang["explain_order_form_1"]}<br>\n<br>\n";
        echo "<form action=\"index.php?page=shop&amp;kartid=$kartid&amp;lang=$lang&amp;job=adduserdata&amp;kart=show\" id=\"submit_shipping_data\" method=\"post\" accept-charset=\"UTF-8\" target=\"_top\">\n";
        echo "<table border=\"0\">\n";
      ?>
        <tr>
          <td align="right">
            <?php echo $loc_lang["first_name"]; ?>
          </td>
          <td width="300">
            <input maxlength="100" size="20" name="firstname"<?php echo "$firstname"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["last_name"]; ?>
          </td>
          <td width="300">
            <input maxlength="100" size="20" name="lastname"<?php echo "$lastname"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["street"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="adress1"<?php echo "$adress1"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["address_2"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="adress2"<?php echo "$adress2"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["zip"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="plz"<?php echo "$plz"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["city"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="city"<? echo "$city"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["province"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="province"<?php echo "$province"; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            <?php echo $loc_lang["country"]; ?>
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="countryname"<?php echo " value=\"$countryname\""; ?>>
          </td>
        </tr>
        
        <tr>
          <td align="right">
            Email: 
          </td>
          <td align="left">
            <input maxlength="100" size="20" name="email"<?php echo "$email"; ?>>
          </td>
        </tr>
      </table>
            <?php
              echo "<input type=\"hidden\" name=\"newsletter\" value=\"nein\">\n";
              echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
              echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
              echo "<table width=\"100%\"><tr><td align=\"center\" width=\"50%\">\n";
              echo "<a target=\"_top\" href=\"{$conf["callup"]}{$link}\"><b>{$loc_lang["back_to_shop"]}</b></a></td>\n";
              echo "<td align=\"center\" width=\"50%\">\n";
              echo "<a href=\"javascript:\" onclick=\"document.getElementById('submit_shipping_data').submit();\" target=\"_top\"><b>{$loc_lang["submit_data"]}</b></a>\n";
              echo "</td></tr><tr><td align=\"justify\" colspan=\"2\"><br>";
              //echo $loc_lang["once_money_arrived"];
              echo "</td></tr></table></form>";
            ?>
    </td>
  </tr>
</table>
</div>
