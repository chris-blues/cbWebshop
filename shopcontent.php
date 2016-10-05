<!-- BEGIN shopcontent.php -->
<?php
include('read_index.php');
/* Lese Vorlage aus Datei in einen String */
$col = "0";
for ($c = 1; $c <= $itemamount; $c++)
 {
  $col++;
  $alt = "{$data["$c"]['item_type']} {$data["$c"]['item_name']}";
  $buy = "{$loc_lang["buy"]}";
  $value = "{$loc_lang["pieces"]} ({$data["$c"]['item_preis']} {$conf["_currency"]}/{$loc_lang["piece"]})";
  
  
// Get category ( music | clothing )
foreach ($conf["item_type"] as $keycat => $valcat)
  {
   if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type'])
     $cat = $conf["item_type"][$keycat]["cat"];
  }

  $template = file_get_contents("shop/templates/item_template_$cat.html");

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($cat == "music")
  {
   $counter = "0";
   $fHandle = fopen("shop/items/{$data["$c"]['item_id']}.dat","r");
   if ($fHandle != NULL)
    {
     while (!feof($fHandle)) // Get Song-Names
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
       $tracks["$counter"]['id'] = str_replace($char_search, $char_replace, $tracks["$counter"]['name']);
      }
     $counter--;
    }
   $tracklist = "<ul>\n";
   for ($track = "1"; $track <= $counter; $track++)
     {
      if (file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.ogg") and file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.mp3"))
        {
         $tracklisten = file_get_contents("shop/templates/get_audio.html");
         $searchtrack  = array('%id%', '%trackname%', '%trackid%');
        // Womit soll das ersetzt werden?
         $replacetrack = array($data["$c"]['item_id'], $tracks["$track"]['name'], "{$tracks["$track"]['id']}");
        // Finde und ersetze Platzhalter in $output
         $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
        }
      else
        {
         $tracklist .= "<li>{$tracks["$track"]['name']}</li>\n";
        }
     }
   $tracklist .= "</ul>\n";
   $data["$c"]['tracklist'] = $tracklist;
  }

  if ($cat == "clothing")
    {
     $sizesdropdown = "";
     $sizes = explode(" ", $data[$c]['item_descr']);
     foreach ($sizes as $sizeskey => $sizesvalue)
       {
        if ($sizesvalue == "XXL") { $sizesvalueshow = $sizesvalue . " +2 " . $conf["_currency"]; $sizesdefault = ""; }
        if ($sizesvalue == "XL") { $sizesvalueshow = $sizesvalue . " +1 " . $conf["_currency"]; $sizesdefault = ""; }
        if ($sizesvalue == "L") { $sizesvalueshow = $sizesvalue; $sizesdefault = "selected"; }
        if ($sizesvalue == "M") { $sizesvalueshow = $sizesvalue . " -1 " . $conf["_currency"]; $sizesdefault = ""; }
        if ($sizesvalue == "S") { $sizesvalueshow = $sizesvalue . " -2 " . $conf["_currency"]; $sizesdefault = ""; }
        $sizesdropdown .= "<option value=\"$sizesvalue\" $sizesdefault>$sizesvalueshow</option>\n";
       }
    }

  /* Was soll ersetzt werden? */
  $search  = array('%id%', 
                   '%name%', 
                   '%type%',
                   '%Type%',
                   '%TYPE%', 
                   '%descr%', 
                   '%preis%', 
                   '%pic%', 
                   '%preview%',
                   '%details%',
                   '%tracklist%',
                   '%alt%',
                   '%buy%',
                   '%value%',
                   '%kartid%',
                   '%lang%',
                   '%c%',
                   '%shop_width%',
                   '%shop_height%',
                   '%shop_pic_width%',
                   '%sizes%',
                   '%_currency%');
  /* Womit soll das ersetzt werden? */
  $replace = array($data["$c"]['item_id'],
                   $data["$c"]['item_name'],
                   $ltype,
                   $data["$c"]['item_type'],
                   $utype,
                   $data["$c"]['item_descr'],
                   $data["$c"]['item_preis'],
                   $data["$c"]['item_pic'],
                   $data["$c"]['item_preview'],
                   $data["$c"]['item_details'],
                   $data["$c"]['tracklist'],
                   $alt,
                   $buy,
                   $value,
                   $kartid,
                   $lang,
                   $c,
                   $item_conf["shop_width"],
                   $item_conf["shop_height"],
                   $item_conf["shop_pic_width"],
                   $sizesdropdown,
                   $conf["_currency"]);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
  echo "<div class=\"spacer-items\">&nbsp;</div>\n";
 }

?>
<!-- END shopcontent.php -->
