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
$directory = $cbWebshop_dirname . '/../../locale';
$gettext_domain = 'cbWebshop';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

include('../header_full.html');
include('../../conf/shop_conf.php');
if (isset($_GET["opt"]))
  {
   $opt = $_GET["opt"];
   $lang = $conf["lang"][$opt];
  }
echo "<body><br>\n<center><br>\n";
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
include('../../locale/' . LOC_LANG . '.php');
echo "<tr><td align=\"justify\">" . gettext("The language you want to use as a template. Here are all languages we already have. We recommend you use english or deutsch to avoid subsequent errors, since these were the first languages we had.
WARNING! Don't use this switch, once you have begun working! It will destroy all your work!") . "<br><br>\n</td>\n</tr>\n";
echo "<tr><td align=\"center\"><input type=\"text\" size=\"46\" name=\"new_lang\">\n</td>\n</tr>\n";
echo "<tr><td align=\"justify\">" . gettext("In to which language would you like to translate? Please enter the language name in its own language! (e.g.:fran&#231;ais instead of french!)") . "<br><br>\n</td>\n</tr>\n";
echo "<tr><td align=\"center\"><input type=\"text\" size=\"46\" name=\"author\">\n</td>\n</tr>\n";
echo "<tr><td align=\"justify\">" . gettext("Please tell us your &quot;name &lt;email-address&gt;&quot; so, that we can come back to you if there are any questions.") . "\n</td>\n</tr>\n</table><br><br><br>\n";
echo "<table border=\"0\" align=\"center\" width=\"1000\" bgcolor=\"{$conf["bgcolor"]}\" rules=\"rows\">\n";
echo "<tr height=\"30\"><td align=\"center\">" . gettext("Systemname of text field") . "</td><td align=\"center\">" . gettext("Your new translation") . "</td><td align=\"center\">" . gettext("Your template") . "</td></tr>\n";
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
        echo "<table width=\"400\" align=\"center\"><tr><td align=\"justify\">" . gettext("Please make sure you have checked for errors trice!!!!! There's nothing worse for us than to find out which version is the best in a strange foreign language!!!") . "</td></tr></table><br>\n<br>\n";
        echo "<input type=\"submit\" value=\" &lt;&lt;&lt; " . gettext("OK, I have double-checked! Send this translation!") . " &gt;&gt;&gt; \">\n"; 
      ?>
    </td>
  </tr>
</table>
</form><br><br><br><br>
<?php echo "</font>{$conf["font_style_close"]}\n"; ?>
</center>
<script type="text/javascript" src="../scripts.js"></script>
</body>
</html>
