<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('../conf/item_conf.php');
include('header_full.html');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n<font face=\"\" size=\"\">";
echo "<center><h2>{$loc_lang["admin_itemsettings"]}</h2>\n";
echo "{$loc_lang["admin_editcarefully"]} <a href=\"help_item.png\" class=\"fancy\"><img src=\"../pics/ask.png\"><b> {$loc_lang["admin_help"]}</b></a></center><br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=item\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach ($item_conf as $key => $value)
  {
      $count++;
      echo "  <tr><td>$count:$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"$value\" type=\"text\" size=\"30\"></td></tr>\n";
  }
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \"></td></tr>\n";
echo "</table>\n</form>\n</font>\n";
// echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
</body>
</html>
