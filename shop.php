<!-- Begin shop/shop.php -->
<?php
if ($debug)
  {
   error_reporting(E_ALL & ~E_NOTICE);
   ini_set("display_errors", 1);
  }
else
  {
   error_reporting(0);
   ini_set("display_errors", 0);
  }
ini_set("log_errors", 1);
ini_set("error_log", "/www/admin/logs/php-error.log");

include('conf/shop_conf.php');
include('conf/countries.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');

$link = "?";
foreach($conf["call"] as $call => $value)
  {
   $link .= "{$call}={$value}&amp;";
  }

foreach($conf["call"] as $call => $value)
  {
   $value = str_replace('\$','$',$value);
  }

include("locale/$lang.php");
include('read_index.php');

//echo "DEBUG shop.php:<br>\nlang: $lang - \$conf[call][lang]: {$conf[call][lang]}<br>\nkartid: $kartid<br>\n<br>\n";

?>
<div class="content" id="shop-main">
  <div class="sidebar" id="sidebar">
    <div class="kart" id="container">
      <?php include('kartline.php'); ?>
    </div>
  </div>
  <div class="shop-content container" name="shop" id="shopframe">
    <?php
      if ($_GET["display"] == "order") { $displayswitch = "1"; include('shop/order.php'); }
      if ($_GET["display"] == "orderaction") { $displayswitch = "1"; include('shop/orderaction.php'); }
      if ($_GET["display"] == "leaveshop") { $displayswitch = "1"; include('shop/leaveshop.php'); }
      if ($displayswitch != "1") { include('shopcontent.php'); }
    ?>
  </div>

</div>
<!-- End shop/shop.php -->
<?php //echo "<pre>"; print_r($conf); echo "</pre>\n"; ?>
