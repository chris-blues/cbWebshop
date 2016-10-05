<!DOCTYPE html>
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
<center>
  <form action="showitems.php">
    <input type="submit" value=" <<< BACK ">
  </form>
<?php
  echo "  <form name=\"del-$c\" action=\"savelist.php\" method=\"get\" accept-charset=\"UTF-8\">\n";
  echo "    <input type=\"hidden\" name=\"job\" value=\"delete\">\n";
  echo "    <input type=\"hidden\" name=\"num\" value=\"$c\">\n";
  echo "    <input type=\"submit\" value=\" delete this item \">\n  </form>\n</center>\n";

$c = $_GET["c"];

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
      if ($data[$counter]['item_type'] == "CD") 
        {
         $tracklist = "../items/{$data[$counter]['item_id']}.dat";
         $data[$counter]['item_details'] = file_get_contents($tracklist);
         $data[$counter]['item_details'] = trim($data[$counter]['item_details'],"\n");
        }
      else $data[$counter]['item_details'] = str_replace("<br>","\n",$data[$counter]['item_details']);
     }
   }
   fclose($fHandle);
   $counter--;

/* ############################################################# */

  echo "<form name=\"item-$c\" action=\"savelist.php?job=updateitem\" method=\"post\" accept-charset=\"UTF-8\" enctype=\"multipart/form-data\">\n";
  echo "<table border=\"0\" align=\"center\">\n";
  echo "  <tr>\n    <td>\n      <b>$c</b><br>\n      <img src=\"../{$data[$c]['item_pic']}\" height=\"120\"><br>\n";
  echo "    </td>\n    <td align=\"right\">\n";
  echo "      ID:<input name=\"item_id\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_id']}\"><br>\n";
  echo "      Name:<input name=\"item_name\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_name']}\"><br>\n";
  echo "      Type:<input name=\"item_type\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_type']}\"><br>\n";
  if ($data[$c]['item_type'] == "CD") 
    {
     echo "      Year:<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_descr']}\"><br>\n";
    }
  if ($data[$c]['item_type'] == "TShirt") 
    {
     echo "      <input name=\"item_descr\" type=\"hidden\" value=\"\">\n";
    }
  if ($data[$c]['item_type'] != "CD" and $data[$c]['item_type'] != "TShirt")
    {
     echo "      Descr:<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_descr']}\"><br>\n";
    }
  echo "      Preis:<input name=\"item_preis\" type=\"text\" length=\"20\" value=\"{$data[$c]['item_preis']}\"><br>\n";
  echo "    </td>\n  </tr>\n  <tr>\n    <td align=\"left\" colspan=\"2\">\n      Details:<br>\n";
  echo "      <textarea name=\"item_details\" cols=\"50\" rows=\"8\">{$data[$c]['item_details']}</textarea><br>\n";
  echo "      <input type=\"submit\" value=\" update this item \">\n      <input type=\"hidden\" name=\"c\" value=\"$c\">\n";
  echo "    </td>\n  </tr>\n";
  /* echo "<pre>";print_r($data);echo "</pre>"; */
?>
</table>
</form>
</body>
</html>
