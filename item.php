<?php
include('../header.html');
$item = $_GET["item"];
$lang = $_GET["lang"];
?>
<?php
/* LESE index.dat und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$id = $data[$counter]['item_id'];}
      $buffer = fgets($fHandle); $data[$counter]['item_name'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$name = $data[$counter]['item_name'];}
      $buffer = fgets($fHandle); $data[$counter]['item_type'] = trim($buffer,"\n"); $utype = strtoupper($buffer); $ltype = strtolower($buffer); if ($data[$counter]['item_id'] == $item) {$Type = $data[$counter]['item_type'];}
      $buffer = fgets($fHandle); $data[$counter]['item_descr'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$descr = $data[$counter]['item_descr'];}
      $buffer = fgets($fHandle); $data[$counter]['item_preis'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$preis = $data[$counter]['item_preis'];}
      $buffer = fgets($fHandle); $data[$counter]['item_pic'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$pic = $data[$counter]['item_pic'];}
      $buffer = fgets($fHandle); $data[$counter]['item_preview'] = trim($buffer,"\n"); if ($data[$counter]['item_id'] == $item) {$preview = $data[$counter]['item_preview'];}
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = str_replace('\n','<br>',$buffer); if ($data[$counter]['item_id'] == $item) {$details = $data[$counter]['item_details'];}
     }
   }
  fclose($fHandle);
  $counter--;
  $utype = strtoupper($Type); 
  $ltype = strtolower($Type);
   
$itemtemplate = "items/item_template.html";
/* Lese Vorlage aus Datei in einen String */
$template = file_get_contents($itemtemplate);
  if ($lang == "english") 
    {
     $alt = "click here to view our $Type $name";
     $buy = "into shopping kart";
     $value = "$preis &euro;/piece";
    }
  else 
    {
     $alt = "clicken Sie hier um die $Type $name anzusehen";
     $buy = "in den Warenkorb";
     $value = "$preis &euro;/St&uuml;ck";
    }
  /* echo "Read $counter entries successfully from index.dat...<br>";
  echo "Items Variables: $id, $name, $ltype, $Type, $utype, $descr, $preis, $pic, $preview, <br>$details, $alt, $buy, $value, $lang, $itemtemplate<br><hr>";  */
  
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
                   '%lang%');
  /* Womit soll das ersetzt werden? */
  $replace = array($id, 
                   $name,
                   $ltype,
                   $Type, 
                   $utype, 
                   $descr, 
                   $preis, 
                   $pic, 
                   $preview,
                   $details,
                   $alt,
                   $buy,
                   $value,
                   $lang);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
?>
