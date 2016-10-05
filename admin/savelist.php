<?php $job = $_GET["job"];  /* Was sollen wir tun? */
                            /* additem = neuen eintrag hinzufügen */
      $num = $_GET["num"];  /* delete = lösche Item Nr. $num */

/* Lese vorhandene Datei ein und erstelle Daten-Array */
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
      $buffer = fgets($fHandle); $buffer = str_replace('\n','<br>',$buffer); $data[$counter]['item_preview'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $buffer = str_replace('\n','<br>',$buffer); $data[$counter]['item_details'] = trim($buffer,"\n");
     }
   }
   fclose($fHandle);
   $counter--;
/* Jetzt sollten wir alle bisherigen Daten haben! */

if ($job == "additem")  /* Wenn wir einen Datensatz hinzufügen sollen */
{
 $counter++;
/* Hole neuen Datensatz von POST */
if((!$_POST["reset_x"]))
 { 
    $buffer = ((isset($_POST["item_id"])) && ($_POST["item_id"] != "")) ? $_POST["item_id"]:""; $data[$counter]['item_id'] = $buffer;
    $buffer = ((isset($_POST["item_name"])) && ($_POST["item_name"] != "")) ? $_POST["item_name"]:""; $data[$counter]['item_name'] = $buffer;
    $buffer = ((isset($_POST["item_type"])) && ($_POST["item_type"] != "")) ? $_POST["item_type"]:""; $data[$counter]['item_type'] = $buffer;
    $buffer = ((isset($_POST["item_descr"])) && ($_POST["item_descr"] != "")) ? $_POST["item_descr"]:""; $data[$counter]['item_descr'] = $buffer;
    $buffer = ((isset($_POST["item_preis"])) && ($_POST["item_preis"] != "")) ? $_POST["item_preis"]:""; $data[$counter]['item_preis'] = $buffer;
    $buffer = ((isset($_POST["upload"])) && ($_POST["upload"] != "")) ? $_POST["upload"]:""; $upload = $buffer; 
    $buffer = ((isset($_POST["item_preview"])) && ($_POST["item_preview"] != "")) ? $_POST["item_preview"]:""; $data[$counter]['item_preview'] = str_replace('\n','<br>',$buffer);
    $buffer = ((isset($_POST["item_details"])) && ($_POST["item_details"] != "")) ? $_POST["item_details"]:""; $data[$counter]['item_details'] = str_replace('\n','<br>',$buffer);
 }  /* Daten sind abgeholt! */
 
 $type = strtolower($data["$counter"]['item_type']);
 $uploaddir = "../items/";
 $uploaddir .= "$type/";
 mkdir($uploaddir, 0777);
 $uploadfile = $uploaddir . basename($_FILES['upload']['name']);
 echo "<table border=\"1\"><tr><td><pre><h3>Upload</h3><br>";
 if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) 
  { echo "File is valid, and was successfully uploaded.<br>"; } 
 else 
  { echo "Error! Could not move file to $uploaddir<br>"; }
 echo 'Here is some more debugging info:<br>';
 echo "filename: $uploadfile<br>";
 print_r($_FILES);
 echo "</pre></td></tr></table>";
 $data[$counter]['item_pic'] = "$type/" . basename($_FILES['upload']['name']);
 chmod($uploadfile, 0755);
 
}  /* Neuer Datensatz ist komplett eingelesen! */

/* SCHREIBE index.dat und schließe index.dat */
if ($job != "")
 {
  $lnb = "\n";
  $fHandle = fopen("../items/index.dat","w");
  for ($c = "1"; $c <= $counter; $c++)
   {
    if ($job == "delete")          /* Wenn wir einen Datensatz $num löschen sollen... */
     {
      if ($c == $num) { $delitem = $data["$c"]['item_id']; continue; }  /* ...dann schreiben wir diesen einfach nicht wieder in die Datei! :) */
     }
    $str = trim($data["$c"]['item_id'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_name'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb); 
    $str = trim($data["$c"]['item_type'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_descr'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_preis'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_pic'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_preview'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_details'],"\n"); fputs($fHandle, $str); fputs($fHandle, $lnb);
   }
  fclose("$fHandle");
 }

echo "<table border=\"1\"><tr><td><pre><h2>index.dat</h2><br>"; /* Sage dem user was passiert ist mit index.dat */
if ($job == "delete")  { echo "<h3>Successfully deleted Entry $delitem</h3><br><br>"; }
if ($job == "additem") { $newitem = $data["$c"]['item_id']; echo "<h3>Successfully added Entry $newitem</h3><br><br>"; print_r($data); }
if ($job == "") { echo "<h3>Nothing happened! Here's the actual data tree:</h3><br><br>"; print_r($data); }
echo "</pre></td></tr></table>"; 

/* Kehre zurück zu showitems.php und zeige den neuen Stand der Daten an! */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
     "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!--meta http-equiv="refresh" content="1; URL=showitems.php"-->
</head>

<body align="center" valign="center">

<a href="showitems.php"><b>BACK!</b></a><br>
</body>
</html>
