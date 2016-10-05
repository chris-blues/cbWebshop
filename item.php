<?php
include('header.html');
echo "<body bgcolor=\"#544a31\" align=\"center\">\n";
$item = $_GET["item"]; 
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 
/* ######################################################## */

/* LESE index.dat in array $data[][] und schließe index.dat */
$counter = "0";
$fHandle = fopen("items/index.dat","r");
if ($fHandle != NULL)
 {
  while (!feof($fHandle))
   {
    $counter++;
    $buffer = fgets($fHandle); $data["$counter"]['item_id'] = trim($buffer,"\n"); if ($data["$counter"]['item_id'] == $item) $c = $counter;  /* Find out which array contains the wanted item */
    $buffer = fgets($fHandle); $data["$counter"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($fHandle); $data["$counter"]['item_type'] = trim($buffer,"\n"); $utype = strtoupper($buffer); $ltype = strtolower($buffer);
    $buffer = fgets($fHandle); $data["$counter"]['item_descr'] = trim($buffer,"\n");
    $buffer = fgets($fHandle); $data["$counter"]['item_preis'] = trim($buffer,"\n");
    $data["$counter"]['item_pic'] = "items/pics/{$data["$counter"]['item_id']}.png";
    $buffer = fgets($fHandle); $data["$counter"]['item_details'] = trim($buffer,"\n");
   }
 }
fclose($fHandle);
$counter--;
$itemamount = $counter;

if ($c == "") { echo "Error! $item does not exist in array!<br>\n<pre>"; print_r($data); echo "</pre>\n"; }

/* ######################################################## */
/* Erstelle Tracklist mit <audio> Playback */
if ($data["$c"]['item_type'] == "CD")
  {
   $counter = "0";
   $fHandle = fopen("items/{$data["$c"]['item_id']}.dat","r");
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
                            ".");
       $char_replace = array("_",
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
        $replacetrack = array($data["$c"]['item_id'], $tracks["$track"]['name'], $tracks["$track"]['id']);
        /* Finde und ersetze Platzhalter in $output */
        $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
     }
   $tracklist .= "</table></font>";
   $data["$c"]['item_details'] = $tracklist;
  }

/* ######################################################## */
/* Lese Vorlage aus Datei in einen String */
$itemtemplate = "items/item_template.html";
$template = file_get_contents($itemtemplate);
  if ($lang == "english") 
    {
     $alt = "click here to view our {$data["$c"]['item_type']} {$data["$c"]['item_name']}";
     $buy = "into shopping kart";
     $value = "{$data["$c"]['item_preis']} &euro;/piece";
    }
  else 
    {
     $alt = "clicken Sie hier um die {$data["$c"]['item_type']} {$data["$c"]['item_name']} anzusehen";
     $buy = "in den Warenkorb";
     $value = "{$data["$c"]['item_preis']} &euro;/St&uuml;ck";
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
  $replace = array($data["$c"]['item_id'], 
                   $data["$c"]['item_name'],
                   $ltype,
                   $data["$c"]['item_type'], 
                   $utype, 
                   $data["$c"]['item_descr'], 
                   $data["$c"]['item_preis'], 
                   $data["$c"]['item_pic'], 
                   $data["$c"]['item_details'],
                   $alt,
                   $buy,
                   $value,
                   $lang,
                   $c,
                   $kartid);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
?>
