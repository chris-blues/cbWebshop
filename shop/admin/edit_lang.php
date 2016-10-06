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

// process lang-file jobs if there are any
if (isset($_GET["rename"]))
  {
   $oldname = $_GET["oldname"];
   $newname = $_GET["rename"];
   $operation_message = "<table align=\"center\" border=\"1\"><tr><td>\n";
   if (rename("../locale/$oldname", "../locale/$newname")) $operation_message .= "New filename : $newname<br>\n";
   else $operation_message .= "Error renaming $oldname to $newname! Do we have permissions?<br>\n";
   $operation_message .= "</td></tr></table>\n";
  }
if (isset($_GET["delete"]))
  {
   $operation_message = "<table align=\"center\" border=\"1\"><tr><td>\n";
   if (unlink("../locale/{$_GET["delete"]}")) $operation_message .= "{$_GET["delete"]} deleted.<br>\n";
   else $operation_message .= "Error deleting {$_GET["delete"]}! Do we have permissions?<br>\n";
   $operation_message .= "</td></tr></table>\n";
  }
if (isset($_GET["register"])) $onload = " onload=\"document.langform.submit();\"";

include('header_short.php');
echo "<body$onload>\n";
echo "<h2>" . gettext("Edit available languages") . "</h2>\n" . gettext("Note that you need a translated language in the shop's locale!!! You can translate the locale-file <a href=\"translate/translate.php\" target=\"_blank\">here</a>. At the bottom of this page you can process existing language files!") . "<br>\n<hr>\n<br>\n";

// Prepare Array for POST + add input fields for new types + hide unnecessary fields
echo "<form name=\"langform\" action=\"save_settings.php?job=shop\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<input type=\"hidden\" name=\"refer\" value=\"edit_lang\">\n";
foreach ($conf as $key => $value)
  {
   if ($key == "lang")
     {
      echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
      foreach($conf["$key"] as $key2 => $value2)
        {
         $count++;
         echo "  <tr><td>$key - $key2:</td><td> <input name=\"$key$key2\" id=\"$key2\" class=\"editArrays\" value=\"$value2\" type=\"text\" size=\"30\"><button type=\"button\" name=\"remove\" value=\"$key$key2\" id=\"buttonRemoveRow_$key2\" data-id=\"$key2\"> " . gettext("Remove") . " </button></td></tr>\n";
        }
      $count++; $key2++;
      echo "  <tr><td>$key - $key2:</td><td> <input name=\"$key$key2\" value=\"{$_GET["register"]}\" type=\"text\" size=\"30\"></td></tr>\n";
      echo "</table>\n";
     }
   if ($key == "item_type")
     {
      foreach($conf["$key"] as $key2 => $value2)
        {
         foreach($conf[$key][$key2] as $key3 => $value3)
           {
            $count++;
            echo "    <input name=\"{$key}{$key2}_{$key3}\" value=\"$value3\" type=\"hidden\">\n";
           }
        }
     }
   if ($key != "lang" and $key != "item_type")
     {
      $count++;
      echo "<input name=\"$key\" value=\"$value\" type=\"hidden\">\n";
     }
  }

echo "<div class=\"center\"><button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button><input type=\"submit\" value=\" " . gettext("Save") . " &gt;&gt;&gt; \"></div>\n</form>\n<br>\n<hr>\n<br>\n";
// echo "Debugging:<br>\n<pre>"; print_r($conf); echo "</pre>\n";

echo $operation_message;
$lang_files = scandir("../locale");
//print_r($lang_files);
$negdir = array_search(".", $lang_files);
unset($lang_files[$negdir]);
$negdir = array_search("..", $lang_files);
unset($lang_files[$negdir]);
sort($lang_files);
echo "<b>" . gettext("Existing language files:") . "</b><br><br>\n<table aling=\"center\" border=\"0\" rules=\"all\">\n";
echo "<tr><td>count</td><td>language</td><td>filename</td><td colspan=\"2\">operations</td></tr>\n";
foreach($lang_files as $filekey => $filevalue)
  {
   $langname = str_replace(".php", "", $filevalue);
   if (in_array($langname, $conf["lang"]))
     {
      echo "<tr><td>$filekey: </td><td>$langname </td><td>$filevalue </td>\n";
      echo "    <td colspan=\"2\"><form action=\"edit_lang.php\" method=\"get\" accept_charset=\"UTF-8\" onsubmit=\"return DeleteCheck()\">\n";
      echo "          <input type=\"text\" size=\"30\" name=\"delete\" value=\"$filevalue\">\n";
      echo "          <input type=\"submit\" value=\"" . gettext("delete file") . "\"></form></td></tr>\n";
     }
   else
     {
      echo "<tr><td colspan=\"4\"></td></tr>\n";
      echo "<tr><td colspan=\"3\"><b>" . gettext("Not registered yet:") . "</b></td>\n";
      echo "    <td><form action=\"edit_lang.php\" method=\"get\" accept_charset=\"UTF-8\" onsubmit=\"return DeleteCheck()\">";
      echo "<input type=\"hidden\" name=\"delete\" value=\"$filevalue\">";
      echo "<input type=\"submit\" value=\"" . gettext("delete file") . "\"></form></td>";
      echo "<td><form action=\"edit_lang.php\" method=\"get\" accept_charset=\"UTF-8\">";
      echo "<input type=\"hidden\" name=\"register\" value=\"$langname\">";
      echo "<input type=\"submit\" value=\"" . gettext("register file") . "\"></form></td></tr>\n";
      echo "<tr><td>$filekey: </td><td>$langname </td><td>$filevalue </td>\n";
      echo "    <td colspan=\"2\"><form action=\"edit_lang.php\" method=\"get\" accept_charset=\"UTF-8\">\n";
      echo "<input type=\"text\" size=\"30\" name=\"rename\" value=\"$filevalue\">";
      echo "<input type=\"hidden\" name=\"oldname\" value=\"$filevalue\">";
      echo "<input type=\"submit\" value=\"" . gettext("rename file") . "\"></form></td></tr>\n";
      echo "<tr><td colspan=\"4\"></td></tr>\n";
     }
   
  }
echo "</table>\n";
//print_r($lang_files);
echo "\n";
?>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
