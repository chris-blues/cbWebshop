<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('../conf/cost_conf.php');
include('../conf/countries.php');
include('header_short.php');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<center><h2>{$loc_lang["admin_edit_costs"]}</h2>\n";
echo "{$loc_lang["admin_editcarefully"]} {$loc_lang["admin_usedots"]}</center><br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=cost\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach($cost as $key => $value)
  {
   if ($key == "_homecountry")
     {
      $count++;
      echo "  <tr><td>{$loc_lang["admin_yourhomecountry"]}</td><td colspan=\"2\"> <select name=\"$key\" size=\"1\">\n";
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
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \"></td></tr>\n";
?>
</table>
</form>
</body>
</html>
