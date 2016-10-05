<?php
error_reporting(0);
ini_set("display_errors", 0);
ini_set("log_errors", 1);
ini_set("error_log", "/www/admin/logs/php-error.log");

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
<div class="shop-content shadow" id="orderform">
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
        echo "<div class=\"orderdata\">\n";
        echo "<form action=\"{$conf["callup"]}{$link}job=adduserdata&amp;kart=show\" id=\"submit_shipping_data\" method=\"post\" accept-charset=\"UTF-8\" target=\"_top\">\n";
      ?>
            <div class="orderline"><?php echo $loc_lang["first_name"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="firstname"<?php echo "$firstname"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["last_name"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="lastname"<?php echo "$lastname"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["street"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="adress1"<?php echo "$adress1"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["address_2"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="adress2"<?php echo "$adress2"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["zip"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="plz"<?php echo "$plz"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["city"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="city"<? echo "$city"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["province"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="province"<?php echo "$province"; ?>></div><br>
            <div class="orderline"><?php echo $loc_lang["country"]; ?></div><div class="orderline"><input maxlength="100" size="20" name="countryname"<?php echo " value=\"$countryname\""; ?>></div><br>
            <div class="orderline">Email: </div><div class="orderline"><input maxlength="100" size="20" name="email"<?php echo "$email"; ?>></div><br>
            <?php
              echo "<input type=\"hidden\" name=\"newsletter\" value=\"nein\">\n";
              echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
              echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\"></form>\n";
              echo "<div class=\"orderbuttons\">";
              echo "<form action=\"{$conf["callup"]}\" id=\"backtoshop\" method=\"get\">\n";
              foreach ($conf["call"] as $call => $value)
                {
                 echo "  <input type=\"hidden\" name=\"$call\" value=\"$value\">\n";
                }
              echo "  <input type=\"submit\" value=\"{$loc_lang["back_to_shop"]}\" title=\"{$loc_lang["back_to_shop"]}\">\n";
              echo "</form></div>\n";
              echo "<div class=\"orderbuttons\">";
              echo "<input type=\"button\" value=\"{$loc_lang["submit_data"]}\" onclick=\"document.getElementById('submit_shipping_data').submit();\" title=\"{$loc_lang["submit_data"]}\"></div>\n";
            ?>
     </div>
     <div class="clear notes" style="padding-top: 25px;"><?php echo $loc_lang["data_privacy_statement"]; ?></div>
</div>
