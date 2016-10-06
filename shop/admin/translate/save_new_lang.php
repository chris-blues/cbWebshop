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
include('../conf/shop_conf.php');
echo "<body><br>\n<br>\n";
echo "{$conf["font_style"]}<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n";

if (!$_POST["reset_x"])
  {
   $lang = $_POST["lang"];
   unset($_POST["lang"]);
   $new_lang = $_POST["new_lang"];
   unset($_POST["new_lang"]);
   $author = $_POST["author"];
   unset($_POST["author"]);
   unset($_POST["template"]);
  }
//echo "<pre>"; print_r($_POST); echo "</pre>\n";

// Put _POST properly into Array $loc_lang
foreach($_POST as $key => $value)
  {
   $switch = "0";
   if (strncmp($key, "mail", 4) == "0")
     {
      $switch = "1";
      $keys = explode("-", $key);
      if ($keys["2"] == "new")
        {
         $key_1 = $keys["0"];
         $key_2 = $keys["1"];
         $loc_lang[$key_1][$key_2] = $value;
        }
     }
   if ($switch == "0")
     {
      $keys = explode("-", $key, -1);
      $key = $keys["0"];
      $loc_lang[$key] = htmlentities($value, ENT_QUOTES | ENT_HTML5, "UTF-8");
      //$loc_lang[$key] = str_replace("\"", "&quot;", $loc_lang[$key]);
     }
  }

$langfile = "../../locale/$new_lang.php";
$fHandle = fopen($langfile, "w");
fputs($fHandle, "<?php\n// Author : $author\n// Be sure to use UTF-8 encoding - NO ISO-9876 stuff!!!!\n// html format strings, special chars must be coded (ö -> &ouml; , ß -> &szlig; , € -> &euro;  etc)\n");
foreach ($loc_lang as $key => $value)
  {
   if ($key == "mail")
     {
      fputs($fHandle, "\n// email format strings, special chars must be used plainly (ö, ß, € etc)\n");
      foreach($loc_lang["mail"] as $key2 => $value2)
        {
         $str = "\$loc_lang[\"mail\"][\"$key2\"] = \"$value2\";\n";
         fputs($fHandle, $str);
        }
     }
   if ($key != "mail")
     {
      $str = "\$loc_lang[\"$key\"] = \"$value\";\n";
      fputs($fHandle, $str);
     }
  }
fputs($fHandle, "?>");
fclose($fHandle);

mail("chris@musicchris.de", "Übersetzung Folkadelic Shop", "$author hat den Shop von $lang in $new_lang übersetzt!\nJruß\n", "From:$author\r\nContent-Type: text/plain; charset = \"UTF-8\"\r\nContent-Transfer-Encoding: 8bit\r\n");
echo "<center>Vielen Dank! Thank you very much! Muchas gra&#231;ias! Mille grazie! Merci beaucoup!</font>{$conf["font_style_close"]}\n</center>";

?>

<script type="text/javascript" src="../scripts.js"></script>
</body>
</html>
