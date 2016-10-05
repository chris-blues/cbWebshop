<?php 
if ($mode == "long")
  {
   if ($lang == "english") 
     {
      $alt = "click here to view our T-Shirt What the folk?";
      $buy = "buy <b>What the folk?</b>";
      $value = "pieces (30 &euro;/piece)";
     }
   else 
     {
      $alt = "clicken Sie hier um die T-Shirt What the folk? anzusehen";
      $buy = "kaufe <b>What the folk?</b>";
      $value = "St&uuml;ck (30 &euro;/St&uuml;ck)";
     }
   
   echo <<<OUTPUT
<td width="50%" align="center">
  <a rel="whatthefolk" href="items/tshirt/whatthefolk.html" class="fancy">
  <img width="200" src="items/tshirt/whatthefolk.png" alt="$alt" title="$alt"></a><br>
  <input type="checkbox" name="ts_wtf" value="ja"><font face="Georgia" size="3"><em>$buy<br>
  <input maxlength="4" size="2" value="1" name="ts_wtfamount"> $value</em></font>
</td>
OUTPUT;
  }

if ($mode == "short")
  {
   if ( $ts_wtf == "ja" )
     {
      $checked = " checked";
     }
   else
     {
      $checked = "";
      $ts_wtfamount = "0";
     }
   echo <<<OUTPUT
<tr>     
  <td width="300" height="20" align="right">
  <em><font face="Georgia" size="3"><a rel="cdgalery" href="items/tshirt/whatthefolk.html" class="fancy">What the folk?</a> - T-Shirt:
  <input type="checkbox" name="ts_wtf" value="ja"$checked>
  </td>
  <td width="200" align="left">
    <em><font face="Georgia" size="3" color="#000000"><input maxlength="5" size="2" value="$ts_wtfamount" name="ts_wtfamount"> $pieces &aacute; 30&euro;
  </td>
</tr>
OUTPUT;
  }
?>
