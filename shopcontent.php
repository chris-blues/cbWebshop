<!DOCTYPE HTML>
<html>
<head>
<title>folkadelic hobo jamboree - symphonic punk disco folk</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="page-topic" content="folkadelic hobo jamboree - symphonic punk disco folk">
<meta name="description" content="folkadelic hobo jamboree - a musical mystery, a fine waste of time, a name german fans still can‘t pronounce? Yes! All that and more...">
<script type="text/javascript" src="../jquery.fancybox-1.3.4/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="../jquery.fancybox-1.3.4/fancybox/jquery.easing-1.3.pack.js"></script>
<script type="text/javascript" src="../jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="../jquery.fancybox-1.3.4/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script>
$(document).ready(function() {
    $("a.fancy").fancybox({
        'transitionIn'   :   'elastic',
        'transitionOut'  :   'elastic',
        'speedIn'        :   600, 
        'speedOut'       :   400, 
        'overlayShow'    :   true,
        'overlayOpacity' :    0.0,
        'overlayColor'   :   '#333',
        'titlePosition'  :   'inside',
        'hideOnContentClick' : true
    });
});
</script>
<style type="text/css">
a:link { color: #24280F; text-decoration: none}
a:visited { color: #24280F; text-decoration: none}
a:hover { color: #999966; text-decoration: none }
</style>
</head>
<?php 
$lang = $_GET["lang"]; 
$kartid = $_GET["kartid"]; 

/* DEBUG */
/* echo "$lang";
echo "$kartid"; */
?>
<body bgcolor="#544a31">
<font face="Georgia" size="3"><em>
<table width="500" border="0" align="center" bgcolor="#544a31">
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
    $buffer = fgets($fHandle); $data["$counter"]['item_id'] = trim($buffer,"\n");
    $buffer = fgets($fHandle); $data["$counter"]['item_name'] = trim($buffer,"\n");
    $buffer = fgets($fHandle); $data["$counter"]['item_type'] = trim($buffer,"\n"); $utype = strtoupper($buffer); $ltype = strtolower($buffer);
    $buffer = fgets($fHandle); $data["$counter"]['item_descr'] = trim($buffer,"\n");
    $buffer = fgets($fHandle); $data["$counter"]['item_preis'] = trim($buffer,"\n");
    $data["$counter"]['item_pic'] = "items/pics/{$data["$counter"]['item_id']}.png";
    $buffer = fgets($fHandle); $data["$counter"]['item_details'] = trim($buffer,"\n");
   }
 }
fclose($fHandle);
$counter--;
/* echo "Read $counter entries successfully from index.dat...<br>"; */
$itemamount = $counter;
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
       echo "</tr><tr height=\"40\"><td></td><td></td></tr><tr>\n";
       $col = "1";
      }
    }
 } 
 /* echo "c : $c --- counter : $counter --- itemamount : $itemamount"; */
?>
  </tr>
</table>
</em>
</font>
</body>
</html>
