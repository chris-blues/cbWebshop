<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
     "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type="text/css">
a:link { color: #24280F; text-decoration: none}
a:visited { color: #24280F; text-decoration: none}
a:hover { color: #999966; text-decoration: none }
</style>
</head>

<body>
<center><form action="newitem.php"><input type="submit" value=" Add a new item "></form></center>
<?php
/* LESE index.dat und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("../items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_name'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_type'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_descr'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preis'] = trim($buffer,"\n");
      $data["$counter"]['item_pic'] = "items/pics/{$data["$counter"]['item_id']}.png";
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
     }
   }
   fclose($fHandle);
   $counter--;

/* ############################################################# */

echo "<table align=\"center\" border=\"0\">\n";
/* Tabelleninhalt */
$cols = "0";
for ($c=1; $c <= $counter; $c++)
 {
  $cols++;
  echo "  <td width=\"180\" height=\"225\" align=\"center\" valign=\"center\"><b>$c - {$data[$c]['item_name']}</b><br><img src=\"../items/pics/{$data[$c]['item_id']}.png\" height=\"100\"><br>\n";
  echo "    <form name=\"del-$c\" action=\"savelist.php\" method=\"get\" accept-charset=\"UTF-8\">\n";
  echo "      <input type=\"hidden\" name=\"job\" value=\"delete\">\n";
  echo "      <input type=\"hidden\" name=\"num\" value=\"$c\">\n";
  echo "      <input type=\"submit\" value=\" delete this item \"></form><form name=\"item-$c\" action=\"viewitem.php?c=$c\" method=\"post\" accept-charset=\"UTF-8\">\n";
  echo "    <input type=\"submit\" value=\" update this item \"></form>\n</td>\n";
  if ($cols == "4") echo "</tr>\n<tr>\n";
 }
?>
  
</table>
<?php /* echo "<pre>\n"; var_dump($data); echo "</pre>\n"; */ ?>
</body>
</html>
