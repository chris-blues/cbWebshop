<?php
include('header_full.html');
echo "<body bgcolor=\"#544a31\" align=\"center\">\n";
$itemid = $_GET["item"]; 
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 
include('read_index.php');

if ($item == "") { echo "Error! $itemid does not exist in array!<br>\n<pre>"; print_r($data); echo "</pre>\n"; }

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($data["$item"]['item_type'] == "CD")
  {
   $counter = "0";
   $fHandle = fopen("items/{$data["$item"]['item_id']}.dat","r");
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
       $tracks["$counter"]['id'] = str_replace($char_search, $char_replace, $tracks["$counter"]['name']);
      }
     $counter--;
    }
   $tracklist = "<font size=\"2\"><table border=\"0\">\n";
   for ($track = "1"; $track <= $counter; $track++)
     {
      $tracklisten = file_get_contents("get_audio.html");
      $searchtrack  = array('%id%', '%trackname%', '%trackid%');
        /* Womit soll das ersetzt werden? */
        $replacetrack = array($data["$item"]['item_id'], $tracks["$track"]['name'], $tracks["$track"]['id']);
        /* Finde und ersetze Platzhalter in $output */
        $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
     }
   $tracklist .= "</table></font>";
   $data["$item"]['item_details'] = $tracklist;
  }

/* ######################################################## */
/* Lese Vorlage aus Datei in einen String */
$itemtemplate = "items/item_template.html";
$template = file_get_contents($itemtemplate);
  if ($lang == "english") 
    {
     $alt = "click here to view our {$data["$item"]['item_type']} {$data["$item"]['item_name']}";
     $buy = "into shopping kart";
     $value = "{$data["$item"]['item_preis']} &euro;/piece";
    }
  else 
    {
     $alt = "clicken Sie hier um {$data["$item"]['item_type']} {$data["$item"]['item_name']} anzusehen";
     $buy = "in den Warenkorb";
     $value = "{$data["$item"]['item_preis']} &euro;/St&uuml;ck";
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
                   '%details%',
                   '%alt%',
                   '%buy%',
                   '%value%',
                   '%lang%',
                   '%c%',
                   '%kartid%');
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
                   $buy,
                   $value,
                   $lang,
                   $item,
                   $kartid);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
?>
