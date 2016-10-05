<?php
include('header_short.php');
echo "<body>\n";

// Write conf-file
if ($_GET["job"] == "shop")
  {
   
   // Integrate _POST into conf
   foreach($_POST as $key => $value)
     {
      $switch = "0";
      if (strncmp($key, "lang", 4) == "0")
        {
         $switch = "1";
         $key = substr($key, 4);
         $conf["lang"][$key] = $value;
         if ($value == "") unset($conf["lang"]["$key"]); // Remove empty values from array
        }
      if (strncmp($key, "item_type", 9) == "0")
        {
         $switch = "1";
         $key = substr($key, 9);
         $keys = explode("_", $key);
         $key1 = $keys["0"]; $key2 = $keys["1"];
         $conf["item_type"][$key1][$key2] = $value;
         if ($value == "") unset($conf["item_type"][$key1]); // Remove empty values from array
        }
      if ($switch == "0")
        {
         $conf[$key] = $value;
        }
     }
   
   //echo "<pre>CONF after POST: "; print_r($conf); echo "</pre>\n";

   if (!sort($conf["lang"])) echo "Failed to sort the array \$conf[\"lang\"]!<br>\n";
   if (!sort($conf["item_type"])) echo "Failed to sort the array \$conf[\"item_type\"]!<br>\n";
   if (!ksort($conf)) echo "Failed to sort the array!<br>\n";
   if (!ksort($conf["lang"])) echo "Failed to sort the array!<br>\n";
   if (!ksort($conf["item_type"])) echo "Failed to sort the array!<br>\n";
   
   //echo "<pre>CONF after SORT: "; print_r($conf); echo "</pre>\n";
   
   reset($conf);
   $configfile = "../conf/shop_conf.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($conf as $key => $value)
     {
      $switch = "0";
      if ($key == "lang")
        {
         $switch = "1";
         foreach($conf[$key] as $key2 => $value2)
           {
            $str = "\$conf[\"$key\"][\"$key2\"] = \"$value2\";\n";
            if ($value2 == "") { $str = ""; }
            fputs($fHandle, $str);
           }
        }
      if ($key == "item_type")
        {
         $switch = "1";
         foreach($conf[$key] as $key2 => $value2)
           {
            foreach($conf[$key][$key2] as $key3 => $value3)
              {
               $str = "\$conf[\"$key\"][\"$key2\"][\"$key3\"] = \"$value3\";\n";
               if ($value3 == "") { $str = ""; }
               fputs($fHandle, $str);
              }
           }
        }
      if ($switch == "0")
        {
         $str = "\$conf[\"$key\"] = \"$value\";\n";
         fputs($fHandle, $str);
        }
     }
  }
  
if ($_GET["job"] == "item")
  {
   if (!ksort($_POST)) echo "Failed to sort the array!<br>\n";
   $configfile = "../conf/item_conf.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($_POST as $key => $value)
     {
      $str = "\$item_conf[\"$key\"] = \"$value\";\n";
      if ($value == "") $str = "";
      fputs($fHandle, $str);
     }
  }

if ($_GET["job"] == "cost")
  {
   if (!ksort($_POST)) echo "Failed to sort the array!<br>\n";
   $configfile = "../conf/cost_conf.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($_POST as $key => $value)
     {
      $str = "\$cost[\"$key\"] = \"$value\";\n";
      fputs($fHandle, $str);
     }
  }

if ($_GET["job"] == "payment")
  {
   foreach($_POST as $key => $value)
     {
      $keys = explode("-", $key);
      //echo "{$keys["0"]} - {$keys["1"]}<br>\n";
      $payment[$keys["0"]][$keys["1"]] = $value;
     }
   //echo "<pre>"; print_r($payment); echo "</pre>\n";
   $configfile = "../conf/payment_conf.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($payment as $key => $value)
     {
      foreach($payment[$key] as $key2 => $value2)
        {
         $str = "\$payment[\"$key\"][\"$key2\"] = \"$value2\";\n";
         fputs($fHandle, $str);
        }
     }
  }

if ($_GET["job"] == "countries")
  {
   foreach ($_POST as $key => $value)
     {
      if ($value != "") $country[$key] = $value;
     }
   sort($country, SORT_STRING);
   $configfile = "../conf/countries.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($country as $key => $value)
     {
      $str = "\$country[\"$key\"] = \"$value\";\n";
      if ($value == "") $str = "";
      fputs($fHandle, $str);
     }
  }

fputs($fHandle, "?>");
fclose($fHandle);

// Output conf-file
$output = file_get_contents($configfile);
$output = htmlentities($output);
echo "$configfile:\n<form><textarea name=\"configfile\" cols=\"105\" rows=\"34\" disabled=\"disabled\">\n";
echo "$output\n</textarea>\n</form>\n";
//echo "<b>Debug:</b><br>\n<pre><b>_GET:</b><br>\n"; print_r($_GET); echo "<br>\n<b>_POST:</b><br>\n"; print_r($_POST); echo "<br>\n<b>ARRAY:</b><br>\n"; 
//if ($job == "shop") print_r($conf);
//if ($job == "countries") print_r($country);
//echo "</pre>\n";
?>
<center><button type="button" value=" Back " onclick="self.location='showitems.php'"> &lt;&lt;&lt; Back </button></center>
</body>
</html>
