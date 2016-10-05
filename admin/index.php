<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
?>
<body>
<table border="0" align="center" width="99%" height="99%">
  <tr>
    <td colspan="2" align="center">
      <font size="5"><b><?php echo $loc_lang["admin_title"]; ?></b></font><br>
      <hr>
    </td>
  </tr>
  <tr height="99%">
    <td align="center" width="200">
      <iframe name="shop-menu" src="shopadminmenu.php" width="200" height="700" scrolling="auto" frameborder="0"></iframe>
    </td>
    <td align="center" valign="top" height="99%">
      <iframe name="shop-admin" src="showitems.php" width="99%" height="99%" scrolling="auto" frameborder="0"></iframe>
    </td>
  </tr>
</table>
</body>
</html>
