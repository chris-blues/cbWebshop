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
if (!isset($lang)) $lang = $_GET["lang"];

if ($job == "additem") 
  {
   $c = $_GET["c"];
   $check = array_search($GLOBALS["data"][$c]["id"], $GLOBALS["kart"]);
   if ($check != "FALSE") 
    {
     $GLOBALS["kart"][1]["amount"] = 1;
     $GLOBALS["kart"][1]["total"] = $GLOBALS["kart"][1]["amount"] * $GLOBALS["data"][$c]["preis"];
    }
   else
    {
     $GLOBALS["kart"][$check]["amount"]++;
     $GLOBALS["kart"][$check]["total"] = $GLOBALS["kart"][$check]["amount"] * $GLOBALS["data"][$c]["preis"];
    }
  
  $GLOBALS["kart"][$itemamount]["id"] = $GLOBALS["data"][$c]["id"];
  $GLOBALS["kart"][$itemamount]["name"] = $GLOBALS["data"][$c]["name"];
  $GLOBALS["kart"][$itemamount]["type"] = $GLOBALS["data"][$c]["type"];
  $GLOBALS["kart"][$itemamount]["preis"] = $GLOBALS["data"][$c]["preis"];
  for ($counter = 1; $counter <= $itemamount; $counter++)
    {
     $kartcontent = "{$kart[$counter]["name"]} ({$kart[$counter]["type"]})<br>{$kart[$itemamount]["amount"]} x {$kart[$itemamount]["preis"]} = {$kart[$itemamount]["total"]}";
    }
  }
?>

<body>
  <p align="right">
  <em><font face="Georgia" size="3">
  <font size="5"><a href="shopcontent.php<?php echo "?lang=$lang&amp;itemlist=$itemlist"; ?>" target="shop">
      <?php
        if ($lang == "english") echo "Back to shop";
        else echo "Zur&uuml;ck zum Shop";
        $output = "</a></font><br><br><br><font size=\"3\"><a href=\"kart.php\" target=\"shop\"><b>";
        if ($lang == "english") { $output .= "Shopping Kart"; }  /* Spracheinstellung  */
        else { $output .= "Warenkorb"; }
        $output .= "</b></a></font><br><hr style=\"width:300px; color:#000000; background-color:#544a31; height:1px; margin-right:0; text-align:right;\"><font size=\"2\">";
        
        $output .= "</font>";
        echo "$output";
      ?>
  </font></em>
  </p>
</body>
</html>
