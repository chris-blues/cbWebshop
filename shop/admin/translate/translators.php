<?php

// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   default: { $lang = "en"; break; }
  }
$directory = $cbPlayer_dirname . '/locale';
$domain = 'cbplayer';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($domain, $directory);
textdomain($domain);
bind_textdomain_codeset($domain, 'UTF-8');
// ============
// init gettext
// ============

include('../conf/shop_conf.php');
include('../header_full.html');
$lang = $_GET["lang"];
echo "<body>\n";
echo "{$conf["font_style"]}<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n";
echo "  <table border=\"0\" align=\"center\" width=\"400\" bgcolor=\"{$conf["bgcolor"]}\">\n";
?>
    <tr>
      <td align="justified"><b>
        <?php echo gettext("Your language is not available? If you have some time to spare, you could help us."); ?></b>
      </td>
    </tr>
  </table>
<?php echo "</font>{$conf["font_style_close"]}\n"; ?>
</body>
</html>
