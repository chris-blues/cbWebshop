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
include('header_full.html');
echo "<body>\n";
if (!natcasesort($conf["lang"])) echo "Failed to sort the array \$conf[\"lang\"]!<br>\n";
if (!sort($conf["item_type"])) echo "Failed to sort the array \$conf[\"item_type\"]!<br>\n";
echo "<h2>" . gettext("Shop Settings") . "</h2>\n";
echo gettext("Edit carefully!") . "<br>\n<hr>\n<br>\n";
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
      echo "  <tr><td>" . gettext("Default language:") . "</td><td colspan=\"2\"><select name=\"_default_lang\" size=\"1\">\n";
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
      echo "  <tr><td>" . gettext("Bank Account:") . "</td><td colspan=\"2\"> <textarea name=\"$key\" cols=\"35\" rows=\"6\">$value</textarea></td></tr>\n";
     }
   if ($key == "call")
     { // If here are variables, we'll need to get them as text, not as variables => So, we re-read shop_conf.php in text-format and strip all unusable information from the lines!
      $settings = file('../conf/shop_conf.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      foreach($settings as $numline => $line)
        {
         $line = rtrim($line);
         if ($line == '<?php' or $line == '?>') { /* echo "line is php: $line<br>\n"; */ continue 1; }
         if (strncmp($line, '$conf["call"]', 13) != "0") { /* echo "strncmp failed with: $line<br>\n"; */ continue 1; }
         $line = str_replace(" ","",$line);
         $line = str_replace('$conf["call"]["',"",$line);
         $line = str_replace('"]',"",$line);
         $line = str_replace('"',"",$line);
         $line = str_replace(';',"",$line);
         $line = trim($line,"\n");
         $line = explode("=",$line);
         echo "  <tr><td>call {$line[0]}: <a href=\"javascript:\" onclick=\"document.getElementById('call-{$line[0]}').value='';\"><img src=\"../pics/del.png\" alt=\"delete this call\" title=\"delete this call\"></a></td><td colspan=\"2\"> <input id=\"call-{$line[0]}\" name=\"call-{$line[0]}\" value=\"{$line[1]}\" type=\"text\" size=\"30\" title=\"If you delete this value, the whole call will be erased from the array.\"></td></tr>\n";
        }
      echo "  <tr><td><input type=\"text\" size=\"30\" name=\"$key-newcall\" value=\"new call\" title=\"Enter a new call here! It will appear in every call of the shop in the URLs, e.g. index.php?newcall=thisvalue&page=shop\"></td><td colspan=\"2\"> <input type=\"text\" size=\"30\" name=\"$key-newvalue\" value=\"\" title=\"Enter your new value here. Variables are accepted, e.g.\$lang.\"></td></tr>\n";
     }
   if ($key == "surpress_ssl_warning")
     {
      if ($conf["surpress_ssl_warning"] == "TRUE") $checked = " checked";
      else $checked = "";
      echo "<tr><td>$key:</td><td colspan=\"2\"> <input type=\"checkbox\" name=\"$key\" value=\"TRUE\"$checked>";
     }
   if ($key != "lang" and $key != "item_type" and $key != "_default_lang" and $key != "bankaccount_info" and $key != "surpress_ssl_warning" and $key != "call")
     {
      $count++;
      echo "  <tr><td>$key:</td><td colspan=\"2\"> <input name=\"$key\" value=\"$value\" type=\"text\" size=\"30\"></td></tr>\n";
     }
  }
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" " . gettext("Save") . " &gt;&gt;&gt; \"></td></tr>\n";
echo "</table>\n</form>\n";
//echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
