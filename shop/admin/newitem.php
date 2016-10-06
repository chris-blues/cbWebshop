<?php

// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   case 'en': { $lang = "en_EN"; break; }
   default: { $lang = "en_EN"; break; }
  }
$cbWebshop_dirname = getcwd();
$directory = $cbWebshop_dirname . '/../locale';
$gettext_domain = 'cbWebshop';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
if (isset($_GET["type"])) { $type = $_GET["type"]; $type--; }
else $type = "-1";
?>

<body>
<?php echo "<h2>" . gettext("Add item to the shop") . "</h2>\n<hr>\n<br>\n"; ?>
<form action="savelist.php?job=additem" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
<table border="0" align="center">

<?php
$modus = "display_data";
include('read_index.php');

/* ############################################################# */


?>
  <tr>
    <td align="right">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
      <?php echo gettext("Type:"); ?><select name="item_type" size="1" onchange="self.location='newitem.php?type='+this.selectedIndex">
        <option<?php if ($type < "0") echo " selected=\"selected\""; ?> width="156" style="width:156px;"><?php echo gettext("Choose type!"); ?></option>
      <?php
        foreach ($conf["item_type"] as $key => $value)
          {
           if ($key == $type) { $selected = " selected=\"selected\""; $itemcat = $conf["item_type"][$key]["cat"]; } else $selected = "";
           echo "<option value=\"{$conf["item_type"][$key]["name"]}\"$selected>{$conf["item_type"][$key]["name"]}</option>\n";
          }
      ?>
      </select><br>
      <?php echo gettext("Name:"); ?><input name="item_name" type="text" length="20" value="New Item"><br>
      <?php if ($itemcat == "music") echo gettext("Year:") . "<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"2014\"><br>\n";
            if ($itemcat != "music") echo gettext("Sizes:") . "<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"S M L XL XXL\"><br>\n"; ?> 
      <?php echo gettext("Price:"); ?><input name="item_preis" type="text" length="20" value="10.00"><br>
    </td>
  </tr>
  <tr>
    <td align="right">
      <font color="FF000"><b><?php echo gettext("PNG-files only!"); ?></b></font> <?php echo gettext("Item's Pic:"); ?><input size="5" name="upload_pic" type="file" accept="image/png">
    </td>
  </tr>
  <tr>
    <td align="center">
      <?php echo gettext("Details (html is allowed!):"); ?>:<br><textarea name="item_details" cols="50" rows="8">Some info about this item.</textarea>
    </td>
  </tr>
 <?php if($itemcat == "music") { ?>
  <tr>
    <td align="center">
      <?php echo gettext("Tracklist (plain text only!)"); ?>:<br><textarea name="tracklist" cols="50" rows="8">01 - Tracklist</textarea>
    </td>
  </tr>  <?php } ?>
  <tr>
    <td align="center">
      <button type="button" value="Back" id="buttonBackToBefore"> &lt;&lt;&lt; <?php echo gettext("Back"); ?> </button>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<input type=\"submit\" value=\"" . gettext("Save") . "\">\n"; ?>
    </td>
  </tr>
</table>
</form>
<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
