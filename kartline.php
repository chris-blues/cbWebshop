<!DOCTYPE html>
<html>
<head>
<title>folkadelic hobo jamboree - symphonic punk disco folk</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="page-topic" content="folkadelic hobo jamboree - symphonic punk disco folk">
<meta name="description" content="folkadelic hobo jamboree - a musical mystery, a fine waste of time, a name german fans still can‘t pronounce? Yes! All that and more...">
<style type="text/css">
a:link { color: #24280F; text-decoration: none}
a:visited { color: #24280F; text-decoration: none}
a:hover { color: #999966; text-decoration: none }
</style>
</head>

<?php
$job = $_GET["job"];
$lang = $_GET["lang"];

if ($job == "additem") 
  {
   $newid = $_GET["id"];
   
/* LESE index.dat in array $data[][] und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n"); if ($newid == $buffer) $newitem = $counter;
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
  /* echo "Read $counter entries successfully from index.dat...<br>"; */
  
  $check = search_array($newid, $kart);
   if ($check != "FALSE") 
   {
    $kart[$check]["amount"]++;
    $kart[$check]["total"] = $kart[$itemamount]["amount"] * $data[$itemamount]["preis"];
   }
  
  $kart[$itemamount]["id"] = $data[$newitem]["id"];
  $kart[$itemamount]["name"] = $data[$newitem]["name"];
  $kart[$itemamount]["type"] = $data[$newitem]["type"];
  $kart[$itemamount]["preis"] = $data[$newitem]["preis"];
  for ($c = 1; $c <= $itemamount; $c++)
    {
     $kartcontent = "{$kart[$c]["name"]} ({$kart[$c]["type"]})<br>{$kart[$itemamount]["amount"]} x {$kart[$itemamount]["preis"]} = {$kart[$itemamount]["total"]}";
    }
  }
?>

<body>
  <p align="right">
  <em><font face="Georgia" size="3">
  <font size="5"><a href="shopcontent.php" target="shop">
      <?php
        if ($lang == "english") echo "Back to shop";
        else echo "Zur&uuml;ck zum Shop";
        $output = "</a></font><br><br><br><font size=\"3\"><a href=\"kart.php\" target=\"shop\"><b>";
        if ($lang == "english") { $output .= "Shopping Kart"; }  /* Spracheinstellung  */
        else { $output .= "Warenkorb"; }
        $output .= "</b></a><br><hr style=\"width:300px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:right;\"><font size=\"2\">";
        
        $output .= "</font>";
        echo "$output";
      ?>
  </font></em>
  </p>
</body>
</html>
