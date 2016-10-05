<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_full.html');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
if (!natcasesort($conf["lang"])) echo "Failed to sort the array \$conf[\"lang\"]!<br>\n";
if (!sort($conf["item_type"])) echo "Failed to sort the array \$conf[\"item_type\"]!<br>\n";
echo "<center><h2>{$loc_lang["admin_shopsettings"]}</h2>\n";
echo "{$loc_lang["admin_editcarefully"]} <a href=\"help.png\" class=\"fancy\"><img src=\"../pics/ask.png\"><b> {$loc_lang["admin_help"]}</b></a></center><br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=shop\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
foreach ($conf as $key => $value)
  {
   if ($key == "lang")
     {
      echo "  <tr><td></td><td colspan=\"2\">\n";
      foreach($conf["$key"] as $key2 => $value2)
        {
         $count++;
         echo "    <input name=\"$key$key2\" value=\"$value2\" type=\"hidden\">\n";
        }
      echo "  </td></tr>\n";
     }
   if ($key == "item_type")
     {
      echo "  <tr><td></td><td colspan=\"2\">\n";
      foreach($conf["$key"] as $key2 => $value2)
        {
         foreach($conf[$key][$key2] as $key3 => $value3)
           {
            $count++;
            echo "    <input name=\"{$key}{$key2}_{$key3}\" value=\"$value3\" type=\"hidden\">\n";
           }
        }
      echo "  </td></tr>\n";
     }
   if ($key == "_default_lang")
     {
      echo "  <tr><td>{$loc_lang["admin_defaultlang"]}</td><td colspan=\"2\"><select name=\"_default_lang\" size=\"1\">\n";
      foreach($conf["lang"] as $langind => $langname)
        {
         if ($langname == $conf["_default_lang"]) $selected = " selected=\"selected\""; else $selected = "";
         echo "    <option$selected>$langname</option>\n";
        }
      echo "  </select></td></tr>\n";
     }
   if ($key == "bankaccount_info")
     {
      $count++;
      echo "  <tr><td>{$loc_lang["admin_bankaccount"]}</td><td colspan=\"2\"> <textarea name=\"$key\" cols=\"35\" rows=\"6\">$value</textarea></td></tr>\n";
     }
   if ($key != "lang" and $key != "item_type" and $key != "_default_lang" and $key != "bankaccount_info")
     {
      $count++;
      echo "  <tr><td>$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"$value\" type=\"text\" size=\"30\"></td></tr>\n";
     }
  }
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \"></td></tr>\n";
echo "</table>\n</form>\n";
//echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
</body>
</html>
