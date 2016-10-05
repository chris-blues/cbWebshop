<?php

/* LESE index.dat und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n");
         if ($data["$counter"]['item_id'] == $itemid) $item = $counter;
         if ($data["$counter"]['item_id'] == $id) $newitem = $counter;
      $buffer = fgets($fHandle); $data[$counter]['item_name'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_type'] = trim($buffer,"\n"); $utype = strtoupper($buffer); $ltype = strtolower($buffer);
      $buffer = fgets($fHandle); $data[$counter]['item_descr'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preis'] = trim($buffer,"\n");
      $data["$counter"]['item_pic'] = "items/pics/{$data["$counter"]['item_id']}.png";
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
      if ($modus != "simple")
        {
         if ($data[$counter]['item_type'] == "CD") 
           {
            $tracklist = "../items/{$data[$counter]['item_id']}.dat";
            $data[$counter]['item_details'] = file_get_contents($tracklist);
            $data[$counter]['item_details'] = trim($data[$counter]['item_details'],"\n");
           }
         else 
           {
            if ($modus == "display_data") $data[$counter]['item_details'] = str_replace("<br>","\n",$data[$counter]['item_details']);
           }
        }
     }
   }
   fclose($fHandle);
   $counter--;
   $itemamount = $counter;

/* ############################################################# */

?>
