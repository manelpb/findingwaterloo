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


var discoverAPI = "http://api.openweathermap.org/data/2.5/forecast/city?id=6167865&APPID=f2cab325db52e7429c3cee3965c9c0b3"
$.getJSON( discoverAPI, function() {
  console.log( "success on access command" );
})
  .done(function(data) {
    for (var i in data.city) {
        console.log(data.city[i])
    }

    /* $.each( data.items, function( i, item ) {
        //$( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
         console.log(items);
        /*if ( i === 3 ) {
          return false;
        }
      });*/

    console.log( "second success" );
  })
  .fail(function() {
    console.log( "error" );
  })
  .always(function() {
    console.log( "complete" );
  });










});

///*****************




/*// Perform other work here ...

// Set another completion function for the request above
jqxhr.complete(function() {
  console.log( "second complete" );
});*/



//load Flicker API

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







