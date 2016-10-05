<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
?>

<body>
<center>
<?php
  $c = $_GET["c"];
  
  echo "<center><h2>{$loc_lang["admin_edit_item"]}</h2></center>\n<hr>\n<br>\n";
  echo "  <form name=\"del-$c\" action=\"savelist.php\" method=\"get\" accept-charset=\"UTF-8\" onsubmit=\"return DeleteCheck()\">\n";
  echo "    <input type=\"hidden\" name=\"job\" value=\"delete\">\n";
  echo "    <input type=\"hidden\" name=\"num\" value=\"$c\">\n";
  echo "    <input type=\"submit\" value=\" {$loc_lang["admin_deleteitem"]} \">\n";
  echo "  </form>\n</center>\n";

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
  echo "  <tr>\n    <td>\n      Item No: <b>$c</b><br>\n      <img src=\"../{$data[$c]['item_pic']}\" height=\"120\" onmouseout=\"src='../{$data[$c]["item_pic"]}'\" onmouseover=\"src='../{$data[$c]["item_pic"]}.png'\" border=\"0\"><br>\n";
  echo "    </td>\n    <td align=\"right\">\n";
  echo "      {$loc_lang["admin_itemname"]}<input name=\"item_name\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_name']}\"><br>\n";
  
  echo "      {$loc_lang["admin_itemtype"]}<select name=\"item_type\" size=\"1\" style=\"width:185px;\" width=\"185\">\n";
  foreach ($conf["item_type"] as $key => $value)
          {
           if ($conf["item_type"][$key]["name"] == $data[$c]['item_type']) { $selected = " selected=\"selected\""; } else $selected = "";
           echo "<option value=\"{$conf["item_type"][$key]["name"]}\"$selected>{$conf["item_type"][$key]["name"]}</option>\n";
          }

  echo "      </select><br>\n";
  
  echo "      {$loc_lang["admin_descryear"]}<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_descr']}\"><br>\n";
  echo "      {$loc_lang["admin_itemprice"]}<input name=\"item_preis\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_preis']}\"><br>\n";
  echo "      {$loc_lang["admin_item_pic"]}<input size=\"5\" name=\"upload_pic\" type=\"file\" accept=\"image/png\"><br>\n";
  echo "      {$loc_lang["admin_pngpricetag"]}<input size=\"5\" name=\"upload_pricetag\" type=\"file\" accept=\"image/png\">\n";
  echo "    </td>\n  </tr>\n  <tr>\n    <td align=\"center\" colspan=\"2\">\n";
  if ($cat == "music") echo "      {$loc_lang["admin_tracklist"]}<br>\n";
  else echo "      {$loc_lang["admin_details"]}<br>\n";
  $data[$c]['item_details'] = trim($data[$c]['item_details'],"\n");
  echo "      <textarea name=\"item_details\" cols=\"50\" rows=\"8\">{$data[$c]['item_details']}</textarea><br>\n";
  echo "      <button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button> <input type=\"submit\" value=\" {$loc_lang["admin_save"]} \">\n      <input type=\"hidden\" name=\"c\" value=\"$c\">\n      <input type=\"hidden\" name=\"oldid\" value=\"$oldid\">\n";
  echo "    </td>\n  </tr>\n</table>\n";
  
  
  if ($cat == "music")
  {
   echo "<table align=\"center\">\n  <tr>\n    <td align=\"center\" colspan=\"2\">\n<br>      <b>{$loc_lang["admin_expectedfilenames"]} shop/items/audio/{$data["$c"]['item_id']}/</b>\n    </td>\n  </tr>\n";
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
</body>
</html>
