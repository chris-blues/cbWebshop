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
    <form action="showitems.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("View items") . "\"></form>\n"; ?>
  </li>
  <li>
    <form action="newitem.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Add new item") . "\"></form>\n"; ?>
  </li>
  <li>
    <hr>
  </li>
  <li>
    <form action="edit_kartfiles.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("View available karts") . "\"></form>\n"; ?>
  </li>
  <li>
    <hr>
  </li>
  <li>
    <form action="shopadminmenu.php" target="shop-menu" method="get">
    <?php
      if ($settings == "hide") echo "<input type=\"hidden\" name=\"settings\" value=\"show\"><input type=\"submit\" value=\"" . gettext("Show options") . "\"></form>\n";
      if ($settings == "show") echo "<input type=\"hidden\" name=\"settings\" value=\"hide\"><input type=\"submit\" value=\"" . gettext("Hide options") . "\"></form>\n";
    ?>
  </li>
  <li class="settings">
    <hr><?php echo gettext("Layout:") . "\n"; ?>
  </li>
  <li class="settings">
    <form action="settings.php" target="shop-admin">
      <?php echo "<input type=\"submit\" value=\"" . gettext("General settings:") . "\"></form>\n"; ?>
  </li>
  <li class="settings">
    <hr><?php echo gettext("Financial:") . "\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_costs.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit costs") . "\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_payment.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit payment") . "\"></form>\n"; ?>
  </li>
  <li class="settings">
    <hr><?php echo gettext("Contents:") . "\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_types.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit item-types") . "\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_lang.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit languages") . "\"></form>\n"; ?>
  </li>
  <li class="settings">
    <form action="edit_countries.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit countries") . "\"></form>\n"; ?>
  </li>
</ul>
</body>
</html>
