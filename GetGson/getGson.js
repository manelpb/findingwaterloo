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

    //click event to get the data from dummy data
    $( "#target" ).click(function() {
    //alert( "Handler for .click() called." );
        document.getElementById("placeholder").innerHTML = output;
    });


    //Title, description, image, geolocation, comments, popularity, type, custom pin icon
    //const SPOT_TYPE=



    //fentch data from API
    var output2 = "<ul>";
    var discoverAPI = "http://api.openweathermap.org/data/2.5/forecast/city?id=6167865&APPID=f2cab325db52e7429c3cee3965c9c0b3"
    var discoverApii = "http://172.31.11.163/findingwaterloo/index.php/api/things"
    $.getJSON( discoverAPI, function() {
      console.log( "success on access command" );
    })
     /* .done(function(data) {
        for (var i in data.list) {
            console.log(data.list[i])
        }*/

     .done(function(data) {
        for (var i in data.list) {
            output2 += "<li>" + data.list[i].main.temp+"</li>";
            console.log(data.list[i])
        }
       /* for (var i in data) {
            console.log(data[i])
        }*/


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

    //click event for get Geso from server

    $( "#target2" ).click(function() {
    //alert( "Handler for .click() called." );
        document.getElementById("placeholder").innerHTML = output2;
    });










});

///*****************




/*// Perform other work here ...

// Set another completion function for the request above
jqxhr.complete(function() {
  console.log( "second complete" );
});*/



//load Flicker API

/*(function() {
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
})();*/







