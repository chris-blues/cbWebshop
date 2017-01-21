<?php

// ============
// init gettext
// ============

//Try to get some language information from the browser request header
$browserlang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

switch($browserlang)
  {
   case 'de': { $lang = "de_DE"; break; }
   case 'en': { $lang = "en_EN"; break; }
   default: { $lang = "en_EN"; break; }
  }
$cbWebshop_dirname = getcwd();
$directory = $cbWebshop_dirname . '/../locale';
$gettext_domain = 'cbWebshop';
$locale = "$lang";// echo "<!-- locale set to => $locale -->\n";

setlocale(LC_MESSAGES, $locale);
bindtextdomain($gettext_domain, $directory);
textdomain($gettext_domain);
bind_textdomain_codeset($gettext_domain, 'UTF-8');
// ============
// init gettext
// ============

if (isset($_GET["kartid"])) $kartid = $_GET["kartid"];
if (isset($_GET["delete"])) $delete = $_GET["delete"];

include('../conf/shop_conf.php');
//include("../locale/{$conf["_default_lang"]}.php");
include('header_short.php');

if (isset($delete) and isset($kartid)) unlink("../tmp/$kartid");

$kartfiles = scandir("../tmp");
$negdir = array_search(".", $kartfiles);  unset($kartfiles[$negdir]);
$negdir = array_search("..", $kartfiles); unset($kartfiles[$negdir]);
sort($kartfiles);

date_default_timezone_set('Europe/Berlin');
?>
<body>
<h2><?php echo gettext("View available karts"); ?></h2>
<hr>
<br>
<table rules="all" border="0">
  <tr>
    <td></td><td>File:</td><td>Date - Size:</td><td></td>
  </tr>
    <?php
      foreach ($kartfiles as $key => $value)
        {
         $kartsize = filesize("../tmp/$value");
         $date = date("d.F.Y H:i:s", filectime("../tmp/$value"));
         echo "<tr><td>$key : $date</td>
                   <td><form action=\"read_kartfile.php\" target=\"kart-content\" method=\"get\">
                         <input type=\"hidden\" name=\"kartid\" value=\"$value\">
                         <input type=\"submit\" value=\"$value\" style=\"width:200px;\">
                   </form></td>
                   <td align=\"right\">$kartsize Bytes</td>
                   <td><form action=\"edit_kartfiles.php\" target=\"shop-admin\" method=\"get\">
                         <input type=\"hidden\" name=\"kartid\" value=\"$value\">
                         <input type=\"hidden\" name=\"delete\" value=\"$value\">
                         <input type=\"submit\" value=\"" . gettext("delete file") . "\" style=\"width:200px;\">
                   </form></td></tr>";
        }
    ?>
</table>
<br>
<iframe src="" name="kart-content" frameborder="0" border="0" scrolling="auto" width="99%" height="400"></iframe>

<?php
echo "<button type=\"button\" value=\" Back \" id=\"buttonBackToBefore\"> &lt;&lt;&lt; " . gettext("Back") . " </button>";
/*  echo "<pre>\n";
  print_r($kartfiles);
  echo "</pre>\n"; */
?>

<script type="text/javascript" src="scripts.js"></script>
</body>
</html>
