<?php
//$dir = getcwd();
//echo "DEBUG: write_kartfile.php<br>\nfile: $dir / $kartfile<br>\n";
/* Write new kart-tmp-file */
   $karthandle = fopen($kartfile, "w");
   if ($karthandle != NULL)
    {
     $lnb = "\n";
     $buffer = "";
     $buffer = trim($lang,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($countryname,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($opt,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($firstname,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($lastname,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($adress1,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($adress2,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($plz,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($city,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($province,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($email,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     $buffer = trim($newsletter,"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
     for ($c = "1"; $c <= $kartamount; $c++)
      {
       if ($_GET["job"] == "remove") { if ($kart["$c"]['item_id'] == $_GET["id"] and strcmp($kart["$c"]['item_size'],$_GET["size"]) == "0") continue; }
       $buffer = trim($kart["$c"]['item_id'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
       $buffer = trim($kart["$c"]['item_name'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
       $buffer = trim($kart["$c"]['item_type'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
       $buffer = trim($kart["$c"]['item_size'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
       $buffer = trim($kart["$c"]['item_preis'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
       $buffer = trim($kart["$c"]['item_amount'],"\n"); fputs($karthandle, $buffer); fputs($karthandle, $lnb);
      }
     $c--;
    }
   else echo "Error! Cannot open $kartfile!";
   fclose($karthandle);
   chmod($kartfile, 0777);
   if ($kartamount < 1) $kartamount = "0";
?>
