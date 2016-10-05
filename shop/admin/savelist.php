<?php
include('header_short.php');
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
?>
<body onload="document.location.href='showitems.php'">

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
      $buffer = ((isset($_POST["item_name"])) && ($_POST["item_name"] != "")) ? $_POST["item_name"]:""; $data[$c]['item_name'] = trim($buffer,"\n");
        $newitem_id = strtolower($data[$c]['item_name']);
        $char_search = array("-",
                             " ",
                             "(",
                             ")",
                             "&",
                             "?",
                             "!",
                             ".",
                             "'",
                             "#");
        $char_replace = array("",
                              "",
                              "",
                              "",
                              "",
                              "",
                              "",
                              "",
                              "",
                              "");
        $data[$c]["item_id"] = str_replace($char_search, $char_replace, $newitem_id);
      $buffer = ((isset($_POST["item_type"])) && ($_POST["item_type"] != "")) ? $_POST["item_type"]:""; $data[$c]['item_type'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_descr"])) && ($_POST["item_descr"] != "")) ? $_POST["item_descr"]:""; $data[$c]['item_descr'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_preis"])) && ($_POST["item_preis"] != "")) ? $_POST["item_preis"]:""; $data[$c]['item_preis'] = trim($buffer,"\n");
      $buffer = ((isset($_POST["item_details"])) && ($_POST["item_details"] != "")) ? $_POST["item_details"]:"";
        $data[$c]['item_details'] = str_replace("\r\n","<br>",$buffer);
        $data[$c]['item_details'] = str_replace("\r","<br>",$data[$c]['item_details']);
        $data[$c]['item_details'] = str_replace("\n","<br>",$data[$c]['item_details']);
        $data[$c]['item_details'] = stripslashes($data[$c]['item_details']);
      $buffer = ((isset($_POST["tracklist"])) && ($_POST["tracklist"] != "")) ? $_POST["tracklist"]:"";
        $data[$c]['tracklist'] = str_replace("\r\n","<br>",$buffer);
        $data[$c]['tracklist'] = str_replace("\r","<br>",$data[$c]['tracklist']);
        $data[$c]['tracklist'] = str_replace("\n","<br>",$data[$c]['tracklist']);
        $data[$c]['tracklist'] = stripslashes($data[$c]['tracklist']);
     }  /* Daten sind abgeholt und einsortiert! */
     
   // Get category ( music | clothing )
   foreach ($conf["item_type"] as $keycat => $valcat)
     {
      if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type']) $cat = $conf["item_type"][$keycat]["cat"];
     }
   //echo "{$data[$c]["item_id"]}'s Type is {$data[$c]['item_type']} of Category: $cat<br>\n";

   // if Name and therefore ID has changed, change the filenames too!
   if ($data[$c]['item_id'] != $oldid)
     {
      echo "<b>ID has changed</b> - changing filenames accordingly...<br>\n";
      $oldfilename = "$oldid";
      $newfilename = "{$data[$c]['item_id']}";
      echo "../items/pics/$newfilename.png: ";
      if (!rename("../items/pics/$oldfilename.png", "../items/pics/$newfilename.png")) echo "ERROR renaming ../items/pics/$oldfilename.png to ../items/pics/$newfilename.png!<br>\n";
      else echo "OK<br>\n";
      echo "../items/pics/$newfilename.png.png: ";
      if (!rename("../items/pics/$oldfilename.png.png", "../items/pics/$newfilename.png.png")) echo "ERROR renaming ../items/pics/$oldfilename.png.png to ../items/pics/$newfilename.png.png!<br>\n";
      else echo "OK<br>\n";
      echo "../items/$newfilename.dat: ";
      if (!rename("../items/$oldfilename.dat", "../items/$newfilename.dat")) echo "ERROR renaming ../items/$oldfilename.dat to ../items/$newfilename.dat!<br>\n";
      else echo "OK<br>\n";
     }
   
   // Create new trackfile - content might have changed...
   if ($cat == "music")
     {
      $tracklistfile = "../items/{$data["$c"]['item_id']}.dat";
      $error = "0";
      echo "<b>Creating</b> $tracklistfile: ";
      $tracklist = str_replace("<br>", "\n", $data["$c"]['tracklist']);
      $tracklist = trim($tracklist,"\n");
      //$data["$c"]['item_details'] = "";
      if (!($tlfHandle = fopen($tracklistfile,"w"))) { echo "ERROR opening $tracklistfile!<br>\n"; $error = "1"; }
      fputs($tlfHandle, $tracklist); fputs($tlfHandle, "\n");
      if (!fclose($tlfHandle)) { echo "ERROR closing $tracklistfile!<br>\n"; $error = "1"; }
      if (!chmod($tracklistfile, 0755)) { echo "ERROR! Cannot change permissions for $tracklistfile!<br>\n"; $error = "1"; }
      if ($error != "1") { echo "OK<br>\n"; }
     }
   else
     {
      if (file_exists("../items/{$data["$c"]['item_id']}.dat"))
        {
         echo "<b>Deleting left-over tracklist-file:</b><br>\n../items/{$data["$c"]['item_id']}.dat: ";
         if (!unlink("../items/{$data["$c"]['item_id']}.dat"))  echo "ERROR deleting ../items/{$data["$c"]['item_id']}.dat<br>\n"; 
         else { echo "OK<br>\n"; }
        }
     }
  }

/* ############################################################# */

if ($job == "additem")  /* Wenn wir einen neuen Datensatz hinzufügen sollen */
{
 $counter++;
/* Hole neuen Datensatz von POST */
if((!$_POST["reset_x"]))
  {
    $buffer = ((isset($_POST["item_name"])) && ($_POST["item_name"] != "")) ? $_POST["item_name"]:""; $data[$counter]['item_name'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_type"])) && ($_POST["item_type"] != "")) ? $_POST["item_type"]:""; $data[$counter]['item_type'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_descr"])) && ($_POST["item_descr"] != "")) ? $_POST["item_descr"]:""; $data[$counter]['item_descr'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_preis"])) && ($_POST["item_preis"] != "")) ? $_POST["item_preis"]:""; $data[$counter]['item_preis'] = trim($buffer,"\n");
    $buffer = ((isset($_POST["item_details"])) && ($_POST["item_details"] != "")) ? $_POST["item_details"]:"";
    $data[$counter]['item_details'] = str_replace("\r\n","<br>",$buffer);
    $data[$counter]['item_details'] = str_replace("\r","<br>",$data[$counter]['item_details']);
    $data[$counter]['item_details'] = str_replace("\n","<br>",$data[$counter]['item_details']);
    $data[$counter]['item_details'] = stripslashes($data[$counter]['item_details']);
    $buffer = ((isset($_POST["tracklist"])) && ($_POST["tracklist"] != "")) ? $_POST["tracklist"]:"";
    $data[$counter]['tracklist'] = str_replace("\r\n","<br>",$buffer);
    $data[$counter]['tracklist'] = str_replace("\r","<br>",$data[$counter]['tracklist']);
    $data[$counter]['tracklist'] = str_replace("\n","<br>",$data[$counter]['tracklist']);
    $data[$counter]['tracklist'] = stripslashes($data[$counter]['tracklist']);
  }  /* Daten sind abgeholt! */
 $newitem_id = strtolower($data[$counter]['item_name']);
       $char_search = array("-",
                            " ",
                            "(",
                            ")",
                            "&",
                            "?",
                            "!",
                            ".",
                            "'",
                            "#");
       $char_replace = array("",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "");
       $data[$counter]["item_id"] = str_replace($char_search, $char_replace, $newitem_id);
 
}  /* Neuer Datensatz ist komplett eingelesen! */

/* ############################################################# */

// Hochgeladene Bilder speichern
$uploaddir = "items/pics";
$uploadfile = "../$uploaddir/{$data[$counter]['item_id']}.png";
//echo "<table border=\"1\"><tr><td><pre><h3>Upload</h3><br>";
if (move_uploaded_file($_FILES['upload_pic']['tmp_name'], $uploadfile)) 
  { /*echo "File is valid, and was successfully uploaded.<br>";*/ } 
else 
  { /*echo "Error! Could not move file to ../$uploaddir/<br>";*/ }
if (move_uploaded_file($_FILES['upload_pricetag']['tmp_name'], "$uploadfile.png")) 
  { /*echo "File is valid, and was successfully uploaded.<br>"; } 
else 
  { /*echo "Error! Could not move file to ../$uploaddir/<br>";*/ }
//echo "Here is some more debugging info:<br>";
chmod($uploadfile, 0755);
chmod("$uploadfile.png", 0755);
//echo "new filename: $uploadfile<br>";
//echo "new filename: $uploadfile.png<br>";
//echo "</pre></td></tr></table>";


/* SCHREIBE index.dat und schließe index.dat */
if ($job != "")    /* Falls kein Job angegeben wurde, schreibe keine neue index.dat! Wozu auch? */
 {
  $lnb = "\n";
  if (!$fHandle = fopen("../items/index.dat","w")) echo "ERROR opening index.dat!<br>\n";
  for ($c = "1"; $c <= $counter; $c++)
   {
    // Get category ( music | clothing )
    foreach ($conf["item_type"] as $keycat => $valcat)
      {
       if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type'])
         $cat = $conf["item_type"][$keycat]["cat"];
      }
    // echo "<b>$c / $counter :</b><br>\n";
    if ($job == "delete")          /* Wenn wir einen Datensatz $num löschen sollen... */
     {
      if ($c == $num)              /* Wenn wir den zu löschenden Eintrag erreicht haben */
        {
         $delitem = $data[$num]['item_id'];
         $delpic = $data[$num]['item_pic'];
         $output = "<b>deleting pics : </b><br>\n";
         $output .= "../{$data[$num]['item_pic']}: ";
         if (!unlink("../$delpic"))    /* versuche das Bild zu löschen! */
           { $output .= "Error! Could not delete ../{$data[$num]['item_pic']}!<br>\n"; }
         else { $output .= "OK<br>\n"; }
         $output .= "../{$data[$num]['item_pic']}.png: ";
         if (!unlink("../$delpic.png"))    /* versuche das Bild zu löschen! */
           { $output .= "Error! Could not delete ../{$data[$num]['item_pic']}.png!<br>\n"; }
         else { $output .= "OK<br>\n"; }
         if ($cat == "music")
           {
            $output .= "../items/$delitem.dat: ";
            if (!unlink("../items/$delitem.dat"))    /* versuche Tracklist zu löschen! */
              { $output .= "Error! Could not delete ../items/$delitem.dat!<br>\n"; }
            else { $output .= "OK<br>\n"; }
           }
         //echo "$output<br>";
         continue;     /* ...dann schreiben wir den betreffenden Datensatz einfach nicht wieder in die Datei! :) */
        }
     }
    if ($cat == "music")
      {
       if ($job == "additem" and $c == $counter)   // If we add a new item and reached it
         {
          $tracklist = str_replace("<br>", "\n", $data["$c"]['tracklist']);
          $tracklistfile = "../items/{$data["$c"]['item_id']}.dat";
          //$data["$c"]['item_details'] = "";
          if (!$tlfHandle = fopen($tracklistfile,"w")) echo "ERROR opening $tracklistfile!<br>\n";
          else echo "$tracklistfile created.<br>\n";
          fputs($tlfHandle, $tracklist); fputs($tlfHandle, "\n");
          fclose($tlfHandle);
          if (!chmod($tracklistfile, 0755)) echo "ERROR! Cannot change permissions for $tracklistfile!<br>\n";
          else echo "Permissions for $tracklistfile have been changed to 0755.<br>\n";
         }
       else
         {
          //$data["$c"]['item_details'] = "";
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
if ($job == "") { /*echo "<h3>No job assigned, so nothing happened!</h3>Here\'s the actual data tree:<br><br>"; print_r($data); */ }
echo "</pre></td></tr></table>";

// echo "<pre>"; print_r($data); echo "</pre>";

echo "<form action=\"showitems.php\"><input type=\"submit\" value=\" " . gettext("Back") . " \"></form>\n";
?>
</body>
</html>
