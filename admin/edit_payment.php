<?php
include('../conf/shop_conf.php');
include("../locale/{$conf["_default_lang"]}.php");
include('../conf/cost_conf.php');
include('../conf/payment_conf.php');
include('../conf/countries.php');
include('header_short.php');
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "<center><h2>{$loc_lang["admin_edit_payment"]}</h2>\n";
echo "{$loc_lang["admin_editcarefully"]} {$loc_lang["admin_usedots"]}</center><br>\n<hr>\n<br>\n";
echo "<form action=\"save_settings.php?job=payment\" method=\"post\" accept-charste=\"UTF-8\">\n";
echo "<table align=\"center\" border=\"0\" rules=\"rows\">\n";
$count = "0";
foreach($payment as $key => $value)
  {
   foreach($payment[$key] as $key2 => $value2)
     {
      $count++;
      echo "  <tr><td>$count:$key $key2:</td><td colspan=\"2\"> <input name=\"$key-$key2\" value=\"$value2\" type=\"text\" size=\"30\"></td></tr>\n";
     }
  }
echo "<tr><td></td><td align=\"left\" colspan=\"1\"><button type=\"button\" value=\" Back \" onclick=\"self.location='showitems.php'\"> &lt;&lt;&lt; {$loc_lang["admin_back"]} </button></td><td colspan=\"1\" align=\"right\"><input type=\"submit\" value=\" {$loc_lang["admin_save"]} &gt;&gt;&gt; \"></td></tr>\n";
?>
</table>
</form>
</body>
</html>
