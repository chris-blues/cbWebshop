<?php
$opt = $_GET["opt"];
if ($opt == "1") $lang = "english";
else $lang = "deutsch";
$current_page = "shop";
$mode = "long";
include ('../header.html'); 
include ('../kopf.php');
?>

<!-- INHALT -->
<table border="0" width="800" align="center" cellpadding="5" cellspacing="0" bgcolor="#544a31">
  <tr align="center">
    <td width="25" align="center" valign="top"></td> 
    <td width="750" align="center" valign="top">
      <br>
        <center>
          <form style="padding:0px;margin:0px;" action="cdorder-payment.php" method="post" accept-charset="UTF-8">
            <?
            if ($lang == "english")
              {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location=self.location+'?opt='+this.selectedIndex">
                   <option value="deutsch">Deutsch</option>
                   <option value="english" selected="selected">English</option>
                 </select><br>
                 <br>

OUTPUT;
              }
            else
              {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location=self.location+'?opt='+this.selectedIndex">
                   <option value="deutsch" selected="selected">Deutsch</option>
                   <option value="english">English</option>
                 </select><br>
                 <br>

OUTPUT;
            }
            ?>
            <br>
            <br>
            <font face="Georgia" size="3"><em>
            <table width="740" border="0" align="center">
              <tr>
                <?php include('items/cd_darkercolors.php'); ?>
                <?php include('items/cd_livemix.php'); ?>
              </tr>
              <tr><td height="40"></td><td></td></tr>
              <tr>
                <?php include('items/cd_roughmix.php'); ?>
                <?php include('items/tshirt_whatthefolk.php'); ?>
              </tr>
              <tr><td height="40"></td><td></td></tr>
            </table>
            <?
            if ($lang == "english")
            {
            echo <<<OUTPUT
              <input type="submit" value=" >>> Go to Shopping Kart and pay ">

OUTPUT;
            }
            else
            {
            echo <<<OUTPUT
              <input type="submit" value=" >>> Zum Einkaufswagen und bezahlen ">

OUTPUT;
            }
            ?>
            <br>
            <br>
            <br>
          </em></font>
        </form>
        </center>
    </td>
    <td width="25" align="center" valign="top"></td>
  </tr>
</table>
<?php include ('../fuss.php'); ?>
