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
      $buffer = fgets($fHandle); $data[$counter]['item_preview'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
      
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
    $buffer = ((isset($_POST["item_preview"])) && ($_POST["item_preview"] != "")) ? $_POST["item_preview"]:""; $data[$counter]['item_preview'] = $buffer;
    $buffer = ((isset($_POST["item_preview"])) && ($_POST["item_preview"] != "")) ? $_POST["item_preview"]:""; $data[$counter]['item_details'] = nl2br($buffer, false);
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
  { echo "Could not move file to $uploaddir<br>"; }
 echo 'Here is some more debugging info:<br>';
 echo "filename: $uploadfile<br>";
 print_r($_FILES);
 echo "</pre></td></tr></table>";
 $data[$counter]['item_pic'] = "$type/" . basename($_FILES['upload']['name']);
 
}  /* Neuer Datensatz ist komplett eingelesen! */

/* SCHREIBE index.dat und schließe index.dat */
if ($job != "")
 {
  $lnb = "\n";
  $fHandle = fopen("../items/index.dat","w");
  for ($c = "1"; $c <= $counter; $c++)
   {
    if ($job == "delete")  /* Wenn wir einen Datensatz $num löschen sollen... */
     {
      if ($c == $num) { continue; }  /* ...dann schreiben wir ihn einfach nicht wieder in die Datei! :) */
      $delitem = $data["$c"]['item_id'];
     }
    $str = $data["$c"]['item_id']; fputs($fHandle, $str); fputs($fHandle, $lnb); $newitem = $str;
    $str = $data["$c"]['item_name']; fputs($fHandle, $str); fputs($fHandle, $lnb); 
    $str = $data["$c"]['item_type']; fputs($fHandle, $str); fputs($fHandle, $lnb); $utype = strtoupper($str);
    $str = $data["$c"]['item_descr']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_preis']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_pic']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_preview']; $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_details']; $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
   }
  fclose("$fHandle");
 }
echo "<table border=\"1\"><tr><td><pre><h2>index.dat</h2><br>"; /* Sage dem user was passiert ist mit index.dat */
if ($job == "delete")  { echo "<h3>Successfully deleted Entry $delitem</h3><br><br>"; }
if ($job == "additem") { echo "<h3>Successfully added Entry $newitem</h3><br><br>"; }
if ($job == "") { echo "<h3>Nothing happened! Here's the actual data tree:</h3><br><br>"; print_r($data); }
echo "</pre></td></tr></table>"; 

if ($job == "additem") 
{
/* Erzeuge php und html files aus den Daten mit Hilfe der Vorlage templates/item_template.php und info_template.html */
/* Erzeuge ../items/type_name.php */
$ltype = strtolower($utype);
$newitemfile = "../items/$ltype" . "_$newitem.php";
$fHandle = fopen($newitemfile,"w");
fclose($fHandle);
chmod($newitemfile, 0777);
$itemtemplate = "templates/item_template.php";

$template = file_get_contents($itemtemplate); /* Lese Vorlage aus Datei in einen String */

/* Was soll ersetzt werden? */
$search  = array('%id%', 
                 '$name$', 
                 '%type%', 
                 '%TYPE%', 
                 '%descr%', 
                 '%preis%', 
                 '%pic%', 
                 '%preview%');
/* Womit soll das ersetzt werden? */
$replace = array($data["$c"]['item_id'], 
                 $data["$c"]['item_name'], 
                 $data["$c"]['item_type'], 
                 $utype, 
                 $data["$c"]['item_descr'], 
                 $str = $data["$c"]['item_preis'], 
                 $data["$c"]['item_pic'], 
                 $data["$c"]['item_preview']);
$output = str_replace($search, $replace, $template);                /* Finde und ersetze Platzhalter im String */
echo "<table border=\"1\"><tr><td><pre><h2>$newitemfile</h2><br>";  /* Sage dem user was passiert ist mit ../items/type_name.php */
$em = file_put_contents($newitemfile, $output);                     /* Schreibe String in Datei ../items/type_name.php */
echo "em: $em";
if (!$em)
  { echo "<h3>Error!</h3><br>File could not be written.<br><br>"; }
else
  { echo "<h3>Success!</h3><br>File has been written with $em bytes.<br><br>"; }
echo "</pre></td></tr></table>";

/* Erzeuge ../items/type/name.html  */
$newinfofile = "../items/$ltype/$newitem.html";
$infotemplate = "templates/info_template.html";

$fHandle = fopen($newinfofile,"w");
fclose($fHandle);
chmod($newinfofile, 0777);

$template = file_get_contents($infotemplate); /* Lese Vorlage aus Datei in einen String */

/* Was soll ersetzt werden? */
$search  = array('%id%', 
                 '$name$', 
                 '%type%', 
                 '%TYPE%', 
                 '%descr%', 
                 '%preis%', 
                 '%pic%', 
                 '%preview%',
                 '%details%');
/* Womit soll das ersetzt werden? */
$replace = array($data["$c"]['item_id'], 
                 $data["$c"]['item_name'], 
                 $data["$c"]['item_type'], 
                 $utype, 
                 $data["$c"]['item_descr'], 
                 $str = $data["$c"]['item_preis'], 
                 $data["$c"]['item_pic'], 
                 $data["$c"]['item_preview'],
                 $data["$c"]['item_details']);
$output = str_replace($search, $replace, $template);                /* Finde und ersetze Platzhalter im String */
echo "<table border=\"1\"><tr><td><pre><h2>$newinfofile</h2><br>";  /* Sage dem user was passiert ist mit ../items/type_name.php */
$em = file_put_contents($newinfofile, $output);                     /* Schreibe String in Datei ../items/type/name.php */
if (!$em)
  { echo "<h3>Error!</h3><br>File could not be written.<br><br>"; }
else
  { echo "<h3>Success!</h3><br>File has been written with $em bytes.<br><br>"; }
echo "</pre></td></tr></table>";

}   /* ENDE Dateierzeugung für neues Item */

/* Kehre zurück zu showiemts.php und zeige den neuen Stand der Daten an! */
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
