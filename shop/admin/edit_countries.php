<?php

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
$directory = $cbWebshop_dirname . '/../locale';
$gettext_domain = 'cbWebshop';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
//include("../locale/{$conf["_default_lang"]}.php");
include('../conf/countries.php');
include('header_short.php');
echo "<body>\n";
if (!sort($country)) echo "Failed to sort the array \$_POST!<br>\n";
echo "<h2>" . gettext("Edit countries") . "</h2>\n";
echo gettext("These will show up in the kart's shipping-list.") . "<br>\n<hr>\n<br>\n";
echo "<form id=\"saveCountries\" action=\"save_settings.php?job=countries\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<input type=\"hidden\" name=\"refer\" value=\"edit_countries\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach($country as $key => $value)
  {
   $count++;
   echo "  <tr><td>$count:$key:</td><td colspan=\"2\"> <input name=\"country_$key\" class=\"editArrays\" id=\"$key\" value=\"$value\" type=\"text\" size=\"30\"><button type=\"button\" name=\"remove\" value=\"country_$key\" id=\"buttonRemoveRow_$key\" data-id=\"$key\"> " . gettext("Remove") . " </button></td></tr>\n";
  }
$count++;
$key++;
echo "  <tr><td>$count:$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"\" type=\"text\" size=\"30\"></td></tr>\n";
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" " . gettext("Save") . " &gt;&gt;&gt; \"></td></tr>\n";
?>
</table>
</form>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
