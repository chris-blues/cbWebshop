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
echo "<h2>" . gettext("Edit item-types") . "</h2>\n" . gettext("These will show up in 'Add new item' once you added an item here.") . "<br><br>\n<hr>\n<br><br>\n";

// Prepare Array for POST + add input fields for new types + hide unnecessary fields
echo "<form action=\"save_settings.php?job=shop\" method=\"post\" accept-charste=\"UTF-8\">\n";
$cat01 = "music";
$cat02 = "clothing";
echo "<input name=\"wheretoreturn\" value=\"itemtypes\" type=\"hidden\">\n";
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
         if ($conf[$key][$key2]["cat"] == $cat01) echo "      <option selected=\"selected\" value=\"$cat01\">" . gettext("Music") . "</option>\n"; else echo "      <option value=\"$cat01\">" . gettext("Music") . "</option>\n";
         if ($conf[$key][$key2]["cat"] == $cat02) echo "      <option selected=\"selected\" value=\"$cat02\">" . gettext("Clothing") . "</option>\n"; else echo "      <option value=\"$cat02\">" . gettext("Clothing") . "</option>\n";
         echo "    </select>\n";
         echo "    <button type=\"button\" name=\"remove\" value=\"$key$key2\" onclick=\"this.form.{$key}{$key2}_name.value=''; this.form.{$key}{$key2}_cat.value=''\"> " . gettext("Remove") . " </button>\n  </td></tr>\n";
        }
      //$count++;
      echo "  <tr><td>$key - $count:</td><td> <input name=\"{$key}{$count}_name\" type=\"text\" size=\"15\">\n";
      echo "    <select name=\"{$key}{$count}_cat\" size=\"1\">\n";
      echo "      <option value=\"\">=category=</option>\n";
      echo "      <option>$cat01</option>\n";
      echo "      <option>$cat02</option>\n";
      echo "    </select>\n  </td></tr>\n";
      echo "</table>\n";
     }
   if ($key == "lang")
     {
      foreach($conf["$key"] as $key2 => $value2)
        {
         echo "<input name=\"$key$key2\" value=\"$value2\" type=\"hidden\">\n";
        }
     }
   if ($key == "call")
     {
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
         echo "<input name=\"call-{$line[0]}\" value=\"{$line[1]}\" type=\"hidden\">\n";
        }
     }
   if ($key != "lang" and $key != "item_type" and $key != "call")
     {
      echo "<input name=\"$key\" value=\"$value\" type=\"hidden\">\n";
     }
  }
echo "<div class=\"center\"><button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button><input type=\"submit\" value=\" " . gettext("Save") . " &gt;&gt;&gt; \"></div>\n</form>\n<br>\n";
// echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";
?>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
