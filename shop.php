<?php
include('conf/shop_conf.php');
if (isset($_GET["lang"])) $lang = $_GET["lang"]; // if we already have a shop.php?lang=somelanguage - get it! Will almost never happen!
if (!isset($lang) or $lang == "") // if $lang is not set or empty - look for shop.php?opt=num (opt = index of language rolldown-menue)
  {
   $langopt = $_GET["opt"]; // try to read opt from _get
   $lang = $conf["lang"][$langopt]; // look up index number in conf/shop_conf.php - will return language string e.g.: "english"
  }
if ($lang == "") $lang = $conf["_default_lang"]; // if $lang is still empty - set to default
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; }
else { $kartid = date("YmdHis"); }

$current_page = "shop";
include ('header_full.html');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">{$conf["font_style"]}";
?>
<!-- INHALT -->
<center>
<table width="770" align="center" border="0">
  <tr>
    <td align="left" valign="top" <? echo "height=\"{$conf["shop_height"]}\""; ?> rowspan="2">
      <?php echo "<iframe name=\"shop\" src=\"shopcontent.php?lang=$lang&amp;kartid=$kartid\" width=\"{$conf["shop_width"]}\" height=\"670\" onload=\"this.height = this.contentDocument.documentElement.offsetHeight\" scrolling=\"auto\" frameborder=\"0\"></iframe>\n"; ?>
    </td>
    <td align="left" valign="top" width="220" height="30" rowspan="1">
      <form style="padding:0px;margin:0px;" action="cdorder-payment.php" method="post" accept-charset="UTF-8">
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
    </td>
  </tr>
  <tr>
    <td align="center" valign="top" <? echo "width=\"{$conf["kart_width"]}\""; ?> rowspan="1">
      <?php echo "<iframe name=\"kart\" id=\"kart_frame\" width=\"{$conf["kart_width"]}\" height=\"100\" onload=\"this.height = this.contentDocument.documentElement.offsetHeight\" frameborder=\"0\" scrolling=\"auto\" src=\"kartline.php?lang=$lang&amp;kartid=$kartid\"></iframe>\n"; ?>
    </td>
  </tr>
</table>
</center>
</em></font>
</body>
</html>
