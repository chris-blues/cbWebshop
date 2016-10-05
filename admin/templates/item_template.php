<?php 
if ($mode == "long")
  {
   if ($lang == "english") 
     {
      $alt = "click here to view our %type% %name%";
      $buy = "buy <b>%name%</b>";
      $value = "pieces (%preis% &euro;/piece)";
     }
   else 
     {
      $alt = "clicken Sie hier um die %type% %name%";
      $buy = "kaufe <b>%name%</b>";
      $value = "St&uuml;ck (%preis% &euro;/St&uuml;ck)";
     }
   
   echo <<<OUTPUT
<td width="50%" align="center">
  <a rel="%id%" href="items/%type%/%id%.html" class="fancy">
  <img width="200" src="items/%pic%" alt="$alt" title="$alt"></a><br>
  <input type="checkbox" name="%id%" value="ja"><font face="Georgia" size="3"><em>$buy<br>
  <input maxlength="4" size="2" value="1" name="%id%amount"> $value</em></font>
</td>
OUTPUT;
  }

if ($mode == "short")
  {
   if ( $%id% == "ja" )
     {
      $checked = " checked";
     }
   else
     {
      $checked = "";
      $%id%amount = "0";
     }
   echo <<<OUTPUT
<tr>     
  <td width="300" height="20" align="right">
  <em><font face="Georgia" size="3"><a rel="cdgalery" href="items/%type%/%id%.html" class="fancy">%name%</a> - %TYPE% (%descr%):
  <input type="checkbox" name="%id%" value="ja"$checked>
  </td>
  <td width="200" align="left">
    <em><font face="Georgia" size="3" color="#000000"><input maxlength="5" size="2" value="$%id%amount" name="%id%amount"> $pieces &aacute; %preis%&euro;
  </td>
</tr>
OUTPUT;
  }
?>
