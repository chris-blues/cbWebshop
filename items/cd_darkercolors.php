<?php 
if ($mode == "long")
  {
   if ($lang == "english") 
     {
      $alt = "click here to view our CD Darker Colors";
      $buy = "buy <b>Darker Colors</b>";
      $value = "pieces (15 &euro;/piece)";
     }
   else 
     {
      $alt = "clicken Sie hier um die CD Darker Colors anzusehen";
      $buy = "kaufe <b>Darker Colors</b>";
      $value = "St&uuml;ck (15 &euro;/St&uuml;ck)";
     }
   
   echo <<<OUTPUT
<td width="50%" align="center">
  <a rel="darkercolors" href="items/cd/darkercolors.html" class="fancy">
  <img width="200" src="items/cd/darkercolors.jpg" alt="$alt" title="$alt"></a><br>
  <input type="checkbox" name="darkercolors" value="ja"><font face="Georgia" size="3"><em>$buy<br>
  <input maxlength="4" size="2" value="1" name="darkercolorsamount"> $value</em></font>
</td>
OUTPUT;
  }

if ($mode == "short")
  {
   if ( $darkercolors == "ja" )
     {
      $checked = " checked";
     }
   else
     {
      $checked = "";
      $darkercolorsamount = "0";
     }
   echo <<<OUTPUT
<tr>     
  <td width="300" height="20" align="right">
  <em><font face="Georgia" size="3"><a rel="cdgalery" href="items/cd/darkercolors.html" class="fancy">Darker Colors</a> - CD (2012):
  <input type="checkbox" name="darkercolors" value="ja"$checked>
  </td>
  <td width="200" align="left">
    <em><font face="Georgia" size="3" color="#000000"><input maxlength="5" size="2" value="$darkercolorsamount" name="darkercolorsamount"> $pieces &aacute; 15&euro;
  </td>
</tr>
OUTPUT;
  }
?>
