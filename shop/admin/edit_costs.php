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
include("../locale/{$conf["_default_lang"]}.php");
include('../conf/cost_conf.php');
include('../conf/countries.php');
include('header_short.php');
echo "<body>\n";
echo "<h2>" . gettext("Edit costs") . "</h2>\n";
echo gettext("Edit carefully!") . " " . gettext("Use dots for decimals (e.g.: 1234.56)") . "<br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=cost\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach($cost as $key => $value)
  {
   if ($key == "_homecountry")
     {
      $count++;
      echo "  <tr><td>" . gettext("Your Home Country:") . "</td><td colspan=\"2\"> <select name=\"$key\" size=\"1\">\n";
      foreach($country as $countryind => $countryname)
        {
         if ($countryname == $cost["_homecountry"]) $selected = " selected=\"selected\""; else $selected = "";
         echo "    <option$selected>$countryname</option>\n";
        }
      echo "  </select></td></tr>\n";
     }
   if ($key != "_homecountry")
     {
      $count++;
      echo "  <tr><td>$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"$value\" type=\"text\" size=\"30\"></td></tr>\n";
     }
  }
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" " . gettext("Save") . " &gt;&gt;&gt; \"></td></tr>\n";
?>
</table>
</form>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
