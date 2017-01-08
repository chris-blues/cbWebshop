    function show_kart()
      {
       if (document.getElementsByName("karthide")[0].style.display == "none")
         {
	  console.log("showing kart");
          $( "div.karthide" ).slideDown( 500 );
          document.getElementsByName('karthide')[0].id = 'karthide';
         }
       else
         {
	  console.log("hiding kart");
          $( "div.karthide" ).slideUp( 500 );
          document.getElementsByName('karthide')[0].id = 'kartshow';
         }
      }

    function show_items()
      {
       if (document.getElementsByName("hideable")["0"].style.display == "none")
         {
	  console.log("showing items");
          document.getElementById("show-details").firstChild.data = document.getElementById("locale_data").getAttribute("data-hideDetails");
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideDown( 500 );
            }
         }
       else
         {
	  console.log("hiding items");
          document.getElementById("show-details").firstChild.data = document.getElementById("locale_data").getAttribute("data-showDetails");
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideUp( 500 );
            }
         }
      }

function DeleteCheck()
 {
  var reallyDelete = document.getElementById("locale_data").getAtrribute("data-adminreallydelete");
  var chk = window.confirm();
  return (chk);
 }

function intokart(id)
  {
   console.log("intokart(intokart" + id + ") called.");
   document.getElementById("intokart" + id).submit();
  }

function switch_country (call, index)
  {
   console.log("changing country");
   self.location = call + 'kart=show&job=addopt&copt=' + index;
  }

function switch_payment(call, index)
  {
   console.log("changing country");
   self.location = call + 'kart=show&job=addopt&opt=' + index;
  }

function initShop ()
  {
   var buyButtons = document.getElementsByClassName("buy");
   for ( var i = 0 ; i < buyButtons.length ; i++ )
     { buyButtons[i].addEventListener("click", function() { intokart( this.getAttribute("data-id") ); });  }
   document.getElementById("show-hide").addEventListener("click", function() { show_kart(); });
   document.getElementById("show-details").addEventListener("click", function() { show_items(); });
  }

document.addEventListener('DOMContentLoaded', function () { initShop(); });
var call = document.getElementById("locale-data").getAttribute("data-call");
console.log("call -> " + call);
var country = document.getElementById("countryname");
if (country != null) { country.addEventListener("change", function() { switch_country(call, this.selectedIndex); }); }
var payment = document.getElementById("payment");
if (payment != null) { payment.addEventListener("change", function() { switch_payment(call, this.selectedIndex); }); }
var submitShippingData = document.getElementById("submitShippingData");
if (submitShippingData != null) submitShippingData.addEventListener("click", function() { document.getElementById("submit_shipping_data").submit(); });
var finalBuy = document.getElementById("final_buy");
if (finalBuy != null) finalBuy.addEventListener("click", function() { document.getElementById("orderform").submit(); });














