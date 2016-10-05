<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('../conf/countries.php');
include('header_short.php');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
if (!sort($country)) echo "Failed to sort the array \$_POST!<br>\n";
echo "<center><h2>{$loc_lang["admin_edit_countries"]}</h2>\n";
echo "{$loc_lang["admin_countries_willshowup"]}</center><br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=countries\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach($country as $key => $value)
  {
   $count++;
   echo "  <tr><td>$count:$key:</td><td colspan=\"2\"> <input name=\"country_$key\" value=\"$value\" type=\"text\" size=\"30\"><button type=\"button\" name=\"remove\" value=\"country_$key\" onclick=\"this.form.country_$key.value='';\"> {$loc_lang["admin_remove"]} </button></td></tr>\n";
  }
$count++;
$key++;
echo "  <tr><td>$count:$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"\" type=\"text\" size=\"30\"></td></tr>\n";
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \"></td></tr>\n";
?>
</table>
</form>
</body>
</html>
