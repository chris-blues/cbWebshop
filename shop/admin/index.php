<?php
$debug = $_GET["debug"];
if (isset($debug) and $debug == "true") $debug = true;
else $debug = false;

$debug = false;

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
   case 'de': { $lang = "de"; break; }
   case 'en': { $lang = "en"; break; }
   case 'fr': { $lang = "fr"; break; }
   default: { $lang = "de"; break; }
  }
$cbWebshop_dirname = getcwd();
$directory = "{$cbWebshop_dirname}/../locale";
$gettext_domain = 'cbWebshop';
$locale = "$lang"; echo "<!-- locale set to => $locale -->\n";

putenv('LC_MESSAGES=' . $locale);
setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
?>
<body>
  <h1 id="shopAdminTools"><?php echo gettext("Shop Admin Tools"); ?></h1>
  <div id="adminContentWrapper">
    <?php include("shopadminmenu.php"); ?>

    <iframe name="shop-admin" src="showitems.php" id="adminContentFrame" class="shadow" scrolling="auto" frameborder="0"></iframe>
  </div>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
