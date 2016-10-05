<?php
if (isset($_GET["kartid"])) $kartid = $_GET["kartid"];
if (isset($_GET["delete"])) $delete = $_GET["delete"];

include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('header_short.html');

if (isset($delete) and isset($kartid)) unlink("../tmp/$kartid");

$kartfiles = scandir("../tmp");
$negdir = array_search(".", $kartfiles);  unset($kartfiles[$negdir]);
$negdir = array_search("..", $kartfiles); unset($kartfiles[$negdir]);
sort($kartfiles);

?>
<body>
<h2><?php echo "{$loc_lang["admin_editkart"]}"; ?></h2>
<hr>
<br>
<table align="center" rules="all" border="0">
  <tr>
    <td></td><td>File:</td><td>Size:</td><td></td>
  </tr>
    <?php
      foreach ($kartfiles as $key => $value)
        {
         $kartsize = filesize("../tmp/$value");
         echo "<tr><td>$key : </td>
                   <td><form action=\"read_kartfile.php\" target=\"kart-content\" method=\"get\">
                         <input type=\"hidden\" name=\"kartid\" value=\"$value\">
                         <input type=\"submit\" value=\"$value\" style=\"width:200px;\">
                   </form></td>
                   <td align=\"right\">$kartsize Bytes</td>
                   <td><form action=\"edit_kartfiles.php\" target=\"shop-admin\" method=\"get\">
                         <input type=\"hidden\" name=\"kartid\" value=\"$value\">
                         <input type=\"hidden\" name=\"delete\" value=\"$value\">
                         <input type=\"submit\" value=\"{$loc_lang["admin_deletefile"]}\" style=\"width:200px;\">
                   </form></td></tr>";
        }
    ?>
</table>
<br>
<iframe src="" name="kart-content" frameborder="0" border="0" scrolling="auto" width="700" height="300"></iframe>

<?php
/*  echo "<pre>\n";
  print_r($kartfiles);
  echo "</pre>\n"; */
?>

</body>
</html>
