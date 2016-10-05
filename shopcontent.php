<?php
include('conf/shop_conf.php');
include('conf/item_conf.php');
include('header_full.html');
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');

echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n";

include('read_index.php');
/* Lese Vorlage aus Datei in einen String */
$col = "0";
$template = file_get_contents("templates/item_template_shop.html");
for ($c = 1; $c <= $itemamount; $c++)
 {
  $col++;
  $alt = "{$loc_lang["click_to_view"]} {$data["$c"]['item_type']} {$data["$c"]['item_name']}{$loc_lang["click_to_view_add"]}";
  $buy = "{$loc_lang["buy"]}";
  $value = "{$loc_lang["pieces"]} ({$data["$c"]['item_preis']} &euro;/{$loc_lang["piece"]})";
  
  
// Get category ( music | clothing )
foreach ($conf["item_type"] as $keycat => $valcat)
  {
   if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type'])
     $cat = $conf["item_type"][$keycat]["cat"];
  }

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($cat == "music")
  {
   $counter = "0";
   $fHandle = fopen("items/{$data["$c"]['item_id']}.dat","r");
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
   $tracklist = "<font size=\"2\"><table border=\"0\">\n";
   for ($track = "1"; $track <= $counter; $track++)
     {
      if (file_exists("items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.ogg") and file_exists("items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.mp3"))
        {
         $tracklisten = file_get_contents("templates/get_audio.html");
         $searchtrack  = array('%id%', '%trackname%', '%trackid%');
        // Womit soll das ersetzt werden?
         $replacetrack = array($data["$c"]['item_id'], $tracks["$track"]['name'], $tracks["$track"]['id']);
        // Finde und ersetze Platzhalter in $output
         $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
        }
      else
        {
         $tracklist .= "<tr><td align=\"left\" valign=\"center\"><img src=\"pics/transparent.png\" width=\"15\" height=\"15\" border=\"0\"> {$tracks["$track"]['name']}</td></tr>\n";
        }
     }
   $tracklist .= "</table></font>\n";
   $data["$c"]['item_details'] = $tracklist;
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
                   '%alt%',
                   '%buy%',
                   '%value%',
                   '%kartid%',
                   '%lang%',
                   '%c%',
                   '%shop_width%',
                   '%shop_height%',
                   '%shop_pic_height%');
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
                   $alt,
                   $buy,
                   $value,
                   $kartid,
                   $lang,
                   $c,
                   $item_conf["shop_width"],
                   $item_conf["shop_height"],
                   $item_conf["shop_pic_height"]);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
 }

?>
</font>
</body>
</html>
