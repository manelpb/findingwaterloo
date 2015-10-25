var map = '';
var zoomLevel = 13;
var LAT;
var LNG;
var formHTML = "<form action=''><input type='text' value='test' /> <input type='button' /> </form>";

'use strict';

app.controller('mapViewController', ['$scope', 'authService', '$location', 'placeInfoService', '$http', function ($scope, authService, $location, placeInfoService, $http) {

    $scope.init = function () {

        if (!authService.authentication.isAuth) {

            $location.path("/login");


        };

        L.mapbox.accessToken = 'pk.eyJ1IjoiYm9iaW5iYyIsImEiOiJ2MkpyLTMwIn0.nay6_wKcFJpEC1y2Y6PDCw';
        //Waterloo coordindates - [43.4822754, -80.5818245]
        map = L.mapbox.map('map', 'mapbox.streets', {
            maxZoom: 18,
            minZoom: 14
        });
        //.setView([43.4822754, -80.5818245], zoomLevel);
        getCurrentLocation();
        var string = navigator.userAgent;
        map.on('locationfound', onLocationFound);
        map.on('click', onMapClick);
        settingCityBoundary(null);
        //                    maskingMap();


        //example code of getting placeinfo
        //getPlaceInfos();
    };

    //example code of getting placeinfo
    /*var getPlaceInfos = function () {
           placeInfoService.getAllPlacesInfo().then(function(response){
               return response;
           });

       };*/
    //current City Coords are limited to waterloo (the cityCoords is not being populated)
    function settingCityBoundary(cityCoords) {
        // Construct a bounding box for this map that the user cannot
        // move out of

        var southWest = L.latLng(43.432744, -80.574186),
            northEast = L.latLng(43.532264, -80.479944),
            bounds = L.latLngBounds(southWest, northEast);

        map.setMaxBounds(bounds);
        //   map = L.mapbox.map('map', 'mapbox.streets', {
        //               // set that bounding box as maxBounds to restrict moving the map
        //               // see full maxBounds documentation:
        //               // http://leafletjs.com/reference.html#map-maxbounds
        //               maxBounds: bounds,
        //               maxZoom: 19,
        //               minZoom: 10
        //    });

        // zoom the map to that bounding box
        //    map.fitBounds(bounds);
    };

    function displayMap(position) {
        map.panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
    };


    function maskingMap() {
        // Create background tile layer
        //  var bg = L.tileLayer(...);
        var bg = L.tileLayer(this);

        // Create foreground tile layer with mask
        //                      http://www.finds.jp/ws/tmc/1.0.0/Kanto_Rapid-900913-L/{z}/{x}/{y}.png

        var fg = L.tileLayer.mask('http://{s}.tile.osm.org/{z}/{x}/{y}.png?{foo}', {
            //          maskUrl : 'star.png', // optional
            //          maskWidth : 800,  //optional
            //          maskHeight : 800 //optional
        });

        // Create map with layers and bind listener to update center of mask

        //    map.

        L.control.layers(bg, fg).addTo(this.map);
        this.map.on("mousemove", function (e) {
            fg.setCenter(e.containerPoint.x, e.containerPoint.y);
        });
        //    map = L.map("map", {
        ////              zoom : ...,
        ////      center : ...,
        //      layers : [ bg, fg ]
        //   })

    };


    function onMapClick(e) {
        L.marker(e.latlng
                //             , {
                //            icon: L.icon({
                //                iconUrl: 'leaf-green.png',
                //                iconSize: [38, 95], // size of the icon
                //                iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                //                popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
                //            })
                //        }
            ).addTo(map)
            .bindPopup(formHTML).openPopup();

        //    alert("You clicked at "+e.latlng);
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

    function displayPOI(POIObject) {
        POIObject.latlng = {
            longitude: POIObject.tgh_geo.location.lat,
            latitude: POIObject.tgh_geo.location.lng
        };
        var latter = L.latLng(POIObject.latlng.latitude, POIObject.latlng.longitude);

        L.marker(latter, {
                icon: L.icon({
                    iconUrl: POIObject.tty_icon,
                    iconSize: [30, 45], // size of the icon
                    iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                    popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
                })
            }).addTo(map)
            .bindPopup(POIObject.thg_title).openPopup();
    };

    function onLocationFound(e) {
        LAT = e.latitude;
        LNG = e.longitude;
        var radius = e.accuracy / 2;
        getJson(e);
        // we will not display a marker for every movement that the user makes

        //setTimeout(getCurrentLocation, 1000);
    };
    //get the Json from backend server
    function getJson(e) {
        console.log(e.latitude);
        var lati;
        var longti;
        var title;
        var discription;
        var address;
        var created;
        var icon;
        var dif = 99999999999; //longla difference value give a impossible value more than any dif
        var index;
        const INTERVAL = 0.000060;
        var discoverApii = "http://172.31.11.163/findingwaterloo/index.php/api/things"
        info = $.getJSON(discoverApii, function () {
                console.log("success on access command");
            })
            //do when load the data successfully
            .done(function (data) {
                //console.log(data);
                for (var i in data) {
                    //
                    displayPOI(data[i]);
                    //output2 += "<li>" + data[i].thgh_geo.location.lat"</li>";
                                                    lati = (data[i]. tgh_geo. location.lat);
                                                    longti = (data[i]. tgh_geo. location.lng);
                                                    //find the spot near by add and sub INTERVAL
                                                    /*if (lati+INTERVAL>e.latitude || lati-INTERVAL<lat)&&(longti+INTERVAAL>e.longitude || longti < e.longitude )
                                                        {

                                                        }*/
                                                    //store the data to local
                                                    title = data[i].thg_title;
                                                    discription = data[i].tgh_description;
                                                    address = data[i].tgh_address;
                                                    created = data[i].tgh_created_at;
                                                    //icon = data[i].tty_icon;
                    //give the index of the nearest place where user's place
                    var tempDif = Math.abs(e.latitude - lati ) + Math.abs(e.longitude - longti);
                    if (dif > tempDif){
                        index = i;
                        dif = tempDif;
                    }

                }

                var radius = e.accuracy / 2;

                //shoot the windows on the map
            var showDesc = data[index].tgh_description;
            if (showDesc === undefined || showDesc === null)
            {
                showDesc = "No info about this location"
            }
                var print = "Name: " + data[index].thg_title + "<br>" + "Description: " + showDesc + "<br>" + "Address: " +  data[index].tgh_address + "<br>" + "Created: " +  data[index].tgh_created_at + "<br>";
                //formHTML = "<form action=''><input type='text' value=" + print + "/> <input type='button' /> </form>";
                formHTML= print;
                L.marker(e.latlng
                    //                        , {
                    //                            icon: L.icon({
                    //                                //iconUrl: 'leaf-green.png',
                    //                                iconUrl: icon,
                    //                                iconSize: [38, 95], // size of the icon
                    //                                iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
                    //                                popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
                    //
                    //                            })
                    //                        }
                ).addTo(map);
                //.bindPopup("Name: " + title + "<br>" + "Description" + discription + "<br>" + "Address " + address + "<br>" + "Created " + created).openPopup();
                L.circle(e.latlng, radius).addTo(map);

                //            console.log("second success");
            })
            // do when the connection failed
            .fail(function () {
                // console.log("error");
            })
    };

    //post the user  location to the backend
    var func = function(){

        var trackingObj = {
            userId: currentUsr,
            longitude: LNG,
            latitude: LAT,
        }

        placeInfoService.addTrackingPoint(trackingObj);
    }

    var currentUsr;


}]);
