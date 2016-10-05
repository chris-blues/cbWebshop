<?php include('header_short.html'); ?>

<body>
<center><form action="showitems.php"><input type="submit" value=" <<< BACK "></form></center><br>
<br>
<form action="savelist.php?job=additem" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
<table border="0" align="center">

<?php
$modus = "display_data";
include('read_index.php');

/* ############################################################# */

if (isset($_GET["type"])) $type = $_GET["type"];
if ($type == "0") $type = "";
if ($type == "1") $type = "CD";
if ($type == "2") $type = "TShirt";
?>
  <tr>
    <td align="right" colspan="2">
      <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
      Type:<select name="item_type" size="1" onchange="self.location='newitem.php?type='+this.selectedIndex">
        <option<?php if ($type == "") echo " selected"; ?>>Choose type!</option>
        <option<?php if ($type == "CD") echo " selected"; ?> value="CD">CD</option>
        <option<?php if ($type == "TShirt") echo " selected"; ?> value="TShirt">TShirt</option>
      </select><br>
      ID:<input name="item_id" type="text" length="20"><br>
      Name:<input name="item_name" type="text" length="20"><br>
      <?php if ($type == "")       echo "Description:<input name=\"item_descr\" type=\"text\" length=\"20\"><br>\n";
            if ($type == "TShirt") echo "<input name=\"item_descr\" type=\"hidden\">\n"; 
            if ($type == "CD")     echo "Year:<input name=\"item_descr\" type=\"text\" length=\"20\"><br>\n"; ?> 
      Preis:<input name="item_preis" type="text" length="20"><br>
    </td>
  </tr>
  <tr>
    <td align="right" colspan="2">
      <font color="FF000"><b>PNG-file!</b></font> Pic:<input size="5" name="upload_pic" type="file" accept="image/png"><br>
      Pricetag:<input size="5" name="upload_pricetag" type="file" accept="image/png">
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <?php if ($type != "CD") echo "Details"; else echo "Tracklist"; ?>:<br><textarea name="item_details" cols="50" rows="8"></textarea>
    </td>
  </tr>
  <tr>
    <td align="center">
      <input type="reset" value=" Reset ">
    </td>
    <td align="center">
      <input type="submit" value=" Save! ">
    </td>
  </tr>
</table>
</form>
</body>
</html>
