<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<?php
include('conf/shop_conf.php');
include('conf/cost_conf.php');
include('conf/payment_conf.php');
include('conf/countries.php');
/* ################################################################### */
/* Hole Variablen aus POST-Formular */
$error = "0"; $posterror = "0";
if (!$_POST["reset_x"])
  {
    if ((isset($_POST["lang"])) && ($_POST["lang"] != "")) $lang = $_POST["lang"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "lang";}
    if ((isset($_POST["kartid"])) && ($_POST["kartid"] != "")) $kartid = $_POST["kartid"]; else {$error = "1"; $posterror++; $errors['post']["$posterror"] = "kartid";}
   }

/* ################################################################### */

define( "LOC_LANG", $lang );
include('locale/' . LOC_LANG . '.php');
$kartmode = "action";
$kartfilepath = "tmp";
include('read_kartfile.php');

/* ################################################################### */


/* Stelle Variablen zusammen */
$date = date("d.m.Y");
if ($countryname == $cost["_homecountry"]) $shippingcost = "{$cost["shipping_home"]}"; else $shippingcost = "{$cost["shipping_foreign"]}";
if ($opt == "1")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["banktransfer"]["home"];
   else $transfercost = $payment["banktransfer"]["foreign"];
   $paymentname = $loc_lang["banktransfer"];
   $paymentnamemail = $loc_lang["mail"]["banktransfer"];
  }
if ($opt == "2")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["paypal"]["home"];
   else $transfercost = $payment["paypal"]["foreign"];
   $paymentname = $loc_lang["paypal"];
   $paymentnamemail = $loc_lang["mail"]["paypal"];
  }
if ($opt == "3")
  {
   if ($countryname == $cost["_homecountry"]) $transfercost = $payment["payondelivery"]["home"];
   else $transfercost = $payment["payondelivery"]["foreign"];
   $paymentname = $loc_lang["payondelivery"];
   $paymentnamemail = $loc_lang["mail"]["payondelivery"];
  }
$costs = $transfercost + $shippingcost;

if ($countryname == "Germany") $countryname_code = "DE";
if ($countryname == "Great Britain") $countryname_code = "GB";
if ($countryname == "Poland") $countryname_code = "PL";
if ($countryname == "USA") $countryname_code = "US";

/* ################################################################### */

//include('header_short.html');
if ($paymentname == "PayPal") $onload = "document.paypal_form.submit();";
else $onload = "document.leaveshop_form.submit();";
if ($newsletter == "ja") $onload .= "document.jnl2_sign_form.submit();";
echo "<body onload=\"$onload\">\n";
echo "<table width=\"500\" height=\"600\" align=\"center\" border=\"0\">";
?>
  <tr>
    <td align="center" valign="center">
<?php

/* ################################################################### */

/* Check for missing data and exit if so - else redirect to checkout-site (PayPal / leaveshop.php) */
if ($error != "0")
  {
   echo "<table border=\"0\"><tr><td align=\"center\"><h4><u><b>ERROR!</b></u></h4></td></tr><tr><td align=\"left\">\n<ol>\n";
   if ($kartemptyerror == "1") $errormessage .= "<li>{$loc_lang["kart_empty_error"]}</li><br>\n";
   if ($errors['kartfile']['country'] == "empty" and $kartemptyerror != "1") $errormessage .= "<li>{$loc_lang["no_country_selected"]}</li><br>\n";
   if ($errors['kartfile']['opt'] == "empty" and $kartemptyerror != "1") $errormessage .= "<li>{$loc_lang["no_payment_selected"]}</li><br>\n";
   if ($kartemptyerror != "1")
     { if ($errors['kartfile']['firstname'] == "empty" or $errors['kartfile']['lastname'] == "empty" or $errors['kartfile']['adress1'] == "empty" or $errors['kartfile']['plz'] == "empty" or $errors['kartfile']['city'] == "empty" or $errors['kartfile']['email'] == "empty")
       $errormessage .= "<li>{$loc_lang["information_missing"]}</li><br>\n";
     }
   echo $errormessage;
   echo "</ol><br>\n";
   echo "</td></tr><tr><td align=\"center\">\n<a href=\"../index.php?page=shop&amp;display=order&amp;kartid=$kartid&amp;lang=$lang$errorreturn\" target=\"_top\"><b>{$loc_lang["back_to_order_form"]}</b></a><br>\n</td></tr></table></td></tr></table>";
   echo "<pre>\n"; print_r($errors); print_r($errorreturn); echo "</pre>\n";
   exit;
  }
  
/* NO ERRORS => Go on! */
/* ################################################################### */
  
else
  {
// If new Country - put it in the list!
foreach($country as $key => $value)
  {
   if ($value == $countryname) $countryexists = "yes";
  }
if (!isset($countryexists) or $countryexists != "yes")
  {
   $key++;
   $country[$key] = htmlspecialchars($countryname, ENT_QUOTES | ENT_HTML5, "UTF-8");
   sort($country, SORT_STRING);
   $configfile = "shop/conf/countries.php";
   $fHandle = fopen($configfile, "w");
   fputs($fHandle, "<?php\n");
   foreach ($country as $key => $value)
     {
      $str = "\$country[\"$key\"] = \"$value\";\n";
      fputs($fHandle, $str);
     }
   fputs($fHandle, "?>");
   fclose($fHandle);
   //echo "<pre>"; print_r($country); echo "</pre>\n";
  }

/* ################################################################### */

   echo "<b>{$loc_lang["one_moment"]}</b><br>\n";
   $pp_returnpath = "/index.php?page=shop&lang=$lang&kartid=$kartid&display=leaveshop&kart=reset";
   $pp_cancelreturnpath = "/index.php?page=shop&lang=$lang&kartid=$kartid";
   if ($opt == "2")
     {
      if ($lang == "english") $lc = "EN"; else $lc = "DE";
      echo "{$loc_lang["redirecting_to_paypal"]}\n";
      echo "<form id=\"checkout_form\" name=\"paypal_form\" method=\"post\" action=\"https://www.paypal.com/cgi-bin/webscr\" accept-charset=\"UTF-8\" target=\"_top\">\n";
        echo "<input id=\"cmd\" name=\"cmd\" type=\"hidden\" value=\"_cart\" />\n";
        echo "<input id=\"upload\" name=\"upload\" type=\"hidden\" value=\"1\" />\n";
        echo "<input id=\"charset\" name=\"charset\" type=\"hidden\" value=\"utf-8\" />\n";
        echo "<input id=\"no_shipping\" name=\"no_shipping\" type=\"hidden\" value=\"2\" />\n";
        echo "<input id=\"no_note\" name=\"no_note\" type=\"hidden\" value=\"0\" />\n";
        echo "<input id=\"rm\" name=\"rm\" type=\"hidden\" value=\"2\" />\n";
        echo "<input id=\"business\" name=\"business\" type=\"hidden\" value=\"{$conf["_paypal_business"]}\" />\n";
        echo "<input id=\"cbt\" name=\"cbt\" type=\"hidden\" value=\"Return to {$conf["this_domain"]}\" />\n";
        echo "<input id=\"currency_code\" name=\"currency_code\" type=\"hidden\" value=\"{$conf["_currency_code"]}\" />\n";
        echo "<input id=\"lc\" name=\"lc\" type=\"hidden\" value=\"$lc\" />\n";
        echo "<input id=\"invoice\" name=\"invoice\" type=\"hidden\" value=\"$kartid\" />\n";
        echo "<input id=\"shopping_url\" name=\"shopping_url\" type=\"hidden\" value=\"{$conf["this_domain"]}\" />\n";
        echo "<input id=\"return\" name=\"return\" type=\"hidden\" value=\"{$conf["this_domain"]}$pp_returnpath\" />\n";
        echo "<input id=\"cancel_return\" name=\"cancel_return\" type=\"hidden\" value=\"{$conf["this_domain"]}$pp_cancelreturnpath\" />\n";
        echo "<input id=\"notify_url\" name=\"notify_url\" type=\"hidden\" value=\"{$conf["this_domain"]}$pp_returnpath\" />\n";
        echo "<input id=\"bn\" name=\"bn\" type=\"hidden\" value=\"{$conf["this_organization"]}\" />\n";
        echo "<input id=\"tax_cart\" name=\"tax_cart\" type=\"hidden\" value=\"0\" />\n";
        echo "<input id=\"first_name\" name=\"first_name\" type=\"hidden\" value=\"$firstname\" \>\n";
        echo "<input id=\"last_name\" name=\"last_name\" type=\"hidden\" value=\"$lastname\" \>\n";
        echo "<input id=\"address1\" name=\"address1\" type=\"hidden\" value=\"$adress1\" \>\n";
        echo "<input id=\"address2\" name=\"address2\" type=\"hidden\" value=\"$adress2\" \>\n";
        echo "<input id=\"zip\" name=\"zip\" type=\"hidden\" value=\"$plz\" \>\n";
        echo "<input id=\"city\" name=\"city\" type=\"hidden\" value=\"$city\" \>\n";
        echo "<input id=\"state\" name=\"state\" type=\"hidden\" value=\"$province\" \>\n";
        echo "<input id=\"countryname\" name=\"countryname\" type=\"hidden\" value=\"$countryname\" \>\n";
        echo "<input id=\"country_code\" name=\"country_code\" type=\"hidden\" value=\"$country_code\" \>\n";
        echo "<input id=\"email-address\" name=\"email\" type=\"hidden\" value=\"$email\" \>\n";

      for ($c = "1"; $c <= $kartamount; $c++)
       {   
        echo "<input id=\"item_number_$c\" name=\"item_number_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_id']}\" />\n";
        echo "<input id=\"quantity_$c\" name=\"quantity_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_amount']}\" />\n";
        echo "<input id=\"item_name_$c\" name=\"item_name_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_name']}\" />\n";
        echo "<input id=\"amount_$c\" name=\"amount_$c\" type=\"hidden\" value=\"{$kart["$c"]['item_preis']}\" />\n";
       }

        echo "<input id=\"shipping_1\" name=\"shipping_1\" type=\"hidden\" value=\"$costs\" />\n";
        echo "<img alt=\"\" border=\"0\" src=\"https://www.paypalobjects.com/de_DE/i/scr/pixel.gif\" width=\"1\" height=\"1\">\n";
        //echo "<input type=\"submit\" value=\"{$loc_lang["buy"]}\">\n";
      echo "</form>\n";
     }
   else
     {
      echo "<form name=\"leaveshop_form\" action=\"../index.php?page=shop&amp;display=leaveshop&amp;kartid=$kartid&amp;lang=$lang&amp;kart=reset\" method=\"post\" accept-charset=\"UTF-8\" target=\"_top\">\n";
      echo "<input type=\"hidden\" name=\"lang\" value=\"$lang\">\n";
      echo "<input type=\"hidden\" name=\"kartid\" value=\"$kartid\">\n";
      //echo "<input type=\"submit\" value=\"{$loc_lang["buy"]}\">\n";
      echo "</form>\n";
     }
  }
?>

    </td>
  </tr>
</table>
