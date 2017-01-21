    function show_kart()
      {
       if (document.getElementsByName("karthide")[0].style.display == "none")
         {
          $( "div.karthide" ).slideDown( 500 );
          document.getElementsByName('karthide')[0].id = 'karthide';
         }
       else
         {
          $( "div.karthide" ).slideUp( 500 );
          document.getElementsByName('karthide')[0].id = 'kartshow';
         }
      }

    function show_items()
      {
       if (document.getElementsByName("hideable")["0"].style.display == "none")
         {
          document.getElementById("show-details").firstChild.data = document.getElementById("locale_data").getAttribute("data-hideDetails");
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideDown( 500 );
            }
         }
       else
         {
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
   document.getElementById("intokart" + id).submit();
  }

function switch_country (call, index)
  {
   self.location = call + 'kart=show&job=addopt&copt=' + index;
  }

function switch_payment(call, index)
  {
   self.location = call + 'kart=show&job=addopt&opt=' + index;
  }

function toggleAudioPlayback(id, numberOfAudioItems)
  {
   audioObjects = document.getElementsByTagName("audio");
   for (var i = 0; i < audioObjects.length; i++)
     {
      audioObjects[i].pause();
      document.getElementsByName("playbutton")[i].src = "shop/pics/play-black.png";
     }
   if (currentlyPlaying == id)
     {
      document.getElementById(id).pause();
      document.getElementById(id + "-button").src = "shop/pics/play-black.png";
      currentlyPlaying = "none";
     }
   else
     {
      document.getElementById(id).play();
      document.getElementById(id + "-button").src = "shop/pics/play_active.png";
      currentlyPlaying = id;
     }
  }

function initShop ()
  {
   console.log("initShop()...");
   var buyButtons = document.getElementsByClassName("buy");
   for ( var i = 0 ; i < buyButtons.length ; i++ )
     { buyButtons[i].addEventListener("click", function() { intokart( this.getAttribute("data-id") ); });  }
   document.getElementById("show-hide").addEventListener("click", function() { show_kart(); });
   if (document.getElementById("show-details") != null) { document.getElementById("show-details").addEventListener("click", function() { show_items(); }); }

   currentlyPlaying = "none";
   var audioItems = document.getElementsByClassName("playAudioTrigger");
   var numberOfAudioItems = audioItems.length;
   console.log(numberOfAudioItems + " audio items detected");
   for (var i=0; i< numberOfAudioItems; i++)
   {
    audioItems[i].addEventListener("click", function() { toggleAudioPlayback(this.getAttribute("data-id"), numberOfAudioItems); });
   }
   console.log("initShop() has ended.");
  }

document.addEventListener('DOMContentLoaded', function () { initShop(); });
var call = document.getElementById("locale-data").getAttribute("data-call");

var country = document.getElementById("countryname");
if (country != null) { country.addEventListener("change", function() { switch_country(call, this.selectedIndex); }); }
var payment = document.getElementById("payment");
if (payment != null) { payment.addEventListener("change", function() { switch_payment(call, this.selectedIndex); }); }
var submitShippingData = document.getElementById("submitShippingData");
if (submitShippingData != null) submitShippingData.addEventListener("click", function() { document.getElementById("submit_shipping_data").submit(); });
var finalBuy = document.getElementById("final_buy");
if (finalBuy != null) finalBuy.addEventListener("click", function() { document.getElementById("orderform").submit(); });














