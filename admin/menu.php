<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
?>
<font size="2">
<table align="center" border="0" width="190">
  <tr>
    <td align="left">
      <form action="showitems.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_view_items"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="newitem.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_add_new_item"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <hr><?php echo "{$loc_lang["admin_layout"]}\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="settings.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_general_settings"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="settings_item.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_item_settings"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <hr><?php echo "{$loc_lang["admin_financial"]}\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="edit_costs.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_costs"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="edit_payment.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_payment"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <hr><?php echo "{$loc_lang["admin_contents"]}\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="edit_types.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_itemtypes"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="edit_lang.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_lang"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="edit_countries.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_countries"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
  <tr>
    <td align="left">
      <hr>
    </td>
  </tr>
  <tr>
    <td align="left">
      <form action="../shop.php" target="_blank"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_view_shop"]}\" style=\"width:180px;\"></form>\n"; ?>
    </td>
  </tr>
</table>
</font>
</body>
</html>
