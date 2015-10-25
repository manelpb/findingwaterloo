var map = '';
var zoomLevel = 13;

'use strict';
app.controller('mapViewController', ['$scope', function ($scope) {

    L.mapbox.accessToken = 'pk.eyJ1IjoiYm9iaW5iYyIsImEiOiJ2MkpyLTMwIn0.nay6_wKcFJpEC1y2Y6PDCw';
    //Waterloo coordindates - [43.4822754, -80.5818245]
    map = L.mapbox.map('map', 'mapbox.streets').setView([43.4822754, -80.5818245], zoomLevel);
    getCurrentLocation();
    var string = navigator.userAgent;
    map.on('locationfound', onLocationFound);

}]);

function displayMap(position) {
    map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
};

function getCurrentLocation() {

    map.locate({
        setView: true,
        maxZoom: 16
    });


    //    if (navigator.geolocation) {
    //        navigator.geolocation.getCurrentPosition(displayMap);
    //    } else {
    //        x.innerHTML = "Geolocation is not supported by this browser.";
    //    }
};

function onLocationFound(e) {
    var radius = e.accuracy / 2;
    getJson(e);
    // we will not display a marker for every movement that the user makes



    setTimeout(getCurrentLocation, 1000);
};
//get the Json from backend server
function getJson(e){
    var discoverApii = "http://172.31.11.163/findingwaterloo/index.php/api/things"
    info = $.getJSON( discoverApii, function() {
      console.log( "success on access command" );
    })
        //do when success
     .done(function(data) {
        //console.log(data);
        for (var i in data) {
            //output2 += "<li>" + data[i].thgh_geo.location.lat"</li>";
            lati = (data[i]. tgh_geo. location.lat);
            longti = (data[i]. tgh_geo. location.lng);
            /*if (lati+INTERVAL>e.latitude || lati-INTERVAL<lat)&&(longti+INTERVAAL>e.longitude || longti < e.longitude )
                {

                }*/
            title = data[i].thg_title;
            discription= data[i].tgh_description;
            address = data[i].tgh_address;
            created = data[i].tgh_created_at;
            icon = data[i].tty_icon;

            console.log(title+"disc   "+discription+"addr  "+address+"create    "+created+"  icon "+icon);

            var radius = e.accuracy / 2;


            //shoot the windows on the map
            L.marker(e.latlng

            //             , {icon: L.icon({
            //        iconUrl: 'leaf-green.png',
            //        iconSize: [38, 95], // size of the icon
            //        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
            //        popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
            //
            //    })}
        ).addTo(map)
        .bindPopup("Name: " + title +"<br>" + "Descripstion" + discription + "<br>"+"Address "+ address + "<br>"+"Created " + created).openPopup();
        L.circle(e.latlng, radius).addTo(map);


            //return[title, discription, address, created];

        }

        console.log( "second success" );
      })
    // do when the connection failed
      .fail(function() {
        console.log( "error" );
      })




};
