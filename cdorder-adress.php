<?php
$current_page = "shop";
include ('../header.html'); 
include ('../kopf.php');

include('getvars.php');
if ($lang == "english") $pieces = "pieces";
else $pieces = "St&uuml;ck";
?>

<table width="800" align="center" bgcolor="#544a31"><tr><td align="center" valign="center">
  <em><font face="Georgia" color="#000000" size="5">
  <? if ($lang == "english") echo "Shipping information"; else echo "Versanddaten"; ?>
  <?php
  echo <<<CDORDER
  </font><br>
   <form action="cdorderaction.php" method="post" accept-charset="UTF-8">
     <input type="hidden" name="lang" value="$lang">
     <input type="hidden" name="darkercolors" value="$darkercolors">
     <input type="hidden" name="darkercolorsamount" value="$darkercolorsamount">
     <input type="hidden" name="livemix" value="$livemix">
     <input type="hidden" name="livemixamount" value="$livemixamount">
     <input type="hidden" name="roughmix" value="$roughmix">
     <input type="hidden" name="roughmixamount" value="$roughmixamount">
     <input type="hidden" name="ts_wtf" value="$ts_wtf">
     <input type="hidden" name="ts_wtfamount" value="$ts_wtfamount">
     <input type="hidden" name="payment" value="$payment">
     <input type="hidden" name="lang" value="$lang">
     

   <table width="700" border="0" bgcolor="#544a31">
   <tr><td height="10"></td><td></td></tr>
   <tr>
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
       Name: 
     </td>
     <td width="300">
       <input maxlength="100" size="38" name="name">
     </td>
     </tr>
     
     <tr>
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
       Street: 
CDORDER;
  }
else
  {
echo <<<CDORDER
       Strasse: 
CDORDER;
  }

echo <<<CDORDER
     </td>
     <td width="300" align="left">
       <input maxlength="100" size="38" name="strasse">
     </td>
     </tr>
     
     <tr>
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
       ZIP - City: 
CDORDER;
  }
else
  {
echo <<<CDORDER
       PLZ - Stadt: 
CDORDER;
  }

echo <<<CDORDER
     </td>
     <td width="300" align="left">
       <input maxlength="100" size="38" name="stadt">
     </td>
     </tr>
     
     <tr>
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
       Province: 
CDORDER;
  }
else
  {
echo <<<CDORDER
       Land: 
CDORDER;
  }

echo <<<CDORDER
     </td>
     <td width="300" align="left">
       <input maxlength="100" size="38" name="province">
     </td>
     </tr>
     
     <tr>
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
       Country: 
CDORDER;
  }
else
  {
echo <<<CDORDER
       Staat: 
CDORDER;
  }

echo <<<CDORDER
     </td>
     <td width="300" align="left">
<!-- start of drop down country selection list -->
<!-- generated via http://javascript.about.com/ Script Generator -->
<select name="land" size="1">
<option value="Afghanistan">Afghanistan</option><option value="Aland Islands">Aland Islands</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua and Barbuda">Antigua and Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option><option value="Botswana">Botswana</option><option value="Bouvet Island">Bouvet Island</option><option value="Brazil">Brazil</option><option value="British Indian Ocean territory">British Indian Ocean territory</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Christmas Island">Christmas Island</option><option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Congo, Democratic Republic">Congo, Democratic Republic</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="CÃ´te d'Ivoire (Ivory Coast)">CÃ´te d'Ivoire (Ivory Coast)</option><option value="Croatia (Hrvatska)">Croatia (Hrvatska)</option><option value="Cuba">Cuba</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="East Timor">East Timor</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Falkland Islands">Falkland Islands</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="French Southern Territories">French Southern Territories</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany" selected="selected">Germany</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard and McDonald Islands">Heard and McDonald Islands</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="Hungary">Hungary</option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><!-- copyright Felgall Pty Ltd --><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Ireland">Ireland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kiribati">Kiribati</option><option value="Korea (north)">Korea (north)</option><option value="Korea (south)">Korea (south)</option><option value="Kuwait">Kuwait</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Macedonia, Former Yugoslav Republic Of">Macedonia, Former Yugoslav Republic Of</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montenegro">Montenegro</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk Island">Norfolk Island</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pakistan">Pakistan</option><option value="Palau">Palau</option><option value="Palestinian Territories">Palestinian Territories</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Pitcairn">Pitcairn</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="RÃ©union">RÃ©union</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saint Helena">Saint Helena</option><option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option><option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><!-- copyright Felgall Pty Ltd --><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia">Serbia</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syria">Syria</option><option value="Taiwan">Taiwan</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad and Tobago">Trinidad and Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks and Caicos Islands">Turks and Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United Kingdom">United Kingdom</option><option  value="United States of America">United States of America</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatican City">Vatican City</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands (British)">Virgin Islands (British)</option><option value="Virgin Islands (US)">Virgin Islands (US)</option><option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option><option value="Western Sahara">Western Sahara</option><option value="Yemen">Yemen</option><option value="Zaire">Zaire</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option></select>
<!-- end of drop down country selection list -->
     </td>
     </tr>
     
     <tr>     
     <td width="200" align="right">
       <em><font face="Georgia" size="3" color="#000000">
       Email:
     </td>
     <td width="300" align="left">
       <input maxlength="100" size="38" name="email">
     </td>
     </tr>
   </table>
   
   <table width="500" border="0" bgcolor="#544a31">
     <tr><td height="50" align="center">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
         <input type="checkbox" name="newsletter" value="ja" checked="checked"><font face="Georgia" color="#000000" size="3"><em> I want to sign in to the Folkadelic Newsletter!</font>
CDORDER;
  }
else
  {
echo <<<CDORDER
         <input type="checkbox" name="newsletter" value="ja" checked="checked"><font face="Georgia" color="#000000" size="3"><em> Ich m&ouml;chte in den Folkadelic Newsletter eingetragen werden!</font>
CDORDER;
  }

echo <<<CDORDER
     </td></tr>
    </table>
    
    <table width="500" border="0" bgcolor="#544a31">
      <tr>
      <td width="250" align="center" valign="top">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
         <input type="reset" value=" Reset ">
CDORDER;
  }
else
  {
echo <<<CDORDER
         <input type="reset" value=" Zur&uuml;cksetzen ">
CDORDER;
  }

echo <<<CDORDER
      </td>
      <td width="250" align="center" valign="top">
CDORDER;

if ($lang == "english")
  {
echo <<<CDORDER
        <input type="submit" value=" >>> Buy now! ">
CDORDER;
  }
else
  {
echo <<<CDORDER
        <input type="submit" value=" >>> Jetzt kaufen! ">
CDORDER;
  }

echo <<<CDORDER
      </td>
      </tr>
      </table>
  </form>
  </em>
</td></tr></table>
CDORDER;
?>
<?php include ('../fuss.php'); ?>
