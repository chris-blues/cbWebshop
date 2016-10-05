<?php
include('../header.html');
$item = $_GET["item"];
$lang = $GLOBALS["lang"];
$c = array_search($item, $GLOBAL["data"]);
$itemtemplate = "items/item_template.html";
/* Lese Vorlage aus Datei in einen String */
$template = file_get_contents($itemtemplate);
  if ($GLOBALS["lang"] == "english") 
    {
     $alt = "click here to view our {$GLOBAL["data"][$c]["type"]} {$GLOBAL["data"][$c]["$name"]}";
     $buy = "into shopping kart";
     $value = "{$GLOBAL["data"][$c]["preis"]} &euro;/piece";
    }
  else 
    {
     $alt = "clicken Sie hier um die {$GLOBAL["data"][$c]["type"]} {$GLOBAL["data"][$c]["$name"]} anzusehen";
     $buy = "in den Warenkorb";
     $value = "{$GLOBAL["data"][$c]["preis"]} &euro;/St&uuml;ck";
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
                   '%lang%',
                   '%c%');
  /* Womit soll das ersetzt werden? */
  $replace = array({$GLOBAL["data"][$c]["id"]}, 
                   {$GLOBAL["data"][$c]["name"]},
                   {$GLOBAL["ltype"]},
                   {$GLOBAL["data"][$c]["type"]}, 
                   {$GLOBAL["utype"]}, 
                   {$GLOBAL["data"][$c]["descr"]}, 
                   {$GLOBAL["data"][$c]["preis"]}, 
                   {$GLOBAL["data"][$c]["pic"]}, 
                   {$GLOBAL["data"][$c]["preview"]},
                   {$GLOBAL["data"][$c]["details"]},
                   $alt,
                   $buy,
                   $value,
                   {$GLOBAL["$lang"]},
                   $c);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
?>
