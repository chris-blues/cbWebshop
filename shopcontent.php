<?php
include('header_short.html');
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 
?>
<body bgcolor="#544a31">
<font face="Georgia" size="3"><em>
<table width="500" border="0" align="center" bgcolor="#544a31">
  <tr>
<?php
include('read_index.php');
/* Lese Vorlage aus Datei in einen String */
$template = file_get_contents("items/item_template_shop.html");
$col = "1";
for ($c = 1; $c <= $itemamount; $c++)
 {
  if ($lang == "english") 
    {
     $alt = "click here to view our {$data["$c"]['item_type']} {$data["$c"]['item_name']}";
     $buy = "buy <b>{$data["$c"]['item_name']}</b>";
     $value = "pieces ({$data["$c"]['item_preis']} &euro;/piece)";
    }
  else 
    {
     $alt = "clicken Sie hier um {$data["$c"]['item_type']} {$data["$c"]['item_name']} anzusehen";
     $buy = "kaufe <b>{$data["$c"]['item_name']}</b>";
     $value = "St&uuml;ck ({$data["$c"]['item_preis']} &euro;/St&uuml;ck)";
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
                   '%kartid%',
                   '%lang%');
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
                   $lang);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
  if ($col == "1") 
    {
     $col = "2";
    }
  else
    {
     if ($itemamount != $c)
      {
       echo "</tr><tr height=\"40\"><td></td><td></td></tr><tr>\n";
       $col = "1";
      }
    }
 } 
?>
  </tr>
</table>
</em>
</font>
</body>
</html>
