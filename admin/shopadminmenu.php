<?php
$settings = $_GET["settings"]; if (!isset($settings)) $settings = "hide";
if ($settings == "hide") $settings_link = "show";
if ($settings == "show") $settings_link = "hide";

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');
?>
<body class="menu">
<ul class="menu">
  <li>
    <form action="showitems.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_view_items"]}\"></form>\n"; ?>
  </li>
  <li>
    <form action="newitem.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_add_new_item"]}\"></form>\n"; ?>
  </li>
  <li>
    <hr>
  </li>
  <li>
    <form action="edit_kartfiles.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_karts"]}\"></form>\n"; ?>
  </li>
  <li>
    <hr>
  </li>
  <li>
    <form action="shopadminmenu.php" target="shop-menu" method="get">
    <?php
      if ($settings == "hide") echo "<input type=\"hidden\" name=\"settings\" value=\"show\"><input type=\"submit\" value=\"{$loc_lang["admin_show_settings"]}\"></form>\n";
      if ($settings == "show") echo "<input type=\"hidden\" name=\"settings\" value=\"hide\"><input type=\"submit\" value=\"{$loc_lang["admin_hide_settings"]}\"></form>\n";
    ?>
  </li>
  <li class="settings">
    <hr><?php echo "{$loc_lang["admin_layout"]}\n"; ?>
  </li>
  <li class="settings">
    <form action="settings.php" target="shop-admin">
      <?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_general_settings"]}\"></form>\n"; ?>
  </li>
  <li class="settings">
    <hr><?php echo "{$loc_lang["admin_financial"]}\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_costs.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_costs"]}\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_payment.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_payment"]}\"></form>\n"; ?>
  </li>
  <li class="settings">
    <hr><?php echo "{$loc_lang["admin_contents"]}\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_types.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_itemtypes"]}\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_lang.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_lang"]}\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_countries.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"{$loc_lang["admin_edit_countries"]}\"></form>\n"; ?>
  </li>
</ul>
</body>
</html>
