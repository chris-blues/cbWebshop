<?php
include('conf/shop_conf.php');
include('conf/item_conf.php');
include('header_full.html');

$itemid = $_GET["item"]; 
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"];

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
include('read_index.php');

if ($item == "") { echo "Error! $itemid does not exist in array!<br>\n<pre>"; print_r($data); echo "</pre>\n"; }

echo "<body bgcolor=\"{$conf["bgcolor"]}\" align=\"{$conf["align"]}\">\n";
echo "<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n{$conf["font_style"]}\n";

// Get category ( music | clothing )
foreach ($conf["item_type"] as $keycat => $valcat)
  {
   if ($conf["item_type"][$keycat]["name"] == $data["$item"]['item_type'])
     $cat = $conf["item_type"][$keycat]["cat"];
  }

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($cat == "music")
  {
   $counter = "0";
   $fHandle = fopen("items/{$data["$item"]['item_id']}.dat","r");
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
      if (file_exists("items/audio/{$data["$item"]['item_id']}/{$tracks["$track"]['id']}.ogg") and file_exists("items/audio/{$data["$item"]['item_id']}/{$tracks["$track"]['id']}.mp3"))
        {
         $tracklisten = file_get_contents("templates/get_audio.html");
         $searchtrack  = array('%id%', '%trackname%', '%trackid%');
        // Womit soll das ersetzt werden?
         $replacetrack = array($data["$item"]['item_id'], $tracks["$track"]['name'], $tracks["$track"]['id']);
        // Finde und ersetze Platzhalter in $output
         $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
        }
      else
        {
         $tracklist .= "<tr><td align=\"left\" valign=\"center\"><img src=\"pics/transparent.png\" width=\"15\" height=\"15\" border=\"0\"> {$tracks["$track"]['name']}</td></tr>\n";
        }
     }
   $tracklist .= "</table></font>\n";
   $data["$item"]['item_details'] = $tracklist;
  }

/* ######################################################## */
/* Lese Vorlage aus Datei in einen String */
$itemtemplate = "templates/item_template.html";
$template = file_get_contents($itemtemplate);
$alt = "{$loc_lang["click_to_view"]} {$data["$item"]['item_type']} {$data["$item"]['item_name']}";
$value = "{$data["$item"]['item_preis']} &euro;/{$loc_lang["piece"]}";

  /* Was soll ersetzt werden? */
  $search  = array('%id%', 
                   '%name%', 
                   '%type%',
                   '%Type%',
                   '%TYPE%', 
                   '%descr%', 
                   '%preis%', 
                   '%pic%', 
                   '%details%',
                   '%alt%',
                   '%buy%',
                   '%value%',
                   '%lang%',
                   '%c%',
                   '%kartid%',
                   '%font_face%',
                   '%font_size%',
                   '%bgcolor%',
                   '%itemview_width%',
                   '%itemview_pic_height%',
                   '%alignment%',
                   '%shop_align%');
  /* Womit soll das ersetzt werden? */
  $replace = array($data["$item"]['item_id'], 
                   $data["$item"]['item_name'],
                   $ltype,
                   $data["$item"]['item_type'], 
                   $utype, 
                   $data["$item"]['item_descr'], 
                   $data["$item"]['item_preis'], 
                   $data["$item"]['item_pic'], 
                   $data["$item"]['item_details'],
                   $alt,
                   $loc_lang["into_shopping_kart"],
                   "{$data["$item"]['item_preis']} &euro;",
                   $lang,
                   $item,
                   $kartid,
                   $conf["font_face"],
                   $conf_["font_size"],
                   $conf["bgcolor"],
                   $item_conf["itemview_width"],
                   $item_conf["itemview_pic_height"],
                   $item_conf["align"],
                   $conf["shop_align"]);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
  echo "{$conf["font_style_close"]}\n";
?>
</font>
</body>
</html>
