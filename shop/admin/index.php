<?php

// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   default: { $lang = "en"; break; }
  }
$directory = $cbPlayer_dirname . '/locale';
$domain = 'cbplayer';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($domain, $directory);
textdomain($domain);
bind_textdomain_codeset($domain, 'UTF-8');
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
?>
<body>
<table border="0" align="center" width="99%" height="99%">
  <tr>
    <td colspan="2" align="center">
      <font size="5"><b><?php echo gettext("Shop Admin Tools"); ?></b></font><br>
      <hr>
    </td>
  </tr>
  <tr height="99%">
    <td align="center" width="200">
      <iframe name="shop-menu" src="shopadminmenu.php" width="200" height="700" scrolling="auto" frameborder="0"></iframe>
    </td>
    <td align="center" valign="top" height="99%">
      <iframe name="shop-admin" src="showitems.php" width="99%" height="99%" scrolling="auto" frameborder="0"></iframe>
    </td>
  </tr>
</table>
</body>
</html>
