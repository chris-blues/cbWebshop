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


// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   case 'en': { $lang = "en_EN"; break; }
   default: { $lang = "en_EN"; break; }
  }
$cbWebshop_dirname = getcwd();
$directory = $cbWebshop_dirname . '/locale';
$gettext_domain = 'cbWebshop';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domainn, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============


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
  <div id="locale_data"
       data-hidedetails="<?php echo gettext("Hide Details"); ?>"
       data-showdetails="<?php echo gettext("Show Details"); ?>"
       data-adminreallydelete="<?php echo gettext("Really delete this item?"); ?>">
  </div>

</div>
<!-- End shop/shop.php -->
<?php if ($debug) { echo "<h2>\$conf</h2><pre>"; print_r($conf); echo "</pre>\n"; } ?>
