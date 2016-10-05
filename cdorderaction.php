<?php
$current_page = "shop";
include ('../header.html'); 
include ('../kopf.php');
?>

<table cellpadding="0" cellspacing="0" width="800" height="20" align="center" bgcolor="#544a31">
<tr>
<td align="center">
<?php
  $id = date("YmdHis");
  $anzahl = 0;
  $shipping = 0;
  $counter = 0;
  if((!$_POST["reset_x"]))
  {
    /* set language */
    $lang = ((isset($_POST["lang"])) && ($_POST["lang"] != "")) ? $_POST["lang"]:"deutsch";
    if ($lang == "english") $pieces = " piece(s)";
    if ($lang == "deutsch") $pieces = " Stueck";
    
    /* set name */
    $name = ((isset($_POST["name"])) && ($_POST["name"] != "")) ? $_POST["name"]:unbekannt;
    
    /* set strasse */
    $strasse = ((isset($_POST["strasse"])) && ($_POST["strasse"] != "")) ? $_POST["strasse"]:unbekannt;
    
    /* set stadt */
    $stadt = ((isset($_POST["stadt"])) && ($_POST["stadt"] != "")) ? $_POST["stadt"]:unbekannt;
    
    /* set land */
    $land = ((isset($_POST["land"])) && ($_POST["land"] != "")) ? $_POST["land"]:unbekannt;
    
    /* set province */
    $province = ((isset($_POST["province"])) && ($_POST["province"] != "")) ? $_POST["province"]:unbekannt;
    
    /* set email */
    $email = ((isset($_POST["email"])) && ($_POST["email"] != "")) ? $_POST["email"]:unbekannt;
    
    /* Newsletter */
    $newsletter = ((isset($_POST["newsletter"])) && ($_POST["newsletter"] != "")) ? $_POST["newsletter"]:"nein";
    if ($newsletter == "nein") { $newslettertext = "KEIN Newsletter!!!"; }
    if ($newsletter == "ja") 
      {
       $newslettertext = "$name möchte in den Newsletter eingetragen werden.";
       if ($lang == "deutsch") { $newslettertextsubscriber = "Sie werden in unseren Newsletter eingetragen werden. Sie erhalten in Kürze eine Bestätigungsmail.";}
       if ($lang == "english") { $newslettertextsubscriber = "You will be added to our Newsletter. You'll recieve a confirmation mail soon."; }
      }
    
    /* CD - Darker Colors */
    $darkercolors = ((isset($_POST["darkercolors"])) && ($_POST["darkercolors"] != "")) ? $_POST["darkercolors"]:$darkercolors = "nein";
    $darkercolorsamount = ((isset($_POST["darkercolorsamount"])) && ($_POST["darkercolorsamount"] != "")) ? $_POST["darkercolorsamount"]:$darkercolorsamount = "0";
    if ($darkercolors == "ja") 
      {
       $pricedarkercolors = $darkercolorsamount * 15;
       $anzahl = $anzahl + $darkercolorsamount; 
       $darkercolorstext = "Darker Colors: $darkercolorsamount $pieces (15 Euro)"; 
       $cdsummarymail = "$darkercolorstext = $pricedarkercolors Euro\n"; 
       $cdsummaryhtml = "$darkercolorstext<br>"; 
       $pricesummaryhtml = "$pricedarkercolors.00 &euro;<br>";
      }
    else
      {
       $darkercolorsamount = "0"; 
       $darkercolorstext = ""; 
       $cdsummarymail = ""; 
       $cdsummaryhtml = ""; 
       $pricesummaryhtml = "";
      }
    
    /* CD - Live Mix */
    $livemix = ((isset($_POST["livemix"])) && ($_POST["livemix"] != "")) ? $_POST["livemix"]:$livemix = "nein";
    $livemixamount = ((isset($_POST["livemixamount"])) && ($_POST["livemixamount"] != "")) ? $_POST["livemixamount"]:$livemixamount = "0";
    if ($livemix == "ja") 
      {
       $pricelivemix = $livemixamount * 10;
       $anzahl = $anzahl + $livemixamount; 
       $livemixtext = "Live Mix: $livemixamount $pieces (10 Euro)"; 
       $cdsummarymail .= "$livemixtext = $pricelivemix Euro\n"; 
       $cdsummaryhtml .= "$livemixtext<br>"; 
       $pricesummaryhtml .= "$pricelivemix.00 &euro;<br>";
      }
    else 
      { 
       $livemixamount = "0"; 
       $livemixtext = ""; 
       $cdsummarymail .= ""; 
       $cdsummaryhtml .= "";  
       $pricesummaryhtml .= "";
      }
    
    /* CD - Rough Mix */
    $roughmix = ((isset($_POST["roughmix"])) && ($_POST["roughmix"] != "")) ? $_POST["roughmix"]:$roughmix = "nein";
    $roughmixamount = ((isset($_POST["roughmixamount"])) && ($_POST["roughmixamount"] != "")) ? $_POST["roughmixamount"]:$roughmixamount = "0";
    if ($roughmix == "ja") 
      {
       $priceroughmix = $roughmixamount * 10;
       $anzahl = $anzahl + $roughmixamount; 
       $roughmixtext = "Rough Mix: $roughmixamount $pieces (10 Euro)"; 
       $cdsummarymail .= "$roughmixtext = $priceroughmix Euro\n"; 
       $cdsummaryhtml .= "$roughmixtext<br>"; 
       $pricesummaryhtml .= "$priceroughmix.00 &euro;<br>";
      }
    else 
      { 
       $roughmixamount = "0"; 
       $roughmixtext = ""; 
       $cdsummarymail .= ""; 
       $cdsummaryhtml .= ""; 
       $pricesummaryhtml .= "";
      }
      
    /* TShirt - What the Folk? */
    $ts_wtf = ((isset($_POST["ts_wtf"])) && ($_POST["ts_wtf"] != "")) ? $_POST["ts_wtf"]:$ts_wtf = "nein";
    $ts_wtfamount = ((isset($_POST["ts_wtfamount"])) && ($_POST["ts_wtfamount"] != "")) ? $_POST["ts_wtfamount"]:$ts_wtfamount = "0";
    if ($ts_wtf == "ja") 
      {
       $pricets_wtf = $ts_wtfamount * 30;
       $anzahl = $anzahl + $ts_wtfamount; 
       $ts_wtftext = "T-Shirt - What the Folk?: $ts_wtfamount $pieces (30 Euro)"; 
       $cdsummarymail .= "$ts_wtftext = $pricets_wtf Euro\n"; 
       $cdsummaryhtml .= "$ts_wtftext<br>"; 
       $pricesummaryhtml .= "$pricets_wtf.00 &euro;<br>";
      }
    else 
      { 
       $ts_wtfamount = "0"; 
       $ts_wtftext = ""; 
       $cdsummarymail .= ""; 
       $cdsummaryhtml .= ""; 
       $pricesummaryhtml .= "";
      }

    /* set payment */
    $payment = ((isset($_POST["payment"])) && ($_POST["payment"] !="")) ? $_POST["payment"]:$payment = "";

    
    /*set date */
    $date = date("d.m.Y");
  }

/* Exit, if not all fields are set! Spam-Protection! */
  if($name == "unbekannt" or $strasse == "unbekannt" or $stadt == "unbekannt" or $land == "unbekannt" or $province == "unbekannt" or $email == "unbekannt")
   {
    echo <<<ERRORTEXT
    <font face="Georgia" color="#4f1c07" size="3"><b><center>
      All fields have to be filled out!<br>
      Alle Felder m&uuml;ssen ausgef&uuml;llt werden!<br>
      <br>
    </center></b></font>
ERRORTEXT;
    exit;
   }
  if ($darkercolorsamount == "0" and $livemixamount == "0" and $roughmixamount == "0" and $ts_wtfamount == "0")
   {
    echo <<<ERRORTEXT
    <font face="Georgia" size="3" color="#4f1c07"><b><center>
      In order to order, you'll have to order something!<br>
      Sie m&uuml;ssen schon etwas bestellen, um zu bestellen!<br>
      <br>
    </center></b></font>
ERRORTEXT;
    exit;
   }

/* calculate prices */
    if ($land == "Germany") { $shipping = 1.45; }
    else { $shipping = 3.45; }

    if ($payment == "Bank Transfer") {$transfercost = 0;}
    if ($payment == "PayPal") {$transfercost = 1.13;}
    if ($payment == "Pay On Delivery") {$transfercost = 5.65;}

  $costs = $transfercost + $shipping;
  $cds = $pricedarkercolors + $priceroughmix + $pricelivemix + $pricets_wtf;
  $preis = $cds + $costs;
  
/* make numbers pretty (2 decimals after point, no thousands-separator) */
  $transfercost = number_format($transfercost, 2, '.', '');
  $costs = number_format($costs, 2, '.', '');
  $cds = number_format($cds, 2, '.', '');
  $preis = number_format($preis, 2, '.', '');
  
 
/* mail for buyer */
  $buyer = "$name <$email>";
  $betreff = "CD-Bestellung @ folkadelic.de - ID:$id";
  $kontoinfo = "Brian Brademann\nKto.Nr.: 915 660 540\nBLZ: 200 411 33\nIBAN: DE83200411330915660540\nBIC/Swift-Code: COBADEHD001\n\nPayPal-ID: LL5N934Z5GMT8\n";
  if ( $lang == "english" ) { $buyermessage = "$date\nID:$id\n\nDear $name!\n\nWe will deliver your items to the following adress:\n$name\n$strasse\n$stadt\n$province\n$land\n\n$cdsummarymail\nCharges for shipping = $shipping\nCharges for $payment = $transfercost\nSum: $preis\n\nThanks for your order!\nFolkadelic Hobo Jamboree\n\n\nOur Bank Account:\n\n$kontoinfo\n\n\n$newslettertextsubscriber"; }
  if ( $lang == "deutsch" ) { $buyermessage = "$date\nID:$id\n\nLiebe(r) $name!\n\nWir werden Ihre Lieferung an folgende Adresse schicken:\n$name\n$strasse\n$stadt\n$province\n$land\n\n$cdsummarymail\nVersandkosten = $shipping\nGebühren für $payment = $transfercost\nSumme: $preis\n\nVielen Dank für Ihre Bestellung!\nFolkadelic Hobo Jamboree\n\n\nUnser Bank-Konto:\n\n$kontoinfo\n\n\n$newslettertextsubscriber"; }

  $buyermessage = wordwrap($buyermessage, 70);
  $header = "From: shop@folkadelic.de\r\n";
  $header .= "Content-Type: text/plain; charset = \"UTF-8\";\r\n";
  $header .= "Content-Transfer-Encoding: 8bit\r\n";
  $header .= "\r\n";

  mail($buyer, $betreff, $buyermessage, $header);
  
/* mail for shop */
  $shopkeeper = "shop@folkadelic.de,chris.potsdam@googlemail.com";
  $shopmessage = "$date\nID:$id\n\n$name <$email> (spricht $lang)\n$strasse\n$stadt\n$province\n$land\n\nbestellt:\n\n$cdsummarymail\nVersand nach $land = $shipping\nGebühren für $payment = $transfercost\nSumme: $preis\n\n$newslettertext";
  $shopmessage = wordwrap($shopmessage, 70);
  $shopheader = "From: $name <$email>\r\n";
  $shopheader .= "Content-Type: text/plain; charset = \"UTF-8\";\r\n";
  $shopheader .= "Content-Transfer-Encoding: 8bit\r\n";
  $shopheader .= "\r\n";
  mail($shopkeeper, $betreff, $shopmessage, $shopheader);

/* Browser Output - Summary/Receit and Payment infos */
  if ($lang == "english")
   {
    if ($payment == "Bank Transfer")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em><b>
    <h3>Thank you for your order!</h3>
    Please send <u>$preis &euro;</u> to the following bank account:<br>
    <br>
    Brian Brademann<br>
    Kto.Nr.: 915 660 540<br>
    BLZ: 200 411 33<br>
    IBAN: DE83200411330915660540<br>
    BIC/Swift-Code: COBADEHD001<br>
    <br>
    As soon as your money arrives we'll send your shipment.<br></b>
    <hr>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Items total <br>
          Shipping of $anzahl CD's <br>
          Charge for $payment <br>
          <b>Total <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    </b></div>
    
ORDERTEXT;
    }
  
    if ($payment == "PayPal")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em><b>
    <h3>Thank you for your order!</h3>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
        <form id="checkout_form" name="checkout_form" method="post" action="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8">
        <input id="cmd" name="cmd" type="hidden" value="_cart" />
        <input id="upload" name="upload" type="hidden" value="1" />
        <input id="charset" name="charset" type="hidden" value="utf-8" />
        <input id="no_shipping" name="no_shipping" type="hidden" value="2" />
        <input id="no_note" name="no_note" type="hidden" value="0" />
        <input id="rm" name="rm" type="hidden" value="2" />
        <input id="business" name="business" type="hidden" value="kassenwart@folkadelic.de" />
        <input id="cbt" name="cbt" type="hidden" value="Return to The Folkadelic Shop" />
        <input id="currency_code" name="currency_code" type="hidden" value="EUR" />
        <input id="lc" name="lc" type="hidden" value="DE" />
        <input id="invoice" name="invoice" type="hidden" value="ENQG-889150" />
        <input id="shopping_url" name="shopping_url" type="hidden" value="http://folkadelic.de" />
        <input id="return" name="return" type="hidden" value="http://folkadelic.de" />
        <input id="cancel_return" name="cancel_return" type="hidden" value="http://folkadelic.de" />
        <input id="notify_url" name="notify_url" type="hidden" value="http://folkadelic.de" />
        <input id="bn" name="bn" type="hidden" value="Folkadelic Hobo Jamboree" />
        <input id="tax_cart" name="tax_cart" type="hidden" value="0" />

ORDERTEXT;
if ( $darkercolors == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id DC2012" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$darkercolorsamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="Darker Colors (2012)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="15.0" />

ORDERTEXT;
  }
if ( $livemix == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id LM2009" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$livemixamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="LiveMix (2009)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="10.0" />

ORDERTEXT;
  }
if ( $roughmix == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id RM2008" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$roughmixamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="RoughMix (2008)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="10.0" />

ORDERTEXT;
  }
if ( $ts_wtf == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id TSWTF" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$ts_wtfamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="T-Shirt WTF" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="30.0" />

ORDERTEXT;
  }
echo <<<ORDERTEXT
        <input id="shipping_1" name="shipping_1" type="hidden" value="$costs" />
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
      </form>
    <font color="#4f1c07">As soon as your transaction is confirmed we'll send your shipment.<br></font></b>
    <hr>
    <font face="Georgia" color="#000000" size="3"><em>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Items total <br>
          Shipping of $anzahl CD's <br>
          Charge for $payment <br>
          <b>Total <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    </b></div>

ORDERTEXT;
    }
  
    if ($payment == "Pay On Delivery")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em>
    <h3>Thank you for your order!</h3>
    <hr>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Items total <br>
          Shipping of $anzahl CD's <br>
          Charge for $payment <br>
          <b>Total <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    Please make sure you have the money ready when the shipment arrives! :)<br>
    </b></div>

ORDERTEXT;
    }
   }
  
  if ($lang == "deutsch")
   {
    if ($payment == "Bank Transfer")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em><b>
    <h3>Danke f&uuml;r Ihre Bestellung!</h3>
    Bitte &uuml;berweisen Sie <u>$preis &euro;</u> auf das folgende Konto:<br>
    <br>
    Brian Brademann<br>
    Kto.Nr.: 915 660 540<br>
    BLZ: 200 411 33<br>
    IBAN: DE83200411330915660540<br>
    BIC/Swift-Code: COBADEHD001<br>
    <br>
    Sobald Ihre Zahlung eintrifft verschicken wir Ihre Bestellung.<br></b>
    <hr>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Waren gesamt <br>
          Versand von $anzahl CD's <br>
          Geb&uuml;hr f&uuml;r $payment <br>
          <b>Insgesamt <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    </b></div>

ORDERTEXT;
    }
  
    if ($payment == "PayPal")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em><b>
    <h3>Danke f&uuml;r Ihre Bestellung!</h3>
      <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
      
        <form id="checkout_form" name="checkout_form" method="post" action="https://www.paypal.com/cgi-bin/webscr" accept-charset="UTF-8">
        <input id="cmd" name="cmd" type="hidden" value="_cart" />
        <input id="upload" name="upload" type="hidden" value="1" />
        <input id="charset" name="charset" type="hidden" value="utf-8" />
        <input id="no_shipping" name="no_shipping" type="hidden" value="2" />
        <input id="no_note" name="no_note" type="hidden" value="0" />
        <input id="rm" name="rm" type="hidden" value="2" />
        <input id="business" name="business" type="hidden" value="kassenwart@folkadelic.de" />
        <input id="cbt" name="cbt" type="hidden" value="Return to The Folkadelic Shop" />
        <input id="currency_code" name="currency_code" type="hidden" value="EUR" />
        <input id="lc" name="lc" type="hidden" value="DE" />
        <input id="invoice" name="invoice" type="hidden" value="ENQG-889150" />
        <input id="shopping_url" name="shopping_url" type="hidden" value="http://folkadelic.de" />
        <input id="return" name="return" type="hidden" value="http://folkadelic.de" />
        <input id="cancel_return" name="cancel_return" type="hidden" value="http://folkadelic.de" />
        <input id="notify_url" name="notify_url" type="hidden" value="http://folkadelic.de" />
        <input id="bn" name="bn" type="hidden" value="Folkadelic Hobo Jamboree" />
        <input id="tax_cart" name="tax_cart" type="hidden" value="0" />
ORDERTEXT;
if ( $darkercolors == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id DC2012" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$darkercolorsamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="Darker Colors (2012)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="15.0" />
ORDERTEXT;
  }
if ( $livemix == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id LM2009" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$livemixamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="LiveMix (2009)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="10.0" />
ORDERTEXT;
  }
if ( $roughmix == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id RM2008" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$roughmixamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="RoughMix (2008)" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="10.0" />
ORDERTEXT;
  }
if ( $ts_wtf == "ja" )
  {
   $counter++;
   echo <<<ORDERTEXT
        <input id="item_number_$counter" name="item_number_$counter" type="hidden" value="$id TSWTF" />
        <input id="quantity_$counter" name="quantity_$counter" type="hidden" value="$ts_wtfamount" />
        <input id="item_name_$counter" name="item_name_$counter" type="hidden" value="T-Shirt WTF" />
        <input id="amount_$counter" name="amount_$counter" type="hidden" value="30.0" />

ORDERTEXT;
  }
echo <<<ORDERTEXT
        <input id="shipping_1" name="shipping_1" type="hidden" value="$costs" />
        <input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_paynow_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
        <img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
      </form>
    <font color="#4f1c07">Sobald Ihre Zahlung best&auml;tigt wird verschicken wir Ihre Bestellung.<br></font></b>
    <br>
    <hr>
    <font face="Georgia" color="#000000" size="3"><em>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Waren gesamt <br>
          Versand von $anzahl CD's <br>
          Geb&uuml;hr f&uuml;r $payment <br>
          <b>Insgesamt <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    </b></div>

ORDERTEXT;
    }
  
    if ($payment == "Pay On Delivery")
    {
    echo <<<ORDERTEXT
    <div align="center">
    <font face="Georgia" color="#000000" size="3"><em>
    <h3>Danke f&uuml;r Ihre Bestellung!</h3>
    <hr>
    <table border="0" bgcolor="#544a31">
      <tr>
        <td align="right">
          $cdsummaryhtml
          Waren gesamt <br>
          Versand von $anzahl CD's <br>
          Geb&uuml;hr f&uuml;r $payment <br>
          <b>Insgesamt <br></b>
        </td>
        <td width="15"></td>
        <td align="right">
          $pricesummaryhtml
          $cds &euro;<br>
          $shipping &euro;<br>
          $transfercost &euro;<br>
          <b><u>$preis &euro;</u></b><br>
        </td>
      </tr>
    </table>
    <hr>
    Bitte stellen Sie sicher, daß das Geld bereit liegt, wenn die Lieferung eintrifft! :)<br>
    </b></div>

ORDERTEXT;
    }
   }
  

  /* Debug Variables */
  /*
  echo "Email:<br>To: $buyer<br>Subject: $betreff<br>Header: $header<br>message: $buyermessage<br>";
  echo "Shopmail:<br>$shopmessage<br>";
  echo "Kontoinfo: $kontoinfo<br>";
  echo "ID: $id<br>";
  echo "Sprache: $lang<br>";
  echo "pieces: $pieces<br>";
  echo "Name: $name<br>";
  echo "Strasse: $strasse<br>";
  echo "Stadt: $stadt<br>";
  echo "Province: $province<br>";
  echo "Land: $land<br>";
  echo "Email: $email<br>";
  echo "darkercolors: $darkercolors<br>";
  echo "darkercolorsamount: $darkercolorsamount<br>";
  echo "$darkercolorstext<br>";
  echo "roughmix: $roughmix<br>";
  echo "roughmixamount: $roughmixamount<br>";
  echo "$roughmixtext<br>";
  echo "livemix: $livemix<br>";
  echo "livemixamount: $livemixamount<br>";
  echo "$livemixtext<br>";
  echo "ts_wtf: $ts_wtf<br>";
  echo "$ts_wtftext<br>";
  echo "cdsummaryhtml: $cdsummaryhtml";
  echo "$pricedarkercolors + $priceroughmix + $pricelivemix + $pricets_wtf == $preis<br>";
  echo "Payment: $payment<br>";
  echo "Transfer: $transfercost &euro;<br>";
  echo "Shipping: $shipping &euro;<br>";
  echo "Costs: $costs &euro;<br>";
  echo "Preis: $preis &euro;<br>";
  echo "Datum: $date<br>";
  echo "Newsletter: $newsletter";
*/
?>
</td>
</tr>
</table>
<?php include ('../fuss.php'); ?>
