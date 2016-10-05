<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
echo "<body>\n";
echo "<table border=\"0\" align=\"center\">\n";
?>
  <tr>
    <td colspan="2" align="center">
      <font size="5"><b><?php echo $loc_lang["admin_title"]; ?></b></font><br>
      <hr>
    </td>
  </tr>
  <tr>
    <td align="center">
      <iframe name="shop-menu" src="shopadminmenu.php" width="200" height="700" scrolling="auto" frameborder="0"></iframe>
    </td>
    <td align="center" valign="top">
      <iframe name="shop-admin" src="showitems.php" width="800" height="700" scrolling="auto" frameborder="0"></iframe>
    </td>
  </tr>
</table>
</body>
</html>
