<?php 
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
if (isset($_GET["type"])) { $type = $_GET["type"]; $type--; }
else $type = "-1";
?>

<body>
<?php echo "<h2>{$loc_lang["admin_addnewitem"]}</h2>\n<hr>\n<br>\n"; ?>
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
      <?php echo $loc_lang["admin_itemtype"]; ?><select name="item_type" size="1" onchange="self.location='newitem.php?type='+this.selectedIndex">
        <option<?php if ($type < "0") echo " selected=\"selected\""; ?> width="156" style="width:156px;"><?php echo $loc_lang["admin_choosetype"]; ?></option>
      <?php
        foreach ($conf["item_type"] as $key => $value)
          {
           if ($key == $type) { $selected = " selected=\"selected\""; $itemcat = $conf["item_type"][$key]["cat"]; } else $selected = "";
           echo "<option value=\"{$conf["item_type"][$key]["name"]}\"$selected>{$conf["item_type"][$key]["name"]}</option>\n";
          }
      ?>
      </select><br>
      <?php echo $loc_lang["admin_itemname"]; ?><input name="item_name" type="text" length="20" value="New Item"><br>
      <?php if ($itemcat == "music") echo "{$loc_lang["admin_itemyear"]}<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"2014\"><br>\n";
            if ($itemcat != "music") echo "{$loc_lang["admin_itemdescr"]}<input name=\"item_descr\" type=\"text\" length=\"20\" value=\"S M L XL XXL\"><br>\n"; ?> 
      <?php echo $loc_lang["admin_itemprice"]; ?><input name="item_preis" type="text" length="20" value="10.00"><br>
    </td>
  </tr>
  <tr>
    <td align="right">
      <font color="FF000"><b><?php echo $loc_lang["admin_pngonly"]; ?></b></font> <?php echo $loc_lang["admin_item_pic"]; ?><input size="5" name="upload_pic" type="file" accept="image/png">
    </td>
  </tr>
  <tr>
    <td align="center">
      <?php echo $loc_lang["admin_details"]; ?>:<br><textarea name="item_details" cols="50" rows="8">Some info about this item.</textarea>
    </td>
  </tr>
 <?php if($itemcat == "music") { ?>
  <tr>
    <td align="center">
      <?php echo $loc_lang["admin_tracklist"]; ?>:<br><textarea name="tracklist" cols="50" rows="8">01 - Tracklist</textarea>
    </td>
  </tr>  <?php } ?>
  <tr>
    <td align="center">
      <button type="button" value="Back" onclick="self.location='showitems.php'"> &lt;&lt;&lt; <?php echo $loc_lang["admin_back"]; ?> </button>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_save"]}\">\n"; ?>
    </td>
  </tr>
</table>
</form>
</body>
</html>
