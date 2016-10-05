<?php include('../header.html'); 
if (!isset($lang)) $lang = $_GET["lang"]; ?>
<body>
<font face="Georgia" size="3"><em>
<table width="500" border="0" align="center">
  <tr>
<?php

/* LESE index.dat in array $data[][] und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n"); $newitem = $buffer;
      $buffer = fgets($fHandle); $data[$counter]['item_name'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_type'] = trim($buffer,"\n"); $utype = strtoupper($buffer); $ltype = strtolower($buffer);
      $buffer = fgets($fHandle); $data[$counter]['item_descr'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preis'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_pic'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preview'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
     }
   }
  fclose($fHandle);
  $counter--;
   echo "Read $counter entries successfully from index.dat...<br>"; 
$itemamount = $counter;
$itemtemplate = "items/item_template_shop.php";
/* Lese Vorlage aus Datei in einen String */
$template = file_get_contents($itemtemplate);
$col = "1";
for ($c = 1; $c <= $itemamount; $c++)
 {
  if ($lang] == "english") 
    {
     $alt = "click here to view our {$data["$c"]['item_type']} {$data["$c"]['item_name']}";
     $buy = "buy <b>{$data["$c"]['item_name']}</b>";
     $value = "pieces ({$data["$c"]['item_preis']} &euro;/piece)";
     echo "$lang";
    }
  else 
    {
     $alt = "clicken Sie hier um die {$data["$c"]['item_type']} {$data["$c"]['item_name']} anzusehen";
     $buy = "kaufe <b>{$data["$c"]['item_name']}</b>";
     $value = "St&uuml;ck ({$data["$c"]['item_preis']} &euro;/St&uuml;ck)";
     echo "$lang";
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
                   '%value%');
  /* Womit soll das ersetzt werden? */
  $replace = array($data["$c"]['item_id'], 
                   $data["$c"]['item_name'],
                   $ltype,
                   $data["$c"]['type'],
                   $utype,
                   $data["$c"]['item_descr'], 
                   $data["$c"]['item_preis'], 
                   $data["$c"]['item_pic'], 
                   $data["$c"]['item_preview'],
                   $data["$c"]['item_details'],
                   $alt,
                   $buy,
                   $value);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  /* echo "$col - $ltype - {$data["$c"]['item_type']}<br>"; */
  echo "$output";
  if ($col == "1") 
    {
     $col = "2";
    }
  else
    {
     if ($itemamount != $c)
      {
       echo "</tr><tr height=\"40\"><td></td><td></td></tr><tr>";
       $col = "1";
      }
    }
 } 
 echo "c : $c --- counter : $counter<br> --- itemamount : $itemamount";
?>
  </tr>
</table>
</em>
</font>
</body>
</html>
