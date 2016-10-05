<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
     "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
<?php

/* $sth = array(key => value, key => value, key => value, key => value); */
/* $sth = array(1 => bla, foo, bar); wird zu  $sth[1] bla $sth["2"] foo $sth["3"] bar */

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
      $buffer = fgets($fHandle); $data[$counter]['item_pic'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $buffer = trim($buffer,"\n"); $data[$counter]['item_preview'] = $buffer;
     }
   }
   fclose($fHandle);
   $counter--;

/* Baue eine Liste der vorhandenen Items */
/* Überschrift */
echo "<table align=\"left\" border=\"1\"\n>";
echo "<tr><td><b>c</b><br></td>\n";
echo "<td align=\"left\">item_id</td>\n";
echo "<td align=\"left\">item_name</td>\n";
echo "<td align=\"left\">item_type</td>\n";
echo "<td align=\"left\">item_descr</td>\n";
echo "<td align=\"left\">item_preis</td>\n";
echo "<td align=\"left\">item_pic</td>\n";
echo "<td align=\"left\">item_preview</td>\n";
echo "</tr>\n";

/* Tabelleninhalt */
for ($c=1; $c <= $counter; $c++)
 {
  echo "<tr><td><b>$c</b><br><font size=\"1\"><a href=\"savelist.php?job=delete&amp;num=$c\">delete this item</a></font></td>";
  echo "<td align=\"left\">{$data[$c]['item_id']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_name']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_type']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_descr']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_preis']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_pic']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_preview']}</td>\n";
  echo "</tr>\n";
 }
?>
</table><br>
<br>
<table align="center" valign="center" border="0">
  <tr>
    <td align="left" valign="center">
      <form action="savelist.php?job=additem" method="post" accept-charset="UTF-8">
      <table>
        <tr><td align="right">item_id</td><td align="left"><input size="50" name="item_id" value=""></td></tr>
        <tr><td align="right">item_name</td><td align="left"><input size="50" name="item_name" value=""></td></tr>
        <tr><td align="right">item_type</td><td align="left"><input size="50" name="item_type" value=""></td></tr>
        <tr><td align="right">item_descr</td><td align="left"><input size="50" name="item_descr" value=""></td></tr>
        <tr><td align="right">item_preis</td><td align="left"><input size="50" name="item_preis" value=""></td></tr>
        <tr><td align="right">item_pic</td><td align="left"><input size="50" name="item_pic" value=""></td></tr>
        <tr><td align="right">item_preview</td><td align="left"><textarea name="item_preview" cols="50" rows="10"></textarea></td></tr>
        <tr>
        <td align="right"><input type="reset" value=" Reset "></td><td align="right"><input type="submit" value=" >>> Save! "></td></tr>
        </table>
      </form><br>
    </td>
  </tr>
</table>
<?php /* var_dump($data); */ ?>
</body>
</html>
