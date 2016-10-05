<?php include('header_short.html'); ?>

<body>
<center><form action="newitem.php"><input type="submit" value=" Add a new item "></form></center>
<?php
$modus = "simple";
include('read_index.php');

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
