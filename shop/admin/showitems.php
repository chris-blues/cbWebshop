<?php
$debug = $_GET["debug"];
if (isset($debug) and $debug == "true") $debug = true;
else $debug = false;

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
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

putenv('LC_MESSAGES=' . $locale);
setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
if ($debug) echo "locale: $locale<br>\n";
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
//include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
echo "<body>\n";

$modus = "simple";
include('read_index.php');

echo "<table align=\"center\" border=\"0\">\n<tr>\n";
/* Tabelleninhalt */
$cols = "0";
for ($c=1; $c <= $counter; $c++)
 {
  $cols++;
  echo "  <td width=\"180\" height=\"225\" align=\"center\" valign=\"center\"><b>$c - {$data[$c]['item_name']}</b><br>\n";
  echo "    <a href=\"viewitem.php?c=$c\">\n";
  echo "    <img src=\"../items/pics/{$data[$c]['item_id']}.png\" height=\"100\" border=\"0\"></a><br>\n";
  echo "    <form name=\"item-$c\" action=\"viewitem.php?c=$c\" method=\"post\" accept-charset=\"UTF-8\">\n";
  echo "    <input type=\"submit\" value=\"" . gettext("edit this item") . "\"></form>\n</td>\n";
  if ($cols == "4") echo "</tr>\n<tr>\n";
 }
?>
  </tr>  
</table>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
