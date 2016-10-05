<!-- Begin shop/shop.php -->
<?php
include('conf/shop_conf.php');
include('conf/item_conf.php');
include('conf/countries.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');

if ($lang == "" or !isset($lang)) $lang = $conf["_default_lang"];
define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');

// ##### Set or keep shopping-kart's id #####
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; }
else { $kartid = date("YmdHis"); }
// ##### Set or keep shopping-kart's id #####

//echo "DEBUG shop.php:<br>\nlang: $lang<br>\nkartid: $kartid<br>\n<br>\n";

?>
<div class="content" id="shop-main">
  <div class="sidebar" id="sidebar">
    <div class="kart" id="container">
      <?php include('kartline.php'); ?>
    </div>
  </div>

  <div class="shop-content container shadow" name="shop" id="shopframe">
    <?php 
      if ($_GET["display"] == "order") { $displayswitch = "1"; include('shop/order.php'); }
      if ($_GET["display"] == "orderaction") { $displayswitch = "1"; include('shop/orderaction.php'); }
      if ($_GET["display"] == "leaveshop") { $displayswitch = "1"; include('shop/leaveshop.php'); }
      if ($displayswitch != "1") { include('shopcontent.php'); }
    ?>
  </div> 

</div>
<!-- End shop/shop.php -->
