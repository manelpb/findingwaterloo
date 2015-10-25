'use strict';
app.factory('placeInfoService', ['$http', '$q', 'ngAuthSettings', function ($http, $q, ngAuthSettings) {

    var serviceBase = ngAuthSettings.apiServiceBaseUri;
    var placeInfoServiceFactory = {};

    var _getAllPlacesInfo = function () {

               var deferred = $q.defer();

              $http.get(serviceBase + 'api/things').success(function (response) {


                deferred.resolve(response);

            }).error(function (err, status) {
                deferred.reject(err);
            });

            return deferred.promise;
        };


    var _addNewTrackingPlaceInfo = function(trackingPlaceInfo){

          return $http.post(serviceBase + 'api/user_track/walk', trackingPlaceInfo).then(function (response) {
            console.log("keep tracking...");
        },
            function(error){
            console.log("lost the point")
        });

    };


    placeInfoServiceFactory.addTrackingPoint = _addNewTrackingPlaceInfo;
    placeInfoServiceFactory.getAllPlacesInfo = _getAllPlacesInfo;

    return placeInfoServiceFactory;

}]);
