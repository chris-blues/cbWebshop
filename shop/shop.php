<!-- Begin shop/shop.php -->
<?php
if ($debug)
  {
//   error_reporting(E_ALL & ~E_NOTICE);
   error_reporting(E_ALL);
   ini_set("display_errors", 1);
  }
else
  {
   error_reporting(0);
   ini_set("display_errors", 0);
  }
ini_set("log_errors", 1);
ini_set("error_log", "admin/logs/php-error.log");


// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   case 'en': { $lang = "en_EN"; break; }
  }

if (isset($_GET["lang"]) and strlen($_GET["lang"]) > 1) $lang = $_GET["lang"];

switch($lang)
  {
   case 'de':      { $lang = "de_DE"; break; }
   case 'de_DE':   { $lang = "de_DE"; break; }
   case 'deutsch': { $lang = "de_DE"; break; }
   case 'en':      { $lang = "en_EN"; break; }
   case 'en_EN':   { $lang = "en_EN"; break; }
   case 'english': { $lang = "en_EN"; break; }
   default:        { $lang = "en_EN"; break; }
  }

$cbWebshop_dirname = getcwd();
$directory = $cbWebshop_dirname . '/shop/locale';
$gettext_domain = 'cbWebshop';
$locale = $lang;// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_ALL, $locale);
bindtextdomain($gettext_domain, $directory);
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

//include("locale/$lang.php");
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

<div id="locale-data"
     data-hideDetails="<?php echo gettext("hide Details"); ?>"
     data-showDetails="<?php echo gettext("show Details"); ?>"
     data-call="<?php echo str_replace("&amp;","&",$conf["callup"]) . $link; ?>">
</div>

<?php if ($_GET["display"] == "orderaction") { ?>
<script type="text/javascript" src="shop/checkout.js"></script>
<?php }
else { ?>
<script type="text/javascript" src="shop/shop.js"></script>
<?php } ?>
<noscript><?php echo gettext("Please activate JavaScript to use this page!"); ?></noscript>

<?php // echo "<!-- \n"; print_r($_GET); echo "\n-->\n"; ?>

<!-- End shop/shop.php -->
