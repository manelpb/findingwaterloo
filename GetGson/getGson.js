//<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
/*document.addEventListener('DOMContentLoaded', function() {




}, false);*/


$( document ).ready(function() {

    //dummy data --will repalce by API later
    var data = {
    "users": [{
        "firstName": "Ray",
            "lastName": "Villalobos",
            "joined": {
            "month": "January111",
                "day": 12,
                "year": 2012
        }
    }, {
        "firstName": "John",
            "lastName": "Jones",
            "joined": {
            "month": "April",
                "day": 28,
                "year": 2010
        }
    }]
}

//text append
var output = "<ul>";
for (var i in data.users) {
    output += "<li>" + data.users[i].firstName + " " + data.users[i].lastName + "--" +          data.users[i].joined.month + "</li>";
}

    output += "</ul>";
    //click event
    $( "#target" ).click(function() {
    //alert( "Handler for .click() called." );
        document.getElementById("placeholder").innerHTML = output;
    });





});

(function() {
  var flickerAPI = "http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
  $.getJSON( flickerAPI, {
    tags: "mount rainier",
    tagmode: "any",
    format: "json"
  })
    .done(function( data ) {
      $.each( data.items, function( i, item ) {
        $( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
        if ( i === 3 ) {
          return false;
        }
      });
    });
})();







