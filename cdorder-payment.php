<?php
$current_page = "shop";
$mode = "short";
include ('../header.html'); 
include ('../kopf.php');
include('getvars.php');
if ($lang == "english") $pieces = "pieces";
else $pieces = "St&uuml;ck";
?>

<table cellpadding="0" cellspacing="0" width="800" height="20" align="center" bgcolor="#544a31"><tr><td align="center" valign="center">
  <form style="padding:0px;margin:0px;" action="cdorder-adress.php" method="post" accept-charset="UTF-8">
<?php 
echo "  <input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";

if ($lang == "english")
  {
  echo <<<CDORDER
  <font face="Georgia" color="#000000" size="5"><em>Your order:</em></font><br>
  <br>
  
CDORDER;
  }
else
  {
  echo <<<CDORDER
  <font face="Georgia" color="#000000" size="5"><em>Ihre Bestellung:</em></font><br>
  <br>
  
CDORDER;
  }

echo <<<CDORDER
    <table width="500" border="0" bgcolor="#544a31">
    
CDORDER;

   include('items/cd_darkercolors.php');
   include('items/cd_livemix.php');
   include('items/cd_roughmix.php');
   include('items/tshirt_whatthefolk.php');
  
  echo <<<CDORDER
    </table><br>
    <br>
    
CDORDER;
  
  if ($lang == "english")
  {
   echo <<<CDORDER
  <font face="Georgia" color="#000000" size="5"><em>Payment</em></font><br>
  <em><font face="Georgia" size="3" color="#000000">
  How do you want to pay your order? Note, there are<br>
  different charges for the different choices.</font>
  
CDORDER;
  }
  else
  {
   echo <<<CDORDER
  <font face="Georgia" color="#000000" size="5"><em>Bezahlweise</em></font><br>
  <em><font face="Georgia" size="3" color="#000000">
  Wie wollen Sie ihre Bestellung bezahlen? Beachten Sie, daß<br>
  die verschiedenen Optionen unterschiedliche Gebühren beinhalten.</font>
  
CDORDER;
  }
  
  echo <<<CDORDER
   <table width="500" border="0" align="center" valign="top" bgcolor="#544a31">
     <tr>
     <em><font face="Georgia" size="3" color="#000000">
     
CDORDER;
  
  if ($lang == "english")
  {
   echo <<<CDORDER
     <td align="center">
     <select name="payment" size="1">
       <option value="Bank Transfer">Bank Transfer (+ 0.00 &euro;)</option>
       <option value="PayPal">PayPal (+ 1.13 &euro;)</option>
       <option value="Pay On Delivery">Pay on delivery (+ 5.65 &euro;)</option>
     </select><br>
     <br>
     
CDORDER;
  }
  else
  {
   echo <<<CDORDER

     <td align="center">
     <select name="payment" size="1">
       <option value="Bank Transfer">&Uuml;berweisung (+ 0.00 &euro;)</option>
       <option value="PayPal">PayPal (+ 1.13 &euro;)</option>
       <option value="Pay On Delivery">Nachnahme (+ 5.65 &euro;)</option>
     </select><br>
     <br>
     
CDORDER;
  }
  
  echo <<<CDORDER
     </td>
     </tr>
   </table>
     
    <table width="500" border="0" align="center" valign="center" bgcolor="#544a31">
      <tr>
      
CDORDER;
  
  if ($lang == "english")
  {
   echo <<<CDORDER
      <td width="250" align="center" valign="top">
         <input type="reset" value=" Reset ">
      </td>
      <td width="250" align="center" valign="top">
        <input type="submit" value=" >>> Ship this to: ">
      </td>
      
CDORDER;
  }
  else
  {
   echo <<<CDORDER
      <td width="250" align="center" valign="top">
         <input type="reset" value=" Zur&uuml;cksetzen ">
      </td>
      <td width="250" align="center" valign="top">
        <input type="submit" value=" >>> Schicke das zu: ">
      </td>
      
CDORDER;
  }
  ?>
      </tr>
    </table>
  </form>
</table>
<!-- FUSS -->
<?php include ('../fuss.php'); ?>
