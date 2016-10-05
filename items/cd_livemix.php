<?php 
if ($mode == "long")
  {
   if ($lang == "english") 
     {
      $alt = "click here to view our CD Live Mix";
      $buy = "buy <b>Live Mix</b>";
      $value = "pieces (10 &euro;/piece)";
     }
   else 
     {
      $alt = "clicken Sie hier um die CD Live Mix anzusehen";
      $buy = "kaufe <b>Live Mix</b>";
      $value = "St&uuml;ck (10 &euro;/St&uuml;ck)";
     }
   
   echo <<<OUTPUT
<td width="50%" align="center">
  <a rel="livemix" href="items/cd/livemix.html" class="fancy">
  <img width="200" src="items/cd/livemix.png" alt="$alt" title="$alt"></a><br>
  <input type="checkbox" name="livemix" value="ja"><font face="Georgia" size="3"><em>$buy<br>
  <input maxlength="4" size="2" value="1" name="livemixamount"> $value</em></font>
</td>
OUTPUT;
  }

if ($mode == "short")
  {
   if ( $livemix == "ja" )
     {
      $checked = " checked";
     }
   else
     {
      $checked = "";
      $livemixamount = "0";
     }
   echo <<<OUTPUT
<tr>     
  <td width="300" height="20" align="right">
  <em><font face="Georgia" size="3"><a rel="cdgalery" href="items/cd/livemix.html" class="fancy">Live Mix</a> - CD (2009):
  <input type="checkbox" name="livemix" value="ja"$checked>
  </td>
  <td width="200" align="left">
    <em><font face="Georgia" size="3" color="#000000"><input maxlength="5" size="2" value="$livemixamount" name="livemixamount"> $pieces &aacute; 10&euro;
  </td>
</tr>
OUTPUT;
  }
?>
