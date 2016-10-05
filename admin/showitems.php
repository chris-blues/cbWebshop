<?php 
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
echo "<body>\n";

$modus = "simple";
include('read_index.php');

echo "<table align=\"center\" border=\"0\">\n<tr>\n";
/* Tabelleninhalt */
$cols = "0";
for ($c=1; $c <= $counter; $c++)
 {
  $cols++;
  echo "  <td width=\"180\" height=\"225\" align=\"center\" valign=\"center\"><b>$c - {$data[$c]['item_name']}</b><br>\n";
  echo "    <a href=\"viewitem.php?c=$c\">\n";
  echo "    <img src=\"../items/pics/{$data[$c]['item_id']}.png\" height=\"100\" border=\"0\"></a><br>\n";
  echo "    <form name=\"item-$c\" action=\"viewitem.php?c=$c\" method=\"post\" accept-charset=\"UTF-8\">\n";
  echo "    <input type=\"submit\" value=\"{$loc_lang["admin_edit_item"]}\"></form>\n</td>\n";
  if ($cols == "4") echo "</tr>\n<tr>\n";
 }
?>
  </tr>  
</table>
</body>
</html>
