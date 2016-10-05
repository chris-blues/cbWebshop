<?php 
if ($mode == "long")
  {
   if ($lang == "english") 
     {
      $alt = "click here to view our CD Rough Mix";
      $buy = "buy <b>Rough Mix</b>";
      $value = "pieces (10 &euro;/piece)";
     }
   else 
     {
      $alt = "clicken Sie hier um die CD Rough Mix anzusehen";
      $buy = "kaufe <b>Rough Mix</b>";
      $value = "St&uuml;ck (10 &euro;/St&uuml;ck)";
     }
   
   echo <<<OUTPUT
<td width="50%" align="center">
  <a rel="roughmix" href="items/cd/roughmix.html" class="fancy">
  <img width="200" src="items/cd/roughmix.png" alt="$alt" title="$alt"></a><br>
  <input type="checkbox" name="roughmix" value="ja"><font face="Georgia" size="3"><em>$buy<br>
  <input maxlength="4" size="2" value="1" name="roughmixamount"> $value</em></font>
</td>
OUTPUT;
  }

if ($mode == "short")
  {
   if ( $roughmix == "ja" )
     {
      $checked = " checked";
     }
   else
     {
      $checked = "";
      /*$roughmixamount = "0";*/
     }
   echo <<<OUTPUT
<tr>     
  <td width="300" height="20" align="right">
  <em><font face="Georgia" size="3"><a rel="cdgalery" href="items/cd/roughmix.html" class="fancy">Rough Mix</a> - CD (2008):
  <input type="checkbox" name="roughmix" value="ja"$checked>
  </td>
  <td width="200" align="left">
    <em><font face="Georgia" size="3" color="#000000"><input maxlength="5" size="2" value="$roughmixamount" name="roughmixamount"> $pieces &aacute; 10&euro;
  </td>
</tr>
OUTPUT;
  }
?>
