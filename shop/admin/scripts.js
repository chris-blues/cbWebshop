//console.log("scripts.js has started!");

if (document.getElementById("deleteItem") != null) {
  document.getElementById("deleteItem").addEventListener("submit", function() {
    return deletecheck();
  });
}

if (document.getElementById("buttonBackToBefore") != null) {
  var backTarget=document.getElementById("buttonBackToBefore").getAttribute("data-target");
  if (backTarget == null ||  backTarget == undefined) backTarget = "showitems";
  document.getElementById("buttonBackToBefore").addEventListener("click", function() {
    console.log("Back button has fired! Target: " + backTarget);
    self.location=backTarget + '.php';
   });
}

if (document.getElementById("final_buy") != null) { document.getElementById("final_buy").addEventListener("click", document.getElementById('orderform').submit() ); }

if (document.getElementById("buttonSubmitShippingData") != null) { document.getElementById("buttonSubmitShippingData").addEventListener("click", document.getElementById('submit_shipping_data').submit() ); }

function removeData(DataID) {
  document.getElementById(DataID).value='';
}

if (document.getElementById("buttonToggleMenu") != null) {
  document.getElementById("buttonToggleMenu").addEventListener("click", function() {
    resizeToViewscreen();
    console.log("buttonToggleMenu has fired");
    if (document.getElementById("menuContent").style.display == "block" || document.getElementById("menuContent").style.display == null || document.getElementById("menuContent").style.display == undefined || document.getElementById("menuContent").style.display == "") {
      $("ul#menuContent").slideUp(250);
    }
    else { $("ul#menuContent").slideDown(250); }
  });
}

var DataArray = document.getElementsByClassName("editArrays");
if (DataArray != null) {
  for (i = 0; i < DataArray.length; i++) {
     document.getElementById("buttonRemoveRow_" + i).addEventListener("click", function() {
       var ID = this.getAttribute("data-id");
       removeData(ID);
    });
  }
}

function resizeToViewscreen() {
  var offsetHead = document.getElementById("shopAdminTools").offsetHeight + 60;
  console.log("offsetHead: " + offsetHead);
  var docHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
  console.log("docHeight: " + docHeight);
  var maxHeight = docHeight - offsetHead;
  console.log("docHeight: " + maxHeight);
  document.getElementById("adminContentFrame").height = maxHeight;
}

if (document.getElementById("adminContentFrame") != null || document.getElementById("adminContentFrame") != undefined) {
  document.addEventListener('DOMContentLoaded', function() {
    console.log("DOMContentLoaded has fired");
    resizeToViewscreen();
  });
}

//console.log("scripts.js has ended!");
