<?php
include('conf/shop_conf.php');
include('header_short.php');
$lang = $_GET["lang"];
echo "<body bgcolor=\"{$conf["bgcolor"]}\">\n";
echo "{$conf["font_style"]}<font face=\"{$conf["font_face"]}\" size=\"{$conf["font_size"]}\">\n";
echo "  <table border=\"0\" align=\"center\" width=\"400\" bgcolor=\"{$conf["bgcolor"]}\">\n";
?>
    <tr>
      <td align="justified"><b>
        <?php define( "LOC_LANG", $lang );
              include('locale/' . LOC_LANG . '.php');
              echo "{$loc_lang["translators_needed_1"]} <a href=\"translate.php\" target=\"_blank\">{$loc_lang["translators_needed_2"]}</a>{$loc_lang["translators_needed_3"]}"; ?></b>
      </td>
    </tr>
  </table>
<?php echo "</font>{$conf["font_style_close"]}\n"; ?>
</body>
</html>
