<?php
if (isset($_GET["lang"])) $lang = $_GET["lang"];
if (!isset($lang) or $lang == "")
  {
   if ($_GET["opt"] == "1") $lang = "english";
   else $lang = "deutsch";
  }
if (isset($_GET["kartid"])) { $kartid = $_GET["kartid"]; }
else { $kartid = date("YmdHisu"); }

$current_page = "shop";
include ('../header.html'); 
include ('../kopf.php');

?>

<!-- INHALT -->
<table border="0" width="800" align="center" cellpadding="5" cellspacing="0" bgcolor="#544a31">
  <tr align="center">
    <td width="750" align="center" valign="top">
      <br>
      <font face="Georgia" size="3"><em>
        <center>
        <table width="770" align="center" border="0">
          <tr>
            <td align="left" valign="top" width="220" height="30" rowspan="1">
              <form style="padding:0px;margin:0px;" action="cdorder-payment.php" method="post" accept-charset="UTF-8">
              <?php
              if ($lang == "english")
               {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location='shop.php?kartid=$kartid&amp;opt='+this.selectedIndex">
                   <option value="deutsch">Deutsch</option>
                   <option value="english" selected="selected">English</option>
                 </select>

OUTPUT;
               }
              else
               {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location='shop.php?kartid=$kartid&amp;opt='+this.selectedIndex">
                   <option value="deutsch" selected="selected">Deutsch</option>
                   <option value="english">English</option>
                 </select>

OUTPUT;
             }
            ?>
            </form>
            </td>
            <td align="left" valign="top" height="631" rowspan="2">
              <?php echo "<iframe name=\"shop\" src=\"shopcontent.php?lang=$lang&amp;kartid=$kartid\" width=\"550\" height=\"631\" scrolling=\"auto\" frameborder=\"0\"></iframe>\n"; ?>
            </td>
          </tr>
          <tr>
            <td align="center" valign="top" width="550" height="600" rowspan="1">
              <?php echo "<iframe name=\"kart\" width=\"230\" height=\"600\" frameborder=\"0\" scrolling=\"auto\" src=\"kartline.php?lang=$lang&amp;kartid=$kartid\"></iframe>\n"; ?>
            </td>
          </tr>
        </table>
        </center>
        </em></font>
    </td>
  </tr>
</table>
<?php include ('../fuss.php'); ?>
