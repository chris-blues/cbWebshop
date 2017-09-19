<!-- BEGIN shopcontent.php -->
<img id="play_active_preload" src="shop/pics/play_active.png" class="hidden" style="display: none;">
<?php
include('shop/conf/shop_conf.php');

include('shop/read_index.php');

$locale_size = gettext("size");
$buy = gettext("Buy");

/* Lese Vorlage aus Datei in einen String */
$col = "0";
for ($c = 1; $c <= $itemamount; $c++)
 {
  $col++;
  $value = sprintf(gettext("pieces (%s €/piece)"), $data["$c"]['item_preis'] );
  if ($debug and $debug != "FALSE") echo "$value <br>\n";

// Get category ( music | clothing )
foreach ($conf["item_type"] as $keycat => $valcat)
  {
   if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type'])
     $cat = $conf["item_type"][$keycat]["cat"];
  }

  $template = file_get_contents("shop/templates/item_template_$cat.html");

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($_GET["accessibility"] != "TRUE") $playbutton = "play-black";
else $playbutton = "play-white";
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
                            "&amp;",
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
      if (file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.ogg") or file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.mp3"))
        {
         $tracklisten = file_get_contents("shop/templates/get_audio.html");
         $searchtrack  = array('%id%', '%trackname%', '%trackid%', '%playbutton%', '%clicktoplay%');
        // Womit soll das ersetzt werden?
         $replacetrack = array($data["$c"]['item_id'], $tracks["$track"]['name'], "{$tracks["$track"]['id']}", $playbutton, gettext("Click here to play this song!"));
        // Finde und ersetze Platzhalter in $tracklist
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
        if ($sizesvalue == "XXL") $sizesvalueshow = $sizesvalue . " (+2 €)";
        if ($sizesvalue == "XL") $sizesvalueshow = $sizesvalue . " (+1 €)";
        if ($sizesvalue == "L") $sizesvalueshow = $sizesvalue . " (±0 €)";
        if ($sizesvalue == "M") $sizesvalueshow = $sizesvalue . " (-1 €)";
        if ($sizesvalue == "S") $sizesvalueshow = $sizesvalue . " (-2 €)";
        $sizesdropdown .= "<option value=\"$sizesvalue\">$sizesvalueshow</option>\n";
       }
    }

  $calls = "";
  foreach($conf["call"] as $call => $value)
    {
     $calls .= "<input type=\"hidden\" name=\"$call\" value=\"$value\">\n";
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
                   '%buy%',
                   '%target%',
                   '%value%',
                   '%kartid%',
                   '%lang%',
                   '%c%',
                   '%shop_width%',
                   '%shop_height%',
                   '%shop_pic_width%',
                   '%size%',
                   '%sizes%',
                   '%_currency%',
                   '%_calls%',
                   '%noscript%');
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
                   $buy,
                   $conf["callup"],
                   $value,
                   $kartid,
                   $lang,
                   $c,
                   $item_conf["shop_width"],
                   $item_conf["shop_height"],
                   $item_conf["shop_pic_width"],
                   $locale_size,
                   $sizesdropdown,
                   $conf["_currency"],
                   $calls,
                   gettext("Please activate JavaScript to use this page!"));
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
  echo "<div class=\"spacer-items\"> </div>\n";
 }

?>
<!-- END shopcontent.php -->
