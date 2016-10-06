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
include('header_short.php');
?>

<body>
<?php
  $c = $_GET["c"];
  
  echo "<h2>" . gettext("edit this item") . "</h2>\n<hr>\n<br>\n";
  echo "  <div style=\"text-align: center;\"><form name=\"del-$c\" action=\"savelist.php\" method=\"get\" accept-charset=\"UTF-8\" id=\"deleteItem\">\n";
  echo "    <input type=\"hidden\" name=\"job\" value=\"delete\">\n";
  echo "    <input type=\"hidden\" name=\"num\" value=\"$c\">\n";
  echo "    <input type=\"submit\" value=\"        " . gettext("delete this item") . "        \">\n";
  echo "  </form></div>\n";

$modus = "display_data";
include('read_index.php');
  // Get category ( music | clothing )
  foreach ($conf["item_type"] as $keycat => $valcat)
    {
     if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type']) $cat = $conf["item_type"][$keycat]["cat"];
    }

  $oldid = $data[$c]['item_id'];
  echo "<form name=\"item-$c\" action=\"savelist.php?job=updateitem\" method=\"post\" accept-charset=\"UTF-8\" enctype=\"multipart/form-data\">\n";
  echo "<table border=\"0\" align=\"center\">\n";
  echo "  <tr>\n    <td>\n      Item No: <b>$c</b><br>\n      <img src=\"../{$data[$c]['item_pic']}\" height=\"120\" border=\"0\"><br>\n";
  echo "    </td>\n    <td align=\"right\">\n";
  echo "      " . gettext("Name:") . "<input name=\"item_name\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_name']}\"><br>\n";

  echo "      " . gettext("Type:") . "<select name=\"item_type\" size=\"1\" style=\"width:185px;\" width=\"185\">\n";
  foreach ($conf["item_type"] as $key => $value)
          {
           if ($conf["item_type"][$key]["name"] == $data[$c]['item_type']) { $selected = " selected=\"selected\""; } else $selected = "";
           echo "<option value=\"{$conf["item_type"][$key]["name"]}\"$selected>{$conf["item_type"][$key]["name"]}</option>\n";
          }

  echo "      </select><br>\n";
  
  echo "      " . gettext("Year/Size:") . "<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_descr']}\"><br>\n";
  echo "      " . gettext("Price:") . "<input name=\"item_preis\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_preis']}\"><br>\n";
  echo "      " . gettext("Item's Pic:") . "<input size=\"5\" name=\"upload_pic\" type=\"file\" accept=\"image/png\"><br>\n";
  echo "    </td>\n  </tr>\n  <tr>\n    <td align=\"center\" colspan=\"2\">\n";
  $data[$c]['tracklist'] = trim($data[$c]['tracklist'],"\n");
  echo "      " . gettext("Details (html is allowed!):") . "<br>\n      <textarea name=\"item_details\" cols=\"50\" rows=\"8\">{$data[$c]['item_details']}</textarea><br>\n";
  if($cat == "music") { echo "      " . gettext("Tracklist (plain text only!)"); ?>:<br><textarea name="tracklist" cols="50" rows="8"><?php echo $data[$c]['tracklist']; ?></textarea><br><?php }
  echo "      <button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button> <input type=\"submit\" value=\" " . gettext("Save") . " \">\n      <input type=\"hidden\" name=\"c\" value=\"$c\">\n      <input type=\"hidden\" name=\"oldid\" value=\"$oldid\">\n";
  echo "    </td>\n  </tr>\n</table>\n";
  
  
  if ($cat == "music")
  {
   echo "<table align=\"center\">\n  <tr>\n    <td align=\"center\" colspan=\"2\">\n<br>      <b>" . gettext("Expected Audio-File-Names in:") . " shop/items/audio/{$data["$c"]['item_id']}/</b>\n    </td>\n  </tr>\n";
   $counter = "0";
   $fHandle = fopen("../items/{$data["$c"]['item_id']}.dat","r");
   if ($fHandle != NULL)
    {
     while (!feof($fHandle))
      {
       $counter++;
       $buffer = fgets($fHandle); $tracks["$counter"]['name'] = trim($buffer,"\n");
       $char_search = array("-",
                            " ",
                            "(",
                            ")",
                            "&",
                            "?",
                            "!",
                            ".",
                            "'",
                            "#");
       $char_replace = array("_",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "");
       $trackname = str_replace($char_search, $char_replace, $tracks["$counter"]['name']);
       if ($trackname != "")
         {
          $tracks["$counter"]['filename_mp3'] = "$trackname.mp3";
          $tracks["$counter"]['filename_ogg'] = "$trackname.ogg";
          echo "  <tr>\n    <td align=\"left\" colspan=\"1\">\n";
          echo "{$tracks["$counter"]['filename_mp3']}</td><td align=\"left\" colspan=\"1\">{$tracks["$counter"]['filename_ogg']}<br>\n";
          echo "    </td>  </tr>\n";
         }
      }
     $counter--;
    }
  }
  /* echo "<pre>";print_r($data);echo "</pre>"; */
?>
</table>
</form>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
