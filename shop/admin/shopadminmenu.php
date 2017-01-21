<?php
$debug = $_GET["debug"];
if (isset($debug) and $debug == "true") $debug = true;
else $debug = false;

$debug = false;

if ($debug)
  {
   error_reporting(E_ALL & ~E_NOTICE);
   ini_set("display_errors", 1);
  }
else
  {
   error_reporting(0);
   ini_set("display_errors", 0);
  }
ini_set("log_errors", 1);
ini_set("error_log", "/www/admin/logs/php-error.log");


// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de"; break; }
   case 'en': { $lang = "en"; break; }
   case 'fr': { $lang = "fr"; break; }
   default: { $lang = "de"; break; }
  }
$cbWebshop_dirname = getcwd();
$directory = "{$cbWebshop_dirname}/../locale";
$gettext_domain = 'cbWebshop';
$locale = "$lang"; echo "<!-- locale set to => $locale -->\n";

putenv('LC_MESSAGES=' . $locale);
setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

?>
<div id="menu">
  <button id="buttonToggleMenu"><?php echo gettext("Menu"); ?></button>
<ul class="menu" id="menuContent">
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
  <!--li>
    <form action="shopadminmenu.php" target="shop-menu" method="get">
      <input type="hidden" name="settings" value="show" id="settingsVisibility" data-switch="<?php echo gettext("Hide options"); ?>">
      <button type="button" id="buttonToggleSettingsVisibility"><?php echo gettext("Show options"); ?></button>
    </form>
  </li-->
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
  <!--li class="settings">
    <form action="edit_lang.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit languages") . "\"></form>\n"; ?>
  </li-->
  <li class="settings">
    <form action="edit_countries.php" target="shop-admin"><?php echo "<input type=\"submit\" value=\"" . gettext("Edit countries") . "\"></form>\n"; ?>
  </li>
</ul>
</div>
