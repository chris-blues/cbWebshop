<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_full.html');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n<font face=\"\" size=\"\">";
echo "<center><br><font size=\"5\"><b>{$loc_lang["admin_edit_itemtypes"]}</b></font><br><br>\n{$loc_lang["admin_willshowup"]}<br><br>\n<hr>\n<br><br>\n";

// Prepare Array for POST + add input fields for new types + hide unnecessary fields
echo "<form action=\"save_settings.php?job=shop\" method=\"post\" accept-charste=\"UTF-8\">\n";
$cat01 = "music";
$cat02 = "clothing";
foreach ($conf as $key => $value)
  {
   if ($key == "item_type")
     {
      echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
      foreach($conf["item_type"] as $key2 => $value2)
        {
         $count++;
         echo "  <tr><td align=\"right\">$key - $key2:</td><td align=\"left\"> <input name=\"{$key}{$key2}_name\" value=\"{$conf[$key][$key2]["name"]}\" type=\"text\" size=\"15\">\n";
         echo "    <select name=\"{$key}{$key2}_cat\" size=\"1\">\n";
         echo "      <option value=\"\">=category=</option>\n";
         if ($conf[$key][$key2]["cat"] == $cat01) echo "      <option selected=\"selected\" value=\"$cat01\">{$loc_lang["admin_cat_music"]}</option>\n"; else echo "      <option value=\"$cat01\">{$loc_lang["admin_cat_music"]}</option>\n";
         if ($conf[$key][$key2]["cat"] == $cat02) echo "      <option selected=\"selected\" value=\"$cat02\">{$loc_lang["admin_cat_clothing"]}</option>\n"; else echo "      <option value=\"$cat02\">{$loc_lang["admin_cat_clothing"]}</option>\n";
         echo "    </select>\n";
         echo "    <button type=\"button\" name=\"remove\" value=\"$key$key2\" onclick=\"this.form.{$key}{$key2}_name.value=''; this.form.{$key}{$key2}_cat.value=''\"> {$loc_lang["admin_remove"]} </button></td></tr>\n";
        }
      $count++;
      echo "  <tr><td>$key - $count:</td><td> <input name=\"{$key}{$count}_name\" type=\"text\" size=\"15\">";
      echo "    <select name=\"{$key}{$count}_cat\" size=\"1\">\n";
      echo "      <option value=\"\">=category=</option>\n";
      echo "      <option>$cat01</option>\n";
      echo "      <option>$cat02</option>\n";
      echo "    </select>\n</td></tr>\n";
      echo "</table>\n";
     }
   if ($key == "lang")
     {
      foreach($conf["$key"] as $key2 => $value2)
        {
         echo "<input name=\"$key$key2\" value=\"$value2\" type=\"hidden\">\n";
        }
     }
   if ($key != "lang" and $key != "item_type")
     {
      echo "<input name=\"$key\" value=\"$value\" type=\"hidden\">\n";
     }
  }
echo "<button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \">\n</form>\n<br>\n";
// echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
</center>
</body>
</html>
