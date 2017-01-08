<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<!-- You should edit the next 2 lines, to include your site's CSS here  -->
<!--link rel="stylesheet" media="(min-width: 1024px)" href="../musicchris.css" type="text/css">
<link rel="stylesheet" media="(max-width: 1023px)" href="../musicchris-mobile.css" type="text/css"-->

<!-- These 2 lines you should keep! Edit only if you use different paths. -->
<link rel="stylesheet" media="(min-width: 1024px)" href="shop/shop.css" type="text/css">
<link rel="stylesheet" media="(max-width: 1023px)" href="shop/shop-mobile.css" type="text/css">

<!-- This adds nice visual efects to the shop. -->
<script type="text/javascript" src="shop/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="../fancybox-2.1.5/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../fancybox-2.1.5/source/jquery.fancybox.css?v=2.1.5" media="screen">
<script type="text/javascript" src="../fancybox-2.1.5/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="../fancybox-2.1.5/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="../fancybox-2.1.5/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="../js/fancybox-settings.js"></script>

</head>
<body>

<?php
$lang = $_GET["lang"];      // This gets the language from the URL. E.g. index.php?lang=english
$debug = $_GET["debug"];

if (!isset($debug) or $debug == "") $debug = false;
else $debug = true;

if ($debug) $debugCall = "&debug=true";
else $debugCall = "";

$availableLanguages = scandir("shop/locale");
foreach ($availableLanguages as $key => $value)
  {
   if ($value == "." or $value == ".." or is_file("shop/locale/$value")) { unset($availableLanguages[$key]); continue; }
   echo "  <a href=\"shop.php?lang={$value}{$debugCall}\">$value</a>";
  }
echo "<br>\n";

// ##### Set or keep shopping-kart's id #####
// You'll need this, to keep the shopping kart while browsing the rest of your site. This will
// result in sth like: index.php?kartid=20140101123456
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; } // Look, if we already got a kart-ID
else { $kartid = date("YmdHis");                           // If not, create one!
$kartid = hash('md5', $kartid); }                       // Create a unique hash from the date.
// ##### Set or keep shopping-kart's id #####

include('shop/shop.php');             // Now finally, load the shop.
?>
</body>
</html>
