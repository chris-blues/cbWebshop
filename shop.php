<?php
if ($_GET["opt"] == "1") $lang = "english";
else $lang = "deutsch";
/* LESE index.dat in array $data[][] und schließe index.dat */
  $counter = "0";
  $fHandle = fopen("items/index.dat","r");
  if ($fHandle != NULL)
   {
    while (!feof($fHandle))
     {
      $counter++;
      $buffer = fgets($fHandle); $data[$counter]['item_id'] = trim($buffer,"\n"); $newitem = $buffer;
      $buffer = fgets($fHandle); $data[$counter]['item_name'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_type'] = trim($buffer,"\n"); $$utype = strtoupper($buffer); $ltype = strtolower($buffer);
      $buffer = fgets($fHandle); $data[$counter]['item_descr'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preis'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_pic'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_preview'] = trim($buffer,"\n");
      $buffer = fgets($fHandle); $data[$counter]['item_details'] = trim($buffer,"\n");
     }
   }
  fclose($fHandle);
  $counter--;
  /* echo "Read $counter entries successfully from index.dat...<br>"; */
  $itemamount = $counter;

$current_page = "shop";
include ('../header.html'); 
include ('../kopf.php');
?>

<!-- INHALT -->
<table border="0" width="800" align="center" cellpadding="5" cellspacing="0" bgcolor="#544a31">
  <tr align="center">
    <td width="750" align="center" valign="top">
      <br>
      <font face="Georgia" size="3"><em>
        <center>
        <form style="padding:0px;margin:0px;" action="cdorder-payment.php" method="post" accept-charset="UTF-8">
        <table width="770" align="center" border="0">
          <tr>
            <td align="center" valign="top" width="550" height="30" rowspan="1">
              <?php
              if ($lang == "english")
               {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location=self.location+'?opt='+this.selectedIndex">
                   <option value="deutsch">Deutsch</option>
                   <option value="english" selected="selected">English</option>
                 </select>

OUTPUT;
               }
              else
               {
               echo <<<OUTPUT
                 <select name="lang" size="1" onchange="self.location=self.location+'?opt='+this.selectedIndex">
                   <option value="deutsch" selected="selected">Deutsch</option>
                   <option value="english">English</option>
                 </select>

OUTPUT;
             }
            echo $lang;
            ?>
            </form>
            </td>
            <td align="right" valign="top" width="220" height="631" rowspan="2">
              <iframe name="kart" width="220" height="634" frameborder="0" scrolling="no" src="kartline.php?lang=<?php echo $lang; ?>"></iframe>
            </td>
          </tr>
          <tr>
            <td align="left" valign="top" height="601" rowspan="1">
              <iframe name="shop" src="shopcontent.php?lang=<?php echo $lang; ?>" width="550" height="600" scrolling="auto" frameborder="0"></iframe>
            </td>
          </tr>
        </table>
        </center>
        </em></font>
    </td>
  </tr>
</table>
<?php include ('../fuss.php'); ?>
