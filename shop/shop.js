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
          document.getElementById("show-details").firstChild.data = document.getElementById("locale_data").getAtrribute("data-hidedetails");
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideDown( 500 );
            }
         }
       else
         {
          document.getElementById("show-details").firstChild.data = document.getElementById("locale_data").getAtrribute("data-showdetails");
          for (var i = 0; i < document.getElementsByName("hideable").length; i++)
            {
             $( "div.hideable" ).slideUp( 500 );
            }
         }
      }

function DeleteCheck () {
  var reallyDelete = document.getElementById("locale_data").getAtrribute("data-adminreallydelete");
  var chk = window.confirm();
  return (chk);
}

