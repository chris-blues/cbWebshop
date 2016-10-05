<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
     "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>

<body>
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
      $buffer = fgets($fHandle); $data[$counter]['item_pic'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preview'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
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
echo "<td align=\"left\">item_details</td>\n";
echo "</tr>\n";

/* Tabelleninhalt */
for ($c=1; $c <= $counter; $c++)
 {
  echo "<tr><td><b>$c</b><br><font size=\"1\"><a href=\"savelist.php?job=delete&amp;num=$c\">delete this item</a></font></td>\n";
  echo "<td align=\"left\">{$data[$c]['item_id']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_name']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_type']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_descr']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_preis']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_pic']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_preview']}</td>\n";
  echo "<td align=\"left\">{$data[$c]['item_details']}</td>\n";
  echo "</tr>\n";
 }  /* Ende Tabelle */
?>
</table><br>
<br>
<table align="center" valign="center" border="0">
  <tr>
    <td align="left" valign="center">
      <form action="savelist.php?job=additem" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
      <table>
        <tr><td align="right" valign="center">item_id</td><td align="left" valign="center"><input size="50" name="item_id" value=""><font size="1">Nur Kleinbuchstaben und Zahlen, keine Leerzeichen!</font></td></tr>
        <tr><td align="right" valign="center">item_name</td><td align="left" valign="center"><input size="50" name="item_name" value=""><font size="1">der Name der angezeigt wird</font></td></tr>
        <tr><td align="right" valign="center">item_type</td><td align="left" valign="center"><input size="50" name="item_type" value=""><font size="1">z.Bsp.: CD, TShirt, Flugzeug...</font></td></tr>
        <tr><td align="right" valign="center">item_descr</td><td align="left" valign="center"><input size="50" name="item_descr" value=""><font size="1">mehr Infos (Jahr etc)</font></td></tr>
        <tr><td align="right" valign="center">item_preis</td><td align="left" valign="center"><input size="50" name="item_preis" value=""><font size="1">Artikel Preis / St&uuml;ck</font></td></tr>
        <tr><td align="right" valign="center">item_pic</td><td align="left" valign="center"><input size="35" name="upload" type="file"><font size="1">Bild (vorhandene Datei wird &uuml;berschrieben!)</font></td></tr>
        <tr><td align="right" valign="center">item_preview</td><td align="left" valign="center"><textarea name="item_preview" cols="50" rows="10"></textarea><font size="1">Vorschau (Soundcloud etc)</font></td></tr>
        <tr><td align="right" valign="center">item_details</td><td align="left" valign="center"><textarea name="item_details" cols="50" rows="10"></textarea><font size="1">Details (Playlist, Gr&ouml;ssen etc)</font></td></tr>
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
