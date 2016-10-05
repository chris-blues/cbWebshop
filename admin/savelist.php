<?php include('header_short.html'); ?>
<body align="center" valign="top">

<?php 
$job = $_GET["job"];  /* Was sollen wir tun? job=additem == neuen eintrag hinzufügen */
$num = $_GET["num"];  /*                     job=delete  == lösche Item Nr. $num     */

include('read_index.php');

if ($job == "updateitem")  /* Wenn wir einen bestehenden Datensatz verändern sollen */
  {
   if((!$_POST["reset_x"]))
     {
      $buffer = ((isset($_POST["c"])) && ($_POST["c"] != "")) ? $_POST["c"]:""; $c = trim($buffer,"\n");
      $buffer = ((isset($_POST["oldid"])) && ($_POST["oldid"] != "")) ? $_POST["oldid"]:""; $oldid = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_id"])) && ($_POST["item_id"] != "")) ? $_POST["item_id"]:""; $data[$c]['item_id'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_name"])) && ($_POST["item_name"] != "")) ? $_POST["item_name"]:""; $data[$c]['item_name'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_type"])) && ($_POST["item_type"] != "")) ? $_POST["item_type"]:""; $data[$c]['item_type'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_descr"])) && ($_POST["item_descr"] != "")) ? $_POST["item_descr"]:""; $data[$c]['item_descr'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_preis"])) && ($_POST["item_preis"] != "")) ? $_POST["item_preis"]:""; $data[$c]['item_preis'] = trim($buffer,"\n");
      $data["$c"]['item_pic'] = "items/pics/{$data["$c"]['item_id']}.png";
      $buffer = ((isset($_POST["item_details"])) && ($_POST["item_details"] != "")) ? $_POST["item_details"]:""; 
      $data[$c]['item_details'] = str_replace("\r\n","<br>",$buffer);
      $data[$c]['item_details'] = str_replace("\r","<br>",$data[$c]['item_details']);
      $data[$c]['item_details'] = str_replace("\n","<br>",$data[$c]['item_details']);
      $data[$c]['item_details'] = stripslashes($data[$c]['item_details']);
     }  /* Daten sind abgeholt und einsortiert! */
   if ($data[$c]['item_id'] != $oldid)
     {
      $oldfilename = "items/pics/$oldid.png";
      $newfilename = "items/pics/{$data[$c]['item_id']}.png";
      if (!rename("../$oldfilename", "../$newfilename")) echo "ERROR renaming $oldfilename to $newfilename!<br>\n";
      if (!rename("../$oldfilename.png", "../$newfilename.png")) echo "ERROR renaming $oldfilename to $newfilename!<br>\n";
      if (!unlink("../items/$oldid.dat")) echo "ERROR deleting items/$oldid.dat!<br>\n";
     }
  }

/* ############################################################# */

if ($job == "additem")  /* Wenn wir einen neuen Datensatz hinzufügen sollen */
{
 $counter++;
/* Hole neuen Datensatz von POST */
if((!$_POST["reset_x"]))
  {
    $buffer = ((isset($_POST["item_id"])) && ($_POST["item_id"] != "")) ? $_POST["item_id"]:""; $data[$counter]['item_id'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_name"])) && ($_POST["item_name"] != "")) ? $_POST["item_name"]:""; $data[$counter]['item_name'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_type"])) && ($_POST["item_type"] != "")) ? $_POST["item_type"]:""; $data[$counter]['item_type'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_descr"])) && ($_POST["item_descr"] != "")) ? $_POST["item_descr"]:""; $data[$counter]['item_descr'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_preis"])) && ($_POST["item_preis"] != "")) ? $_POST["item_preis"]:""; $data[$counter]['item_preis'] = trim($buffer,"\n");
    $data["$counter"]['item_pic'] = "items/pics/{$data["$counter"]['item_id']}.png";
    $buffer = ((isset($_POST["item_details"])) && ($_POST["item_details"] != "")) ? $_POST["item_details"]:""; 
    $data[$counter]['item_details'] = str_replace("\r\n","<br>",$buffer);
    $data[$counter]['item_details'] = str_replace("\r","<br>",$data[$counter]['item_details']);
    $data[$counter]['item_details'] = str_replace("\n","<br>",$data[$counter]['item_details']);
    $data[$counter]['item_details'] = stripslashes($data[$counter]['item_details']);
  }  /* Daten sind abgeholt! */
 
 $uploaddir = "items/pics";
 $uploadfile = "../$uploaddir/{$data[$counter]['item_id']}.png";
 echo "<table border=\"1\"><tr><td><pre><h3>Upload</h3><br>";
 if (move_uploaded_file($_FILES['upload_pic']['tmp_name'], $uploadfile)) 
   { echo "File is valid, and was successfully uploaded.<br>"; } 
 else 
   { echo "Error! Could not move file to ../$uploaddir/<br>"; }
 if (move_uploaded_file($_FILES['upload_pricetag']['tmp_name'], "$uploadfile.png")) 
   { echo "File is valid, and was successfully uploaded.<br>"; } 
 else 
   { echo "Error! Could not move file to ../$uploaddir/<br>"; }
 echo "Here is some more debugging info:<br>";
 chmod($uploadfile, 0755);
 chmod("$uploadfile.png", 0755);
 echo "new filename: $uploadfile<br>";
 echo "new filename: $uploadfile.png<br>";
 print_r($_FILES);
 echo "</pre></td></tr></table>";
}  /* Neuer Datensatz ist komplett eingelesen und Bilder hochgeladen! */

/* ############################################################# */

/* SCHREIBE index.dat und schließe index.dat */
if ($job != "")    /* Falls kein Job angegeben wurde, schreibe keine neue index.dat! Wozu auch? */
 {
  $lnb = "\n";
  if (!$fHandle = fopen("../items/index.dat","w")) echo "ERROR opening index.dat!<br>\n";
  for ($c = "1"; $c <= $counter; $c++)
   {
    echo "<b>$c / $counter :</b><br>\n";
    if ($job == "delete")          /* Wenn wir einen Datensatz $num löschen sollen... */
     {
      if ($c == $num)              /* Wenn wir den zu löschenden Eintrag erreicht haben */
        {
         $delitem = $data[$num]['item_id'];
         $delpic = $data[$num]['item_pic'];
         $output = "deleting pics : <br>\n";
         if (!unlink("../$delpic"))    /* versuche das Bild zu löschen! */
           { $output .= "Error! Could not delete {$data[$num]['item_pic']}!<br>\n"; }
         else { $output .= "{$data[$num]['item_pic']} deleted.<br>\n"; }
         if (!unlink("../$delpic.png"))    /* versuche das Bild zu löschen! */
           { $output .= "Error! Could not delete {$data[$num]['item_pic']}.png!<br>\n"; }
         else { $output .= "{$data[$num]['item_pic']}.png deleted.<br>\n"; }
         if ($data[$num]['item_type'] == "CD")
           {
            if (!unlink("../items/$delitem.dat"))    /* versuche Tracklist zu löschen! */
              { $output .= "Error! Could not delete ../items/$delitem.dat!<br>\n"; }
            else { $output .= "../items/$delitem.dat deleted.<br>\n"; }
           }
         echo "$output<br>";
         continue;     /* ...dann schreiben wir den betreffenden Datensatz einfach nicht wieder in die Datei! :) */
        }
     }
    if ($data[$c]['item_type'] == "CD")
      {
       if ($c == $counter)
         {
          $tracklist = str_replace("<br>", "\n", $data["$c"]['item_details']);
          $tracklistfile = "../items/{$data["$c"]['item_id']}.dat";
          $data["$c"]['item_details'] = "";
          if (!$tlfHandle = fopen($tracklistfile,"w")) echo "ERROR opening $tracklistfile!<br>\n";
          else echo "$tracklistfile created.<br>\n";
          fputs($tlfHandle, $tracklist); fputs($tlfHandle, "\n");
          fclose($tlfHandle);
          if (!chmod($tracklistfile, 0755)) echo "ERROR! Cannot change permissions for $tracklistfile!<br>\n";
          else echo "Permissions for $tracklistfile have been changed to 0755.<br>\n";
         }
       else
         {
          $data["$c"]['item_details'] = "";
         }
      }
    $str = trim($data["$c"]['item_id'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_name'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb); 
    $str = trim($data["$c"]['item_type'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_descr'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_preis'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
    $str = trim($data["$c"]['item_details'],"\n"); $str = stripslashes($str); fputs($fHandle, $str); fputs($fHandle, $lnb);
   }
  fclose($fHandle);
 }

/* ############################################################# */

echo "<table border=\"1\" align=\"center\"><tr><td><pre><h2>index.dat</h2><br>"; /* Sage dem user was passiert ist mit index.dat */
if ($job == "delete")  { echo "<h3>Successfully deleted Entry $delitem</h3><br><br>"; }
if ($job == "additem") { echo "<h3>Successfully added Entry {$data[$c]['item_id']}</h3><br><br>\n$tracklistfile<br>\n"; }
if ($job == "updateitem") { echo "<h3>Successfully updated Entry {$data[$c]['item_id']}</h3><br><br>\n$tracklistfile<br>\n"; }
if ($job == "") { echo "<h3>No job assigned, so nothing happened!</h3>Here\'s the actual data tree:<br><br>"; print_r($data); }
echo "</pre></td></tr></table>";

/* echo "<pre>"; print_r($data); echo "</pre>"; */

/* Kehre zurück zu showitems.php und zeige den neuen Stand der Daten an! */
?>


<center><form action="showitems.php"><input type="submit" value=" Back "></form></center>
</body>
</html>
