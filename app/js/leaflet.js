var map = '';
var zoomLevel = 13;
const INTERVAL = 0.000060;
var info;
var lati;
var longti;
var title;
var discription;
var address;
var created;
var icon;
function Initialize() {



    L.mapbox.accessToken = 'pk.eyJ1IjoiYm9iaW5iYyIsImEiOiJ2MkpyLTMwIn0.nay6_wKcFJpEC1y2Y6PDCw';
    map = L.mapbox.map('map', 'mapbox.streets')
        .setView([43.4822754, -80.5818245], zoomLevel);
    getCurrentLocation();
    var string = navigator.userAgent;
    map.on('locationfound', onLocationFound);

};

function displayMap(position) {
    map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
};

function getCurrentLocation() {

    map.locate({setView: true, maxZoom: 16});


//    if (navigator.geolocation) {
//        navigator.geolocation.getCurrentPosition(displayMap);
//    } else {
//        x.innerHTML = "Geolocation is not supported by this browser.";
//    }
};

//shot the info on the screen
function onLocationFound(e) {

    getJson(e);

};



//get information from Gson data
function getJson(e){



    var discoverApii = "http://172.31.11.163/findingwaterloo/index.php/api/things"
    info = $.getJSON( discoverApii, function() {
      console.log( "success on access command" );
    })
     /* .done(function(data) {
        for (var i in data.list) {
            console.log(data.list[i])
        }*/

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

        L.marker(e.latlng).addTo(map)
        //.bindPopup("You are within " + radius + " meters from this point"+).openPopup();
        .bindPopup("Name: " + title +"\n" + "Descripstion" + discription + "\n"+"Address "+ address + "Created " + created).openPopup();
        L.circle(e.latlng, radius).addTo(map);

            //return[title, discription, address, created];



        }


        console.log( "second success" );
      })
      .fail(function() {
        console.log( "error" );
      })



   /*
    console.log(title+"disc   "+discription+"addr  "+address+"create    "+created);

        return info;
         */





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
