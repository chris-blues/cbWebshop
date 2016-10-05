<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_full.html');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<center><br><font size=\"5\"><b>{$loc_lang["admin_editlang"]}</b></font><br><br>\n{$loc_lang["admin_notelangfile"]}<br><br>\n<hr>\n<br><br>\n";

// Prepare Array for POST + add input fields for new types + hide unnecessary fields
echo "<form action=\"save_settings.php?job=shop\" method=\"post\" accept-charste=\"UTF-8\">\n";
foreach ($conf as $key => $value)
  {
   if ($key == "lang")
     {
      echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
      foreach($conf["$key"] as $key2 => $value2)
        {
         $count++;
         echo "  <tr><td>$count:$key - $key2:</td><td> <input name=\"$key$key2\" value=\"$value2\" type=\"text\" size=\"30\"><button type=\"button\" name=\"remove\" value=\"$key$key2\" onclick=\"this.form.$key$key2.value='';\"> {$loc_lang["admin_remove"]} </button></td></tr>\n";
        }
      $count++; $key2++;
      echo "  <tr><td>$count:$key - $key2:</td><td> <input name=\"$key$key2\" value=\"\" type=\"text\" size=\"30\"></td></tr>\n";
      echo "</table>\n";
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
   if ($key != "lang" and $key != "item_type")
     {
      $count++;
      echo "<input name=\"$key\" value=\"$value\" type=\"hidden\">\n";
     }
  }

echo "<button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \">\n</form>\n<br>\n<hr>\n<br>\n";
// echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
</center>
</body>
</html>
