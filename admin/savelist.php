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
    $buffer = ((isset($_POST["item_pic"])) && ($_POST["item_pic"] != "")) ? $_POST["item_pic"]:""; $data[$counter]['item_pic'] = $buffer;
    $buffer = ((isset($_POST["item_preview"])) && ($_POST["item_preview"] != "")) ? $_POST["item_preview"]:""; $data[$counter]['item_preview'] = $buffer;
 }
}  /* Neuer Datensatz ist eingelesen! */

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
     }
    $str = $data["$c"]['item_id']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_name']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_type']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_descr']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_preis']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_pic']; fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = $data["$c"]['item_preview']; $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
   }
  fclose("$fHandle");
/*  $message = "Successfully added Entry {$data[\"$c\"]['item_id']}"; */
 }
/* Kehre zurück zu showiemts.php und zeige den neuen Stand der Daten an! */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
     "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>folkadelic shop admin</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="1; URL=showitems.php">
</head>

<body align="center" valign="center">

<a href="showitems.php"><b>BACK!</b></a><br>
</body>
</html>
