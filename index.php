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

</head>
<body>
<?php
$lang = $_GET["lang"];      // This gets the language from the URL. E.g. index.php?lang=english

// You'll need this, to keep the shopping kart while browsing the rest of your site. This will
// result in sth like: index.php?kartid=20140101123456
// ##### Set or keep shopping-kart's id #####
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; } // Look, if we already got a kart-ID
else { $kartid = date("YmdHis");                           // If not, create one!
$kartid = hash('md5', $kartid); }                       // Create a unique hash from the date.
// ##### Set or keep shopping-kart's id #####

include('shop/shop.php');             // Now finally, load the shop.
?>
</body>
</html>
