<?php

/* LESE index.dat und schließe index.dat */
  //$dir = getcwd();
  //echo "DEBUG: read_index.php<br>\nfile: $dir /shop/items/index.dat<br>\n";
  $counter = "0";
  $fHandle = fopen("shop/items/index.dat","r");
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
    // Get category ( music | clothing )
      foreach ($conf["item_type"] as $keycat => $valcat)
        {
         if ($conf["item_type"][$keycat]["name"] == $data["$counter"]['item_type'])
           $cat = $conf["item_type"][$keycat]["cat"];
        }
   /*   if ($modus != "simple")
        {  */
         if ($cat == "music") 
           {
            $tracklist = "items/{$data[$counter]['item_id']}.dat";
            $data[$counter]['tracklist'] = file_get_contents($tracklist);
            $data[$counter]['tracklist'] = trim($data[$counter]['tracklist'],"\n");
           }
         else 
           {
           /* if ($modus == "display_data")*/ $data[$counter]['item_details'] = str_replace("<br>","\n",$data[$counter]['item_details']);
           }
     /*   }   */
     }
   }
   fclose($fHandle);
   $counter--;
   $itemamount = $counter;

/* ############################################################# */

?> 
