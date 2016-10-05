<?php
include('header_short.html');
include('conf/shop_conf.php');
echo "<body bgcolor=\"{$conf["bgcolor"]}\"><br>\n<br>\n";
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
      $loc_lang[$key] = htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, "UTF-8");
      //$loc_lang[$key] = str_replace("\"", "&quot;", $loc_lang[$key]);
     }
  }
$date = date("YmdHis");
$langfile = "locale/$new_lang-$date.php";
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
fputs($fHandle, "foreach(\$loc_lang as \$key => \$value)\n  {\n   if (\$key == \"mail\")\n     {\n      foreach(\$loc_lang[\"mail\"] as \$key2 => \$value2)\n        {\n         \$loc_lang[\$key][\$key2] = nl2br(\$value2, false);\n        }\n     }\n   if (\$key != \"mail\")\n     {\n      \$loc_lang[\$key] = nl2br(\$value, false);\n     }\n  }\n");
fputs($fHandle, "?>");
fclose($fHandle);
unset($loc_lang);
include("locale/$lang.php");
mail("chris@musicchris.de", "Übersetzung Folkadelic Shop", "$author hat den Shop von $lang in $new_lang übersetzt!\nJruß\n", "From:$author\r\nContent-Type: text/plain; charset = \"UTF-8\"\r\nContent-Transfer-Encoding: 8bit\r\n");
echo "<center>Vielen Dank! Thank you very much! Muchas gra&#231;ias! Mille grazie! Merci beaucoup!\n{$loc_lang["translation_submitted"]}</center></font>{$conf["font_style_close"]}";
echo "<pre>"; print_r($loc_lang); echo "</pre>\n";
?>

</body>
</html>
