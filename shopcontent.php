<?php
include('conf/shop_conf.php');
include('conf/item_conf.php');
include('header_short.html');
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');

echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n{$conf["font_style"]}\n";
$tablewidth = $conf["shop_width"] - 50;
echo "<table width=\"$tablewidth\" align=\"{$conf["shop_align"]}\" border=\"0\">\n  <tr>\n";

include('read_index.php');
/* Lese Vorlage aus Datei in einen String */
$col = "0";
$template = file_get_contents("templates/item_template_shop.html");
for ($c = 1; $c <= $itemamount; $c++)
 {
  $col++;
  $alt = "{$loc_lang["click_to_view"]} {$data["$c"]['item_type']} {$data["$c"]['item_name']}{$loc_lang["click_to_view_add"]}";
  $buy = "{$loc_lang["buy"]} <b>{$data["$c"]['item_name']}</b>";
  $value = "{$loc_lang["pieces"]} ({$data["$c"]['item_preis']} &euro;/{$loc_lang["piece"]})";

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
                   '%kartid%',
                   '%lang%',
                   '%shop_width%',
                   '%shop_height%',
                   '%shop_pic_height%');
  /* Womit soll das ersetzt werden? */
  $replace = array($data["$c"]['item_id'],
                   $data["$c"]['item_name'],
                   $ltype,
                   $data["$c"]['item_type'],
                   $utype,
                   $data["$c"]['item_descr'],
                   $data["$c"]['item_preis'],
                   $data["$c"]['item_pic'],
                   $data["$c"]['item_preview'],
                   $data["$c"]['item_details'],
                   $alt,
                   $buy,
                   $value,
                   $kartid,
                   $lang,
                   $item_conf["shop_width"],
                   $item_conf["shop_height"],
                   $item_conf["shop_pic_height"]);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
  if ($col == $conf["shop_columns"]) { echo "  </tr>\n  <tr>\n"; $col = "0"; }
 }
 
echo "  </tr>\n</table>\n{$conf["font_style_close"]}\n";
?>
</font>
</body>
</html>
