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

    // we will not display a marker for every movement that the user makes
    L.marker(e.latlng

            //             , {icon: L.icon({
            //        iconUrl: 'leaf-green.png',
            //        iconSize: [38, 95], // size of the icon
            //        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
            //        popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
            //
            //    })}
        ).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(map);

    setTimeout(getCurrentLocation, 1000);
};
