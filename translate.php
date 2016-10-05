<?php
include('header_short.html');
include('conf/shop_conf.php');
if (isset($_GET["opt"]))
  {
   $opt = $_GET["opt"];
   $lang = $conf["lang"][$opt];
  }
echo "<body bgcolor=\"{$conf["bgcolor"]}\"><br>\n<center><br>\n";
echo "{$conf["font_style"]}<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n";
echo "<form action=\"save_new_lang.php\" method=\"post\" accept-charset=\"UTF-8\">\n";
echo "<table width=\"400\"><tr><td align=\"center\">\n";
echo "<select name=\"lang\" size=\"1\" onchange=\"self.location='translate.php?opt='+this.selectedIndex\">\n";
  foreach($conf["lang"] as $key => $value)
    {
     if ($lang == $value) { $selected = " selected=\"selected\""; $lang = $value; }
     else { $selected = ""; }
     if (!isset($lang)) $lang = $conf["_default_lang"];
     echo "<option value=\"$value\"$selected>$value</option>\n";
    }
  echo "</select>\n</td>\n</tr>\n";
define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
echo "<tr><td align=\"justify\">{$loc_lang["translation_base_language"]}<br><br>\n</td>\n</tr>\n";
echo "<tr><td align=\"center\"><input type=\"text\" size=\"46\" name=\"new_lang\">\n</td>\n</tr>\n";
echo "<tr><td align=\"justify\">{$loc_lang["translation_new_language"]}<br><br>\n</td>\n</tr>\n";
echo "<tr><td align=\"center\"><input type=\"text\" size=\"46\" name=\"author\">\n</td>\n</tr>\n";
echo "<tr><td align=\"justify\">{$loc_lang["translation_author"]}\n</td>\n</tr>\n</table><br><br><br>\n";
echo "<table border=\"0\" align=\"center\" width=\"1000\" bgcolor=\"{$conf["bgcolor"]}\" rules=\"rows\">\n";
echo "<tr height=\"30\"><td align=\"center\">{$loc_lang["translation_variable"]}</td><td align=\"center\">{$loc_lang["translation_new_field"]}</td><td align=\"center\">{$loc_lang["translation_template"]}</td></tr>\n";
$count = "0";
foreach($loc_lang as $key => $value)
  {
   if ($key == "mail")
     {
      foreach($loc_lang["mail"] as $key2 => $value2)
        {
         $count++;
         $value2 = htmlentities($value2, ENT_COMPAT | ENT_HTML401, "UTF-8");
         echo "<tr>\n<td align=\"right\">$count: $key-$key2:</td>\n";
         echo "<td align=\"left\"><textarea name=\"$key-$key2-new\" rows=\"4\" cols=\"50\"></textarea></td>\n";
         echo "<td><textarea name=\"$key-$key2-$lang\" rows=\"4\" cols=\"50\" readonly=\"readonly\">$value2</textarea></td></tr>";
        }
     }
   if ($key != "mail")
     {
      $count++;
      echo "<tr>\n<td align=\"right\">$count: $key:</td>\n";
      echo "<td align=\"left\"><textarea name=\"$key-new\" rows=\"4\" cols=\"50\"></textarea></td>\n";
      echo "<td><textarea name=\"template\" rows=\"4\" cols=\"50\" readonly=\"readonly\">$value</textarea></td></tr>";
     }
  }
?>
  <tr>
    <td align="center" valign="bottom" colspan="3">
      <br>
      <br>
      <?php 
        echo "<table width=\"400\" align=\"center\"><tr><td align=\"justify\">{$loc_lang["translation_send_warn"]}</td></tr></table><br>\n<br>\n";
        echo "<input type=\"submit\" value=\"{$loc_lang["translation_send"]}\">\n"; 
      ?>
    </td>
  </tr>
</table>
</form><br><br><br><br>
<?php echo "</font>{$conf["font_style_close"]}\n"; ?>
</center>
</body>
</html>
