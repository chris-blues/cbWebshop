<?php

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
    // Get category ( music | clothing )
      foreach ($conf["item_type"] as $keycat => $valcat)
        {
         if ($conf["item_type"][$keycat]["name"] == $data["$counter"]['item_type'])
           $cat = $conf["item_type"][$keycat]["cat"];
        }
      if ($modus != "simple")
        {
         if ($cat == "music")
           {
            $tracklist = "../items/{$data[$counter]['item_id']}.dat";
            $data[$counter]['item_details'] = file_get_contents($tracklist);
            $data[$counter]['item_details'] = str_replace("\r\n", "", $data[$counter]['item_details']);
            $data[$counter]['item_details'] = str_replace("\r", "", $data[$counter]['item_details']);
            $data[$counter]['item_details'] = str_replace("\n", "", $data[$counter]['item_details']);
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

/* ############################################################# */

?>
