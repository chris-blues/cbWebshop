<?php
include('shop/conf/shop_conf.php');
include('shop/conf/item_conf.php');
include('shop/conf/countries.php');
include('shop/conf/cost_conf.php');
include('shop/conf/payment_conf.php');
//echo getcwd() . "\n";
//echo "<pre>"; print_r($conf); echo "</pre>";

// Try to get language
if (isset($_GET["lang"])) $lang = $_GET["lang"]; // if we already have a ?lang=somelanguage - get it! Will almost never happen!
if (!isset($lang) or $lang == "") // if $lang is not set or empty - look for ?opt=num (opt = index of language rolldown-menue)
  {
   $langopt = $_GET["opt"]; // try to read opt from _get
   $lang = $conf["lang"][$langopt]; // look up index number in conf/shop_conf.php - will return language string e.g.: "english"
  }
if ($lang == "") $lang = $conf["_default_lang"]; // if $lang is still empty - set to default
//Load loc_lang file
define( "LOC_LANG", $lang );
include('shop/locale/' . LOC_LANG . '.php');

// Try to get kartid
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; } // if we already have a kart-id - use it!
else { $kartid = date("YmdHis"); }                         // if not - create one!

// Try to get several variables
$job = $_GET["job"];
$id = $_GET["id"];
$c = $_GET["c"];
$kartfile = "shop/tmp/kart-$kartid.tmp";

// Read content of shop
include('shop/read_index.php');

// ###################### We got all there is to get ###########################

?>

<!-- HTML CONTENT -->

<!-- Build Shop content -->
<div id="shop-content">
<?php
$template = file_get_contents("shop/templates/item_template_shop.html");
for ($c = 1; $c <= $itemamount; $c++)
 {
  $col++;
  $alt = "{$loc_lang["click_to_view"]} {$data["$c"]['item_type']} {$data["$c"]['item_name']}{$loc_lang["click_to_view_add"]}";
  $buy = "{$loc_lang["buy"]}";
  $value = "{$loc_lang["pieces"]} ({$data["$c"]['item_preis']} &euro;/{$loc_lang["piece"]})";
  
// ########################################################
// Get category ( music | clothing )
foreach ($conf["item_type"] as $keycat => $valcat)
  {
   if ($conf["item_type"][$keycat]["name"] == $data["$c"]['item_type'])
     $cat = $conf["item_type"][$keycat]["cat"];
  }

// ########################################################
// Generate Tracklist with <audio> Playback
if ($cat == "music")
  {
   $counter = "0";
   $fHandle = fopen("shop/items/{$data["$c"]['item_id']}.dat","r");
   if ($fHandle != NULL)
    {
     while (!feof($fHandle)) // Get Song-Names
      {
       $counter++;
       $buffer = fgets($fHandle); $tracks["$counter"]['name'] = trim($buffer,"\n");
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
       $char_replace = array("_",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "",
                             "");
       $tracks["$counter"]['id'] = str_replace($char_search, $char_replace, $tracks["$counter"]['name']);
      }
     $counter--;
    }
   $tracklist = "<font size=\"2\"><table border=\"0\">\n";
   for ($track = "1"; $track <= $counter; $track++)
     {
      if (file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.ogg") and file_exists("shop/items/audio/{$data["$c"]['item_id']}/{$tracks["$track"]['id']}.mp3"))
        {
         $tracklisten = file_get_contents("shop/templates/get_audio.html");
         $searchtrack  = array('%id%', '%trackname%', '%trackid%');
        // Womit soll das ersetzt werden?
         $replacetrack = array($data["$c"]['item_id'], $tracks["$track"]['name'], $tracks["$track"]['id']);
        // Finde und ersetze Platzhalter in $output
         $tracklist .= str_replace($searchtrack, $replacetrack, $tracklisten);
        }
      else
        {
         $tracklist .= "<tr><td align=\"left\" valign=\"center\"><img src=\"shop/pics/transparent.png\" width=\"15\" height=\"15\" border=\"0\"> {$tracks["$track"]['name']}</td></tr>\n";
        }
     }
   $tracklist .= "</table></font>\n";
   $data["$c"]['item_details'] = $tracklist;
  }
  

  /* Was soll ersetzt werden? */
  $search  = array('%id%', 
                   '%name%', 
                   '%type%',
                   '%Type%',
                   '%TYPE%', 
                   '%descr%', 
                   '%preis%', 
                   '%pic%', 
                   '%preview%',
                   '%details%',
                   '%alt%',
                   '%buy%',
                   '%value%',
                   '%kartid%',
                   '%lang%',
                   '%c%',
                   '%shop_width%',
                   '%shop_height%',
                   '%shop_pic_height%');
  /* Womit soll das ersetzt werden? */
  $replace = array($data["$c"]['item_id'],
                   $data["$c"]['item_name'],
                   $ltype,
                   $data["$c"]['item_type'],
                   $utype,
                   $data["$c"]['item_descr'],
                   $data["$c"]['item_preis'],
                   $data["$c"]['item_pic'],
                   $data["$c"]['item_preview'],
                   $data["$c"]['item_details'],
                   $alt,
                   $buy,
                   $value,
                   $kartid,
                   $lang,
                   $c,
                   $item_conf["shop_width"],
                   $item_conf["shop_height"],
                   $item_conf["shop_pic_height"]);
  /* Finde und ersetze Platzhalter in $output */
  $output = str_replace($search, $replace, $template);
  echo "$output";
 }
?>
</div>

<!-- SHOPPING KART -->
<div id="shopping-kart">

</div>

<!-- Language Selector -->
<div id="language-selector">
<form style="padding:0px;margin:0px;" action="shop/cdorder-payment.php" method="post" accept-charset="UTF-8" name="language-selector">
  <?php
  echo "<select name=\"lang\" size=\"1\" onchange=\"self.location='shop.php?kartid=$kartid&amp;opt='+this.selectedIndex\">\n";
  foreach($conf["lang"] as $key => $value)
    {
     if ($lang == $value) $selected = " selected=\"selected\"";
     else $selected = "";
     echo "<option value=\"$value\"$selected>$value</option>\n";
    }
  echo "</select>\n";
  ?>
</form>
</div>
<!-- Language Selector -->
