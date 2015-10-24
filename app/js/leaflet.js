var map = '';
var zoomLevel = 13;

function Initialize() {



    L.mapbox.accessToken = 'pk.eyJ1IjoiYm9iaW5iYyIsImEiOiJ2MkpyLTMwIn0.nay6_wKcFJpEC1y2Y6PDCw';
    map = L.mapbox.map('map', 'mapbox.streets')
        .setView([43.4822754, -80.5818245], zoomLevel);
    getCurrentLocation();

};

function displayMap(position) {
    map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
};

function getCurrentLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(displayMap);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }



};

function createIcon() {

    var greenIcon = L.icon({
        iconUrl: 'leaf-green.png',

        iconSize: [38, 95], // size of the icon
        iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
        shadowAnchor: [4, 62], // the same for the shadow
        popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor

    })
};
window.onload = Initialize;
