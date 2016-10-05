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
           echo "<p style=\"font-weight: bold;\">" . gettext("This connection is NOT encrypted with SSL! I strongly recommend: do NOT send your private data through an unencrypted connection!") . "\n";
           ?>
           <form action="https://<?php echo $_SERVER["HTTP_HOST"] . "/" . $conf["callup"]; ?>" method="get" accept-charset="UTF-8">
           <?php foreach($conf["call"] as $call => $value) { ?>
             <input type="hidden" name="<?php echo $call; ?>" value="<?php echo $value; ?>">
            <?php } ?>
             <input type="hidden" name="display" value="order">
             <input type="submit" value="<?php echo gettext("Encrypt now!"); ?>">
           </form></p>
           
           <?php
          }
        else { ?> <img src="pics/ssl20.png" style="vertical-align: middle;" alt="<?php echo gettext("This connection is encrypted with SSL."); ?>" title="<?php echo gettext("This connection is encrypted with SSL."); ?>"><br> <?php }
       }
        echo gettext("Now we need to know, where we shall send the order. You still can make changes to the contents of the shopping kart!") . "<br>\n<br>\n";
        echo "<div class=\"orderdata\">\n";
        echo "<form action=\"{$conf["callup"]}{$link}job=adduserdata&amp;kart=show\" id=\"submit_shipping_data\" method=\"post\" accept-charset=\"UTF-8\" target=\"_top\">\n";
      ?>
            <div class="orderline"><?php echo gettext("First name: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="firstname"<?php echo "$firstname"; ?>></div><br>
            <div class="orderline"><?php echo gettext("Last name: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="lastname"<?php echo "$lastname"; ?>></div><br>
            <div class="orderline"><?php echo gettext("Street No: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="adress1"<?php echo "$adress1"; ?>></div><br>
            <div class="orderline"><?php echo gettext("Adress line 2: (optional) "); ?></div><div class="orderline"><input maxlength="100" size="20" name="adress2"<?php echo "$adress2"; ?>></div><br>
            <div class="orderline"><?php echo gettext("ZIP: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="plz"<?php echo "$plz"; ?>></div><br>
            <div class="orderline"><?php echo gettext("City: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="city"<? echo "$city"; ?>></div><br>
            <div class="orderline"><?php echo gettext("Province: (optional) "); ?></div><div class="orderline"><input maxlength="100" size="20" name="province"<?php echo "$province"; ?>></div><br>
            <div class="orderline"><?php echo gettext("Country: "); ?></div><div class="orderline"><input maxlength="100" size="20" name="countryname"<?php echo " value=\"$countryname\""; ?>></div><br>
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
              echo "  <input type=\"submit\" value=\"&lt;&lt;&lt; " . gettext("Back to shop") . "\" title=\"" . gettext("Back to shop") . "\">\n";
              echo "</form></div>\n";
              echo "<div class=\"orderbuttons\">";
              echo "<input type=\"button\" value=\" " . gettext("Submit data!") . " &gt;&gt;&gt; \" onclick=\"document.getElementById('submit_shipping_data').submit();\" title=\"" . gettext("Submit data!") . "\"></div>\n";
            ?>
     </div>
     <div class="clear notes" style="padding-top: 25px;"><?php echo gettext("Your data will not be shared with anybody! We only use it to label your package, so that it will find you. We store your data only for a short time, in order to be able to respond, if there should be something wrong with your shipment. This data is stored in our email-account, so no one else will have access to it. The data stored on our server is deleted, as soon as the order has been made."); ?></div>
</div>
